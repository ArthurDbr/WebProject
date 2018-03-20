<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * Users
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UsersRepository")
 */
class Users extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var int
     *
     * @ORM\Column(name="age", type="integer", nullable=true)
     */
    protected $age;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=true)
     */
    protected $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255, nullable=true)
     */
    protected $prenom;

    /**
     * @var theme
     *
     * @ORM\Column(name="theme", type="string", length=255, nullable=true)
     */
    protected $theme = 'United';

    /**
    * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Evenement", cascade={"persist", "remove"})
    *
    */

    private $listeEvenement;

    public function __construct(){
        $this->listeEvenement = new ArrayCollection();
    }

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
     * Get age
     *
     * @return int
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set age
     *
     * @param int $age
     *
     * @return users
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return users
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     *
     * @return users
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }



    

    /**
     * Add listeEvenement
     *
     * @param \AppBundle\Entity\Evenement $listeEvenement
     *
     * @return Users
     */
    public function addListeEvenement(\AppBundle\Entity\Evenement $listeEvenement)
    {
        $this->listeEvenement[] = $listeEvenement;

        return $this;
    }

    /**
     * Remove listeEvenement
     *
     * @param \AppBundle\Entity\Evenement $listeEvenement
     */
    public function removeListeEvenement(\AppBundle\Entity\Evenement $listeEvenement)
    {
        $this->listeEvenement->removeElement($listeEvenement);
    }

    /**
     * Get listeEvenement
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getListeEvenement()
    {
        return $this->listeEvenement;
    }

    /**
     * Set theme
     *
     * @param string $theme
     *
     * @return Users
     */
    public function setTheme($theme)
    {
        $this->theme = $theme;

        return $this;
    }

    /**
     * Get theme
     *
     * @return string
     */
    public function getTheme()
    {
        return $this->theme;
    }
}
