<?php

namespace UserBundle\Utils;

use Doctrine\ORM\EntityManager;

class UserValidate {

    private $em;

    public function __construct(EntityManager $em) {
        $this->em = $em;
    }

    public function isValidUser($userTokenRequest) {

        $explode = explode('_', $userTokenRequest); // split all parts
//        print_r($explode);
//        $reqUserId = '';
//        $reqUserToken = '';
        $reqUserId = array_pop($explode); // removes the last element, and returns it
        if (count($explode) > 0) {
            $reqUserToken = implode('_', $explode); // glue the remaining pieces back together
        }
        //if (count($userToken) == 2) {
        if ($reqUserId != null && $reqUserToken != null) {
            $userData = $this->em->getRepository('UserBundle:User')->findOneById($reqUserId);
            if ($userData) {
                if ($userData->getUserSessionId() === $reqUserToken) {
                    return true;
                }
            }
        }
        return false;




//        $user = $this->token_storage->getToken()->getUser();
//        $userId = $user->getUserSessionId();
//        return $userId;
    }

    public function getUserDataId($userTokenRequest) {
        try {
            $explode = explode('_', $userTokenRequest); // split all parts
            $reqUserId = array_pop($explode); // removes the last element, and returns it
            if ($reqUserId != null) {
                $userData = $this->em->getRepository('UserBundle:User')->findOneById($reqUserId);
                if ($userData) {
                    return $userData->getId();
                }
//                echo $userData->getId();
            }
            return false;
        } catch (Exception $ex) {
            print_r($ex->getMessage());
        }
    }

}
