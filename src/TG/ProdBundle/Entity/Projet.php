<?php

namespace TG\ProdBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Projet
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="TG\ProdBundle\Entity\ProjetRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Projet
{
    /**
     * @ORM\ManyToOne(targetEntity="TG\ProdBundle\Entity\Etape")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Valid()
     */
    private $etape;

    /**
     * @ORM\ManyToOne(targetEntity="TG\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Valid()
     */
     private $assign;

    /**
     * @ORM\ManyToOne(targetEntity="TG\ClientBundle\Entity\Contact")
     * @Assert\Valid()
     */
     private $contact;

    /**
     * @ORM\ManyToOne(targetEntity="TG\ProdBundle\Entity\Projet")
     * @Assert\Valid()
     */
    private $projetparent;

    /**
     * @ORM\ManyToOne(targetEntity="TG\UserBundle\Entity\User", inversedBy="projets")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Valid()
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="TG\ProdBundle\Entity\Type")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Valid()
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="TG\ClientBundle\Entity\Client", inversedBy="projets")
     * @Assert\Valid()
     */
    private $client;

    /**
     * @ORM\OneToMany(targetEntity="TG\ProdBundle\Entity\Commentaire", mappedBy="projet", cascade={"persist", "remove"})
     * @Assert\Valid()
     */
    private $commentaires;

    /**
     * @ORM\OneToMany(targetEntity="TG\ComptaBundle\Entity\Devis", mappedBy="projet", cascade={"persist", "remove"})
     * @Assert\Valid()
     */
    private $devix;

    /**
     * @ORM\OneToMany(targetEntity="TG\ComptaBundle\Entity\Facture", mappedBy="projet", cascade={"persist", "remove"})
     * @Assert\Valid()
     */
    private $factures;

    /**
     * @ORM\OneToMany(targetEntity="TG\CreaBundle\Entity\Crea", mappedBy="projet", cascade={"persist", "remove"})
     * @Assert\Valid()
     */
    private $creas;

    /**
     * @ORM\OneToMany(targetEntity="TG\ProdBundle\Entity\Documentjoint", mappedBy="projet", cascade={"persist", "remove"})
     * @Assert\Valid()
     */
    private $documentjoints;

    /**
    * @Gedmo\Slug(fields={"titre"})
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
     * @ORM\Column(name="published", type="boolean")
     * @Assert\Type(type="bool")
     */
    private $published = true;

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
     * @ORM\Column(name="delai", type="datetime", nullable=true)
     * @Assert\DateTime()
     */
    private $delai;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="avancement", type="datetime", nullable=true)
     * @Assert\DateTime()
     */
    private $avancement;

     /**
     * @var string
     *
     * @ORM\Column(name="livraison", type="string", length=255)
     */
    private $livraison;

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
     * @ORM\Column(name="usermodif", type="string", nullable=true)
     */
    private $usermodif;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255)
     * @Assert\Length(min=5)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="text")
     * @Assert\NotBlank()
     */
    private $contenu;

    /**
     * @var string
     *
     * @ORM\Column(name="recap", type="text")
     * @Assert\NotBlank()
     */
    private $recap;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="maj", type="datetime")
     * @Assert\DateTime()
     */
    private $maj;

    /**
     * @ORM\Column(name="nbcommentaires", type="smallint", nullable=true)
     */
    private $nbcommentaires = 0;


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
     * Set titre
     *
     * @param string $titre
     * @return Projet
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string 
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set contenu
     *
     * @param string $contenu
     * @return Projet
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Get contenu
     *
     * @return string 
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * Set recap
     *
     * @param string $recap
     * @return Projet
     */
    public function setRecap($recap)
    {
        $this->recap = $recap;

        return $this;
    }

    /**
     * Get recap
     *
     * @return string 
     */
    public function getRecap()
    {
        return $this->recap;
    }

    /**
     * Set published
     *
     * @param boolean $published
     * @return Projet
     */
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * Get published
     *
     * @return boolean 
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * Set delai
     *
     * @param \DateTime $delai
     * @return Projet
     */
    public function setDelai($delai)
    {
        $this->delai = $delai;

        return $this;
    }

    /**
     * Get delai
     *
     * @return \DateTime 
     */
    public function getDelai()
    {
        return $this->delai;
    }

    /**
     * Set avancement
     *
     * @param \DateTime $avancement
     * @return Projet
     */
    public function setAvancement($avancement)
    {
        $this->avancement = $avancement;

        return $this;
    }

    /**
     * Get avancement
     *
     * @return \DateTime
     */
    public function getAvancement()
    {
        return $this->avancement;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Projet
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set etape
     *
     * @param string $etape
     * @return Projet
     */
    public function setEtape($etape)
    {
        $this->etape = $etape;

        return $this;
    }

    /**
     * Get etape
     *
     * @return string 
     */
    public function getEtape()
    {
        return $this->etape;
    }

      public function __construct()
    {
        $this->dateadd = new \DateTime('now');
        $this->devix = new ArrayCollection();
        $this->factures = new ArrayCollection();
        $this->creas = new ArrayCollection();
        $this->maj = new \DateTime('now');
        $this->commentaires = new ArrayCollection();
        $this->documentjoints = new ArrayCollection();
    }

    /**
     * Set client
     *
     * @param \TG\ClientBundle\Entity\Client $client
     * @return Projet
     */
    public function setClient(\TG\ClientBundle\Entity\Client $client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client
     *
     * @return \TG\ClientBundle\Entity\Client 
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
    * @ORM\PreUpdate
    */
    public function linkProjet()
    {
        $linkprojet = $this->getProjetparent();

        if ($linkprojet !== null)
        {
            if ($linkprojet->getProjetparent() !== null)
            {
            $newlinkprojet = $linkprojet->getProjetparent();
            $this->setProjetparent($newlinkprojet);
            }
        }
    }

    /**
    * @ORM\PrePersist
    */
    public function increaseProjet()
    {
        $this->getClient()->increaseProjet();
    }

    /**
    * @ORM\PreRemove
    */
    public function decrease()
    {
        $this->getClient()->decreaseProjet();
    }

    /**
     * Set dateadd
     *
     * @param \DateTime $dateadd
     * @return Projet
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
     * Set datemodif
     *
     * @param \DateTime $datemodif
     * @return Projet
     */
    public function setDatemodif()
    {
        $this->datemodif = new \DateTime('now');

        return $this;
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

    /**
     * Add devix
     *
     * @param \TG\ComptaBundle\Entity\Devis $devix
     * @return Projet
     */
    public function addDevis(\TG\ComptaBundle\Entity\Devis $devix)
    {
        $this->devix[] = $devix;

        $devix->setProjet($this);

        return $this;
    }

    /**
     * Remove devix
     *
     * @param \TG\ComptaBundle\Entity\Devis $devix
     */
    public function removeDevis(\TG\ComptaBundle\Entity\Devis $devix)
    {
        $this->devix->removeElement($devix);
    }

    /**
     * Get devix
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDevix()
    {
        return $this->devix->toArray();
    }

    /**
     * Add factures
     *
     * @param \TG\ComptaBundle\Entity\Facture $factures
     * @return Projet
     */
    public function addFacture(\TG\ComptaBundle\Entity\Facture $factures)
    {
        $this->factures[] = $factures;

        $factures->setProjet($this);

        return $this;
    }

    /**
     * Remove factures
     *
     * @param \TG\ComptaBundle\Entity\Facture $factures
     */
    public function removeFacture(\TG\ComptaBundle\Entity\Facture $factures)
    {
        $this->factures->removeElement($factures);
    }

    /**
     * Get factures
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFactures()
    {
        return $this->factures->toArray();
    }

    /**
     * Add creas
     *
     * @param \TG\CreaBundle\Entity\Crea $creas
     * @return Projet
     */
    public function addCrea(\TG\CreaBundle\Entity\Crea $creas)
    {
        $this->creas[] = $creas;

        $creas->setProjet($this);

        return $this;
    }

    /**
     * Remove creas
     *
     * @param \TG\CreaBundle\Entity\Crea $creas
     */
    public function removeCrea(\TG\CreaBundle\Entity\Crea $creas)
    {
        $this->creas->removeElement($creas);
    }

    /**
     * Get creas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCreas()
    {
        return $this->creas->toArray();
    }

    /**
     * Set maj
     * @ORM\PreUpdate
     * @param \DateTime $maj
     * @return Projet
     */
    public function setMaj($maj)
    {
        if ($this->getDatemodif() === null) {
            $maj = $this->getDateadd();
        }
        else {
            $maj = $this->getDatemodif();
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

    public function increaseCommentaire()
    {
        $this->nbcommentaires++;
    }

    public function decreaseCommentaire()
    {
        $this->nbcommentaires--;
    }

    /**
     * Set nbcommentaires
     *
     * @param integer $nbcommentaires
     * @return Projet 
     */
    public function setNbcommentaires($nbcommentaires)
    {
        $this->nbcommentaires = $nbcommentaires;

        return $this;
    }

    /**
     * Get nbcommentaires
     *
     * @return integer 
     */
    public function getNbcommentaires()
    {
        return $this->nbcommentaires;
    }

    /**
     * Add commentaires
     *
     * @param \TG\ProdBundle\Entity\Commentaire $commentaires
     * @return Projet
     */
    public function addCommentaire(\TG\ProdBundle\Entity\Commentaire $commentaires)
    {
        $this->commentaires[] = $commentaires;

        return $this;
    }

    /**
     * Remove commentaires
     *
     * @param \TG\ProdBundle\Entity\Commentaire $commentaires
     */
    public function removeCommentaire(\TG\ProdBundle\Entity\Commentaire $commentaires)
    {
        $this->commentaires->removeElement($commentaires);
    }

    /**
     * Get commentaires
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCommentaires()
    {
        return $this->commentaires;
    }

    /**
     * Add devix
     *
     * @param \TG\ComptaBundle\Entity\Devis $devix
     * @return Projet
     */
    public function addDevix(\TG\ComptaBundle\Entity\Devis $devix)
    {
        $this->devix[] = $devix;

        $devix->setProjet($this);

        return $this;
    }

    /**
     * Remove devix
     *
     * @param \TG\ComptaBundle\Entity\Devis $devix
     */
    public function removeDevix(\TG\ComptaBundle\Entity\Devis $devix)
    {
        $this->devix->removeElement($devix);
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Projet
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
     * Set projet
     *
     * @param \TG\ProdBundle\Entity\Projet $projet
     * @return Projet
     */
    public function setProjetparent(\TG\ProdBundle\Entity\Projet $projetparent = null)
    {
        $this->projetparent = $projetparent;

        return $this;
    }

    /**
     * Get projet
     *
     * @return \TG\ProdBundle\Entity\Projet 
     */
    public function getProjetparent()
    {
        return $this->projetparent;
    }

    /**
     * Set user
     *
     * @param \TG\UserBundle\Entity\User $user
     * @return Projet
     */
    public function setUser(\TG\UserBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \TG\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set assign
     *
     * @param \TG\UserBundle\Entity\User $assign
     * @return Projet
     */
    public function setAssign(\TG\UserBundle\Entity\User $assign)
    {
        $this->assign = $assign;

        return $this;
    }

    /**
     * Get assign
     *
     * @return \TG\UserBundle\Entity\User 
     */
    public function getAssign()
    {
        return $this->assign;
    }

    /**
     * Add documentjoints
     *
     * @param \TG\ProdBundle\Entity\Documentjoint $documentjoints
     * @return Projet
     */
    public function addDocumentjoint(\TG\ProdBundle\Entity\Documentjoint $documentjoints)
    {
        $this->documentjoints[] = $documentjoints;

        $documentjoints->setProjet($this);

        return $this;
    }

    /**
     * Remove documentjoints
     *
     * @param \TG\ProdBundle\Entity\Documentjoint $documentjoints
     */
    public function removeDocumentjoint(\TG\ProdBundle\Entity\Documentjoint $documentjoints)
    {
        $this->documentjoints->removeElement($documentjoints);
    }

    /**
     * Get documentjoints
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDocumentjoints()
    {
        return $this->documentjoints->toArray();
    }

    /**
     * Set contact
     *
     * @param \TG\ClientBundle\Entity\contact $contact
     * @return Projet
     */
    public function setContact(\TG\ClientBundle\Entity\contact $contact)
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * Get contact
     *
     * @return \TG\ClientBundle\Entity\contact 
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * Set livraison
     *
     * @param string $livraison
     * @return Projet
     */
    public function setLivraison($livraison)
    {
        $this->livraison = $livraison;

        return $this;
    }

    /**
     * Get livraison
     *
     * @return string 
     */
    public function getLivraison()
    {
        return $this->livraison;
    }

    /**
     * Set usermodif
     *
     * @param string $usermodif
     *
     * @return Projet
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
}
