<?php
/**
 * Tracking referals
 * @author: Nikolay Ermin <keltanas@gmail.com>
 */

namespace keltanas\Bundle\TrackingBundle\EventListener;

use Doctrine\ORM\EntityManager;
use keltanas\Bundle\TrackingBundle\Entity\History;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class RequestRefererListener
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
     * Value for default
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        if (!$request->cookies->has('referer')) {
            $request->cookies->set('referer', $request->headers->get('referer'));
        }
    }

    /**
     * Store value to cookie
     * @param FilterResponseEvent $event
     */
    public function onKernelResponse(FilterResponseEvent $event)
    {
        $request = $event->getRequest();
        if (!$this->debug || ($this->debug && !in_array(substr($request->getRequestUri(), 0, 2), ['/_', '/j', '/c', '/i']))) {
            $history = null;
            if ($request->cookies->has('tracker_id')) {
                /** @var History $history */
                $history = $this->em->find('keltanasTrackingBundle:History', $request->cookies->get('tracker_id'));
                if ($history) {
                    $history->setCounter($history->getCounter() + 1);
                    $this->em->persist($history);
                    $this->em->flush();
                }
            }
            if (!$history) {
                $history = new History();
                $history->setIp($request->getClientIp());
                $history->setReferer(urldecode($request->headers->get('referer')));
                $history->setUa($request->headers->get('User-Agent'));
                $history->setUri($request->getUri());
                $history->setCounter(1);

                if ($request->query->get('utm_source')) {
                    $tail = $request->query->all();
                    foreach ($tail as $key => $val) {
                        switch ($key) {
                            case 'utm_source': $history->setUtmSource($val); unset($tail[$key]); break;
                            case 'utm_medium': $history->setUtmMedium($val); unset($tail[$key]); break;
                            case 'utm_campaign': $history->setUtmCampaign($val); unset($tail[$key]); break;
                            case 'utm_content': $history->setUtmContent($val); unset($tail[$key]); break;
                            case 'utm_term': $history->setUtmTerm($val); unset($tail[$key]); break;
                            case 'keyword': $history->setUtmTerm($val); unset($tail[$key]); break;
                        }
                    }
                    $history->setTail($tail);
                }
//                if ($request->query->count()) {
//                    $history->setCounter(0);
//                    $event->getResponse()->setStatusCode(302);
//                    $event->getResponse()->headers->set('Location', $request->getSchemeAndHttpHost() . $request->getPathInfo());
//                }

                $this->em->persist($history);
                $this->em->flush();
                $event->getResponse()->headers->setCookie(
                    new Cookie('referer', $request->headers->get('referer'), time() + 3600 * 24 * 365, '/', '.' . $request->getHost(), false, false)
                );
                $event->getResponse()->headers->setCookie(
                    new Cookie('tracker_id', $history->getId(), time() + 3600 * 24 * 365, '/', '.' . $request->getHost(), false, false)
                );
                $event->getRequest()->cookies->set('tracker_id', $history->getId());
            }
        }
    }
}
