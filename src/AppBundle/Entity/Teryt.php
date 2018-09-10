<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Teryt
 *
 * @ORM\Table(name="teryt")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TerytRepository")
 */
class Teryt
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
     * @var int
     *
     * @ORM\Column(name="Woj", type="integer")
     */
    private $woj;

    /**
     * @var int
     *
     * @ORM\Column(name="Pow", type="integer", nullable=true)
     */
    private $pow;

    /**
     * @var int
     *
     * @ORM\Column(name="Gmi", type="integer", nullable=true)
     */
    private $gmi;

    /**
     * @var int
     *
     * @ORM\Column(name="Rodz", type="integer", nullable=true)
     */
    private $rodz;

    /**
     * @var string
     *
     * @ORM\Column(name="Nazwa", type="string", length=255)
     */
    private $nazwa;

    /**
     * @var string
     *
     * @ORM\Column(name="Nazwa_Dod", type="string", length=255)
     */
    private $nazwaDod;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Stan_Na", type="date")
     */
    private $stanNa;


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
     * Set woj
     *
     * @param integer $woj
     *
     * @return Teryt
     */
    public function setWoj($woj)
    {
        $this->woj = $woj;

        return $this;
    }

    /**
     * Get woj
     *
     * @return int
     */
    public function getWoj()
    {
        return $this->woj;
    }

    /**
     * Set pow
     *
     * @param integer $pow
     *
     * @return Teryt
     */
    public function setPow($pow)
    {
        $this->pow = $pow;

        return $this;
    }

    /**
     * Get pow
     *
     * @return int
     */
    public function getPow()
    {
        return $this->pow;
    }

    /**
     * Set gmi
     *
     * @param integer $gmi
     *
     * @return Teryt
     */
    public function setGmi($gmi)
    {
        $this->gmi = $gmi;

        return $this;
    }

    /**
     * Get gmi
     *
     * @return int
     */
    public function getGmi()
    {
        return $this->gmi;
    }

    /**
     * Set rodz
     *
     * @param integer $rodz
     *
     * @return Teryt
     */
    public function setRodz($rodz)
    {
        $this->rodz = $rodz;

        return $this;
    }

    /**
     * Get rodz
     *
     * @return int
     */
    public function getRodz()
    {
        return $this->rodz;
    }

    /**
     * Set nazwa
     *
     * @param string $nazwa
     *
     * @return Teryt
     */
    public function setNazwa($nazwa)
    {
        $this->nazwa = $nazwa;

        return $this;
    }

    /**
     * Get nazwa
     *
     * @return string
     */
    public function getNazwa()
    {
        return $this->nazwa;
    }

    /**
     * Set nazwaDod
     *
     * @param string $nazwaDod
     *
     * @return Teryt
     */
    public function setNazwaDod($nazwaDod)
    {
        $this->nazwaDod = $nazwaDod;

        return $this;
    }

    /**
     * Get nazwaDod
     *
     * @return string
     */
    public function getNazwaDod()
    {
        return $this->nazwaDod;
    }

    /**
     * Set stanNa
     *
     * @param \DateTime $stanNa
     *
     * @return Teryt
     */
    public function setStanNa($stanNa)
    {
        $this->stanNa = $stanNa;

        return $this;
    }

    /**
     * Get stanNa
     *
     * @return \DateTime
     */
    public function getStanNa()
    {
        return $this->stanNa;
    }
}

