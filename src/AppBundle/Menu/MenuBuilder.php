<?php
/**
 * Created by PhpStorm.
 * User: Yilsen
 * Date: 09/04/2018
 * Time: 22:42
 */

namespace AppBundle\Menu;


use Knp\Menu\FactoryInterface;

class MenuBuilder
{
    private $factory;

    /**
     * MenuBuilder constructor.
     * @param FactoryInterface $factory
     */
    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public function createMainMenu(array $options)
    {
        $menu = $this->factory->createItem('root');
        $menu->addChild('Volunteers', array('route' => 'listVolunteers'));
        $menu->addChild('Positions', array('route' => 'listPositions'));

        return $menu;
    }

}