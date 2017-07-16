<?php
namespace UserBundle\Entity;

//php bin/console doctrine:generate:entities UserBundle/Entity/User

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
//use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")

 * @UniqueEntity(fields={"email"}, groups={"AppRegistration"},message="Your E-Mail adress has already been registered")
 */
class User extends BaseUser//implements UserInterface
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    protected $email;
    
    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    protected $user_session_id;

    
    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    protected $firstname;
 
    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    protected $lastname;
    
    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $current_login;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $previous_login;
    
    /**
     * @ORM\Column(type="boolean", nullable=true, options={"default"=false})
     */
    protected $user_logged;
    
    
     /** @ORM\Column(name="facebook_id", type="string", length=255, nullable=true) */
    protected $facebook_id;
 
    /** @ORM\Column(name="facebook_access_token", type="string", length=255, nullable=true) */
    protected $facebook_access_token;
 
    /** @ORM\Column(name="google_id", type="string", length=255, nullable=true) */
    protected $google_id;
 
    /** @ORM\Column(name="google_access_token", type="string", length=255, nullable=true) */
    protected $google_access_token;
    
    /**
     * @ORM\Column(type="datetime")
     */
    protected $register_date;

    
    public function __construct() {
        parent::__construct();
        $this->setRegisterDate(new \DateTime());
           //$this->setUserSessionId("sss");
           //$this->setUsername("sss");
        //your own logic
    }
    public function setEmail($email){
        parent::setEmail($email);
        $this->setUsername($email);
    }
    

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
     * Set user_session_id
     *
     * @param string $userSessionId
     * @return User
     */
    public function setUserSessionId($userSessionId)
    {
        $this->user_session_id = $userSessionId;

        return $this;
    }

    /**
     * Get user_session_id
     *
     * @return string 
     */
    public function getUserSessionId()
    {
        return $this->user_session_id;
    }

    /**
     * Set current_login
     *
     * @param \DateTime $currentLogin
     * @return User
     */
    public function setCurrentLogin($currentLogin)
    {
        $this->current_login = $currentLogin;

        return $this;
    }

    /**
     * Get current_login
     *
     * @return \DateTime 
     */
    public function getCurrentLogin()
    {
        return $this->current_login;
    }

    /**
     * Set previous_login
     *
     * @param \DateTime $previousLogin
     * @return User
     */
    public function setPreviousLogin($previousLogin)
    {
        $this->previous_login = $previousLogin;

        return $this;
    }

    /**
     * Get previous_login
     *
     * @return \DateTime 
     */
    public function getPreviousLogin()
    {
        return $this->previous_login;
    }

    /**
     * Set user_logged
     *
     * @param boolean $userLogged
     * @return User
     */
    public function setUserLogged($userLogged)
    {
        $this->user_logged = $userLogged;

        return $this;
    }

    /**
     * Get user_logged
     *
     * @return boolean 
     */
    public function getUserLogged()
    {
        return $this->user_logged;
    }

    /**
     * Set facebook_id
     *
     * @param string $facebookId
     * @return User
     */
    public function setFacebookId($facebookId)
    {
        $this->facebook_id = $facebookId;

        return $this;
    }

    /**
     * Get facebook_id
     *
     * @return string 
     */
    public function getFacebookId()
    {
        return $this->facebook_id;
    }

    /**
     * Set facebook_access_token
     *
     * @param string $facebookAccessToken
     * @return User
     */
    public function setFacebookAccessToken($facebookAccessToken)
    {
        $this->facebook_access_token = $facebookAccessToken;

        return $this;
    }

    /**
     * Get facebook_access_token
     *
     * @return string 
     */
    public function getFacebookAccessToken()
    {
        return $this->facebook_access_token;
    }



    /**
     * Set googleId
     *
     * @param string $googleId
     *
     * @return User
     */
    public function setGoogleId($googleId)
    {
        $this->google_id = $googleId;

        return $this;
    }

    /**
     * Get googleId
     *
     * @return string
     */
    public function getGoogleId()
    {
        return $this->google_id;
    }

    /**
     * Set googleAccessToken
     *
     * @param string $googleAccessToken
     *
     * @return User
     */
    public function setGoogleAccessToken($googleAccessToken)
    {
        $this->google_access_token = $googleAccessToken;

        return $this;
    }

    /**
     * Get googleAccessToken
     *
     * @return string
     */
    public function getGoogleAccessToken()
    {
        return $this->google_access_token;
    }

    /**
     * Set registerDate
     *
     * @param \DateTime $registerDate
     *
     * @return User
     */
    public function setRegisterDate($registerDate)
    {
        $this->register_date = $registerDate;

        return $this;
    }

    /**
     * Get registerDate
     *
     * @return \DateTime
     */
    public function getRegisterDate()
    {
        return $this->register_date;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     *
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     *
     * @return User
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }
}
