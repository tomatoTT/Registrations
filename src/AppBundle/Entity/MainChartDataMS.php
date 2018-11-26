<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MainChartDataMS
 *
 * @ORM\Table(name="main_chart_data__m_s")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MainChartDataMSRepository")
 */
class MainChartDataMS
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
     * @var int
     *
     * @ORM\Column(name="Units", type="integer")
     */
    private $units;
    
    /**
     * @var int
     *
     * @ORM\Column(name="TIV", type="integer")
     */
    private $tIV;

    /**
     * @var string
     *
     * @ORM\Column(name="MS", type="decimal", precision=3, scale=3)
     */
    private $mS;


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
     * @return main_chart_data_MS
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
     * @return main_chart_data_MS
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
     * @return main_chart_data_MS
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
     * @return main_chart_data_MS
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
     * Set tIV
     *
     * @param integer $tIV
     *
     * @return main_chart_data_MS
     */
    function setTIV($tIV) 
    {
        
        $this->tIV = $tIV;
        
        return $this;
    }
    
    /**
     * Get tIV
     *
     * @return int
     */
    function getTIV() 
    {
        return $this->tIV;
    }
    
    /**
     * Set mS
     *
     * @param string $mS
     *
     * @return main_chart_data_MS
     */
    public function setMS($mS)
    {
        $this->mS = $mS;

        return $this;
    }

    /**
     * Get mS
     *
     * @return string
     */
    public function getMS()
    {
        return $this->mS;
    }
}

