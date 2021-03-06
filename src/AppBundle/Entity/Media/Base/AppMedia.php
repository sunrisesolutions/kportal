<?php

namespace AppBundle\Entity\Media\Base;

use AppBundle\Entity\H5P\ContentMedia;
use AppBundle\Entity\Media\Media;
use AppBundle\Entity\Organisation\Organisation;
use AppBundle\Entity\User\User;
use Sonata\MediaBundle\Entity\BaseMedia;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/** @ORM\MappedSuperclass */
class AppMedia extends BaseMedia {
	/**
	 * @ORM\Id
	 * @ORM\Column(type="string", length=24)
	 * @ORM\GeneratedValue(strategy="CUSTOM")
	 * @ORM\CustomIdGenerator(class="AppBundle\Doctrine\ORM\RandomIdGenerator")
	 */
	protected $id;
	
	function __construct() {
		$this->mediaH5PContent     = new ArrayCollection();
		$this->enabled             = true;
	}
	
	/**
	 * @var Media
	 */
	protected $thumbnail;
	
	/**
	 * @var User
	 */
	protected $avatarUser;
	
	/**
	 * @var ArrayCollection
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\H5P\ContentMedia", mappedBy="media", orphanRemoval=true)
	 */
	protected $mediaH5PContent;
	
	public function addMediaH5PContent(ContentMedia $cMedia) {
		$this->mediaH5PContent->add($cMedia);
		$cMedia->setMedia($this);
	}
	
	public function removeMediaH5PContent(ContentMedia $cMedia) {
		$this->mediaH5PContent->remove($cMedia);
		$cMedia->setMedia(null);
	}
	
	/**
	 * @var Organisation
	 * @ORM\OneToOne(targetEntity="AppBundle\Entity\Organisation\Organisation", mappedBy="logo")
	 */
	protected $logoOrganisation;
	
	/**
	 * Get id
	 *
	 * @return int $id
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * @return Organisation
	 */
	public function getLogoOrganisation() {
		return $this->logoOrganisation;
	}
	
	/**
	 * @param Organisation $logoOrganisation
	 */
	public function setLogoOrganisation($logoOrganisation) {
		$this->logoOrganisation = $logoOrganisation;
	}
	
	
	/**
	 * @param ArrayCollection $resumeCandidates
	 */
	public function setResumeCandidates($resumeCandidates) {
		$this->resumeCandidates = $resumeCandidates;
	}
	
	/**
	 * @return Media
	 */
	public function getThumbnail() {
		return $this->thumbnail;
	}
	
	/**
	 * @param Media $thumbnail
	 */
	public function setThumbnail($thumbnail) {
		$this->thumbnail = $thumbnail;
	}
	
	/**
	 * @return User
	 */
	public function getAvatarUser() {
		return $this->avatarUser;
	}
	
	/**
	 * @param User $avatarUser
	 */
	public function setAvatarUser($avatarUser) {
		$this->avatarUser = $avatarUser;
	}
	
	/**
	 * @return ArrayCollection
	 */
	public function getMediaH5PContent() {
		return $this->mediaH5PContent;
	}
	
	/**
	 * @param ArrayCollection $mediaH5PContent
	 */
	public function setMediaH5PContent($mediaH5PContent) {
		$this->mediaH5PContent = $mediaH5PContent;
	}
}