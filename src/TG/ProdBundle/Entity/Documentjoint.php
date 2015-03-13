<?php

namespace TG\ProdBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Documentjoint
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="TG\ProdBundle\Entity\DocumentjointRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Documentjoint
{
    /**
     * @ORM\ManyToOne(targetEntity="TG\ProdBundle\Entity\Projet", inversedBy="documentjoints")
     * @ORM\JoinColumn(name="projet_id", referencedColumnName="id", nullable=false)
     */
    private $projet;

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
     * @ORM\Column(name="extention", type="string", length=255)
     */
    private $extention;

    /**
     * @var string
     *
     * @ORM\Column(name="alt", type="string", length=255)
     */
    private $alt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    private $file;

    private $tempFilename;

    public function __construct()
    {
      $this->date = new \DateTime('now');
    }

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
     * Set extention
     *
     * @param string $extention
     * @return Documentjoint
     */
    public function setExtention($extention)
    {
        $this->extention = $extention;

        return $this;
    }

    /**
     * Get extention
     *
     * @return string 
     */
    public function getExtention()
    {
        return $this->extention;
    }

    /**
     * Set alt
     *
     * @param string $alt
     * @return Documentjoint
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;

        return $this;
    }

    /**
     * Get alt
     *
     * @return string 
     */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Documentjoint
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set projet
     *
     * @param \TG\ProdBundle\Entity\Projet $projet
     * @return Documentjoint
     */
    public function setProjet(\TG\ProdBundle\Entity\Projet $projet)
    {
        $this->projet = $projet;

        return $this;
    }

    /**
     * Get projet
     *
     * @return \TG\ProdBundle\Entity\Projet 
     */
    public function getProjet()
    {
        return $this->projet;
    }

        public function getFile()
    {
        return $this->file;
    }

        public function setFile(UploadedFile $file)
        {
        $this->file = $file;

        // On vérifie si on avait déjà un fichier pour cette entité
        if (null !== $this->extention) {
          // On sauvegarde l'extension du fichier pour le supprimer plus tard
          $this->tempFilename = $this->extention;

          // On réinitialise les valeurs des attributs extention et alt
          $this->extention = null;
          $this->alt = null;
        }
      }

      /**
       * @ORM\PrePersist()
       * @ORM\PreUpdate()
       */
      public function preUpload()
      {
        if (null === $this->file) {
          return;
        }

        $this->extention = $this->file->guessExtension();

        $this->alt = $this->file->getClientOriginalName();
      }

      /**
       * @ORM\PostPersist()
       * @ORM\PostUpdate()
       */
      public function upload()
      {
        if (null === $this->file) {
          return;
        }

        $this->file->move(
          $this->getUploadRootDir(),
          'Piece_jointe'.$this->id.'.'.$this->extention
        );
      }

      /**
       * @ORM\PreRemove()
       */
      public function preRemoveUpload()
      {
        $this->tempFilename = $this->getUploadRootDir().'/'.$this->getProjet()->getClient()->getSlug().'/'.$this->getProjet()->getSlug().'/'.'Piece_jointe'.$this->id.'.'.$this->extention;
      }

      /**
       * @ORM\PostRemove()
       */
      public function removeUpload()
      {
        if (file_exists($this->tempFilename)) {
          unlink($this->tempFilename);
        }
      }

      public function getUploadDir()
      {
        return 'uploads';
      }

      protected function getUploadRootDir()
      {
        return __DIR__.'/../../../../web/'.$this->getUploadDir().'/'.$this->getProjet()->getClient()->getSlug().'/'.$this->getProjet()->getSlug();
      }

      public function getWebPath()
      {
        return $this->getUploadDir().'/'.$this->getProjet()->getClient()->getSlug().'/'.$this->getProjet()->getSlug().'/'.'Piece_jointe'.$this->id.'.'.$this->extention;
      }
    }
