<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Labels
 *
 * @ORM\Table(name="labels")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LabelsRepository")
 */
class Labels
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
     * @ORM\Column(name="MonthYear", type="string", length=255)
     */
    private $monthYear;


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
     * Set monthYear
     *
     * @param string $monthYear
     *
     * @return Labels
     */
    public function setMonthYear($monthYear)
    {
        $this->monthYear = $monthYear;

        return $this;
    }

    /**
     * Get monthYear
     *
     * @return string
     */
    public function getMonthYear()
    {
        return $this->monthYear;
    }
}

