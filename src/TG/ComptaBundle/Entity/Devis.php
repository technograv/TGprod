<?php

namespace TG\ComptaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Devis
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="TG\ComptaBundle\Entity\DevisRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Devis
{
    /**
     * @ORM\ManyToOne(targetEntity="TG\ProdBundle\Entity\Projet", inversedBy="devix")
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
     * @ORM\Column(name="infos", type="text", nullable=true)
     */
    private $infos;

    /**
     * @var integer
     *
     * @ORM\Column(name="numero", type="string", length=255, nullable=true)
     */
    private $numero;

    /**
     * @var integer
     *
     * @ORM\Column(name="prixHT", type="integer", nullable=true)
     * @Assert\Regex(pattern="#^[\d]*[,]?[\d]{2}$#", message="Le format du Prix HT n'est pas correct ex: 123,45")
     */
    private $prixHT;

    /**
     * @var integer
     *
     * @ORM\Column(name="tva", type="integer", nullable=true)
     * @Assert\Regex(pattern="#^[\d]*[,]?[\d]{2}$#", message="Le format de la TVA n'est pas correct ex: 123,45")
     */
    private $tva;

    /**
     * @var integer
     *
     * @ORM\Column(name="prixttc", type="integer", nullable=true)
     * @Assert\Regex(pattern="#^[\d]*[,]?[\d]{2}$#", message="Le format du Prix TTC n'est pas correct ex: 123,45")
     */
    private $prixttc;

    /**
     * @var integer
     *
     * @ORM\Column(name="acompte", type="integer", nullable=true)
     * @Assert\Regex(pattern="#^[\d]*[,]?[\d]{2}$#", message="Le format de l'acompte n'est pas correct ex: 123,45")
     */
    private $acompte;

    /**
    * @var \DateTime
    *
    * @ORM\Column(name="dateadd", type="datetime")
    * @Assert\DateTime()
    */
    private $dateadd;

    /**
     * @Assert\File(maxSize="1M", mimeTypes={"application/pdf", "application/x-pdf"})
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
     * Set numero
     *
     * @param integer $numero
     * @return Devis
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
     * Set prixHT
     *
     * @param integer $prixHT
     * @return Devis
     */
    public function setPrixHT($prixHT)
    {
        $this->prixHT = $prixHT;

        return $this;
    }

    /**
     * Get prixHT
     *
     * @return integer 
     */
    public function getPrixHT()
    {
        return $this->prixHT;
    }

    /**
     * Set tva
     *
     * @param integer $tva
     * @return Devis
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
     * Set prixttc
     *
     * @param integer $prixttc
     * @return Devis
     */
    public function setPrixttc($prixttc)
    {
        $this->prixttc = $prixttc;

        return $this;
    }

    /**
     * Get prixttc
     *
     * @return integer 
     */
    public function getPrixttc()
    {
        return $this->prixttc;
    }

    /**
     * Set acompte
     *
     * @param integer $acompte
     * @return Devis
     */
    public function setAcompte($acompte)
    {
        $this->acompte = $acompte;

        return $this;
    }

    /**
     * Get acompte
     *
     * @return integer 
     */
    public function getAcompte()
    {
        return $this->acompte;
    }

    /**
     * Set extention
     *
     * @param string $extention
     * @return Devis
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
     * @return Devis
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
     * @return Devis
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
     * @return Devis
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
      'Devis'.$this->id.'.'.$this->extention   // Le nom du fichier à créer, ici « id.extension »
    );
  }

  /**
   * @ORM\PreRemove()
   */
  public function preRemoveUpload()
  {
    // On sauvegarde temporairement le nom du fichier, car il dépend de l'id
    $this->tempFilename = $this->getUploadRootDir().'/'.$this->getProjet()->getClient()->getSlug().'/'.$this->getProjet()->getSlug().'/'.'Devis'.$this->id.'.'.$this->extention;
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
    return $this->getUploadDir().'/'.$this->getProjet()->getClient()->getSlug().'/'.$this->getProjet()->getSlug().'/'.'Devis'.$this->id.'.'.$this->extention;
  }

    /**
     * Set dateadd
     *
     * @param \DateTime $dateadd
     * @return Devis
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
