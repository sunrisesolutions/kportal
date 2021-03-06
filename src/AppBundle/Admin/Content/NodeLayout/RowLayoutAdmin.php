<?php

namespace AppBundle\Admin\Content\NodeLayout;

use AppBundle\Admin\BaseAdmin;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Valid;

class RowLayoutAdmin extends GenericLayoutAdmin {
	protected $parentAssociationMapping = 'rootContainer';
	
	protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
		// this text filter will be used to retrieve autocomplete fields
		$datagridMapper
			->add('id')
			->add('name');
	}
	
	protected function configureListFields(ListMapper $listMapper) {
		$listMapper
			->addIdentifier('id');
	}
	
	protected function configureFormFields(FormMapper $formMapper) {
		$isAdmin   = $this->isAdmin();
		$container = $this->getConfigurationPool()->getContainer();
//		$position  = $container->get( 'app.user' )->getPosition();
		
		// define group zoning
 		$formMapper
			->tab('form.tab_info')
			->with('form.group_general')//            ->add('children')
		;
		$formMapper->add('name',null, array(
			'label'=>'list.label_name'
		));
		
		$formMapper->add('parent', ModelType::class, array(
//					'label' => 'form.label_work_location',
				'property' => 'name',
				
				'btn_add'     => false,
				'required'    => false,
				'constraints' => new Valid(),
				'multiple'    => false,
				'query'       => $this->getParentQuery()
			)
		);
		
		
		$formMapper
			->end()
			->end();
		
	}
}