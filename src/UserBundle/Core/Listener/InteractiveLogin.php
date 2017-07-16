<?php

namespace UserBundle\Core\Listener;

//require_once __DIR__.'\UserAgentParser.php';

use UserBundle\Entity\Session;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\ORM\EntityManager;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use UserBundle\Core\UserAgentParser;
use FOS\UserBundle\Model\UserManagerInterface;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

//use DateTime;
//use Acme\UserBundle\Document\LoginHistory;

class InteractiveLogin extends Controller {

    protected $container;
    protected $em;
    protected $sessVal;
    protected $userManager;

    public function __construct(ContainerInterface $container, EntityManager $em, UserManagerInterface $userManager) {
        $this->container = $container;
        $this->em = $em;
        $this->userManager = $userManager;
        // $this->interactiveLoginObj = $this;
    }

    public function onLogin(InteractiveLoginEvent $event) {
        //global $sessVal;
        $user = $event->getAuthenticationToken()->getUser();
        //$sessVal = "test sess";

        $this->addtoDB($user);
    }

    public function onConfirmed(FilterUserResponseEvent $event) {
        $user = $event->getUser();
        //$sessVal = "test sess";

        $this->addtoDB($user, true);
        /* if ($user instanceof UserInterface) {
          $user->setUsername($user->getEmail());
          $user->setUsernameCanonical($user->getEmailCanonical());
          $this->userManager->updateUser($user);
          } */
    }

    public function addtoDB($user, $register_confirmed = false) {
        if ($user instanceof UserInterface) {
            //$ua = new UAP();
            //$browser_arr = UserAgentParser::getBrowser($_SERVER['HTTP_USER_AGENT']);
            $browser_arr = UserAgentParser::getBrowser($_SERVER['HTTP_USER_AGENT']);
            $browser_name = $browser_arr["short_name"] . " " . $browser_arr["version"];
            $os_arr = UserAgentParser::getOperatingSystem($_SERVER['HTTP_USER_AGENT']);
            $os_name = $os_arr["name"];


            $userIdval = $user->getId();

//            $track_settings_sql = "select timezone from track_settings where user_id=" . $userIdval;
//            $em_tracker = $this->getDoctrine()->getManager('tracker');
//            $conn = $em_tracker->getConnection();
//            $settings_result = $conn->query($track_settings_sql)->fetchAll();
//
//            $offset = +5.5;
//            $tz = timezone_name_from_abbr(null, $offset * 3600, true);
//            if ($tz === false)
//                $tz = timezone_name_from_abbr(null, $offset * 3600, false);
//            //date_default_timezone_set($tz);
//            $this->session->set('timezone', $timezone);




            $session = new Session();
            //$session->setUserId($user->getId());
            $session->setUserId($userIdval);
            
            //$sessionid = $this->container->get('session')->getId() . round(microtime(true) * 1000);
            $tokenGenerator = $this->get('fos_user.util.token_generator');
            $tokenId = $tokenGenerator->generateToken();
          
            $session->setSessionId($tokenId);
            //$ip_add = "117.206.111.218"; //$this->container->get('request')->getClientIp();
            $ip_add = $this->container->get('request')->getClientIp();
            if (isset($_SERVER['HTTP_CLIENT_IP']) ||
                    isset($_SERVER['HTTP_X_FORWARDED_FOR']) ||
                    in_array(@$_SERVER['REMOTE_ADDR'], array('127.0.0.1', 'fe80::1', '::1'))
            ) {
                //$location = json_decode(file_get_contents("http://freegeoip.net/json/{$ip_add}"));
                //$location_val = $location->city . ", " . $location->region_name . ", " . $location->country_code;
                $location_val = "NA";
            } else {
                //$location = json_decode(file_get_contents("http://ipinfo.io/{$ip_add}"));
                //$location_val = $location->city . ", " . $location->region . ", " . $location->country;
                //$location_val = "NA";
                
                /*
                 * Commented now need to fix
                 */
                
//                $url = "http://freegeoip.net/json/" . $ip_add;
//
//                $ch = curl_init($url);
//                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//                $json = '';
//                if (($json = curl_exec($ch) ) === false) {
//                    //echo 'Curl error: ' . curl_error($ch);
//                    $location_val = "NA";
//                } else {
//                    $location = json_decode($json);
//                    //print_r($array);
//                    //echo 'Operation completed without any errors';
//                    $location_val = $location->city . ", " . $location->region_name . ", " . $location->country_code;
//                }
//                // Close handle
//                curl_close($ch);
                
                $location_val = "NA";
            }


            $session->setUserIp($ip_add);


            //$myVariable = $this->container->setParameter(my_foo, "from con");
            //$this->container->setParameter(my_foo, "from con");

            $session->setUserLocation($location_val);
            $session->setUserBrowser($browser_name);
            $session->setUserOs($os_name);
            $this->em->persist($session);
            $this->em->flush();

            //$sessionid = $this->container->get('session')->getId() . round(microtime(true) * 1000);
            $user->setUserSessionId($tokenId);
            $user->setPreviousLogin($user->getCurrentLogin());
            $user->setCurrentLogin(new \DateTime());
            $user->setUserLogged(true);

//            $sql = "delete from mytable where mytable.fieldone_id = :fieldoneid and mytable.fieldtwo_id = :fieldtwoid";

            $sql = "DELETE FROM user_session WHERE user_id = :userid  and id NOT IN ( 
  SELECT id 
  FROM ( 
    SELECT id 
    FROM user_session WHERE user_id = :userid 
    ORDER BY id DESC 
    LIMIT 30
  ) x 
)";

            $params = array('userid' => $userIdval);
            $em = $this->getDoctrine()->getEntityManager();
            $stmt = $em->getConnection()->prepare($sql);
            $stmt->execute($params);

            if ($register_confirmed) {
                $user->setUsername($user->getEmail());
                $user->setUsernameCanonical($user->getEmailCanonical());
            }
            $this->userManager->updateUser($user);
        }
    }

}
