<?php

/**
 * This file is part of the <name> project.
 *
 * (c) <yourname> <youremail>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Entity\Media;

//use AppBundle\Event\UndefinedMethodEvent;
use AppBundle\Entity\Media\Base\AppMedia;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;


/**
 * This file has been generated by the Sonata EasyExtends bundle.
 *
 * @link https://sonata-project.org/bundles/easy-extends
 *
 * References :
 *   working with object : http://www.doctrine-project.org/projects/orm/2.0/docs/reference/working-with-objects/en
 *
 * @author <yourname> <youremail>
 */
/**
 * @ORM\Entity
 * @ORM\Table(name="media__media")
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
class Media extends AppMedia
{

    function __construct()
    {
        $this->bannerOrganisations = new ArrayCollection();
        $this->enabled = true;
    }

    public function clearGalleryItems()
    {
        $items = $this->getGalleryHasMedias();
        if(!$items instanceof Collection) {
            return;
        }
        foreach ($items as $item) {
            $this->galleryHasMedias->removeElement($item);
            $item->setMedia(null);
        }
    }

    public function setThumbnail($thumbnail)
    {
        $thumbnail->setContext('thumbnail');
        return parent::setThumbnail($thumbnail);
    }

    public function getMediaExtension()
    {
        $ext = $this->getExtension();
        if (empty($ext)) {
            $metadata = $this->getProviderMetadata();
            if (isset($metadata['provider_name'])) {
                $ext = strtolower($metadata['provider_name']);
            }
            /**
             *
             * if (isset($metadata['filename'])) {
             * $filename = $metadata['filename'];
             * $ext = pathinfo($filename, PATHINFO_EXTENSION);
             * }
             */
        }
        return $ext;
    }

    public function setEnabled($enabled)
    {
        parent::setEnabled($enabled);
        if ($enabled === false) {
            if (($galleryItems = $this->galleryHasMedias) instanceof Collection) {
                foreach ($galleryItems as $item) {
                    $item->setEnabled($enabled);
                }
            }
        }
    }


}
