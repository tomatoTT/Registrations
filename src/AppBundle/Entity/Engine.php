<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Engine
 *
 * @ORM\Table(name="engine")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EngineRepository")
 */
class Engine
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="Type", type="string", length=255, unique=true)
     */
    private $type;

    /**
     * @var int
     *
     * @ORM\Column(name="Displacement", type="integer")
     */
    private $displacement;

    /**
     * @var int
     *
     * @ORM\Column(name="Power_kW", type="integer")
     */
    private $powerkW;

    /**
     * @var int
     *
     * @ORM\Column(name="Power_HP", type="integer")
     */
    private $powerHP;

    /**
     * @var int
     *
     * @ORM\Column(name="Torque", type="integer")
     */
    private $torque;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Engine
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set displacement
     *
     * @param integer $displacement
     *
     * @return Engine
     */
    public function setDisplacement($displacement)
    {
        $this->displacement = $displacement;

        return $this;
    }

    /**
     * Get displacement
     *
     * @return int
     */
    public function getDisplacement()
    {
        return $this->displacement;
    }

    /**
     * Set power
     *
     * @param integer $power
     *
     * @return Engine
     */
    public function setPower($power)
    {
        $this->power = $power;

        return $this;
    }

    /**
     * Get power
     *
     * @return int
     */
    public function getPower()
    {
        return $this->power;
    }

    /**
     * Set powerHP
     *
     * @param integer $powerHP
     *
     * @return Engine
     */
    public function setPowerHP($powerHP)
    {
        $this->powerHP = $powerHP;

        return $this;
    }

    /**
     * Get powerHP
     *
     * @return int
     */
    public function getPowerHP()
    {
        return $this->powerHP;
    }

    /**
     * Set torque
     *
     * @param integer $torque
     *
     * @return Engine
     */
    public function setTorque($torque)
    {
        $this->torque = $torque;

        return $this;
    }

    /**
     * Get torque
     *
     * @return int
     */
    public function getTorque()
    {
        return $this->torque;
    }
}

