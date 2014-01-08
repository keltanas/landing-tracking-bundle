<?php

namespace keltanas\Bundle\TrackingBundle\Controller;

use Doctrine\ORM\EntityManager;
use keltanas\Bundle\TrackingBundle\Entity\RfqRepository;
use Knp\Component\Pager\Paginator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use keltanas\Bundle\TrackingBundle\Entity\Rfq;
use keltanas\Bundle\TrackingBundle\Form\RfqType;

/**
 * Rfq controller.
 *
 */
class RfqController extends Controller
{

    /**
     * Lists all Rfq entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        /** @var \keltanas\Bundle\TrackingBundle\Entity\RfqRepository $repository */
        $repository = $em->getRepository('keltanasTrackingBundle:Rfq');

        /** @var Paginator $paginator */
        $paginator  = $this->get('knp_paginator');
        $entities = $paginator->paginate(
            $repository->getFindAllQuery(),
            $this->get('request')->query->get('page', 1)/*page number*/,
            10/*limit per page*/
        );

        return $this->render('keltanasTrackingBundle:Rfq:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Rfq entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Rfq();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            /** @var EntityManager $em */
            $em = $this->getDoctrine()->getManager();
            $history = $em->find('keltanasTrackingBundle:History', $entity->getHistoryId());
            if ($history) {
                $entity->setHistory($history);

                $em->persist($entity);
                $em->flush();

                return $this->redirect($this->generateUrl('keltanas_tracking_rfq_show', array('id' => $entity->getId())));
            } else {
                $this->get('session')->getFlashBag()->add('error', sprintf('History "%s" not found', $entity->getHistoryId()));
            }
        }

        return $this->render('keltanasTrackingBundle:Rfq:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Rfq entity.
    *
    * @param \keltanas\Bundle\TrackingBundle\Entity\Rfq $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Rfq $entity)
    {
        $form = $this->createForm(new RfqType(), $entity, array(
            'action' => $this->generateUrl('keltanas_tracking_rfq_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Rfq entity.
     *
     */
    public function newAction()
    {
        $entity = new Rfq();
        $entity->setCreatedAt(new \DateTime());
        $form   = $this->createCreateForm($entity);

        return $this->render('keltanasTrackingBundle:Rfq:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Rfq entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('keltanasTrackingBundle:Rfq')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Rfq entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('keltanasTrackingBundle:Rfq:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Rfq entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('keltanasTrackingBundle:Rfq')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Rfq entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('keltanasTrackingBundle:Rfq:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Rfq entity.
    *
    * @param \keltanas\Bundle\TrackingBundle\Entity\Rfq $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Rfq $entity)
    {
        $form = $this->createForm(new RfqType(), $entity, array(
            'action' => $this->generateUrl('keltanas_tracking_rfq_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Rfq entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('keltanasTrackingBundle:Rfq')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Rfq entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('keltanas_tracking_rfq_edit', array('id' => $id)));
        }

        return $this->render('keltanasTrackingBundle:Rfq:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Rfq entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('keltanasTrackingBundle:Rfq')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Rfq entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('keltanas_tracking_rfq'));
    }

    /**
     * Creates a form to delete a Rfq entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('keltanas_tracking_rfq_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
