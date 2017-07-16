<?php

namespace AppBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;

class BranchService extends Controller {

    protected $em;
    protected $container;

    public function __construct(EntityManager $em, ContainerInterface $container) {
        $this->em = $em;
        $this->container = $container;
    }

    public function getAllBranches() {
        $repository = $this->em->getRepository('DataAdminBundle:Branch');
        $query = $repository->createQueryBuilder('b')
                ->select('b.id, b.branchNameEn as bn, b.branchCode as bc')
                ->orderBy('b.branchNameEn', 'ASC')
                ->getQuery();
        return $query->getResult();
    }

    public function getDirectoryItems($categoryName, $page, $limit, $lang = "en") {
        $commonColumns = ', d.directorySchema, d.viewCount as viewCount';

        $categoryId = $this->get("category_id_service")->getCategoryId($categoryName);
        $repository = $this->em->getRepository('DataAdminBundle:Directory');
        if ($lang == "en") {
            $query = $repository->createQueryBuilder('d')
                    ->select('d.id, d.headingNameEn as headingName, d.addressEn as address, d.descriptionEn as description, d.pageUrl, d.primaryContact, d.isPageActive' . $commonColumns)
                    ->where('d.categoryId = :categoryId')
                    ->setParameter('categoryId', $categoryId)
                    ->getQuery();
        } else {
            $query = $repository->createQueryBuilder('d')
                    ->select('d.id, d.headingNameTa as headingName, d.addressTa as address, d.descriptionTa as description, d.pageUrl, d.primaryContact, d.isPageActive' . $commonColumns)
                    ->where('d.categoryId = :categoryId')
                    ->setParameter('categoryId', $categoryId)
                    ->getQuery();
        }
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($query, $page, $limit, array(
            'defaultSortFieldName' => 'viewCount',
            'defaultSortDirection' => 'desc',
        ));
        return $pagination;
        //return $query->getResult();
    }

}
