<?php
namespace AppBundle\Entity\Content\NodeType\Blog;

 use AppBundle\Entity\Content\NodeType\Blog\Base\AppBlogItem;
use AppBundle\Entity\Content\NodeType\Blog\Base\AppBlogNode;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * ORM\Entity
 * ORM\Table(name="content__node__blog_item")
 *
 * @Hateoas\Relation(
 *  "self",
 *  href= @Hateoas\Route(
 *         "get_jobs",
 *         parameters = { "user" = "expr(object.getId())"},
 *         absolute = true
 *     ),
 *  attributes = { "method" = {} },
 * )
 *
 */
class BlogItem extends AppBlogItem
{
    function __construct()
    {
        parent::__construct();
        
    }

}
