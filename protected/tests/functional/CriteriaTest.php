<?php

class CriteriaTest extends WebTestCase
{
	public $fixtures=array(
		'criterias'=>'Criteria',
	);

	public function testShow()
	{
		$this->open('?r=criteria/view&id=1');
	}

	public function testCreate()
	{
		$this->open('?r=criteria/create');
	}

	public function testUpdate()
	{
		$this->open('?r=criteria/update&id=1');
	}

	public function testDelete()
	{
		$this->open('?r=criteria/view&id=1');
	}

	public function testList()
	{
		$this->open('?r=criteria/index');
	}

	public function testAdmin()
	{
		$this->open('?r=criteria/admin');
	}
}
