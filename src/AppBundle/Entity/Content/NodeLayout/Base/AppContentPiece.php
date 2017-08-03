<?php

namespace AppBundle\Entity\Content\NodeLayout\Base;

use AppBundle\Entity\Content\ContentNode;
use AppBundle\Entity\Content\NodeLayout\InlineLayout;
use AppBundle\Entity\Media\Media;
use AppBundle\Entity\User\Base\AppUser;
use Doctrine\Common\Collections\ArrayCollection;
use Sonata\UserBundle\Entity\BaseUser;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/** @ORM\MappedSuperclass */
abstract class AppContentPiece {
	/**
	 * ID_REF
	 * @ORM\Id
	 * @ORM\Column(type="string", length=24)
	 * @ORM\GeneratedValue(strategy="CUSTOM")
	 * @ORM\CustomIdGenerator(class="AppBundle\Doctrine\ORM\RandomIdGenerator")
	 */
	protected $id;
	
	function __construct() {
	
	}
	
	/**
	 * @return mixed
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * @var InlineLayout
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Content\NodeLayout\InlineLayout",inversedBy="contentPieces")
	 * @ORM\JoinColumn(name="id_inline_layout", referencedColumnName="id", onDelete="CASCADE", nullable=false)
	 */
	protected $layout;
	
	/**
	 * @var array
	 * @ORM\Column(type="attribute_array",nullable=true)
	 */
	protected $shortcodes;
	
	/**
	 * @var string
	 * @ORM\Column(type="text",nullable=true)
	 */
	protected $raw;
	/**
	 * @var string
	 * @ORM\Column(type="string",length=255,nullable=true)
	 */
	protected $formatter;
	/**
	 * @var string
	 * @ORM\Column(type="text",nullable=true)
	 */
	protected $content;
	
	/**
	 * @return string
	 */
	public function getRaw() {
		return $this->raw;
	}
	
	/**
	 * @param string $raw
	 */
	public function setRaw($raw) {
		$this->raw = $raw;
	}
	
	/**
	 * @return string
	 */
	public function getFormatter() {
		return $this->formatter;
	}
	
	/**
	 * @param string $formatter
	 */
	public function setFormatter($formatter) {
		$this->formatter = $formatter;
	}
	
	/**
	 * @return string
	 */
	public function getContent() {
		return $this->content;
	}
	
	/**
	 * @param string $content
	 */
	public function setContent($content) {
		$this->content = $content;
	}
	
	/**
	 * @return InlineLayout
	 */
	public function getLayout() {
		return $this->layout;
	}
	
	/**
	 * @param InlineLayout $layout
	 */
	public function setLayout($layout) {
		$this->layout = $layout;
	}
}