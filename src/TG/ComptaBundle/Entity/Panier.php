<?php

namespace TG\ComptaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Panier
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="TG\ComptaBundle\Entity\PanierRepository")
 */
class Panier
{
    /**
     * @ORM\ManyToOne(targetEntity="TG\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Valid()
     */
    private $user;

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
     * @ORM\Column(name="chantier", type="string", length=255, nullable=false)
     */
    private $chantier;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;


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
     * Set chantier
     *
     * @param string $chantier
     *
     * @return Panier
     */
    public function setChantier($chantier)
    {
        $this->chantier = $chantier;

        return $this;
    }

    /**
     * Get chantier
     *
     * @return string
     */
    public function getChantier()
    {
        return $this->chantier;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Panier
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
     * Set user
     *
     * @param \TG\UserBundle\Entity\User $user
     *
     * @return Panier
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
}
