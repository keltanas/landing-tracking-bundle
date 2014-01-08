<?php

namespace keltanas\Bundle\TrackingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use keltanas\Bundle\TrackingBundle\Entity\Rfq;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * History
 *
 * @ORM\Table(name="keltanas_history")
 * @ORM\Entity(repositoryClass="keltanas\Bundle\TrackingBundle\Entity\HistoryRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class History
{
    /**
     * @var string
     *
     * @ORM\Id
     * @ORM\Column(type="string", length=36)
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @var Rfq
     *
     * @ORM\OneToMany(targetEntity="keltanas\Bundle\TrackingBundle\Entity\Rfq", mappedBy="history")
     */
    private $rfq;

    /**
     * @var string
     *
     * @ORM\Column(name="ip", type="string", length=15)
     */
    private $ip;

    /**
     * @var string
     *
     * @ORM\Column(name="ua", type="string", length=255)
     */
    private $ua;

    /**
     * @var string
     *
     * @ORM\Column(name="uri", type="string", length=255)
     */
    private $uri;

    /**
     * @var string
     *
     * @ORM\Column(name="referer", type="string", length=255, nullable=true)
     */
    private $referer;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="tracking_at", type="datetime")
     */
    private $trackingAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;

    /**
     * @var int
     *
     * @ORM\Column(name="counter", type="integer", nullable=true)
     */
    private $counter;

    /**
     * @var string
     *
     * @ORM\Column(name="utm_source", type="string", length=255, nullable=true)
     */
    private $utmSource;

    /**
     * @var string
     *
     * @ORM\Column(name="utm_medium", type="string", length=255, nullable=true)
     */
    private $utmMedium;

    /**
     * @var string
     *
     * @ORM\Column(name="utm_campaign", type="string", length=255, nullable=true)
     */
    private $utmCampaign;

    /**
     * @var string
     *
     * @ORM\Column(name="utm_content", type="string", length=255, nullable=true)
     */
    private $utmContent;

    /**
     * @var string
     *
     * @ORM\Column(name="utm_term", type="string", length=255, nullable=true)
     */
    private $utmTerm;

    /**
     * @var array
     *
     * @ORM\Column(name="tail", type="json_array", nullable=true)
     */
    private $tail;

    /**
     * @var boolean
     *
     * @ORM\Column(name="bot", type="boolean")
     */
    private $bot = false;

    public function __toString()
    {
        return $this->getId();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param \keltanas\Bundle\TrackingBundle\Entity\Rfq $rfq
     */
    public function setRfq($rfq)
    {
        $this->rfq = $rfq;
    }

    /**
     * @return \keltanas\Bundle\TrackingBundle\Entity\Rfq
     */
    public function getRfq()
    {
        return $this->rfq;
    }

    /**
     * Set ip
     *
     * @param string $ip
     * @return History
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get ip
     *
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set ua
     *
     * @param string $ua
     * @return History
     */
    public function setUa($ua)
    {
        $this->ua = $ua;

        return $this;
    }

    /**
     * Get ua
     *
     * @return string
     */
    public function getUa()
    {
        return $this->ua;
    }

    /**
     * @param string $uri
     */
    public function setUri($uri)
    {
        $this->uri = $uri;
    }

    /**
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * Set referer
     *
     * @param string $referer
     * @return History
     */
    public function setReferer($referer)
    {
        $this->referer = $referer;

        return $this;
    }

    /**
     * Get referer
     *
     * @return string
     */
    public function getReferer()
    {
        return $this->referer;
    }

    /**
     * Get trackingAt
     *
     * @return \DateTime
     */
    public function getTrackingAt()
    {
        return $this->trackingAt;
    }

    /**
     * @ORM\PrePersist
     */
    public function setTrackingAtValue()
    {
        $this->trackingAt = new \DateTime('now');
    }

    /**
     * @ORM\PreUpdate
     * @ORM\PrePersist
     */
    public function setUpdatedAtValue()
    {
        $this->updatedAt = new \DateTime('now');
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }


    /**
     * Set utmSource
     *
     * @param string $utmSource
     * @return History
     */
    public function setUtmSource($utmSource)
    {
        $this->utmSource = $utmSource;

        return $this;
    }

    /**
     * Get utmSource
     *
     * @return string
     */
    public function getUtmSource()
    {
        return $this->utmSource;
    }

    /**
     * Set utmMedium
     *
     * @param string $utmMedium
     * @return History
     */
    public function setUtmMedium($utmMedium)
    {
        $this->utmMedium = $utmMedium;

        return $this;
    }

    /**
     * Get utmMedium
     *
     * @return string
     */
    public function getUtmMedium()
    {
        return $this->utmMedium;
    }

    /**
     * Set utmCampaign
     *
     * @param string $utmCampaign
     * @return History
     */
    public function setUtmCampaign($utmCampaign)
    {
        $this->utmCampaign = $utmCampaign;

        return $this;
    }

    /**
     * Get utmCampaign
     *
     * @return string
     */
    public function getUtmCampaign()
    {
        return $this->utmCampaign;
    }

    /**
     * Set utmContent
     *
     * @param string $utmContent
     * @return History
     */
    public function setUtmContent($utmContent)
    {
        $this->utmContent = $utmContent;

        return $this;
    }

    /**
     * Get utmContent
     *
     * @return string
     */
    public function getUtmContent()
    {
        return $this->utmContent;
    }

    /**
     * Set utmTerm
     *
     * @param string $utmTerm
     * @return History
     */
    public function setUtmTerm($utmTerm)
    {
        $this->utmTerm = $utmTerm;

        return $this;
    }

    /**
     * Get utmTerm
     *
     * @return string
     */
    public function getUtmTerm()
    {
        return $this->utmTerm;
    }

    /**
     * Set tail
     *
     * @param array $tail
     * @return array
     */
    public function setTail($tail)
    {
        $this->tail = $tail;

        return $this;
    }

    /**
     * Get tail
     *
     * @return array
     */
    public function getTail()
    {
        return $this->tail;
    }

    /**
     * @param int $counter
     */
    public function setCounter($counter)
    {
        $this->counter = $counter;
    }

    /**
     * @return int
     */
    public function getCounter()
    {
        return $this->counter;
    }

    /**
     * @param boolean $bot
     */
    public function setBot($bot)
    {
        $this->bot = $bot;
    }

    /**
     * @return boolean
     */
    public function getBot()
    {
        return $this->bot;
    }

}
