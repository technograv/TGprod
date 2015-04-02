<?php

namespace TG\ClientBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Contact
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="TG\ClientBundle\Entity\ContactRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Contact
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="TG\ClientBundle\Entity\Client", inversedBy="contacts")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Valid()
     */
    private $client;

    /**
     * @var string
     *
     * @ORM\Column(name="civilite", type="string", length=30, nullable=true)
     * @Assert\Length(max=4)
     */
    private $civilite;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\Length(min=4)
     */
    private $name;

     /**
     * @ORM\Column(name="defaut", type="boolean")
     * @Assert\Type(type="bool")
     */
    private $defaut = false;

    /**
     * @var string
     *
     * @ORM\Column(name="tel", type="string", length=10)
     * @Assert\Length(min=10, max=10)
     * @Assert\Regex(pattern="#^0[1-9][0-9]{8}$#", message="Doit commencer par 0 et comporter 10 chiffres.")
     */
    private $tel;

    /**
     * @var string
     *
     * @ORM\Column(name="portable", type="string", length=10, nullable=true)
     * @Assert\Length(min=10, max=10)
     * @Assert\Regex(pattern="#^0[1-9][0-9]{8}$#", message="Doit commencer par 0 et comporter 10 chiffres.")
     */
    private $portable;

    /**
     * @var string
     *
     * @ORM\Column(name="fax", type="string", length=10, nullable=true)
     * @Assert\Length(min=10, max=10)
     * @Assert\Regex(pattern="#^0[1-9][0-9]{8}$#", message="Doit commencer par 0 et comporter 10 chiffres.")
     */
    private $fax;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     * @Assert\Email()
     */
    private $email;

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
     * @return Contact
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
     * Set tel
     *
     * @param string $tel
     * @return Contact
     */
    public function setTel($tel)
    {
        $this->tel = $tel;

        return $this;
    }

    /**
     * Get tel
     *
     * @return string 
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * Set portable
     *
     * @param string $portable
     * @return Contact
     */
    public function setPortable($portable)
    {
        $this->portable = $portable;

        return $this;
    }

    /**
     * Get portable
     *
     * @return string 
     */
    public function getPortable()
    {
        return $this->portable;
    }

    /**
     * Set client
     *
     * @param \TG\ClientBundle\Entity\Client $client
     * @return Contact
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
     * Set email
     *
     * @param string $email
     * @return Contact
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set fax
     *
     * @param string $fax
     * @return Contact
     */
    public function setFax($fax)
    {
        $this->fax = $fax;

        return $this;
    }

    /**
     * Get fax
     *
     * @return string 
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * Set defaut
     *
     * @param boolean $defaut
     * @return Contact
     */
    public function setDefaut($defaut)
    {
        $this->defaut = $defaut;

        return $this;
    }

    /**
     * Get defaut
     *
     * @return boolean 
     */
    public function getDefaut()
    {
        return $this->defaut;
    }

    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Set civilite
     *
     * @param string $civilite
     * @return Contact
     */
    public function setCivilite($civilite)
    {
        $this->civilite = $civilite;

        return $this;
    }

    /**
     * Get civilite
     *
     * @return string 
     */
    public function getCivilite()
    {
        return $this->civilite;
    }
}
