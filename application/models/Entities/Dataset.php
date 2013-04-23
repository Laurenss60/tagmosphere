<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entities\Dataset
 */
class Dataset
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $name
     */
    private $name;

    /**
     * @var string $url
     */
    private $url;

    /**
     * @var string $nametag
     */
    private $nametag;

    /**
     * @var datetime $updated
     */
    private $updated;

    /**
     * @var Entities\Category
     */
    private $category;


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
     * @return Dataset
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
     * Set url
     *
     * @param string $url
     * @return Dataset
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set nametag
     *
     * @param string $nametag
     * @return Dataset
     */
    public function setNametag($nametag)
    {
        $this->nametag = $nametag;
        return $this;
    }

    /**
     * Get nametag
     *
     * @return string 
     */
    public function getNametag()
    {
        return $this->nametag;
    }

    /**
     * Set updated
     *
     * @param datetime $updated
     * @return Dataset
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
        return $this;
    }

    /**
     * Get updated
     *
     * @return datetime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set category
     *
     * @param Entities\Category $category
     * @return Dataset
     */
    public function setCategory(\Entities\Category $category = null)
    {
        $this->category = $category;
        return $this;
    }

    /**
     * Get category
     *
     * @return Entities\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }
}