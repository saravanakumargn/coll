<?php

namespace DataAdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use APY\DataGridBundle\Grid\Mapping as GRID;

// php bin/console doctrine:generate:entities DataAdminBundle/Entity/CollegeBranches

/**
 * DataAdminBundle\Entity\CollegeBranches
 *
 * @ORM\Table(name="college_branches")
 * @ORM\Entity
 * 
 */
class CollegeBranches {

    /**
     * @ORM\Column(type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;
    
    /**
     * @var integer $collegeId
     *
     * @ORM\Column(name="college_id", type="string", length=255)
     */
    private $collegeId;
    
    /**
     * @var integer $branchId
     *
     * @ORM\Column(name="branch_id", type="string", length=255)
     */
    private $branchId;
    
    /**
     * @var text $approvedIntake
     *
     * @ORM\Column(name="approved_intake", type="integer", length=5,  nullable=true, options={"default"=0})
     */
    private $approvedIntake;    
    
    /**
     * @var text $startingYear
     *
     * @ORM\Column(name="starting_year", type="integer", length=5,  nullable=true, options={"default"=0})
     */
    private $startingYear;    
        
    /**
     * @var text $nbaAccredited
     *
     * @ORM\Column(name="nba_accredited", type="boolean", options={"default"=false})
     */
    private $nbaAccredited;      
    
    /**
     * @var integer $accreditationValid
     *
     * @ORM\Column(name="accreditation_valid", type="string", length=60)
     */
    private $accreditationValid;    
}
