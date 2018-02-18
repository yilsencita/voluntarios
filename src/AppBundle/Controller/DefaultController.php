<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Volunteer;
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
        $newVolunteer = new Volunteer();
        $newVolunteer->setDni('06628952F');
        $newVolunteer->setName('Arthia');
        $newVolunteer->setSurname('Fernandez Zevallos');
        $newVolunteer->setBirthdate(\DateTime::createFromFormat('Y-m-d','1983-02-14'));
        $newVolunteer->setPhone('600265701');
        $newVolunteer->setEmail('yilsen@gmail.com');
        $newVolunteer->setAddress('Calle Estremera 3, 3ºB, 28051, Madrid');
        $newVolunteer->setState('Selected');

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
