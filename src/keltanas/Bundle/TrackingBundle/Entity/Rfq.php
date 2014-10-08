<?php

namespace keltanas\Bundle\TrackingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use keltanas\Bundle\TrackingBundle\Entity\Form;
use keltanas\Bundle\TrackingBundle\Entity\History;

/**
 * Rfq
 *
 * @ORM\Table(name="keltanas_rfq")
 * @ORM\Entity(repositoryClass="keltanas\Bundle\TrackingBundle\Entity\RfqRepository")
 */
class Rfq
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Form
     *
     * @ORM\ManyToOne(targetEntity="keltanas\Bundle\TrackingBundle\Entity\Form", inversedBy="rfq")
     * @ORM\JoinColumn(name="form_id", referencedColumnName="id", nullable=true)
     */
    private $form;

    /**
     * @var History
     *
     * @ORM\ManyToOne(targetEntity="keltanas\Bundle\TrackingBundle\Entity\History", inversedBy="rfq")
     * @ORM\JoinColumn(name="history_id", referencedColumnName="id")
     */
    private $history;

    /**
     * @var string
     */
    private $history_id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="button", type="string", length=255, nullable=true)
     */
    private $button;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="ip", type="string", length=15)
     */
    private $ip;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var integer
     *
     * @ORM\Column(name="number_entry", type="integer")
     */
    private $numberEntry;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer", nullable=true)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="result", type="text", nullable=true)
     */
    private $result;


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
     * @param Form $form
     */
    public function setForm($form)
    {
        $this->form = $form;
        $this->setTitle($form->getTitle());
        $this->setButton($form->getButton());
    }

    /**
     * @return Form
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * @param History $history
     */
    public function setHistory($history)
    {
        $this->history = $history;
        if ($history) {
            $this->setNumberEntry($history->getCounter());
        }
    }

    /**
     * @return History
     */
    public function getHistory()
    {
        return $this->history;
    }

    /**
     * @param string $history_id
     */
    public function setHistoryId($history_id)
    {
        $this->history_id = $history_id;
    }

    /**
     * @return string
     */
    public function getHistoryId()
    {
        return $this->history ? $this->history->getId() : $this->history_id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Rfq
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set button
     *
     * @param string $button
     * @return Rfq
     */
    public function setButton($button)
    {
        $this->button = $button;

        return $this;
    }

    /**
     * Get button
     *
     * @return string
     */
    public function getButton()
    {
        return $this->button;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Rfq
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return Rfq
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set ip
     *
     * @param string $ip
     * @return Rfq
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Rfq
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set numberEntry
     *
     * @param integer $numberEntry
     * @return Rfq
     */
    public function setNumberEntry($numberEntry)
    {
        $this->numberEntry = $numberEntry;

        return $this;
    }

    /**
     * Get numberEntry
     *
     * @return integer
     */
    public function getNumberEntry()
    {
        return $this->numberEntry;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return Rfq
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set result
     *
     * @param string $result
     * @return Rfq
     */
    public function setResult($result)
    {
        $this->result = $result;

        return $this;
    }

    /**
     * Get result
     *
     * @return string
     */
    public function getResult()
    {
        return $this->result;
    }
}
