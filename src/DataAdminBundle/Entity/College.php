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
     * @ORM\Column(name="address_ta", type="string", length=100, nullable=false)
     * @GRID\Column(field="addressTa", size=150, title="Address Tamil")
     */
    private $addressTa;    
    /**
     * @var text $content
     *
     * @ORM\Column(name="address_en", type="string", length=100, nullable=false)
     * @GRID\Column(field="addressEn", size=150, title="Address English")
     */
    private $addressEn;
    
    /**
     * @var text $districtId
     *
     * @ORM\ManyToOne(targetEntity="District", inversedBy="list_items")
     * @ORM\JoinColumn(name="district_id", referencedColumnName="id")
     * @GRID\Column(field="districtId.districtNameEn", size=150, title="District")
     */
    private $districtId;  

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
    private $email_id;    
    /**
     * @var text $content
     *
     * @ORM\Column(name="website_name", type="string", length=60, nullable=true)
     */
    private $websiteName;    
    /**
     * @var text $content
     *
     * @ORM\Column(name="hq_distance", type="integer", length=3, nullable=true)
     */
    private $hqDistance;    
    /**
     * @var text $content
     *
     * @ORM\Column(name="railway_near", type="string", length=60, nullable=true)
     */
    private $railwayNear;       
    /**
     * @var text $content
     *
     * @ORM\Column(name="railway_distance", type="integer", length=3, nullable=true)
     */
    private $railwayDistance;    
    
    /**
     * @var string $lat
     *
     * @ORM\Column(name="lat", type="decimal", scale=6, nullable=true)
     */
    private $lat;

    /**
     * @var string $lng
     *
     * @ORM\Column(name="lng", type="decimal", scale=6, nullable=true)
     */
    private $lng;      
    
    /**
     * @var text $isActive
     *
     * @ORM\Column(name="is_active", type="boolean", options={"default"=true})
     */
    private $isActive;    

    /**
     * @var text $isBlocked
     *
     * @ORM\Column(name="is_blocked", type="boolean",  nullable=false, options={"default"=false})
     */
    private $isBlocked;

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
//        $this->pageUrl = $pageUrl;
        $this->pageUrl = $this->seoUrl($pageUrl);

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
     * Set addressTa
     *
     * @param string $addressTa
     *
     * @return College
     */
    public function setAddressTa($addressTa)
    {
        $this->addressTa = $addressTa;

        return $this;
    }

    /**
     * Get addressTa
     *
     * @return string
     */
    public function getAddressTa()
    {
        return $this->addressTa;
    }

    /**
     * Set addressEn
     *
     * @param string $addressEn
     *
     * @return College
     */
    public function setAddressEn($addressEn)
    {
        $this->addressEn = $addressEn;

        return $this;
    }

    /**
     * Get addressEn
     *
     * @return string
     */
    public function getAddressEn()
    {
        return $this->addressEn;
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
        $this->email_id = $emailId;

        return $this;
    }

    /**
     * Get emailId
     *
     * @return string
     */
    public function getEmailId()
    {
        return $this->email_id;
    }

    /**
     * Set websiteName
     *
     * @param string $websiteName
     *
     * @return College
     */
    public function setWebsiteName($websiteName)
    {
        $this->websiteName = $websiteName;

        return $this;
    }

    /**
     * Get websiteName
     *
     * @return string
     */
    public function getWebsiteName()
    {
        return $this->websiteName;
    }

    /**
     * Set hqDistance
     *
     * @param integer $hqDistance
     *
     * @return College
     */
    public function setHqDistance($hqDistance)
    {
        $this->hqDistance = $hqDistance;

        return $this;
    }

    /**
     * Get hqDistance
     *
     * @return integer
     */
    public function getHqDistance()
    {
        return $this->hqDistance;
    }

    /**
     * Set railwayNear
     *
     * @param string $railwayNear
     *
     * @return College
     */
    public function setRailwayNear($railwayNear)
    {
        $this->railwayNear = $railwayNear;

        return $this;
    }

    /**
     * Get railwayNear
     *
     * @return string
     */
    public function getRailwayNear()
    {
        return $this->railwayNear;
    }

    /**
     * Set railwayDistance
     *
     * @param integer $railwayDistance
     *
     * @return College
     */
    public function setRailwayDistance($railwayDistance)
    {
        $this->railwayDistance = $railwayDistance;

        return $this;
    }

    /**
     * Get railwayDistance
     *
     * @return integer
     */
    public function getRailwayDistance()
    {
        return $this->railwayDistance;
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
     * Set isBlocked
     *
     * @param boolean $isBlocked
     *
     * @return College
     */
    public function setIsBlocked($isBlocked)
    {
        $this->isBlocked = $isBlocked;

        return $this;
    }

    /**
     * Get isBlocked
     *
     * @return boolean
     */
    public function getIsBlocked()
    {
        return $this->isBlocked;
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

    /**
     * Set districtId
     *
     * @param \DataAdminBundle\Entity\District $districtId
     *
     * @return College
     */
    public function setDistrictId(\DataAdminBundle\Entity\District $districtId = null)
    {
        $this->districtId = $districtId;

        return $this;
    }

    /**
     * Get districtId
     *
     * @return \DataAdminBundle\Entity\District
     */
    public function getDistrictId()
    {
        return $this->districtId;
    }
}
