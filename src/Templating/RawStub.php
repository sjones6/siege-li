<?php

namespace SiegeLi\Templating;


class RawStub
{


	/**
	* @var string | stub template string
	**/
	protected $stub = '';


	/**
	* @param string | raw stub
	**/
	public function __construct($stub = '')
	{

		$this->setStub($stub);
	
	}
		
	/**
	* Description
	*
	* @param string | stub string
	*
	* @return void
	*
	* @author Spencer Jones
	**/
	public function setStub($stub)
	{

		$this->stub = $stub;
	
	}


	/**
	* Description
	*
	* @param void 
	*
	* @return string | stub string
	*
	* @author Spencer Jones
	**/
	public function getStub()
	{

		return $this->stub;	
	
	}
		

}