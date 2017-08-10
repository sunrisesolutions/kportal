<?php

namespace AppBundle\Admin\Content\NodeType\Taxonomy;

use AppBundle\Admin\BaseAdmin;
use AppBundle\Entity\Content\ContentEntity\IndividualEntity;
use AppBundle\Entity\Content\NodeLayout\ColumnLayout;

use AppBundle\Entity\Content\NodeLayout\GenericLayout;
use AppBundle\Entity\Content\NodeLayout\InlineLayout;
use AppBundle\Entity\Content\NodeLayout\RootLayout;
use AppBundle\Entity\Content\NodeLayout\RowLayout;
use AppBundle\Entity\Content\NodeType\Article\ArticleNode;
use AppBundle\Entity\Content\NodeType\Taxonomy\TaxonomyContext;

use AppBundle\Entity\H5P\Content;
use AppBundle\Entity\H5P\ContentType\MultiChoice\ContentMultiChoice;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\CoreBundle\Form\Type\CollectionType;
use Symfony\Component\Validator\Constraints\Valid;

class TaxonomyContextAdmin extends BaseAdmin {
	
	/**
	 * @param TaxonomyContext $object
	 */
	public function toString($object) {
		return ($object->getTitle()) ?: $object->getTopic();
	}
	
	protected function configureListFields(ListMapper $listMapper) {
		$listMapper
			->addIdentifier('id')
			->add('slug', 'text', [ 'editable' => true ]);
	}
	
	protected function configureFormFields(FormMapper $formMapper) {
		$isAdmin   = $this->isAdmin();
		$container = $this->getConfigurationPool()->getContainer();
		
		
		/** @var TaxonomyContext $subject */
		$subject = $this->getSubject();
		
		// define group zoning
		$formMapper
			->tab('form.tab_info')
			->with('form.group_general', [ 'class' => 'col-md-12' ]);
		
		$formMapper
			->add('slug', null, array())
			->add('type')

//			->add('layout.children', ModelAutocompleteType::class, array(
////				'label'              => 'form.label_example_entry',
//				'property'           => 'name',
//				'to_string_callback' => function(GenericLayout $entity, $property) {
//					return $entity->getName();
//				},
//				'required'           => true,
//				'multiple'           => true
//			))
		;
		
		
		$formMapper
			->end()
			->end();
		
	}
	
	/**
	 * @param TaxonomyContext $object
	 */
	public function preValidate($object) {
	
	}
	
	/**
	 * @param TaxonomyContext $object
	 */
	public function postPersist($object) {

//		$container->get( 'app.admin.candidate' )->update( $candidate );
//		$this->getModelManager()->update( $object );
		$this->updateProperties($object);
	}
	
	/**
	 * @param TaxonomyContext $object
	 */
	public function postUpdate($object) {

//		$container->get( 'app.admin.candidate' )->update( $candidate );
//		$this->getModelManager()->update( $object );
//		$this->getModelManager()->update( $object );
		$this->updateProperties($object);
	}
	
	private function updateProperties(TaxonomyContext $object) {
	}
}