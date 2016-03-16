<?php

namespace TG\ComptaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Stock
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="TG\ComptaBundle\Entity\StockRepository")
 */
class Stock
{
    /**
     * @ORM\ManyToMany(targetEntity="TG\ComptaBundle\Entity\Dimension", cascade={"persist"})
     * @ORM\OrderBy({"name" = "ASC"})
     */
    private $dimensions;

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
     * @ORM\Column(name="prix", type="integer", nullable=false)
     */
    private $prix;

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
     *
     * @return Stock
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
     * Set prix
     *
     * @param integer $prix
     *
     * @return Stock
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return integer
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->dimensions = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add dimension
     *
     * @param \TG\ComptaBundle\Entity\Dimension $dimension
     *
     * @return Stock
     */
    public function addDimension(\TG\ComptaBundle\Entity\Dimension $dimension)
    {
        $this->dimensions[] = $dimension;

        return $this;
    }

    /**
     * Remove dimension
     *
     * @param \TG\ComptaBundle\Entity\Dimension $dimension
     */
    public function removeDimension(\TG\ComptaBundle\Entity\Dimension $dimension)
    {
        $this->dimensions->removeElement($dimension);
    }

    /**
     * Get dimensions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDimensions()
    {
        return $this->dimensions->toArray();
    }
}
