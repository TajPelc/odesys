<?php

class EvaluationTest extends WebTestCase
{
	public $fixtures=array(
		'evaluations'=>'Evaluation',
	);

	public function testShow()
	{
		$this->open('?r=evaluation/view&id=1');
	}

	public function testCreate()
	{
		$this->open('?r=evaluation/create');
	}

	public function testUpdate()
	{
		$this->open('?r=evaluation/update&id=1');
	}

	public function testDelete()
	{
		$this->open('?r=evaluation/view&id=1');
	}

	public function testList()
	{
		$this->open('?r=evaluation/index');
	}

	public function testAdmin()
	{
		$this->open('?r=evaluation/admin');
	}
}
