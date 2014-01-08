<?php

namespace keltanas\Bundle\TrackingBundle\Controller;

use keltanas\Bundle\TrackingBundle\Entity\HistoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function testAction()
    {
        return $this->render('keltanasTrackingBundle:Default:test.html.twig');
    }

    public function indexAction()
    {
        /** @var HistoryRepository $repository */
        $repository = $this->getDoctrine()->getRepository('keltanasTrackingBundle:History');

        $dateToday = new \DateTime('today');
        $dateYesterday = new \DateTime('yesterday');

        return $this->render('keltanasTrackingBundle:Default:index.html.twig', [
                'dateToday' => $dateToday,
                'dateYesterday' => $dateYesterday,
                'sourcesToday' => $repository->getQueryGroupingByRange($dateToday)->getResult(),
                'sourcesYesterday' => $repository->getQueryGroupingByRange($dateYesterday, $dateToday)->getResult(),
            ]);
    }

    public function listAction()
    {
        /** @var \keltanas\Bundle\TrackingBundle\Entity\HistoryRepository $repository */
        $repository = $this->getDoctrine()->getRepository('keltanasTrackingBundle:History');

        $paginator  = $this->get('knp_paginator');
        $history = $paginator->paginate(
            $repository->getQueryNoBot(),
            $this->getRequest()->query->get('page', 1)/*page number*/,
            20/*limit per page*/
        );

        return $this->render('keltanasTrackingBundle:Default:list.html.twig', [
                'history' => $history,
            ]);
    }
}
