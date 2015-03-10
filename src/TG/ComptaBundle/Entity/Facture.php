<?php

namespace TG\ComptaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * facture
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="TG\ComptaBundle\Entity\factureRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Facture
{
    /**
     * @ORM\ManyToOne(targetEntity="TG\ProdBundle\Entity\Projet", inversedBy="factures")
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
     * @ORM\Column(name="extention", type="string", length=255)
     */
    private $extention;

    /**
     * @ORM\Column(name="alt", type="string", length=255)
     */
    private $alt;

    /**
     * @ORM\Column(name="infos", type="text")
     */
    private $infos;

    /**
     * @var integer
     *
     * @ORM\Column(name="numero", type="integer")
     */
    private $numero;

    /**
     * @var integer
     *
     * @ORM\Column(name="montantHT", type="integer")
     */
    private $montantHT;

    /**
     * @var integer
     *
     * @ORM\Column(name="tva", type="integer")
     */
    private $tva;

    /**
     * @var integer
     *
     * @ORM\Column(name="netapayer", type="integer")
     */
    private $netapayer;

    /**
    * @var \DateTime
    *
    * @ORM\Column(name="dateadd", type="datetime")
    * @Assert\DateTime()
    */
    private $dateadd;

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
     * Set numero
     *
     * @param integer $numero
     * @return facture
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero
     *
     * @return integer 
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set montantHT
     *
     * @param integer $montantHT
     * @return facture
     */
    public function setMontantHT($montantHT)
    {
        $this->montantHT = $montantHT;

        return $this;
    }

    /**
     * Get montantHT
     *
     * @return integer 
     */
    public function getMontantHT()
    {
        return $this->montantHT;
    }

    /**
     * Set tva
     *
     * @param integer $tva
     * @return facture
     */
    public function setTva($tva)
    {
        $this->tva = $tva;

        return $this;
    }

    /**
     * Get tva
     *
     * @return integer 
     */
    public function getTva()
    {
        return $this->tva;
    }

    /**
     * Set netapayer
     *
     * @param integer $netapayer
     * @return facture
     */
    public function setNetapayer($netapayer)
    {
        $this->netapayer = $netapayer;

        return $this;
    }

    /**
     * Get netapayer
     *
     * @return integer 
     */
    public function getNetapayer()
    {
        return $this->netapayer;
    }

    /**
     * Set extention
     *
     * @param string $extention
     * @return Facture
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
     * @return Facture
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
     * @return Facture
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
     * Set projet
     *
     * @param \TG\ProdBundle\Entity\Projet $projet
     * @return Facture
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
    // Si jamais il n'y a pas de fichier (champ facultatif)
    if (null === $this->file) {
      return;
    }

    // Le nom du fichier est son id, on doit juste stocker également son extension
    // Pour faire propre, on devrait renommer cet attribut en « extension », plutôt que « extention »
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
      'Facture'.$this->id.'.'.$this->extention   // Le nom du fichier à créer, ici « id.extension »
    );
  }

  /**
   * @ORM\PreRemove()
   */
  public function preRemoveUpload()
  {
    // On sauvegarde temporairement le nom du fichier, car il dépend de l'id
    $this->tempFilename = $this->getUploadRootDir().'/'.$this->getProjet()->getClient()->getSlug().'/'.$this->getProjet()->getSlug().'/'.'Facture'.$this->id.'.'.$this->extention;
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
    return $this->getUploadDir().'/'.$this->getProjet()->getClient()->getSlug().'/'.$this->getProjet()->getSlug().'/'.'Facture'.$this->id.'.'.$this->extention;
  }

    /**
     * Set dateadd
     *
     * @param \DateTime $dateadd
     * @return Facture
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
