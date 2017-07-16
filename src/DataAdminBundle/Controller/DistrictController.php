<?php

namespace DataAdminBundle\Controller;

use DataAdminBundle\Entity\District;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

use APY\DataGridBundle\Grid\Source\Entity;
use APY\DataGridBundle\Grid\Action\RowAction;
use APY\DataGridBundle\Grid\Export\ExcelExport;
use APY\DataGridBundle\Grid\Export\JSONExport;

/**
 * District controller.
 *
 * @Route("district")
 */
class DistrictController extends Controller
{

 /**
     * Lists all Directory entities.
     *
     * @Route("/", name="district_index")
     * @Method("GET|POST")
     */
    public function indexAction() {
        $source = new Entity('DataAdminBundle:District');
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

        $myRowAction = new RowAction('Show', 'district_show');
        $grid->addRowAction($myRowAction);

// Add row actions in the default row actions column
        $myRowAction = new RowAction('Edit', 'district_edit');
        $grid->addRowAction($myRowAction);

        $grid->addExport(new ExcelExport('Excel Export'));
        $grid->addExport(new JSONExport('JSON Export'));

        return $grid->getGridResponse('district/district-list.html.twig');
    }    

    /**
     * Creates a new district entity.
     *
     * @Route("/new", name="district_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $district = new District();
        $form = $this->createForm('DataAdminBundle\Form\DistrictType', $district);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($district);
            $em->flush();

            return $this->redirectToRoute('district_show', array('id' => $district->getId()));
        }

        return $this->render('district/new.html.twig', array(
            'district' => $district,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a district entity.
     *
     * @Route("/{id}", name="district_show")
     * @Method("GET")
     */
    public function showAction(District $district)
    {
        $deleteForm = $this->createDeleteForm($district);

        return $this->render('district/show.html.twig', array(
            'district' => $district,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing district entity.
     *
     * @Route("/{id}/edit", name="district_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, District $district)
    {
        $deleteForm = $this->createDeleteForm($district);
        $editForm = $this->createForm('DataAdminBundle\Form\DistrictType', $district);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('district_edit', array('id' => $district->getId()));
        }

        return $this->render('district/edit.html.twig', array(
            'district' => $district,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a district entity.
     *
     * @Route("/{id}", name="district_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, District $district)
    {
        $form = $this->createDeleteForm($district);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($district);
            $em->flush();
        }

        return $this->redirectToRoute('district_index');
    }

    /**
     * Creates a form to delete a district entity.
     *
     * @param District $district The district entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(District $district)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('district_delete', array('id' => $district->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
