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
     * @ORM\Column(name="Teryt", type="string", length=255)
     */
    private $teryt;

    /**
     * @var string
     *
     * @ORM\Column(name="Powiat", type="string", length=255, nullable=true)
     */
    private $powiat;

    /**
     * @var string
     *
     * @ORM\Column(name="FullTeryt", type="string", length=255, nullable=true)
     */
    private $fullTeryt;
    
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
     * Set teryt
     *
     * @param string $teryt
     *
     * @return TerytPow
     */
    public function setTeryt($teryt)
    {
        $this->teryt = $teryt;

        return $this;
    }

    /**
     * Get teryt
     *
     * @return string
     */
    public function getTeryt()
    {
        return $this->teryt;
    }

    /**
     * Set powiat
     *
     * @param string $powiat
     *
     * @return TerytPow
     */
    public function setPowiat($powiat)
    {
        $this->powiat = $powiat;

        return $this;
    }

    /**
     * Get powiat
     *
     * @return string
     */
    public function getPowiat()
    {
        return $this->powiat;
    }
    
    /**
     * Set fullTeryt
     *
     * @param string $fullTeryt
     *
     * @return TerytPow
     */
    function setFullTeryt($fullTeryt)
    {
        $this->fullTeryt = $fullTeryt;
        
        return $this;
    }
    
    /**
     * Get fullTeryt
     *
     * @return string
     */
    function getFullTeryt()
    {
        return $this->fullTeryt;
    }
}

