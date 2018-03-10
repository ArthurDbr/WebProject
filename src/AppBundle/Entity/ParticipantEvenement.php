<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ParticipantEvenement
 *
 * @ORM\Table(name="participant_evenement")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ParticipantEvenementRepository")
 */
class ParticipantEvenement
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
     * @ORM\Column(name="idPersonne", type="integer")
     */
    private $idPersonne;

    /**
     * @var int
     *
     * @ORM\Column(name="idEvenement", type="integer")
     */
    private $idEvenement;


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
     * Set idPersonne
     *
     * @param integer $idPersonne
     *
     * @return ParticipantEvenement
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
     * Set idEvenement
     *
     * @param integer $idEvenement
     *
     * @return ParticipantEvenement
     */
    public function setIdEvenement($idEvenement)
    {
        $this->idEvenement = $idEvenement;

        return $this;
    }

    /**
     * Get idEvenement
     *
     * @return int
     */
    public function getIdEvenement()
    {
        return $this->idEvenement;
    }
}

