<?php
/**
 * Created by PhpStorm.
 * User: Yilsen
 * Date: 12/03/2018
 * Time: 21:35
 */

namespace AppBundle\Lib;


class StatusVolunteer
{
    const SELECTED='selected';
    const PRESELECTED='preselected';
    const DISCARDED='discarded';
    const DROP='drop';

    protected static $states = array (
        'SELECTED' => self::SELECTED,
        'PRESELECTED' => self::PRESELECTED,
        'DISCARDED' => self::DISCARDED,
        'DROP' => self::DROP
    );

    public static function getStates()
    {
        return self::$states;
    }
}