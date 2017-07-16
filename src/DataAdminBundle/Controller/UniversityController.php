<?php

namespace DataAdminBundle\Controller;

use DataAdminBundle\Entity\University;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use APY\DataGridBundle\Grid\Source\Entity;
use APY\DataGridBundle\Grid\Action\RowAction;
use APY\DataGridBundle\Grid\Export\ExcelExport;
use APY\DataGridBundle\Grid\Export\JSONExport;

/**
 * University controller.
 *
 * @Route("university")
 */
class UniversityController extends Controller
{

 /**
     * Lists all Directory entities.
     *
     * @Route("/", name="university_index")
     * @Method("GET|POST")
     */
    public function indexAction() {
        $source = new Entity('DataAdminBundle:University');
        // Get a grid instance
        $grid = $this->get('grid');

        // Set the default order of the grid
        //$grid->setDefaultOrder('current_login', 'desc');
        // Attach the source to the grid
        $grid->setSource($source);

        // Set the selector of the number of items per page
        $grid->setLimits(array(5, 10, 20, 50, 100, 200));

//        $userColumns = array('headingName', 'isActive', 'modifiedon');
//
//        $grid->setColumnsOrder($userColumns);
//        $grid->setVisibleColumns($userColumns);

        // Set the default limit
        $grid->setDefaultLimit(50);

        $myRowAction = new RowAction('Show', 'university_show');
        $grid->addRowAction($myRowAction);

// Add row actions in the default row actions column
        $myRowAction = new RowAction('Edit', 'university_edit');
        $grid->addRowAction($myRowAction);

        $grid->addExport(new ExcelExport('Excel Export'));
        $grid->addExport(new JSONExport('JSON Export'));

        return $grid->getGridResponse('university/university-list.html.twig');
    }  
    
    /**
     * Creates a new university entity.
     *
     * @Route("/new", name="university_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $university = new University();
        $form = $this->createForm('DataAdminBundle\Form\UniversityType', $university);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($university);
            $em->flush();

            return $this->redirectToRoute('university_show', array('id' => $university->getId()));
        }

        return $this->render('university/new.html.twig', array(
            'university' => $university,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a university entity.
     *
     * @Route("/{id}", name="university_show")
     * @Method("GET")
     */
    public function showAction(University $university)
    {
        $deleteForm = $this->createDeleteForm($university);

        return $this->render('university/show.html.twig', array(
            'university' => $university,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing university entity.
     *
     * @Route("/{id}/edit", name="university_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, University $university)
    {
        $deleteForm = $this->createDeleteForm($university);
        $editForm = $this->createForm('DataAdminBundle\Form\UniversityType', $university);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('university_edit', array('id' => $university->getId()));
        }

        return $this->render('university/edit.html.twig', array(
            'university' => $university,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a university entity.
     *
     * @Route("/{id}", name="university_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, University $university)
    {
        $form = $this->createDeleteForm($university);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($university);
            $em->flush();
        }

        return $this->redirectToRoute('university_index');
    }

    /**
     * Creates a form to delete a university entity.
     *
     * @param University $university The university entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(University $university)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('university_delete', array('id' => $university->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
