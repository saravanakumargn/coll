<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_session")
 */
class Session {

    /**
     * @ORM\Column(type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @ORM\Column(type="integer")
     */
    protected $user_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $session_id;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $date_created;

    /**
     * @ORM\Column(type="string", length=48)
     */
    protected $user_location;

    /**
     * @ORM\Column(type="string", length=32)
     */
    protected $user_ip;

    /**
     * @ORM\Column(type="string", length=20)
     */
    protected $user_browser;

    /**
     * @ORM\Column(type="string", length=20)
     */
    protected $user_os;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $user_is_mobile=false;

    public function __construct() {
        $this->setDateCreated(new \DateTime());
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set user_id
     *
     * @param integer $userId
     * @return Session
     */
    public function setUserId($userId) {
        $this->user_id = $userId;

        return $this;
    }

    /**
     * Get user_id
     *
     * @return integer 
     */
    public function getUserId() {
        return $this->user_id;
    }

    /**
     * Set session_id
     *
     * @param string $sessionId
     * @return Session
     */
    public function setSessionId($sessionId) {
        $this->session_id = $sessionId;

        return $this;
    }

    /**
     * Get session_id
     *
     * @return string 
     */
    public function getSessionId() {
        return $this->session_id;
    }

    /**
     * Set date_created
     *
     * @param \DateTime $dateCreated
     * @return Session
     */
    public function setDateCreated($dateCreated) {
        $this->date_created = $dateCreated;

        return $this;
    }

    /**
     * Get date_created
     *
     * @return \DateTime 
     */
    public function getDateCreated() {
        return $this->date_created;
    }

    /**
     * Set user_location
     *
     * @param string $userLocation
     * @return Session
     */
    public function setUserLocation($userLocation) {
        $this->user_location = $userLocation;

        return $this;
    }

    /**
     * Get user_location
     *
     * @return string 
     */
    public function getUserLocation() {
        return $this->user_location;
    }

    /**
     * Set user_ip
     *
     * @param string $userIp
     * @return Session
     */
    public function setUserIp($userIp) {
        $this->user_ip = $userIp;

        return $this;
    }

    /**
     * Get user_ip
     *
     * @return string 
     */
    public function getUserIp() {
        return $this->user_ip;
    }

    /**
     * Set user_browser
     *
     * @param string $userBrowser
     * @return Session
     */
    public function setUserBrowser($userBrowser) {
        $this->user_browser = $userBrowser;

        return $this;
    }

    /**
     * Get user_browser
     *
     * @return string 
     */
    public function getUserBrowser() {
        return $this->user_browser;
    }

    /**
     * Set user_os
     *
     * @param string $userOs
     * @return Session
     */
    public function setUserOs($userOs) {
        $this->user_os = $userOs;

        return $this;
    }

    /**
     * Get user_os
     *
     * @return string 
     */
    public function getUserOs() {
        return $this->user_os;
    }

    /**
     * Set user_logged
     *
     * @param boolean $user_is_mobile
     * @return User
     */
    public function setUserIsMobile($user_is_mobile) {
        $this->user_is_mobile = $user_is_mobile;
        return $this;
    }

    /**
     * Get user_logged
     *
     * @return boolean 
     */
    public function getUserIsMobile() {
        return $this->user_is_mobile;
    }

}
