<?php
/**
 * Created by PhpStorm.
 * User: Yilsen
 * Date: 12/03/2018
 * Time: 22:31
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PositionKind
 *
 * @ORM\Table(name="positionKind")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PositionKindRepository")
 */
class PositionKind
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
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Position", mappedBy="positionKind")
     */
    private $positions;

    /**
     * @return string
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
     * @return mixed
     */
    public function getPositions()
    {
        return $this->positions;
    }

    /**
     * @param mixed $positions
     */
    public function setPositions($positions)
    {
        $this->positions = $positions;
    }
}