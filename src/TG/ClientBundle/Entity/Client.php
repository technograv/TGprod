<?php

namespace TG\ClientBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Client
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="TG\ClientBundle\Entity\ClientRepository")
 * @UniqueEntity(fields="name", message="Un client de ce nom existe déjà.")
 * @ORM\HasLifecycleCallbacks()
 */
class Client
{
    /**
     * @ORM\oneToMany(targetEntity="TG\ProdBundle\Entity\Projet", mappedBy="client", cascade={"remove"})
     */
    private $projets;

    /**
     * @ORM\oneToMany(targetEntity="TG\ClientBundle\Entity\Contact", mappedBy="client", cascade={"remove"})
     */
    private $contacts;

    /**
     * @ORM\OneToMany(targetEntity="TG\CreaBundle\Entity\Logo", mappedBy="client", cascade={"persist", "remove"})
     * @Assert\Valid()
     */
    private $logos;

    /**
    * @Gedmo\Slug(fields={"name"})
    * @ORM\Column(length=128, unique=true)
    */
    private $slug;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     * @Assert\Length(min=2)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=255)
     * @Assert\Length(min=2)
     */
    private $adresse;

    /**
     * @var integer
     *
     * @ORM\Column(name="cp", type="string", length=5)
     * @Assert\Length(min=5, max=5)
     * @Assert\Regex(pattern="#^((0[1-9])|([1-8][0-9])|(9[0-8]))[0-9]{3}$#", message="Ne doit pas commencer par 00 et doit comporter 5 chiffres.")
     */
    private $cp;

    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=255)
     * @Assert\Length(min=1)
     */
    private $ville;

    /**
     * @var string
     *
     * @ORM\Column(name="pays", type="string", length=255)
     * @Assert\Length(min=4)
     */
    private $pays;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=255, nullable=true)
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="useradd", type="string", length=255, nullable=false)
     */
    private $useradd;

    /**
     * @var string
     *
     * @ORM\Column(name="usermodif", type="string", length=255, nullable=true)
     */
    private $usermodif = null;

    /**
     * @var string
     *
     * @ORM\Column(name="siret", type="string", length=14, nullable=true)
     * @Assert\Length(min=14, max=14)
     * @Assert\Regex(pattern="#^[0-9]{14}$#", message="Doit comporter 14 chiffres.")
     */
    private $siret;

    /**
     * @var string
     *
     * @ORM\Column(name="notes", type="text", nullable=true)
     */
    private $notes;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateadd", type="datetime")
     * @Assert\DateTime()
     */
    private $dateadd;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datemodif", type="datetime", nullable=true)
     * @Assert\DateTime()
     */
    private $datemodif;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="maj", type="datetime")
     * @Assert\DateTime()
     */
    private $maj;

     /**
     * @var string
     *
     * @ORM\Column(name="nbprojets", type="smallint", nullable=true)
     */
    private $nbprojets = 0;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Client
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     * @return Client
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string 
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set cp
     *
     * @param integer $cp
     * @return Client
     */
    public function setCp($cp)
    {
        $this->cp = $cp;

        return $this;
    }

    /**
     * Get cp
     *
     * @return integer 
     */
    public function getCp()
    {
        return $this->cp;
    }

    /**
     * Set ville
     *
     * @param string $ville
     * @return Client
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return string 
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set pays
     *
     * @param string $pays
     * @return Client
     */
    public function setPays($pays)
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * Get pays
     *
     * @return string 
     */
    public function getPays()
    {
        return $this->pays;
    }

    /**
     * Set code
     *
     * @param string $code
     * @return Client
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string 
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set siret
     *
     * @param string $siret
     * @return Client
     */
    public function setSiret($siret)
    {
        $this->siret = $siret;

        return $this;
    }

    /**
     * Get siret
     *
     * @return string 
     */
    public function getSiret()
    {
        return $this->siret;
    }

    /**
     * Set notes
     *
     * @param string $notes
     * @return Client
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;

        return $this;
    }

    /**
     * Get notes
     *
     * @return string 
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Set dateadd
     *
     * @param \DateTime $dateadd
     * @return Client
     */
    public function setDateadd($dateadd)
    {
        $this->dateadd = $dateadd;

        return $this;
    }

    /**
     * Get dateadd
     *
     * @return \DateTime 
     */
    public function getDateadd()
    {
        return $this->dateadd;
    }

    /**
     * Get datemodif
     *
     * @return \DateTime 
     */
    public function getDatemodif()
    {
        return $this->datemodif;
    }

    public function __construct()
    {
        $this->dateadd = new \DateTime('now');
        $this->pays = 'France';
        $this->projets = new ArrayCollection();
        $this->contacts = new ArrayCollection();
        $this->logos = new ArrayCollection();
        $this->maj = new \DateTime('now');
    }

    /**
     * Set datemodif
     * @ORM\PreUpdate
     * @param \DateTime $datemodif
     * @return Client
     */
    public function setDatemodif()
    {
        $this->datemodif = new \DateTime('now');

        return $this;
    }

    /**
     * Set maj
     * @ORM\PreUpdate
     * @param \DateTime $maj
     * @return Client
     */
    public function setMaj($maj)
    {
        if ($this->getDatemodif() !== null) {
            $maj = $this->getDatemodif();
        }
        else {
       }
        
        $this->maj = $maj;

        return $this;
    }

    /**
     * Get maj
     *
     * @return \DateTime 
     */
    public function getMaj()
    {
        return $this->maj;
    }

    /**
     * Add projets
     *
     * @param \TG\ProdBundle\Entity\Projet $projets
     * @return Client
     */
    public function addProjet(\TG\ProdBundle\Entity\Projet $projets)
    {
        $this->projets[] = $projets;

        $projet->setClient($this);

        return $this;
    }

    /**
     * Remove projets
     *
     * @param \TG\ProdBundle\Entity\Projet $projets
     */
    public function removeProjet(\TG\ProdBundle\Entity\Projet $projets)
    {
        $this->projets->removeElement($projets);
    }

    /**
     * Get projets
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProjets()
    {
        return $this->projets;
    }

    public function increaseProjet()
    {
        $this->nbprojets++;
    }

    public function decreaseProjet()
    {
        $this->nbprojets--;
    }

    /**
     * Set nbprojets
     *
     * @param integer $nbprojets
     * @return Client
     */
    public function setNbprojets($nbprojets)
    {
        $this->nbprojets = $nbprojets;

        return $this;
    }

    /**
     * Get nbprojets
     *
     * @return integer 
     */
    public function getNbprojets()
    {
        return $this->nbprojets;
    }

    /**
     * Add logos
     *
     * @param \TG\CreaBundle\Entity\Logo $logos
     * @return Client
     */
    public function addLogo(\TG\CreaBundle\Entity\Logo $logos)
    {
        $this->logos[] = $logos;

        $logos->setClient($this);

        return $this;
    }

    /**
     * Remove logos
     *
     * @param \TG\CreaBundle\Entity\Logo $logos
     */
    public function removeLogo(\TG\CreaBundle\Entity\Logo $logos)
    {
        $this->logos->removeElement($logos);
    }

    /**
     * Get logos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLogos()
    {
        return $this->logos->toArray();
    }

    /**
     * Set useradd
     *
     * @param string $useradd
     * @return Client
     */
    public function setUseradd($useradd)
    {
        $this->useradd = $useradd;

        return $this;
    }

    /**
     * Get useradd
     *
     * @return string 
     */
    public function getUseradd()
    {
        return $this->useradd;
    }

    /**
     * Set usermodif
     *
     * @param string $usermodif
     * @return Client
     */
    public function setUsermodif($usermodif)
    {
        $this->usermodif = $usermodif;

        return $this;
    }

    /**
     * Get usermodif
     *
     * @return string 
     */
    public function getUsermodif()
    {
        return $this->usermodif;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Client
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Add contacts
     *
     * @param \TG\ClientBundle\Entity\Contact $contacts
     * @return Client
     */
    public function addContact(\TG\ClientBundle\Entity\Contact $contacts)
    {
        $this->contacts[] = $contacts;

        $contact->setClient($this);

        return $this;
    }

    /**
     * Remove contacts
     *
     * @param \TG\ClientBundle\Entity\Contact $contacts
     */
    public function removeContact(\TG\ClientBundle\Entity\Contact $contacts)
    {
        $this->contacts->removeElement($contacts);
    }

    /**
     * Get contacts
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getContacts()
    {
        return $this->contacts->toArray();
    }
}
