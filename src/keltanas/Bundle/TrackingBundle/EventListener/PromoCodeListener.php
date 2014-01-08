<?php
/**
 *
 * @author: Nikolay Ermin <keltanas@gmail.com>
 */

namespace keltanas\Bundle\TrackingBundle\EventListener;


use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class PromoCodeListener
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * @var boolean
     */
    private $debug;

    public function __construct(EntityManager $em, $debug = false)
    {
        $this->em = $em;
        $this->debug = $debug;
    }

    /**
     * Store value to cookie
     * @param FilterResponseEvent $event
     */
    public function onKernelResponse(FilterResponseEvent $event)
    {
        $event->getResponse()->setContent(
            str_replace('<!--promocode-->',
                substr($event->getRequest()->cookies->get('tracker_id'), -6, 6),
                $event->getResponse()->getContent()
            )
        );
    }
}
