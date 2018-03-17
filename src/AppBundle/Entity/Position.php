<?php
/**
 * Created by PhpStorm.
 * User: Yilsen
 * Date: 14/03/2018
 * Time: 22:35
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Position
 *
 * @ORM\Table(name="position")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PositionRepository")
 */
class Position
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id", type="integer", unique=true)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=45)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="shift", type="string", length=15)
     */
    private $shift;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Volunteer", mappedBy="position")
     */
    private $volunteers;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PositionKind", inversedBy="positions")
     * @ORM\JoinColumn(name="positionKind_id", referencedColumnName="id")
     */
    private $positionKind;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

   /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getShift()
    {
        return $this->shift;
    }

    /**
     * @param string $shift
     */
    public function setShift($shift)
    {
        $this->shift = $shift;
    }

    /**
     * @return mixed
     */
    public function getVolunteers()
    {
        return $this->volunteers;
    }

    /**
     * @param mixed $volunteers
     */
    public function setVolunteers($volunteers)
    {
        $this->volunteers = $volunteers;
    }

    /**
     * @return mixed
     */
    public function getPositionKind()
    {
        return $this->positionKind;
    }

    /**
     * @param mixed $positionKind
     */
    public function setPositionKind($positionKind)
    {
        $this->positionKind = $positionKind;
    }
}