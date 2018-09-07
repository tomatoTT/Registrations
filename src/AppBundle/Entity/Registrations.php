<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Registrations
 *
 * @ORM\Table(name="registrations")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RegistrationsRepository")
 */
class Registrations
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
     * @ORM\Column(name="Make", type="string", length=255)
     */
    private $make;

    /**
     * @var string
     *
     * @ORM\Column(name="Model", type="string", length=255)
     */
    private $model;

    /**
     * @var int
     *
     * @ORM\Column(name="Reg_year", type="integer")
     */
    private $regYear;

    /**
     * @var int
     *
     * @ORM\Column(name="Reg_month", type="integer")
     */
    private $regMonth;

    /**
     * @var int
     *
     * @ORM\Column(name="Units", type="integer")
     */
    private $units;

    /**
     * @var string
     *
     * @ORM\Column(name="REGON", type="string", length=255)
     */
    private $rEGON;

    /**
     * @var string
     *
     * @ORM\Column(name="Reg_type", type="string", length=255)
     */
    private $regType;

    /**
     * @var int
     *
     * @ORM\Column(name="TERYT", type="integer")
     */
    private $tERYT;


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
     * Set make
     *
     * @param string $make
     *
     * @return Registrations
     */
    public function setMake($make)
    {
        $this->make = $make;

        return $this;
    }

    /**
     * Get make
     *
     * @return string
     */
    public function getMake()
    {
        return $this->make;
    }

    /**
     * Set model
     *
     * @param string $model
     *
     * @return Registrations
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get model
     *
     * @return string
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set regYear
     *
     * @param integer $regYear
     *
     * @return Registrations
     */
    public function setRegYear($regYear)
    {
        $this->regYear = $regYear;

        return $this;
    }

    /**
     * Get regYear
     *
     * @return int
     */
    public function getRegYear()
    {
        return $this->regYear;
    }

    /**
     * Set regMonth
     *
     * @param integer $regMonth
     *
     * @return Registrations
     */
    public function setRegMonth($regMonth)
    {
        $this->regMonth = $regMonth;

        return $this;
    }

    /**
     * Get regMonth
     *
     * @return int
     */
    public function getRegMonth()
    {
        return $this->regMonth;
    }

    /**
     * Set units
     *
     * @param integer $units
     *
     * @return Registrations
     */
    public function setUnits($units)
    {
        $this->units = $units;

        return $this;
    }

    /**
     * Get units
     *
     * @return int
     */
    public function getUnits()
    {
        return $this->units;
    }

    /**
     * Set rEGON
     *
     * @param string $rEGON
     *
     * @return Registrations
     */
    public function setREGON($rEGON)
    {
        $this->rEGON = $rEGON;

        return $this;
    }

    /**
     * Get rEGON
     *
     * @return string
     */
    public function getREGON()
    {
        return $this->rEGON;
    }

    /**
     * Set regType
     *
     * @param string $regType
     *
     * @return Registrations
     */
    public function setRegType($regType)
    {
        $this->regType = $regType;

        return $this;
    }

    /**
     * Get regType
     *
     * @return string
     */
    public function getRegType()
    {
        return $this->regType;
    }

    /**
     * Set tERYT
     *
     * @param integer $tERYT
     *
     * @return Registrations
     */
    public function setTERYT($tERYT)
    {
        $this->tERYT = $tERYT;

        return $this;
    }

    /**
     * Get tERYT
     *
     * @return int
     */
    public function getTERYT()
    {
        return $this->tERYT;
    }
}

