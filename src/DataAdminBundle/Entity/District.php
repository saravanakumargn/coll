<?php

namespace DataAdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use APY\DataGridBundle\Grid\Mapping as GRID;

// php bin/console doctrine:generate:entities DataAdminBundle/Entity/District

/**
 * DataAdminBundle\Entity\District
 *
 * @ORM\Table(name="district")
 * @ORM\Entity
 * 
 */
class District {

    /**
     * @ORM\Column(type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @var text $content
     *
     * @ORM\Column(name="district_name_ta", type="string", length=100, nullable=false)
     * @GRID\Column(field="districtNameTa", size=150, title="District Name Tamil")
     */
    private $districtNameTa;    
    /**
     * @var text $content
     *
     * @ORM\Column(name="district_name_en", type="string", length=100, nullable=false)
     * @GRID\Column(field="districtNameEn", size=150, title="District Name English")
     */
    private $districtNameEn;

    private function seoUrl($str) {
        if ($str !== mb_convert_encoding(mb_convert_encoding($str, 'UTF-32', 'UTF-8'), 'UTF-8', 'UTF-32'))
            $str = mb_convert_encoding($str, 'UTF-8', mb_detect_encoding($str));
        $str = htmlentities($str, ENT_NOQUOTES, 'UTF-8');
        $str = preg_replace('`&([a-z]{1,2})(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig);`i', '\1', $str);
        $str = html_entity_decode($str, ENT_NOQUOTES, 'UTF-8');
        $str = preg_replace(array('`[^a-z0-9]`i', '`[-]+`'), '-', $str);
        $str = strtolower(trim($str, '-'));
        return $str;
        /*
          //Lower case everything
          $string = strtolower($string);
          //Make alphanumeric (removes all other characters)
          $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
          //Clean up multiple dashes or whitespaces
          $string = preg_replace("/[\s-]+/", " ", $string);
          //Convert whitespaces and underscore to dash
          $string = preg_replace("/[\s_]/", "-", $string);
          return $string;

         */
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
     * Set districtNameTa
     *
     * @param string $districtNameTa
     *
     * @return District
     */
    public function setDistrictNameTa($districtNameTa)
    {
        $this->districtNameTa = trim($districtNameTa);

        return $this;
    }

    /**
     * Get districtNameTa
     *
     * @return string
     */
    public function getDistrictNameTa()
    {
        return $this->districtNameTa;
    }

    /**
     * Set districtNameEn
     *
     * @param string $districtNameEn
     *
     * @return District
     */
    public function setDistrictNameEn($districtNameEn)
    {
        $this->districtNameEn = trim($districtNameEn);

        return $this;
    }

    /**
     * Get districtNameEn
     *
     * @return string
     */
    public function getDistrictNameEn()
    {
        return $this->districtNameEn;
    }
}
