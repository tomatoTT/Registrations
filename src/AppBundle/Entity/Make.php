<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Make
 *
 * @ORM\Table(name="make")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MakeRepository")
 */
class Make
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
     * @ORM\Column(name="Make", type="string", length=255, unique=true)
     */
    private $make;
    
    /**
     *
     * @var string
     * 
     * @ORM\Column(name="Color", type="string", length=255, unique=true) 
     */
    private $color;


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
     * @return Make
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
     * Set color
     *
     * @param string $color
     *
     * @return Color
     */
    function setColor($color) 
    {
        $this->color = $color;
        
        return $this;
    }
    
    /**
     * Get color
     *
     * @return string
     */
    function getColor() 
    {
        return $this->color;
    }
    
}

