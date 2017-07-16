<?php

namespace DataAdminBundle\Controller;

use DataAdminBundle\Entity\College;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

use APY\DataGridBundle\Grid\Source\Entity;
use APY\DataGridBundle\Grid\Action\RowAction;
use APY\DataGridBundle\Grid\Export\ExcelExport;
use APY\DataGridBundle\Grid\Export\JSONExport;
/**
 * College controller.
 *
 * @Route("college")
 */
class CollegeController extends Controller
{
    
 /**
     * Lists all Directory entities.
     *
     * @Route("/", name="college_index")
     * @Method("GET|POST")
     */
    public function indexAction() {
        $source = new Entity('DataAdminBundle:College');
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

        $myRowAction = new RowAction('Show', 'college_show');
        $grid->addRowAction($myRowAction);

// Add row actions in the default row actions column
        $myRowAction = new RowAction('Edit', 'college_edit');
        $grid->addRowAction($myRowAction);

        $grid->addExport(new ExcelExport('Excel Export'));
        $grid->addExport(new JSONExport('JSON Export'));

        return $grid->getGridResponse('college/college-list.html.twig');
    }  
    /**
     * Creates a new college entity.
     *
     * @Route("/new", name="college_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $college = new College();
        $form = $this->createForm('DataAdminBundle\Form\CollegeType', $college);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($college);
            $em->flush();

            return $this->redirectToRoute('college_show', array('id' => $college->getId()));
        }
        $allBranches = $this->get("branch_service")->getAllBranches();
        return $this->render('college/new.html.twig', array(
            'college' => $college,
            'allBranches' => $allBranches
        ));

//        return $this->render('college/new.html.twig', array(
//            'college' => $college,
//            'form' => $form->createView(),
//        ));
    }

    /**
     * Finds and displays a college entity.
     *
     * @Route("/{id}", name="college_show")
     * @Method("GET")
     */
    public function showAction(College $college)
    {
        $deleteForm = $this->createDeleteForm($college);

        return $this->render('college/show.html.twig', array(
            'college' => $college,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing college entity.
     *
     * @Route("/{id}/edit", name="college_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, College $college)
    {
        $deleteForm = $this->createDeleteForm($college);
        $editForm = $this->createForm('DataAdminBundle\Form\CollegeType', $college);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('college_edit', array('id' => $college->getId()));
        }

        return $this->render('college/edit.html.twig', array(
            'college' => $college,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a college entity.
     *
     * @Route("/{id}", name="college_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, College $college)
    {
        $form = $this->createDeleteForm($college);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($college);
            $em->flush();
        }

        return $this->redirectToRoute('college_index');
    }

    /**
     * Creates a form to delete a college entity.
     *
     * @param College $college The college entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(College $college)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('college_delete', array('id' => $college->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
