<?php
/**
 *
 * @author: Nikolay Ermin <keltanas@gmail.com>
 */

namespace keltanas\Bundle\TrackingBundle\Component;


use Doctrine\ORM\EntityManager;
use keltanas\Bundle\TrackingBundle\Entity\History;
use Symfony\Bundle\TwigBundle\TwigEngine;
use Symfony\Component\HttpFoundation\Request;

class Postman
{
    private $from;

    private $to;

    /** @var \Swift_Mailer */
    private $mailer;

    /** @var TwigEngine */
    private $templating;

    /** @var EntityManager  */
    private $em;

    public function __construct(array $config, \Swift_Mailer $mailer, TwigEngine $templating, EntityManager $em)
    {
        $this->to = $config['email_to'];
        $this->from = $config['email_from'];
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->em = $em;
    }

    public function sendMessage($subject, $template, $data, Request $request = null)
    {
        $history = null;
        if ($request && $request->cookies->has('tracker_id')) {
            /** @var \keltanas\Bundle\TrackingBundle\Entity\History $history */
            $history = $this->em->find('keltanasTrackingBundle:History', $request->cookies->get('tracker_id'));
        }

        $message = $this->mailer->createMessage()
            ->setSubject($subject)
            ->setFrom($this->from)
            ->setTo($this->to)
            ->setBody($this->templating->render($template, [
                'data' => $data,
                'history' => $history,
            ]), 'text/html', 'utf-8');
        $this->mailer->send($message);
    }
}
