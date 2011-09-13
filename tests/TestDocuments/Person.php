<?php
namespace TestDocuments;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\Document(collection="person")
 */
class Person
{

	/**
	 * @ODM\Id
	 */
	protected $id;
	
	/**
	 * @ODM\Field(type="string")
	 */
	protected $name;
	
	/**
	 * @ODM\Field(type="int")
	 */
	protected $age;
	
	/**
	 * @return the $name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @param field_type $name
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * @return the $age
	 */
	public function getAge() {
		return $this->age;
	}

	/**
	 * @param field_type $age
	 */
	public function setAge($age) {
		$this->age = $age;
	}

	/**
	 * @return the $id
	 */
	public function getId() {
		return $this->id;
	}

	
	
}