<?php

namespace TG\CreaBundle\Entity;

use TG\ClientBundle\Entity\Client;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Logo
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="TG\CreaBundle\Entity\LogoRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Logo
{
    /**
     * @ORM\ManyToOne(targetEntity="TG\ClientBundle\Entity\Client", inversedBy="logos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="extention", type="string", length=255)
     */
    private $extention;

    /**
     * @ORM\Column(name="alt", type="string", length=255)
     */
    private $alt;

    /**
     * @ORM\Column(name="infos", type="text", nullable=true)
     */
    private $infos;

    /**
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
     * @return Logo
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
     * @return Logo
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
     * @return Logo
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
    // Si jamais il n'y a pas de fichier (champ facultatif)
    if (null === $this->file) {
      return;
    }

    // Le nom du fichier est son id, on doit juste stocker également son extension
    $this->extention = $this->file->guessExtension();

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
      $this->getClient()->getSlug().'-logo'.$this->id.'.'.$this->extention   // Le nom du fichier à créer, ici « id.extension »
    );
  }

  /**
   * @ORM\PreRemove()
   */
  public function preRemoveUpload()
  {
    // On sauvegarde temporairement le nom du fichier, car il dépend de l'id
    $this->tempFilename = $this->getUploadRootDir().'/'.$this->getClient()->getSlug().'/'.$this->getClient()->getSlug().'-logo'.$this->getId().'.'.$this->getExtention();
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
    return __DIR__.'/../../../../web/'.$this->getUploadDir().'/'.$this->getClient()->getSlug();
  }

  public function getWebPath() //pour l'affichage TWIG
  {
    return $this->getUploadDir().'/'.$this->getClient()->getSlug().'/'.$this->getClient()->getSlug().'-logo'.$this->getId().'.'.$this->getExtention();
  }

    /**
     * Set client
     *
     * @param \TG\ClientBundle\Entity\Client $client
     * @return Logo
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
     * Set date
     *
     * @param \dateTime $date
     * @return Logo
     */
    public function setDate(\dateTime $date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \dateTime 
     */
    public function getDate()
    {
        return $this->date;
    }
}
