<?php

namespace keltanas\Bundle\TrackingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use keltanas\Bundle\TrackingBundle\Entity\Rfq;

/**
 * Form
 *
 * @ORM\Table(name="keltanas_form")
 * @ORM\Entity(repositoryClass="keltanas\Bundle\TrackingBundle\Entity\FormRepository")
 */
class Form
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
     * @var Rfq
     *
     * @ORM\OneToMany(targetEntity="keltanas\Bundle\TrackingBundle\Entity\Rfq", mappedBy="form")
     */
    private $rfq;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="button", type="string", length=255)
     */
    private $button;

    /**
     * @var string
     *
     * @ORM\Column(name="template", type="string", length=255)
     */
    private $template;

    public function __toString()
    {
        return sprintf('%s (%s)', $this->getName(), $this->getTitle());
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
     * Set name
     *
     * @param string $name
     * @return Form
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
     * Set email
     *
     * @param string $email
     * @return Form
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Form
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
     * @return Form
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
     * @param string $template
     */
    public function setTemplate($template)
    {
        $this->template = $template;
    }

    /**
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }
}
