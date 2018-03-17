<?php
/**
 * Created by PhpStorm.
 * User: Yilsen
 * Date: 17/03/2018
 * Time: 22:48
 */

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
}