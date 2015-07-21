<?php

namespace TG\ComptaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Besoin
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="TG\ComptaBundle\Entity\BesoinRepository")
 */
class Besoin
{
    /**
     * @ORM\ManyToOne(targetEntity="TG\ComptaBundle\Entity\Stock")
     * @ORM\JoinColumn(nullable=false)
     */
    private $stock;

    /**
     * @ORM\ManyToOne(targetEntity="TG\ComptaBundle\Entity\Dimension")
     * @ORM\JoinColumn(nullable=false)
     */
    private $dimension;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="nombre", type="integer")
     */
    private $nombre;

    /**
    * @var \DateTime
    *
    * @ORM\Column(name="dateadd", type="datetime")
    * @Assert\DateTime()
    */
    private $dateadd;


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
     * Set nombre
     *
     * @param integer $nombre
     *
     * @return Besoin
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return integer
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set stock
     *
     * @param \TG\ComptaBundle\Entity\Stock $stock
     *
     * @return Besoin
     */
    public function setStock(\TG\ComptaBundle\Entity\Stock $stock)
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * Get stock
     *
     * @return \TG\ComptaBundle\Entity\Stock
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * Set dimension
     *
     * @param \TG\ComptaBundle\Entity\Dimension $dimension
     *
     * @return Besoin
     */
    public function setDimension(\TG\ComptaBundle\Entity\Dimension $dimension)
    {
        $this->dimension = $dimension;

        return $this;
    }

    /**
     * Get dimension
     *
     * @return \TG\ComptaBundle\Entity\Dimension
     */
    public function getDimension()
    {
        return $this->dimension;
    }

    /**
     * Set dateadd
     *
     * @param \DateTime $dateadd
     *
     * @return Besoin
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
