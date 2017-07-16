<?php

namespace DataAdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use APY\DataGridBundle\Grid\Mapping as GRID;

// php bin/console doctrine:generate:entities DataAdminBundle/Entity/University

/**
 * DataAdminBundle\Entity\University
 *
 * @ORM\Table(name="university")
 * @ORM\Entity
 * 
 */
class University {

    /**
     * @ORM\Column(type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @var text $content
     *
     * @ORM\Column(name="university_name_ta", type="string", length=100, nullable=false)
     * @GRID\Column(field="universityNameTa", size=150, title="University Name Tamil")
     */
    private $universityNameTa;    
    /**
     * @var text $content
     *
     * @ORM\Column(name="university_name_en", type="string", length=100, nullable=false)
     * @GRID\Column(field="universityNameEn", size=150, title="University Name English")
     */
    private $universityNameEn;


    /**
     * Get id
     *
     * @return guid
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set universityNameTa
     *
     * @param string $universityNameTa
     *
     * @return University
     */
    public function setUniversityNameTa($universityNameTa)
    {
        $this->universityNameTa = $universityNameTa;

        return $this;
    }

    /**
     * Get universityNameTa
     *
     * @return string
     */
    public function getUniversityNameTa()
    {
        return $this->universityNameTa;
    }

    /**
     * Set universityNameEn
     *
     * @param string $universityNameEn
     *
     * @return University
     */
    public function setUniversityNameEn($universityNameEn)
    {
        $this->universityNameEn = $universityNameEn;

        return $this;
    }

    /**
     * Get universityNameEn
     *
     * @return string
     */
    public function getUniversityNameEn()
    {
        return $this->universityNameEn;
    }
}
