<?php

class alternativeTest extends WebTestCase
{
	public $fixtures=array(
		'alternatives'=>'alternative',
	);

	public function testShow()
	{
		$this->open('?r=alternative/view&id=1');
	}

	public function testCreate()
	{
		$this->open('?r=alternative/create');
	}

	public function testUpdate()
	{
		$this->open('?r=alternative/update&id=1');
	}

	public function testDelete()
	{
		$this->open('?r=alternative/view&id=1');
	}

	public function testList()
	{
		$this->open('?r=alternative/index');
	}

	public function testAdmin()
	{
		$this->open('?r=alternative/admin');
	}
}
