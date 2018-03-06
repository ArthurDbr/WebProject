<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Evenement
 *
 * @ORM\Table(name="evenement")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\evenementRepository")
 */
class Evenement
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
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="lieu", type="string", length=255)
     */
    private $lieu;

    /**
     * @var int
     *
     * @ORM\Column(name="idPersonne", type="integer")
     */
    private $idPersonne;

    /**
     * @var int
     *
     * @ORM\Column(name="idTypeEvenement", type="integer")
     */
    private $idTypeEvenement;


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
     * Set description
     *
     * @param string $description
     *
     * @return evenement
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set lieu
     *
     * @param string $lieu
     *
     * @return evenement
     */
    public function setLieu($lieu)
    {
        $this->lieu = $lieu;

        return $this;
    }

    /**
     * Get lieu
     *
     * @return string
     */
    public function getLieu()
    {
        return $this->lieu;
    }

    /**
     * Set idPersonne
     *
     * @param integer $idPersonne
     *
     * @return evenement
     */
    public function setIdPersonne($idPersonne)
    {
        $this->idPersonne = $idPersonne;

        return $this;
    }

    /**
     * Get idPersonne
     *
     * @return int
     */
    public function getIdPersonne()
    {
        return $this->idPersonne;
    }

    /**
     * Set idTypeEvenement
     *
     * @param integer $idTypeEvenement
     *
     * @return evenement
     */
    public function setIdTypeEvenement($idTypeEvenement)
    {
        $this->idTypeEvenement = $idTypeEvenement;

        return $this;
    }

    /**
     * Get idTypeEvenement
     *
     * @return int
     */
    public function getIdTypeEvenement()
    {
        return $this->idTypeEvenement;
    }
}

