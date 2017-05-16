<?php

namespace CustomerPortalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Passenger
 *
 * @ORM\Table(name="passenger")
 * @ORM\Entity(repositoryClass="CustomerPortalBundle\Repository\PassengerRepository")
 */
class Passenger
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=4)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=255)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="surname", type="string", length=255)
     */
    private $surname;

    /**
     * @var string
     *
     * @ORM\Column(name="passportid", type="string", length=20, unique=true)
     */
    private $passportid;


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
     * Set title
     *
     * @param string $title
     * @return Passenger
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     * @return Passenger
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string 
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set surname
     *
     * @param string $surname
     * @return Passenger
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get surname
     *
     * @return string 
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Set passportid
     *
     * @param string $passportid
     * @return Passenger
     */
    public function setPassportid($passportid)
    {
        $this->passportid = $passportid;

        return $this;
    }

    /**
     * Get passportid
     *
     * @return string 
     */
    public function getPassportid()
    {
        return $this->passportid;
    }
}
