<?php

namespace AppBundle\Entity\Content\NodeType\Taxonomy\Base;

use AppBundle\Entity\Content\ContentNode;
use AppBundle\Entity\Content\NodeType\Taxonomy\TaxonomyContext;
use AppBundle\Entity\Content\NodeType\Taxonomy\TaxonomyItem;
use AppBundle\Entity\Content\NodeType\Taxonomy\TaxonomyNode;
use AppBundle\Entity\User\User;
use Doctrine\Common\Collections\ArrayCollection;
use Sonata\MediaBundle\Entity\BaseGallery as BaseGallery;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

abstract class AppTaxonomyNode extends ContentNode {
	
	function __construct() {
		parent::__construct();
		$this->container = true;
		$this->items     = new ArrayCollection();
		
	}
	
	/**
	 * @var ArrayCollection
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\Content\NodeType\Taxonomy\TaxonomyItem", mappedBy="taxonomy", cascade={"all"}, orphanRemoval=true)
	 */
	protected $items;
	
	public function addItem(TaxonomyItem $item) {
		$this->items->add($item);
		$item->setTaxonomy($this);
	}
	
	public function removeItem(TaxonomyItem $item) {
		$this->items->removeElement($item);
		$item->setTaxonomy(null);
	}
	
	
	/**
	 * @var TaxonomyContext
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Content\NodeType\Taxonomy\TaxonomyContext",inversedBy="taxonomies")
	 * @ORM\JoinColumn(name="id_taxonomy_context", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected $context;
	
	/**
	 * @var boolean
	 * @ORM\Column(type="boolean", nullable=true, options={"default":true})
	 */
	protected $enabled = true;
	
	/**
	 * @return bool
	 */
	public function isEnabled() {
		return $this->enabled;
	}
	
	/**
	 * @return TaxonomyContext
	 */
	public function getContext() {
		return $this->context;
	}
	
	/**
	 * @param TaxonomyContext $context
	 */
	public function setContext($context) {
		$this->context = $context;
	}
	
	/**
	 * @param bool $enabled
	 */
	public function setEnabled($enabled) {
		$this->enabled = $enabled;
	}
	
	
	/**
	 * @return ArrayCollection
	 */
	public function getItems() {
		return $this->items;
	}
	
	/**
	 * @param ArrayCollection $items
	 */
	public function setItems($items) {
		$this->items = $items;
	}
	
	
}