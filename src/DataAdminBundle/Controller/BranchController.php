<?php

namespace DataAdminBundle\Controller;

use DataAdminBundle\Entity\Branch;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

use APY\DataGridBundle\Grid\Source\Entity;
use APY\DataGridBundle\Grid\Action\RowAction;
use APY\DataGridBundle\Grid\Export\ExcelExport;
use APY\DataGridBundle\Grid\Export\JSONExport;

/**
 * Branch controller.
 *
 * @Route("branch")
 */
class BranchController extends Controller
{

 /**
     * Lists all Directory entities.
     *
     * @Route("/", name="branch_index")
     * @Method("GET|POST")
     */
    public function indexAction() {
        $source = new Entity('DataAdminBundle:Branch');
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

        $myRowAction = new RowAction('Show', 'branch_show');
        $grid->addRowAction($myRowAction);

// Add row actions in the default row actions column
        $myRowAction = new RowAction('Edit', 'branch_edit');
        $grid->addRowAction($myRowAction);

        $grid->addExport(new ExcelExport('Excel Export'));
        $grid->addExport(new JSONExport('JSON Export'));

        return $grid->getGridResponse('branch/branch-list.html.twig');
    }       

    /**
     * Creates a new branch entity.
     *
     * @Route("/new", name="branch_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $branch = new Branch();
        $form = $this->createForm('DataAdminBundle\Form\BranchType', $branch);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($branch);
            $em->flush();

            return $this->redirectToRoute('branch_show', array('id' => $branch->getId()));
        }

        return $this->render('branch/new.html.twig', array(
            'branch' => $branch,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a branch entity.
     *
     * @Route("/{id}", name="branch_show")
     * @Method("GET")
     */
    public function showAction(Branch $branch)
    {
        $deleteForm = $this->createDeleteForm($branch);

        return $this->render('branch/show.html.twig', array(
            'branch' => $branch,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing branch entity.
     *
     * @Route("/{id}/edit", name="branch_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Branch $branch)
    {
        $deleteForm = $this->createDeleteForm($branch);
        $editForm = $this->createForm('DataAdminBundle\Form\BranchType', $branch);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('branch_edit', array('id' => $branch->getId()));
        }

        return $this->render('branch/edit.html.twig', array(
            'branch' => $branch,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a branch entity.
     *
     * @Route("/{id}", name="branch_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Branch $branch)
    {
        $form = $this->createDeleteForm($branch);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($branch);
            $em->flush();
        }

        return $this->redirectToRoute('branch_index');
    }

    /**
     * Creates a form to delete a branch entity.
     *
     * @param Branch $branch The branch entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Branch $branch)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('branch_delete', array('id' => $branch->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
