<?php

namespace AppBundle\Entity\Content\ContentEntity;

use AppBundle\Entity\Content\ContentEntity\Base\AppContentEntity;
use AppBundle\Entity\NLP\Sense;
use AppBundle\Entity\User\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="content__entity")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"individual" = "AppBundle\Entity\Content\ContentEntity\IndividualEntity"})
 */
abstract class ContentEntity extends AppContentEntity {

}