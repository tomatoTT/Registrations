<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MainChartDataMSPowiat
 *
 * @ORM\Table(name="main_chart_data_m_s_powiat")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MainChartDataMSPowiatRepository")
 */
class MainChartDataMSPowiat
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
     * @var string
     *
     * @ORM\Column(name="countyName", type="string", length=255)
     */
    private $countyName;

    /**
     * @var int
     *
     * @ORM\Column(name="Units", type="integer")
     */
    private $units;
    
    /**
     * @var string
     *
     * @ORM\Column(name="countyCode", type="string", length=255)
     */
    private $countyCode;

    /**
     * @var int
     *
     * @ORM\Column(name="TIV", type="integer")
     */
    private $tIV;


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
     * @return MainChartDataMSPowiat
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
     * @return MainChartDataMSPowiat
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
     * @return MainChartDataMSPowiat
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
     * Set countyName
     *
     * @param string $countyName
     *
     * @return MainChartDataMSPowiat
     */
    public function setCountyName($countyName)
    {
        $this->countyName = $countyName;

        return $this;
    }

    /**
     * Get countyName
     *
     * @return string
     */
    public function getCountyName()
    {
        return $this->countyName;
    }

    /**
     * Set units
     *
     * @param integer $units
     *
     * @return MainChartDataMSPowiat
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
     * @return MainChartDataMSPowiat
     */
    public function setTIV($tIV)
    {
        $this->tIV = $tIV;

        return $this;
    }

    /**
     * Get tIV
     *
     * @return int
     */
    public function getTIV()
    {
        return $this->tIV;
    }
    
    /**
     * Set countyCode
     *
     * @param string $countyCode
     *
     * @return MainChartDataMSPowiat
     */
    function setCountyCode($countyCode)
    {
        $this->countyCode = $countyCode;
        
        return $this;
    }
    
    /**
     * Get countyCode
     *
     * @return string
     */
    function getCountyCode()
    {
        return $this->countyCode;
    }
}

