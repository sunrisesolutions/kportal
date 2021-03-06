<?php

namespace Bean\Component\Dictionary\Model\Base;

use Doctrine\Common\Collections\ArrayCollection;

interface EntryInterface {
	/**
	 * @return mixed
	 */
	public function getId();
	
	/**
	 * @param mixed $id
	 */
	public function setId($id);
	
	/**
	 * @return mixed
	 */
	public function getLocale();
	
	/**
	 * @param mixed $locale
	 */
	public function setLocale($locale);
	
	/**
	 * @return mixed
	 */
	public function getPhrase();
	
	/**
	 * @param mixed $phrase
	 */
	public function setPhrase($phrase);
	
	/**
	 * @return mixed
	 */
	public function getPhoneticSymbols();
	
	/**
	 * @param mixed $phoneticSymbols
	 */
	public function setPhoneticSymbols($phoneticSymbols);
	
	/**
	 * @return mixed
	 */
	public function getDefinition();
	
	/**
	 * @param mixed $definition
	 */
	public function setDefinition($definition);
	
	/**
	 * @return mixed
	 */
	public function getBriefComment();
	
	/**
	 * @param mixed $commnent
	 */
	public function setBriefComment($commnent);
	
	/**
	 * @return mixed
	 */
	public function getType();
	
	/**
	 * @param mixed $type
	 */
	public function setType($type);
	
	/**
	 * @return mixed
	 */
	public function getSense();
	
	/**
	 * @param mixed $sense
	 */
	public function setSense($sense);
	
	/**
	 * @return ArrayCollection
	 */
	public function getExamples();
	
	/**
	 * @param ArrayCollection $samples
	 */
	public function setExamples($samples);
	
	/**
	 * @param ArrayCollection $entries
	 */
	public function setUsageEntries($entries);
	
	/**
	 * @return ArrayCollection
	 */
	public function getUsageEntries();
	
	/**
	 * @param ArrayCollection $usages
	 */
	public function setUsages($usages);
	
	/**
	 * @return ArrayCollection
	 */
	public function getUsages();
	
	/**
	 * @param ArrayCollection
	 */
	public function setExampleEntries($entries);
	
	
	/**
	 * @return ArrayCollection
	 */
	public function getExampleEntries();
	
}