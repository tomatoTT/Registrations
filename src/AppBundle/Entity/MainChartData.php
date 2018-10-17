<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MainChartData
 *
 * @ORM\Table(name="main_chart_data")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MainChartDataRepository")
 */
class MainChartData
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
     * @var int
     *
     * @ORM\Column(name="RegYear", type="integer")
     */
    private $regYear;

    /**
     * @var int
     *
     * @ORM\Column(name="RegMonth", type="integer")
     */
    private $regMonth;


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
     * @return MainChartData
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
     * Set regYear
     *
     * @param integer $regYear
     *
     * @return MainChartData
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
     * @return MainChartData
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
}

