<?php

namespace TG\CreaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Crea
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="TG\CreaBundle\Entity\CreaRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Crea
{ 
    /**
     * @ORM\ManyToOne(targetEntity="TG\ProdBundle\Entity\Projet", inversedBy="creas")
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
     * @var string
     *
     * @ORM\Column(name="infos", type="text", nullable=true)
     */
    private $infos;

    /**
    * @var \DateTime
    *
    * @ORM\Column(name="dateadd", type="datetime")
    * @Assert\DateTime()
    */
    private $dateadd;

    /**
     * @Assert\File(maxSize="150M", mimeTypes={"application/pdf", "application/x-pdf", "jpeg", "image/png", "image/vnd.adobe.photoshop", "image/jpeg", "application/octet-stream", "application/postscript", "image/bmp", "application/zip", "application/x-cdlink", "image/x-icon"})
     */
    private $file;

    private $tempFilename;

    public function __construct()
    {
      $this->dateadd = new \DateTime('now');
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
     * @return Crea
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
     * @return Crea
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
     * Set infos
     *
     * @param string $infos
     * @return Crea
     */
    public function setInfos($infos)
    {
        $this->infos = $infos;

        return $this;
    }

    /**
     * Get infos
     *
     * @return string 
     */
    public function getInfos()
    {
        return $this->infos;
    }

    /**
     * Get file
     *
     * @return string 
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set projet
     *
     * @param \TG\ProdBundle\Entity\Projet $projet
     * @return Crea
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
    // Si jamais il n'y a pas de fichier (champ facultatif)
    if (null === $this->file) {
      return;
    }

    // Le nom du fichier est son id, on doit juste stocker également son extension
    // Pour faire propre, on devrait renommer cet attribut en « extension », plutôt que « extention »
    $this->extention = $this->file->getClientOriginalExtension();

    // Et on génère l'attribut alt de la balise <img>, à la valeur du nom du fichier sur le PC de l'internaute
    $this->alt = $this->file->getClientOriginalName();
  }

  /**
   * @ORM\PostPersist()
   * @ORM\PostUpdate()
   */
  public function upload()
  {
    // Si jamais il n'y a pas de fichier (champ facultatif)
    if (null === $this->file) {
      return;
    }

    // On déplace le fichier envoyé dans le répertoire de notre choix
    $this->file->move(
      $this->getUploadRootDir(), // Le répertoire de destination
      'Compo'.$this->id.'.'.$this->extention   // Le nom du fichier à créer, ici « id.extension »
    );
  }

  /**
   * @ORM\PreRemove()
   */
  public function preRemoveUpload()
  {
    // On sauvegarde temporairement le nom du fichier, car il dépend de l'id
    $this->tempFilename = $this->getUploadRootDir().'/'.'Compo'.$this->id.'.'.$this->extention;
  }

  /**
   * @ORM\PostRemove()
   */
  public function removeUpload()
  {
    // En PostRemove, on n'a pas accès à l'id, on utilise notre nom sauvegardé
    if (file_exists($this->tempFilename)) {
      // On supprime le fichier
      unlink($this->tempFilename);
    }
  }

  public function getUploadDir()
  {
    // On retourne le chemin relatif vers l'image pour un navigateur
    return 'uploads';
  }

  protected function getUploadRootDir()
  {
    // On retourne le chemin relatif vers l'image pour notre code PHP
    return __DIR__.'/../../../../web/'.$this->getUploadDir().'/'.$this->getProjet()->getClient()->getSlug().'/'.$this->getProjet()->getSlug();
  }

  public function getWebPath() //pour l'affichage TWIG
  {
    return $this->getUploadDir().'/'.$this->getProjet()->getClient()->getSlug().'/'.$this->getProjet()->getSlug().'/'.'Compo'.$this->id.'.'.$this->extention;
  }

    /**
     * Set dateadd
     *
     * @param \DateTime $dateadd
     * @return Crea
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
}
