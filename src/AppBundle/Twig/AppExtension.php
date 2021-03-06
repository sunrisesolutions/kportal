<?php

namespace AppBundle\Twig;

use AppBundle\Entity\Content\ContentNode;
use AppBundle\Entity\Content\NodeType\Article\ArticleNode;
use AppBundle\Entity\Content\NodeType\Blog\BlogNode;
use AppBundle\Service\SiteService;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class AppExtension extends \Twig_Extension {
	private $generator;
	private $siteService;
	private $requestStack;
	
	public function __construct(UrlGeneratorInterface $generator, SiteService $siteService, RequestStack $requestStack) {
		$this->generator    = $generator;
		$this->siteService  = $siteService;
		$this->requestStack = $requestStack;
	}
	
	/**
	 * Returns a list of functions to add to the existing list.
	 *
	 * @return array An array of functions
	 */
	public function getFunctions() {
		return array(
			new \Twig_SimpleFunction('generateContentPath', array( $this, 'getContentPath' ), array(
				'is_safe_callback' => array(
					$this,
					'isUrlGenerationSafe'
				)
			)),
			new \Twig_SimpleFunction('fileServerURL', array( $this, 'getFileServerURL' ), array()),
			new \Twig_SimpleFunction('isCurrentPage', array( $this, 'isCurrentPage' ), array())
		);
	}
	
	public function isCurrentPage($path) {
		$attributes = $this->requestStack->getCurrentRequest()->attributes;
		
		return $path === $this->generator->generate($attributes->get('_route'), $attributes->get('_route_params'), UrlGeneratorInterface::ABSOLUTE_PATH);
	}
	
	public function getFileServerURL($type = 'file') {
		return $this->siteService->getFileServerURL($type);
	}
	
	public function getContentPath(ContentNode $node, $relative = false) {
		$name   = '';
		$params = [];
		if($node instanceof ArticleNode) {
			$name   = 'content_article';
			$params = [
				'entitySlug'  => $node->getOwner()->getSlug(),
				'articleSlug' => $node->getSlug()
			];
		} elseif($node instanceof BlogNode) {
			$name   = 'content_blog';
			$params = [
				'slug' => $node->getSlug()
			];
		}
		
		return $this->getPath($name, $params, $relative);
	}
	
	/**
	 * @param string $name
	 * @param array  $parameters
	 * @param bool   $relative
	 *
	 * @return string
	 */
	private function getPath($name, $parameters = array(), $relative = false) {
		return $this->generator->generate($name, $parameters, $relative ? UrlGeneratorInterface::RELATIVE_PATH : UrlGeneratorInterface::ABSOLUTE_PATH);
	}
	
	/**
	 * Determines at compile time whether the generated URL will be safe and thus
	 * saving the unneeded automatic escaping for performance reasons.
	 *
	 * The URL generation process percent encodes non-alphanumeric characters. So there is no risk
	 * that malicious/invalid characters are part of the URL. The only character within an URL that
	 * must be escaped in html is the ampersand ("&") which separates query params. So we cannot mark
	 * the URL generation as always safe, but only when we are sure there won't be multiple query
	 * params. This is the case when there are none or only one constant parameter given.
	 * E.g. we know beforehand this will be safe:
	 * - path('route')
	 * - path('route', {'param': 'value'})
	 * But the following may not:
	 * - path('route', var)
	 * - path('route', {'param': ['val1', 'val2'] }) // a sub-array
	 * - path('route', {'param1': 'value1', 'param2': 'value2'})
	 * If param1 and param2 reference placeholder in the route, it would still be safe. But we don't know.
	 *
	 * @param \Twig_Node $argsNode The arguments of the path/url function
	 *
	 * @return array An array with the contexts the URL is safe
	 */
	public function isUrlGenerationSafe(\Twig_Node $argsNode) {
		// support named arguments
		$paramsNode = $argsNode->hasNode('parameters') ? $argsNode->getNode('parameters') : (
		$argsNode->hasNode(1) ? $argsNode->getNode(1) : null
		);
		
		if(null === $paramsNode || $paramsNode instanceof \Twig_Node_Expression_Array && count($paramsNode) <= 2 &&
		                           ( ! $paramsNode->hasNode(1) || $paramsNode->getNode(1) instanceof \Twig_Node_Expression_Constant)
		) {
			return array( 'html' );
		}
		
		return array();
	}
	
}