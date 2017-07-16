<?php

namespace DataAdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use APY\DataGridBundle\Grid\Mapping as GRID;

// php bin/console doctrine:generate:entities DataAdminBundle/Entity/Branch

/**
 * DataAdminBundle\Entity\Course
 *
 * @ORM\Table(name="branch")
 * @ORM\Entity
 * 
 */
class Branch {

    /**
     * @ORM\Column(type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @var text $content
     *
     * @ORM\Column(name="branch_name_ta", type="string", length=100, nullable=false)
     * @GRID\Column(field="branchNameTa", size=150, title="Branch Name Tamil")
     */
    private $branchNameTa;   
    
    /**
     * @var text $content
     *
     * @ORM\Column(name="branch_name_en", type="string", length=100, nullable=false)
     * @GRID\Column(field="branchNameEn", size=150, title="Branch Name English")
     */
    private $branchNameEn;
    /**
     * @var text $viewCount
     *
     * @ORM\Column(name="branch_code", type="string", length=10, nullable=false)
     */
    private $branchCode;
    

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
     * Set branchNameTa
     *
     * @param string $branchNameTa
     *
     * @return Branch
     */
    public function setBranchNameTa($branchNameTa)
    {
        $this->branchNameTa = trim($branchNameTa);

        return $this;
    }

    /**
     * Get branchNameTa
     *
     * @return string
     */
    public function getBranchNameTa()
    {
        return $this->branchNameTa;
    }

    /**
     * Set branchNameEn
     *
     * @param string $branchNameEn
     *
     * @return Branch
     */
    public function setBranchNameEn($branchNameEn)
    {
        $this->branchNameEn = trim($branchNameEn);

        return $this;
    }

    /**
     * Get branchNameEn
     *
     * @return string
     */
    public function getBranchNameEn()
    {
        return $this->branchNameEn;
    }

    /**
     * Set branchCode
     *
     * @param string $branchCode
     *
     * @return Branch
     */
    public function setBranchCode($branchCode)
    {
        $this->branchCode = trim($branchCode);

        return $this;
    }

    /**
     * Get branchCode
     *
     * @return string
     */
    public function getBranchCode()
    {
        return $this->branchCode;
    }
}
