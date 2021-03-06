<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Position;
use AppBundle\Entity\Volunteer;
use AppBundle\Lib\StatusVolunteer;
use Doctrine\DBAL\Types\ArrayType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMInvalidArgumentException;
use Doctrine\ORM\TransactionRequiredException;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\File\File;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
//        return $this->render('default/index.html.twig', [
//            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
//        ]);
        return $this->redirectToRoute('listVolunteers');
    }

    /**
     * @Route("/listVolunteers", name="listVolunteers")
     */
    public function listVolunteersAction(Request $request)
    {
        $volunteers = $this->get('volunteers.volunteer_manager')->volunteersList();
        return $this->render('volunteer/list.html.twig', array('title' => 'Volunteers List', 'list' => $volunteers));
    }

//    /**
//     * @Route("/createVolunteer/{dni}", name="createVolunteer", defaults={"dni"=null})
//     */
//    public function createVolunteerAction(Request $request, $dni)
//    {
        //$newVolunteer = $this->get('volunteers.volunteer_manager')->createRandomVolunteer();

//        if (!empty($dni)) {
//            $volunteer = $this->get('doctrine.orm.entity_manager')->find(Volunteer::class, $dni);
//        } else {
//            $volunteer = new Volunteer();
//        }
//
//        $form = $this->createFormBuilder($volunteer)
//            ->add('Dni', TextType::class)
//            ->add('Name', TextType::class)
//            ->add('Surname', TextType::class)
//            ->add('Birthdate', DateType::class)
//            ->add('Phone', TextType::class)
//            ->add('Email', EmailType::class)
//            ->add('Address', TextType::class)
//            ->getForm();
//
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $volunteer = $form->getData();
//            $this->get('volunteers.volunteer_manager')->saveVolunteer($volunteer);
//            return $this->redirectToRoute('createVolunteer', array('dni' => $volunteer->getDni()));
//        }
//
////        return $this->render('volunteer/view.html.twig',array('title' => 'New Volunteer','volunteer' => $newVolunteer));
//        return $this->render('volunteer/view.html.twig', array('title' => 'New Volunteer', 'form' => $form->createView()));
//    }



    /**
     * @Route("/viewVolunteerForm/{dni}", name="viewVolunteerForm", defaults={"dni"=null})
     * @param Request $request
     */
    public function viewVolunteerFormAction(Request $request, $dni)
    {
        if (!empty($dni)) {
            $volunteer = $this->get('doctrine.orm.entity_manager')->find(Volunteer::class, $dni);
        } else {
            $volunteer = new Volunteer();
        }

        $form = $this->createFormBuilder($volunteer)
            ->setAction($this->generateUrl('handleVolunteerForm'/*, array('dni'=> $dni)*/))
            ->add('Dni', TextType::class)
            ->add('Name', TextType::class)
            ->add('Surname', TextType::class)
            ->add('Birthdate', DateType::class)
            ->add('Phone', TextType::class)
            ->add('Email', EmailType::class)
            ->add('Address', TextType::class)
            ->add('State', ChoiceType::class, array('choices' => StatusVolunteer::getStates()))
            ->add('Position', EntityType::class, array(
                'class' => Position::class,
//                'choices' => $this->get('volunteers.position_manager')->positionsList(),
                'choice_label' => 'ExtendedName'
            ))
//            ->add('Position', ChoiceType::class, array('choices' => $this->get('volunteers.position_manager')->positionsChoices()))
            ->getForm();

//        $form->handleRequest($request);
        return $this->render('volunteer/viewForm.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/loadVolunteersForm/", name="loadVolunteersForm")
     */
    public function loadVolunteersFormAction()
    {
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('handleLoadVolunteersForm'))
            ->add('File', FileType::class, array('label' => 'Load excel file'))
            ->getForm();

        return $this->render('volunteer/loadForm.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/handleLoadVolunteersForm/", name="handleLoadVolunteersForm")
     */
    public function handleLoadVolunteersFormAction(Request $request)
    {
        $form = $this->createFormBuilder()
            ->add('File', FileType::class, array('label' => 'Load excel file'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('File');

            /** @var UploadedFile $fileData */
            $fileData = $file->getData();

            $this->get('volunteers.volunteersLoad_service')->volunteersLoadFromExcel($fileData);

//            echo $fileData->guessExtension();
//            echo get_class($file);
//            var_dump($file->getData());
//            var_dump($file);
            die('Hola mundo');
        }
        die('Adiós mundo');

    }


    /**
//     * @Route("/handleVolunteerForm/{dni}", name="handleVolunteerForm")
     * @Route("/handleVolunteerForm", name="handleVolunteerForm")
     */
    public function handleVolunteerFormAction(Request $request/*, $dni*/)
    {
        $dni = $request->request->get('form')['Dni'];
        try {
            if (!$volunteer = $this->get('doctrine.orm.entity_manager')->find(Volunteer::class, $dni)) {
                $volunteer = new Volunteer();
            }
        }catch (\Exception $e) {
            return $this->redirectToRoute('viewVolunteerForm');
        }

        $form = $this->createFormBuilder($volunteer)
            ->add('Dni', TextType::class)
            ->add('Name', TextType::class)
            ->add('Surname', TextType::class)
            ->add('Birthdate', DateType::class)
            ->add('Phone', TextType::class)
            ->add('Email', EmailType::class)
            ->add('Address', TextType::class)
            ->add('State', ChoiceType::class, array('choices' => StatusVolunteer::getStates()))
            ->add('Position', EntityType::class, array(
                'class' => Position::class,
                'choice_label' => 'ExtendedName'
            ))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $volunteer = $form->getData();
            $this->get('volunteers.volunteer_manager')->saveVolunteer($volunteer);

            return $this->redirectToRoute('viewVolunteer', array('dni' => $volunteer->getDni()));
        }

        return $this->redirectToRoute('listVolunteers');
    }

    /**
     * @Route("/viewVolunteer/{dni}", name="viewVolunteer")
     */
    public function viewVolunteerAction(Request $request, $dni)
    {
        $volunteer = $this->get('volunteers.volunteer_manager')->volunteer($dni);
        return $this->render('volunteer/view.html.twig', array('title' => 'New Volunteer', 'volunteer' => $volunteer));
    }

}
