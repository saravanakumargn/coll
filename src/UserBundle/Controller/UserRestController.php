<?php

namespace UserBundle\Controller;

use Symfony\Component\HttpKernel\Exception\HttpNotFoundException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;
use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Tracker\UserBundle\Entity\Session;

class UserRestController extends Controller {

    /**
     * 
     * @param type $username
     * 
     * @View(serializerGroups={"Default","Details"})
     */
    public function getUserAction($username) {
//    $user = "Test";//$this->getRepository('UserBundle:User')->findOneByUsername($username);
////    if(!is_object($user)){
////      throw $this->createNotFoundException();
////    }
//    return $user;
        $result_array = array();
        $request = $this->getRequest();
        $username = $request->get('uname');
        $password = $request->get('pword');
        $callback = $this->getRequest()->get('callback'); // Check to see if callback parameter is in URL
        $response = new JsonResponse(); // Construct a new JSON response
        if (isset($callback))
            $response->setCallback($callback);  // Set callback function to variable passed in callback

        $um = $this->get('fos_user.user_manager');
        $user = $um->findUserByEmail($username);
//        $user = $um->findUserByUsername($username);
//        if(!$user){
//            $user = $um->findUserByEmail($username);
//        }
//        if(!$user instanceof User){
//            throw new HttpNotFoundException("User not found");
//        }
        if (!$user) {
            $result_array['success'] = false;
            $result_array['msg'] = "Invalid username or password";
            $response->setData($result_array);
            return $response;
        }
        $factory = $this->get('security.encoder_factory');
        $encoder = $factory->getEncoder($user);
        if (!$encoder) {
            return false;
        }
        if ($encoder->isPasswordValid($user->getPassword(), $password, $user->getSalt())) {
            $security = $this->get('security.context');
            $providerKey = $this->container->getParameter('fos_user.firewall_name');
            $roles = $user->getRoles();
            $token = new UsernamePasswordToken($user, null, $providerKey, $roles);
            $security->setToken($token);
        } else {
            $result_array['success'] = false;
            $result_array['msg'] = "Invalid username or password";
            $response->setData($result_array);
            return $response;
        }
        if (!$user->isEnabled()) {
            $result_array['success'] = false;
            $result_array['msg'] = "User account is Disabled";
            $response->setData($result_array);
            return $response;
        }
        if ($user->isLocked()) {
            $result_array['success'] = false;
            $result_array['msg'] = "User account is locked";
            $response->setData($result_array);
            return $response;
        }
        if ($user->isExpired()) {
            $result_array['success'] = false;
            $result_array['msg'] = "User account is Expired";
            $response->setData($result_array);
            return $response;
        }
        if (!$user->isCredentialsNonExpired()) {
            $result_array['success'] = false;
            $result_array['msg'] = "User account Credentials Expired";
            $response->setData($result_array);
            return $response;
        }

        $session = new Session();
        $session->setUserId($user->getId());
        $sessionid = $this->container->get('session')->getId() . round(microtime(true) * 1000);
        $session->setSessionId($sessionid);
        $session->setUserIp("NA");
        $session->setUserLocation("NA");
        $session->setUserBrowser("NA");
        $session->setUserOs("NA");
        $session->setUserIsMobile(true);
        $em = $this->get('doctrine')->getManager();
        $em->persist($session);
        $em->flush();

        $user->setUserSessionId($sessionid);
        $user->setPreviousLogin($user->getCurrentLogin());
        $user->setCurrentLogin(new \DateTime());
        $user->setUserLogged(true);
        $um->updateUser($user);

//        if(!$this->checkUserPassword($user, $password)){
//            throw new AccessDeniedException("Wrong password");
//        }
        //$this->loginUser($user);
        $result_array['success'] = true;
        $result_array['msg'] = "Valid user";

        /*
         * get user currency from DB
         */

        $em = $this->get('doctrine')->getManager('tracker');
        $conn = $em->getConnection();

        $track_settings_sql = "select * from track_settings where user_id=" . $user->getId();
        $settings_result = $conn->query($track_settings_sql)->fetchAll();
//        if (empty($settings_result)) {
////                var_dump($settings_result);
//            //return $this->render('TrackerTrackBundle:Page:index.html.twig');
//        }
//        $a = new \NumberFormatter("en-IN", \NumberFormatter::CURRENCY);
//        var_dump($a->format(123456789.12345));



        $obj = new \stdClass;
        $obj->uid = $user->getId();
        $obj->usid = $user->getUserSessionId();
        $obj->uemail = $user->getEmail();

        // add user currency to response object
        //$obj->ucurrency = "en-IN";
        if (empty($settings_result)) {
            $obj->ucurrency = "en-IN";
        } else {
            $obj->ucurrency = $settings_result[0]["currency_local"];
        }


        $result_array['user'] = $obj;
        $response->setData($result_array);

        return $response;

        //return array('success' => true, 'user' => $user);
    }

    /**
     * 
     * 
     * @View(serializerGroups={"Register"})
     */
    public function getRegisterAction() {
//        $result_array = array();
        $request = $this->getRequest();
        $useremail = $request->get('uemail');
//        $password = $request->get('pword');
        $user = "te";
        return $useremail;
    }

}
