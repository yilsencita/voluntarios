<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Volunteer;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
        $volunteers = $this->get('volunteers.volunteer_manager')->listVolunteers();
        return $this->render('volunteer/list.html.twig', array('title' => 'Volunteers List', 'list' => $volunteers));
    }

    /**
     * @Route("/createVolunteer/{dni}", name="createVolunteer", defaults={"dni"=null})
     */
    public function createVolunteerAction(Request $request, $dni)
    {
        //$newVolunteer = $this->get('volunteers.volunteer_manager')->createRandomVolunteer();

        if (!empty($dni)) {
            $volunteer = $this->get('doctrine.orm.entity_manager')->find(Volunteer::class, $dni);
        } else {
            $volunteer = new Volunteer();
        }

        $form = $this->createFormBuilder($volunteer)
            ->add('Dni', TextType::class)
            ->add('Name', TextType::class)
            ->add('Surname', TextType::class)
            ->add('Birthdate', DateType::class)
            ->add('Phone', TextType::class)
            ->add('Email', EmailType::class)
            ->add('Address', TextType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $volunteer = $form->getData();
            $this->get('volunteers.volunteer_manager')->saveVolunteer($volunteer);
            return $this->redirectToRoute('createVolunteer', array('dni' => $volunteer->getDni()));
        }

//        return $this->render('volunteer/view.html.twig',array('title' => 'New Volunteer','volunteer' => $newVolunteer));
        return $this->render('volunteer/view.html.twig', array('title' => 'New Volunteer', 'form' => $form->createView()));
    }

    public function updateVolunteerAction(Request $request)
    {

    }

    /**
     * @Route("/viewVolunteerForm/{dni}", name="viewVolunteerForm")
     * @param Request $request
     */
    public function viewVolunteerFormAction(Request $request, $dni)
    {
        $volunteer = $this->get('doctrine.orm.entity_manager')->find(Volunteer::class, $dni);
        $form = $this->createFormBuilder($volunteer)
            ->setAction($this->generateUrl('handleVolunteerForm', array('dni'=> $dni)))
            ->add('Dni', TextType::class)
            ->add('Name', TextType::class)
            ->add('Surname', TextType::class)
            ->add('Birthdate', DateType::class)
            ->add('Phone', TextType::class)
            ->add('Email', EmailType::class)
            ->add('Address', TextType::class)
            ->getForm();

//        $form->handleRequest($request);
        return $this->render('volunteer/viewForm.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/handleVolunteerForm/{dni}", name="handleVolunteerForm")
     */
    public function handleVolunteerFormAction(Request $request, $dni)
    {
        $volunteer = $this->get('doctrine.orm.entity_manager')->find(Volunteer::class, $dni);
        $form = $this->createFormBuilder($volunteer)
            ->add('Dni', TextType::class)
            ->add('Name', TextType::class)
            ->add('Surname', TextType::class)
            ->add('Birthdate', DateType::class)
            ->add('Phone', TextType::class)
            ->add('Email', EmailType::class)
            ->add('Address', TextType::class)
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
        $volunteer = $this->get('volunteers.volunteer_manager')->listVolunteer($dni);
        return $this->render('volunteer/view.html.twig', array('title' => 'New Volunteer', 'volunteer' => $volunteer));
    }
}
