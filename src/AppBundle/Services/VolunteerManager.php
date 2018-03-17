<?php
/**
 * Created by PhpStorm.
 * User: Yilsen
 * Date: 21/02/2018
 * Time: 23:38
 */

namespace AppBundle\Services;


use AppBundle\Entity\Volunteer;
use Doctrine\ORM\EntityManager;

class VolunteerManager
{

    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createRandomVolunteer()
    {
        $newVolunteer = new Volunteer();
        $newVolunteer->setDni('06628957F');
        $newVolunteer->setName('Arthia');
        $newVolunteer->setSurname('Fernandez Zevallos');
        $newVolunteer->setBirthdate(\DateTime::createFromFormat('Y-m-d','1983-02-14'));
        $newVolunteer->setPhone('600265701');
        $newVolunteer->setEmail('yilsen@gmail.com');
        $newVolunteer->setAddress('Calle Estremera 3, 3ºB, 28051, Madrid');
        $newVolunteer->setState('Selected');

        $this->saveVolunteer($newVolunteer);

        return $newVolunteer;
    }

    public function saveVolunteer($volunteer)
    {
        $this->entityManager->persist($volunteer);
        $this->entityManager->flush();
    }

    public function volunteersList()
    {
        return $this->entityManager->getRepository('AppBundle:Volunteer')->findAll();
    }

    public function volunteer($dni)
    {
        return $this->entityManager->find('AppBundle:Volunteer',$dni);
    }
}