<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Volunteer;
use Doctrine\ORM\EntityManager;
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
        return $this->render('volunteer/list.html.twig',array('title' => 'Volunteers List'));
    }

    /**
     * @Route("/createVolunteer", name="createVolunteer")
     */
    public function createVolunteerAction(Request $request)
    {
        $newVolunteer = $this->get('volunteers.volunteer_manager')->createRandomVolunteer();

        return $this->render('volunteer/view.html.twig',array('title' => 'New Volunteer','volunteer' => $newVolunteer));
    }

    /**
     * @Route("/viewVolunteer", name="viewVolunteer")
     */
    public function viewVolunteerAction(Request $request)
    {
        return $this->render('volunteer/view.html.twig',array('title' => 'New Volunteer'));
    }
}
