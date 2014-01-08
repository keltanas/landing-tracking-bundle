<?php

namespace keltanas\Bundle\TrackingBundle\Controller;

use Doctrine\ORM\EntityManager;
use keltanas\Bundle\TrackingBundle\Entity\Rfq;
use keltanas\Bundle\TrackingBundle\Form\AdaptiveFormType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormError;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use keltanas\Bundle\TrackingBundle\Entity\Form as FormEntity;
use keltanas\Bundle\TrackingBundle\Form\FormType;
use Symfony\Component\HttpFoundation\Response;

/**
 * Form controller.
 *
 */
class FormController extends Controller
{
    /**
     * Create and serve adaptive form
     */
    public function serveAction(Request $request, $name)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        /** @var FormEntity $entity */
        $entity = $em->getRepository('keltanasTrackingBundle:Form')->findOneBy(['name'=>$name]);

        if (!$entity) {
            return new Response(sprintf('Form "%s" not found!', $name));
        }

        $form = $this->createForm(new AdaptiveFormType($entity), null, [
            'action' => $this->generateUrl('keltanas_tracking_form_serve', ['name'=>$name]),
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $this->get('keltanas.postman')->sendMessage(
                    'Form: ' . $name,
                    'keltanasTrackingBundle:Form:mail.html.twig',
                    array_merge($form->getData(), ['entity' => $entity]),
                    $request
                );

                $history = $em->find('keltanasTrackingBundle:History', $request->cookies->get('tracker_id'));
                $rfq = new Rfq();
                $rfq->setName($form->get('name')->getData());
                $rfq->setPhone($form->get('phone')->getData());
                $rfq->setForm($entity);
                $rfq->setHistory($history);
                $rfq->setCreatedAt(new \DateTime());
                $rfq->setIp($this->getRequest()->getClientIp());
                $em->persist($rfq);
                $em->flush();

                return new JsonResponse([
                    'status' => 'ok',
                    'message' => $this->get('translator')->trans('promo.form.message.success'),
                ]);
            } else {
                $errors = [];
                /** @var Form $child */
                foreach ($form as $child) {
                    $errors[$child->getName()] = array_reduce($child->getErrors(), function($result, FormError $err) {
                            return $result .= $err->getMessage();
                        }, null);
                }
                return new JsonResponse(['status'=>'error', 'errors'=>$errors, 'message'=>$form->getErrorsAsString()]);
            }
        }

        return $this->render($entity->getTemplate(), [
                'form' => $form->createView(),
                'entity' => $entity,
            ]);
    }

    /**
     * Lists all Form entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('keltanasTrackingBundle:Form')->findAll();

        return $this->render('keltanasTrackingBundle:Form:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new Form entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new FormEntity();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('keltanas_tracking_form_show', array('id' => $entity->getId())));
        }

        return $this->render('keltanasTrackingBundle:Form:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Form entity.
    *
    * @param Form $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(FormEntity $entity)
    {
        $form = $this->createForm(new FormType(), $entity, array(
            'action' => $this->generateUrl('keltanas_tracking_form_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'form.create'));

        return $form;
    }

    /**
     * Displays a form to create a new Form entity.
     *
     */
    public function newAction()
    {
        $entity = new FormEntity();
        $entity->setTemplate('keltanasTrackingBundle:Form:form.html.twig');
        $form   = $this->createCreateForm($entity);

        return $this->render('keltanasTrackingBundle:Form:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Form entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('keltanasTrackingBundle:Form')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Form entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('keltanasTrackingBundle:Form:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Form entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('keltanasTrackingBundle:Form')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Form entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('keltanasTrackingBundle:Form:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Form entity.
    *
    * @param Form $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(FormEntity $entity)
    {
        $form = $this->createForm(new FormType(), $entity, array(
            'action' => $this->generateUrl('keltanas_tracking_form_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'form.update'));

        return $form;
    }
    /**
     * Edits an existing Form entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('keltanasTrackingBundle:Form')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Form entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

//            return $this->redirect($this->generateUrl('keltanas_tracking_form_edit', array('id' => $id)));
            return $this->redirect($this->generateUrl('keltanas_tracking_form'));
        }

        return $this->render('keltanasTrackingBundle:Form:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Form entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('keltanasTrackingBundle:Form')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Form entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('keltanas_tracking_form'));
    }

    /**
     * Creates a form to delete a Form entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('keltanas_tracking_form_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'form.delete'))
            ->getForm()
        ;
    }
}
