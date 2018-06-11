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


    /**
     * @return \AppBundle\Entity\Position[]
     */
    public function positionsList()
    {
        return $this->entityManager->getRepository('AppBundle:Position')->findAll();
    }

//    public function positionsChoices()
//    {
//        $arrayPositions = array();
//        $positions = $this->positionsList();
//
//        foreach ($positions as $position) {
//            $arrayPositions[$position->getName().$position->getShift()] = $position->getId();
//        }
//
//        return $arrayPositions;
//    }

    public function savePosition($position)
    {
        $this->entityManager->persist($position);
        $this->entityManager->flush();
    }

}