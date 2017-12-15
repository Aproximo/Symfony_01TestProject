<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;




/**
 * @ORM\Entity
 * @ORM\Table(name="accounts")
 */
class Accounts
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="fill the title please")
     */
    private $account;


    /**
     * @ORM\Column(type="string")
     */
    private $date_added;


    /**
     *@ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="accounts")
     * @ORM\JoinTable(
     *     joinColumns={@ORM\JoinColumn(onDelete="CASCADE")})
     */
    private $user;




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
     * Set account
     *
     * @param string $account
     *
     * @return Accounts
     */
    public function setAccount($account)
    {
        $this->account = $account;

        return $this;
    }

    /**
     * Get account
     *
     * @return string
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * Set dateAdded
     *
     * @param string $dateAdded
     *
     * @return Accounts
     */
    public function setDateAdded($dateAdded)
    {
        $this->date_added = $dateAdded;

        return $this;
    }

    /**
     * Get dateAdded
     *
     * @return string
     */
    public function getDateAdded()
    {
        return $this->date_added;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Accounts
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
