<?php

namespace AppBundle\Entity\Content\Base;

use AppBundle\Entity\Content\ContentEntity\ContentEntity;
use AppBundle\Entity\Content\ContentNode;
use AppBundle\Entity\Content\ContentPiece\ContentPieceH5P;
use AppBundle\Entity\Content\NodeLayout\RootLayout;
use AppBundle\Entity\Content\NodeType\Taxonomy\TaxonomyItem;
use AppBundle\Entity\Media\Media;
use AppBundle\Entity\User\Base\AppUser;
use Doctrine\Common\Collections\ArrayCollection;
use Sonata\UserBundle\Entity\BaseUser;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/** @ORM\MappedSuperclass */
abstract class AppContentNode {
	
	function __construct() {
		$this->createdAt     = new \DateTime();
		$this->taxonomyItems = new ArrayCollection();
	}
	
	public function getAbstractContent() {
		if( ! empty($this->abstract)) {
			return $this->abstract;
		}
		
		return '<p>' . substr(strip_tags($this->getContent()), 0, 255) . '... </p>';
	}
	
	/**
	 * ID_REF
	 * @ORM\Id
	 * @ORM\Column(type="string", length=24)
	 * @ORM\GeneratedValue(strategy="CUSTOM")
	 * @ORM\CustomIdGenerator(class="AppBundle\Doctrine\ORM\RandomIdGenerator")
	 */
	protected $id;
	
	/**
	 * @var ArrayCollection
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\Content\NodeType\Taxonomy\TaxonomyItem", mappedBy="content", cascade={"all"}, orphanRemoval=true)
	 */
	protected $taxonomyItems;
	
	public function addTaxonomyItem(TaxonomyItem $item) {
		$this->taxonomyItems->add($item);
		$item->setContent($this);
	}
	
	public function removeTaxonomyItem(TaxonomyItem $item) {
		$this->taxonomyItems->removeElement($item);
		$item->setContent(null);
	}
	
	/**
	 * @var ContentEntity
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Content\ContentEntity\ContentEntity",inversedBy="contentNodes")
	 * @ORM\JoinColumn(name="id_owner", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected
		$owner;
	
	/**
	 * @var RootLayout
	 * @ORM\OneToOne(targetEntity="AppBundle\Entity\Content\NodeLayout\RootLayout", mappedBy="node", cascade={"persist","merge"}, orphanRemoval=true)
	 */
	protected $layout;
	
	/**
	 * @var array
	 * @ORM\Column(type="attribute_array", nullable=true)
	 */
	protected
		$h5pContent;
	
	/**
	 * @var \DateTime
	 * @ORM\Column(type="datetime")
	 */
	protected
		$createdAt;
	
	/**
	 * @var \DateTime
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	protected
		$updatedAt;
	
	/**
	 * @var boolean
	 * @ORM\Column(type="boolean", options={"default":false})
	 */
	protected
		$container = false;
	
	/**
	 * @var string
	 * @ORM\Column(type="string",length=255, nullable=true)
	 */
	protected
		$abstract;
	
	/**
	 * ID_REF
	 * @var string
	 * @ORM\Column(type="string", length=24, nullable=true)
	 */
	protected
		$topic;
	
	/**
	 * ID_REF
	 * @var string
	 * @ORM\Column(type="string", length=24, nullable=true)
	 */
	protected
		$rootTopic;
	
	/**
	 * @var string
	 * @ORM\Column(type="string", length=128, nullable=true)
	 */
	protected
		$slug;
	
	/**
	 * @var string
	 * @ORM\Column(type="string", length=256, nullable=true)
	 */
	protected
		$publicUrl;
	
	/**
	 * @var string
	 * @ORM\Column(type="string", length=5, options={"default":"en_GB"} ,  nullable=true)
	 */
	protected
		$locale = 'en_GB';
	
	/**
	 * @var string
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected
		$title;
	
	/**
	 * @var string
	 * @ORM\Column(type="text",nullable=true)
	 */
	protected
		$rawContent;
	
	/**
	 * @var string
	 * @ORM\Column(type="text")
	 */
	protected
		$content;
	
	/**
	 * @return mixed
	 */
	public
	function getId() {
		return $this->id;
	}
	
	/**
	 * @return string
	 */
	public
	function getTopic() {
		return $this->topic;
	}
	
	/**
	 * @param string $topic
	 */
	public
	function setTopic(
		$topic
	) {
		$this->topic = $topic;
	}
	
	/**
	 * @return string
	 */
	public
	function getLocale() {
		return $this->locale;
	}
	
	/**
	 * @param string $locale
	 */
	public
	function setLocale(
		$locale
	) {
		$this->locale = $locale;
	}
	
	/**
	 * @return string
	 */
	public function getRawContent() {
		return $this->rawContent;
	}
	
	/**
	 * @param string $rawContent
	 */
	public function setRawContent($rawContent) {
		$this->rawContent = $rawContent;
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
	 * @return string
	 */
	public
	function getRootTopic() {
		return $this->rootTopic;
	}
	
	/**
	 * @param string $rootTopic
	 */
	public
	function setRootTopic(
		$rootTopic
	) {
		$this->rootTopic = $rootTopic;
	}
	
	/**
	 * @return bool
	 */
	public
	function isContainer() {
		return $this->container;
	}
	
	/**
	 * @param bool $container
	 */
	public
	function setContainer(
		$container
	) {
		$this->container = $container;
	}
	
	/**
	 * @return ContentEntity
	 */
	public
	function getOwner() {
		return $this->owner;
	}
	
	/**
	 * @param ContentEntity $owner
	 */
	public
	function setOwner(
		$owner
	) {
		$this->owner = $owner;
	}
	
	/**
	 * @return string
	 */
	public
	function getSlug() {
		return $this->slug;
	}
	
	/**
	 * @param string $slug
	 */
	public
	function setSlug(
		$slug
	) {
		$this->slug = $slug;
	}
	
	
	/**
	 * @return \DateTime
	 */
	public
	function getCreatedAt() {
		return $this->createdAt;
	}
	
	/**
	 * @param \DateTime $createdAt
	 */
	public
	function setCreatedAt(
		$createdAt
	) {
		$this->createdAt = $createdAt;
	}
	
	/**
	 * @return \DateTime
	 */
	public
	function getUpdatedAt() {
		return $this->updatedAt;
	}
	
	/**
	 * @param \DateTime $updatedAt
	 */
	public
	function setUpdatedAt(
		$updatedAt
	) {
		$this->updatedAt = $updatedAt;
	}
	
	/**
	 * @return string
	 */
	public
	function getPublicUrl() {
		return $this->publicUrl;
	}
	
	/**
	 * @param string $publicUrl
	 */
	public
	function setPublicUrl(
		$publicUrl
	) {
		$this->publicUrl = $publicUrl;
	}
	
	/**
	 * @return string
	 */
	public
	function getTitle() {
		return $this->title;
	}
	
	/**
	 * @param string $title
	 */
	public
	function setTitle(
		$title
	) {
		$this->title = $title;
	}
	
	/**
	 * @return string
	 */
	public
	function getAbstract() {
		return $this->abstract;
	}
	
	/**
	 * @param string $abstract
	 */
	public
	function setAbstract(
		$abstract
	) {
		$this->abstract = $abstract;
	}
	
	/**
	 * @return RootLayout
	 */
	public function getLayout() {
		return $this->layout;
	}
	
	/**
	 * @return array
	 */
	public function getH5pContent() {
		return $this->h5pContent;
	}
	
	/**
	 * @param array $h5pContent
	 */
	public function setH5pContent($h5pContent) {
		$this->h5pContent = $h5pContent;
	}
	
	/**
	 * @return ArrayCollection
	 */
	public function getTaxonomyItems() {
		return $this->taxonomyItems;
	}
	
	/**
	 * @param ArrayCollection $taxonomyItems
	 */
	public function setTaxonomyItems($taxonomyItems) {
		$this->taxonomyItems = $taxonomyItems;
	}
}