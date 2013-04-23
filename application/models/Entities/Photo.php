<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entities\Photo
 */
class Photo
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var text $photo
     */
    private $photo;

    /**
     * @var integer $atmosphere
     */
    private $atmosphere;

    /**
     * @var datetime $created
     */
    private $created;

    /**
     * @var Entities\User
     */
    private $user;

    /**
     * @var Entities\Location
     */
    private $location;


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
     * Set photo
     *
     * @param text $photo
     * @return Photo
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
        return $this;
    }

    /**
     * Get photo
     *
     * @return text 
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Set atmosphere
     *
     * @param integer $atmosphere
     * @return Photo
     */
    public function setAtmosphere($atmosphere)
    {
        $this->atmosphere = $atmosphere;
        return $this;
    }

    /**
     * Get atmosphere
     *
     * @return integer 
     */
    public function getAtmosphere()
    {
        return $this->atmosphere;
    }

    /**
     * Set created
     *
     * @param datetime $created
     * @return Photo
     */
    public function setCreated($created)
    {
        $this->created = $created;
        return $this;
    }

    /**
     * Get created
     *
     * @return datetime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set user
     *
     * @param Entities\User $user
     * @return Photo
     */
    public function setUser(\Entities\User $user = null)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * Get user
     *
     * @return Entities\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set location
     *
     * @param Entities\Location $location
     * @return Photo
     */
    public function setLocation(\Entities\Location $location = null)
    {
        $this->location = $location;
        return $this;
    }

    /**
     * Get location
     *
     * @return Entities\Location 
     */
    public function getLocation()
    {
        return $this->location;
    }
}