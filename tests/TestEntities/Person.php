<?php
namespace TestEntities;

/**
 * @Entity
 * @Table
 *
 */
class Person {
	
	
	/**
	 * @Id
	 * @GeneratedValue(strategy="AUTO")
	 * @Column(type="integer")
	 */
	protected $id;
	
	
	/**
	 * @Column
	 */
	protected $name;
	
	
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
	 * @return the $id
	 */
	public function getId() {
		return $this->id;
	}

	
}