<?php
/**
 * Created by PhpStorm.
 * User: Yilsen
 * Date: 17/03/2018
 * Time: 22:58
 */

namespace AppBundle\Services;


use Doctrine\ORM\EntityManager;

class PositionManager
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    public function positionsList()
    {
        return $this->entityManager->getRepository('AppBundle:Position')->findAll();
    }

}