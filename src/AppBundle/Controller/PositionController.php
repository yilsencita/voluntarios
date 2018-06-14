<?php
/**
 * Created by PhpStorm.
 * User: Yilsen
 * Date: 17/03/2018
 * Time: 22:48
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Position;
use AppBundle\Entity\PositionKind;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PositionController extends Controller
{
    /**
     * @Route("/listPositions", name="listPositions")
     */
    public function listPositionsAction(Request $request)
    {
        $positions = $this->get('volunteers.position_manager')->positionsList();
        return $this->render('position/list.html.twig', array('title' => 'Positions List', 'list' => $positions));

    }

    /**
     * @Route("/viewPositionForm/{id}", name="viewPositionForm", defaults={"id"=null})
     */
    public function viewPositionFormAction(Request $request, $id)
    {
        if (!empty($id)) {
            $position = $this->get('doctrine.orm.entity_manager')->find(Position::class, $id);
        } else {
            $position = new Position();
        }

        $form = $this->createFormBuilder($position)
            ->setAction($this->generateUrl('handlePositionForm', array('id'=> $id)))
            ->add('Name', TextType::class)
            ->add('Shift', TextType::class)
            ->add('PositionKind', EntityType::class, array('class' => PositionKind::class, 'choice_label' => 'name'))
            ->getForm();

        return $this->render('position/viewForm.html.twig', array('form' => $form->createView()));

    }

    /**
     * @Route("/viewPosition/{extendedName}", name="viewPosition")
     * @param Request $request
     * @param $extendedName
     */
    public function viewPositionAction(Request $request, $extendedName)
    {
        /** @var Position $position */
        if ($position = $this->get('volunteers.position_manager')->positionByExtendedName(urldecode ($extendedName))) {
            return $this->render('position/view.html.twig', array('title' => $position->getExtendedName(),'position' => $position));
        }

        return $this->redirectToRoute('listPositions');
    }

    /**
     * @Route("/handlePositionForm", name="handlePositionForm")
     */
    public function handleVolunteerFormAction(Request $request)
    {
        $position = new Position();

        $form = $this->createFormBuilder($position)
            ->add('Name', TextType::class)
            ->add('Shift', TextType::class)
            ->add('PositionKind', EntityType::class, array('class' => PositionKind::class, 'choice_label' => 'name'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $position = $form->getData();
            $this->get('volunteers.position_manager')->savePosition($position);

            return $this->redirectToRoute('listPositions');
        }

        $this->get('session')->getFlashBag()->add('error', 'Error al procesar del formuario de posición');
        return $this->redirectToRoute('viewPositionForm');
    }
}