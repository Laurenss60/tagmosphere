<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entities\PhotoTag
 */
class PhotoTag
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var Entities\Photo
     */
    private $photo;

    /**
     * @var Entities\Tag
     */
    private $tag;


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
     * @param Entities\Photo $photo
     * @return PhotoTag
     */
    public function setPhoto(\Entities\Photo $photo = null)
    {
        $this->photo = $photo;
        return $this;
    }

    /**
     * Get photo
     *
     * @return Entities\Photo 
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Set tag
     *
     * @param Entities\Tag $tag
     * @return PhotoTag
     */
    public function setTag(\Entities\Tag $tag = null)
    {
        $this->tag = $tag;
        return $this;
    }

    /**
     * Get tag
     *
     * @return Entities\Tag 
     */
    public function getTag()
    {
        return $this->tag;
    }
}