<?php

namespace TG\ComptaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Dimension
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="TG\ComptaBundle\Entity\DimensionRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Dimension
{
    /**
     * @ORM\ManyToMany(targetEntity="TG\ComptaBundle\Entity\Stock", cascade={"persist"})
     */
    private $stocks;

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
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="longueur", type="integer", nullable=false)
     */
    private $longueur;

    /**
     * @var integer
     *
     * @ORM\Column(name="largeur", type="integer", nullable=false)
     */
    private $largeur;


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
     * Set longueur
     *
     * @param integer $longueur
     *
     * @return Dimension
     */
    public function setLongueur($longueur)
    {
        $this->longueur = $longueur;

        return $this;
    }

    /**
     * Get longueur
     *
     * @return integer
     */
    public function getLongueur()
    {
        return $this->longueur;
    }

    /**
     * Set largeur
     *
     * @param integer $largeur
     *
     * @return Dimension
     */
    public function setLargeur($largeur)
    {
        $this->largeur = $largeur;

        return $this;
    }

    /**
     * Get largeur
     *
     * @return integer
     */
    public function getLargeur()
    {
        return $this->largeur;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->stocks = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add stock
     *
     * @param \TG\ComptaBundle\Entity\Stock $stock
     *
     * @return Dimension
     */
    public function addStock(\TG\ComptaBundle\Entity\Stock $stock)
    {
        $this->stocks[] = $stock;

        return $this;
    }

    /**
     * Remove stock
     *
     * @param \TG\ComptaBundle\Entity\Stock $stock
     */
    public function removeStock(\TG\ComptaBundle\Entity\Stock $stock)
    {
        $this->stocks->removeElement($stock);
    }

    /**
     * Get stocks
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getStocks()
    {
        return $this->stocks;
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
    * @ORM\PrePersist
    */
    public function SetName()
    {
        $this->name = $this->getLongueur().' x '.$this->getLargeur();

        return $this;
    }

    /**
     * Add besoin
     *
     * @param \TG\ComptaBundle\Entity\Besoin $besoin
     *
     * @return Dimension
     */
    public function addBesoin(\TG\ComptaBundle\Entity\Besoin $besoin)
    {
        $this->besoins[] = $besoin;

        return $this;
    }

    /**
     * Remove besoin
     *
     * @param \TG\ComptaBundle\Entity\Besoin $besoin
     */
    public function removeBesoin(\TG\ComptaBundle\Entity\Besoin $besoin)
    {
        $this->besoins->removeElement($besoin);
    }

    /**
     * Get besoins
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBesoins()
    {
        return $this->besoins;
    }
}
