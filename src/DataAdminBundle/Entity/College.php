<?php

namespace DataAdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use APY\DataGridBundle\Grid\Mapping as GRID;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

// php bin/console doctrine:generate:entities DataAdminBundle/Entity/College

/**
 * DataAdminBundle\Entity\College
 *
 * @ORM\Table(name="college")
 * @ORM\Entity
 * @UniqueEntity("tnea_code")
 * @UniqueEntity("page_url")
 * 
 */
class College {

    /**
     * @ORM\Column(type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;
    /**
     * @var text $collegeName
     *
     * @ORM\Column(name="college_name", type="string", length=100, nullable=false)
     */
    private $collegeName;   
    /**
     * @var text $tneaCode
     *
     * @ORM\Column(name="tnea_code", type="integer", length=6, nullable=false, unique=true)
     */
    private $tneaCode;   
    /**
     * @var string $pageUrl
     *
     * @ORM\Column(name="page_url", type="string", length=100, nullable=true, unique=true)
     */
    private $pageUrl;
    /**
     * @var text $content
     *
     * @ORM\Column(name="full_address", type="string", length=200, nullable=false)
     * @GRID\Column(field="fullAddress", size=150, title="Address English")
     */
    private $fullAddress;
    /**
     * @var text $district
     *
     * @ORM\Column(name="district", type="string", length=64, nullable=true)
     */
    private $district;       
    /**
     * @var text $viewCount
     *
     * @ORM\Column(name="pincode", type="integer", length=6,  nullable=false)
     */
    private $pincode;   
    /**
     * @var text $content
     *
     * @ORM\Column(name="phone_no", type="string", length=32, nullable=true)
     */
    private $phoneNo;    
    /**
     * @var text $content
     *
     * @ORM\Column(name="fax_no", type="string", length=32, nullable=true)
     */
    private $faxNo;    
    /**
     * @var text $content
     *
     * @ORM\Column(name="email_id", type="string", length=60, nullable=true)
     */
    private $emailId;    
    /**
     * @var text $content
     *
     * @ORM\Column(name="website_name", type="string", length=60, nullable=true)
     */
    private $website;  
    
    /**
     * @var string $lat
     *
     * @ORM\Column(name="lat", type="decimal", precision=26, scale=4, nullable=true)
     */
    private $lat;

    /**
     * @var string $lng
     *
     * @ORM\Column(name="lng", type="decimal", precision=26, scale=4, nullable=true)
     */
    private $lng;      
    
    /**
     * @var text $isActive
     *
     * @ORM\Column(name="is_active", type="boolean", options={"default"=true})
     */
    private $isActive;    

    /**
     * @ORM\Column(type="datetime")
     */
    private $modifiedon;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdon;

    /**
     * @var text $viewed
     *
     * @ORM\Column(name="viewed", type="integer", length=5,  nullable=true, options={"default"=0})
     */
    private $viewed;    
    
    private function seoUrl($str) {
        if ($str !== mb_convert_encoding(mb_convert_encoding($str, 'UTF-32', 'UTF-8'), 'UTF-8', 'UTF-32'))
            $str = mb_convert_encoding($str, 'UTF-8', mb_detect_encoding($str));
        $str = htmlentities($str, ENT_NOQUOTES, 'UTF-8');
        $str = preg_replace('`&([a-z]{1,2})(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig);`i', '\1', $str);
        $str = html_entity_decode($str, ENT_NOQUOTES, 'UTF-8');
        $str = preg_replace(array('`[^a-z0-9]`i', '`[-]+`'), '-', $str);
        $str = strtolower(trim($str, '-'));
        return $str;
    }    
    public function __construct() {
        $this->setCreatedon(new \DateTime());
        if ($this->getModifiedon() == null) {
            $this->setModifiedon(new \DateTime());
        }
    }    

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function updateModifiedDatetime() {
        // update the modified time
        $this->setModifiedon(new \DateTime());
    }    


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
     * Set collegeName
     *
     * @param string $collegeName
     *
     * @return College
     */
    public function setCollegeName($collegeName)
    {
        $this->collegeName = $collegeName;

        return $this;
    }

    /**
     * Get collegeName
     *
     * @return string
     */
    public function getCollegeName()
    {
        return $this->collegeName;
    }

    /**
     * Set tneaCode
     *
     * @param integer $tneaCode
     *
     * @return College
     */
    public function setTneaCode($tneaCode)
    {
        $this->tneaCode = $tneaCode;

        return $this;
    }

    /**
     * Get tneaCode
     *
     * @return integer
     */
    public function getTneaCode()
    {
        return $this->tneaCode;
    }

    /**
     * Set pageUrl
     *
     * @param string $pageUrl
     *
     * @return College
     */
    public function setPageUrl($pageUrl)
    {
        $this->pageUrl = $pageUrl;

        return $this;
    }

    /**
     * Get pageUrl
     *
     * @return string
     */
    public function getPageUrl()
    {
        return $this->pageUrl;
    }

    /**
     * Set fullAddress
     *
     * @param string $fullAddress
     *
     * @return College
     */
    public function setFullAddress($fullAddress)
    {
        $this->fullAddress = $fullAddress;

        return $this;
    }

    /**
     * Get fullAddress
     *
     * @return string
     */
    public function getFullAddress()
    {
        return $this->fullAddress;
    }

    /**
     * Set district
     *
     * @param string $district
     *
     * @return College
     */
    public function setDistrict($district)
    {
        $this->district = $district;

        return $this;
    }

    /**
     * Get district
     *
     * @return string
     */
    public function getDistrict()
    {
        return $this->district;
    }

    /**
     * Set pincode
     *
     * @param integer $pincode
     *
     * @return College
     */
    public function setPincode($pincode)
    {
        $this->pincode = $pincode;

        return $this;
    }

    /**
     * Get pincode
     *
     * @return integer
     */
    public function getPincode()
    {
        return $this->pincode;
    }

    /**
     * Set phoneNo
     *
     * @param string $phoneNo
     *
     * @return College
     */
    public function setPhoneNo($phoneNo)
    {
        $this->phoneNo = $phoneNo;

        return $this;
    }

    /**
     * Get phoneNo
     *
     * @return string
     */
    public function getPhoneNo()
    {
        return $this->phoneNo;
    }

    /**
     * Set faxNo
     *
     * @param string $faxNo
     *
     * @return College
     */
    public function setFaxNo($faxNo)
    {
        $this->faxNo = $faxNo;

        return $this;
    }

    /**
     * Get faxNo
     *
     * @return string
     */
    public function getFaxNo()
    {
        return $this->faxNo;
    }

    /**
     * Set emailId
     *
     * @param string $emailId
     *
     * @return College
     */
    public function setEmailId($emailId)
    {
        $this->emailId = $emailId;

        return $this;
    }

    /**
     * Get emailId
     *
     * @return string
     */
    public function getEmailId()
    {
        return $this->emailId;
    }

    /**
     * Set website
     *
     * @param string $website
     *
     * @return College
     */
    public function setWebsite($website)
    {
        $this->website = $website;

        return $this;
    }

    /**
     * Get website
     *
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Set lat
     *
     * @param string $lat
     *
     * @return College
     */
    public function setLat($lat)
    {
        $this->lat = $lat;

        return $this;
    }

    /**
     * Get lat
     *
     * @return string
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * Set lng
     *
     * @param string $lng
     *
     * @return College
     */
    public function setLng($lng)
    {
        $this->lng = $lng;

        return $this;
    }

    /**
     * Get lng
     *
     * @return string
     */
    public function getLng()
    {
        return $this->lng;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return College
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set modifiedon
     *
     * @param \DateTime $modifiedon
     *
     * @return College
     */
    public function setModifiedon($modifiedon)
    {
        $this->modifiedon = $modifiedon;

        return $this;
    }

    /**
     * Get modifiedon
     *
     * @return \DateTime
     */
    public function getModifiedon()
    {
        return $this->modifiedon;
    }

    /**
     * Set createdon
     *
     * @param \DateTime $createdon
     *
     * @return College
     */
    public function setCreatedon($createdon)
    {
        $this->createdon = $createdon;

        return $this;
    }

    /**
     * Get createdon
     *
     * @return \DateTime
     */
    public function getCreatedon()
    {
        return $this->createdon;
    }

    /**
     * Set viewed
     *
     * @param integer $viewed
     *
     * @return College
     */
    public function setViewed($viewed)
    {
        $this->viewed = $viewed;

        return $this;
    }

    /**
     * Get viewed
     *
     * @return integer
     */
    public function getViewed()
    {
        return $this->viewed;
    }
}
