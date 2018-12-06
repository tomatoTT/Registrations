<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TerytPow
 *
 * @ORM\Table(name="teryt_pow")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TerytPowRepository")
 */
class TerytPow
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
     * @ORM\Column(name="CountyCode", type="string", length=255)
     */
    private $countyCode;

    /**
     * @var string
     *
     * @ORM\Column(name="CountyName", type="string", length=255, nullable=true)
     */
    private $countyName;
    
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
     * Set countyCode
     *
     * @param string $countyCode
     *
     * @return TerytPow
     */
    public function setCountyCode($countyCode)
    {
        $this->countyCode = $countyCode;

        return $this;
    }

    /**
     * Get countyCode
     *
     * @return string
     */
    public function getCountyCode()
    {
        return $this->teryt;
    }

    /**
     * Set countyName
     *
     * @param string $countyName
     *
     * @return TerytPow
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
}