<?php

namespace SiegeLi\Helpers;

// Laravel
use Illuminate\Support\Str;
use Illuminate\Support\Collection;

class Stub
{


	/**
	* @var string | stub name
	**/
	protected $stubName;

	/**
	* @var string | stub text raw
	**/
	protected $stubText;

	/**
	* @var type | desc
	**/
	protected $stubs;

	public function __construct()
	{

		$this->stubs = new Collection(scandir($this->stubPath()));

	}

	/**
	* The static counterpart to "exists
	*
	* @param void
	*
	* @return boolean | whether stub exists/not
	*
	* @author Spencer Jones
	**/
	public static function has($name = '')
	{
	
		return (new self())->stubs->contains($name);

	}

	/**
	* Gets a stubbed file
	*
	* @param string | $name of stub to get
	* @param 
	*
	* @return string
	*
	* @author Spencer Jones
	**/
	public static function get($name = '', array $options = [])
	{
	
		$stub = new self();

		$stub->setStubName($name);

		$safeName = $stub->getStubName();

		if ($stub->exists($safeName)) {

			$stub->setStubText($stub->getRawStub($safeName)); 

			// If the options array 
			if (!empty($options)) {

				return $stub->makeWithOptions(new Collection($options));

			}

			return $stub;

		}

		throw new \Exception('Stub not found');

	}

	/**
	* The o
	*
	* @param stirng | name of stub
	*
	* @return boolean | whether or not stub exists or not
	*
	* @author Spencer Jones
	**/
	public function exists($name = '') {
	
		return $this->stubs->contains($name);

	}

	/**
	* Make the populated stub text
	*
	* @param array | options
	*
	* @return
	*
	* @author Spencer Jones
	**/
	public function make(array $options = []) {
	
		return $this->makeWithOptions(new Collection($options));

	}
		
	/**
	* Makes fully populated stub with options array
	*
	* @param object | Illuminate\Supports\Collection
	*
	* @return void
	*
	* @author Spencer Jones
	**/
	public function makeWithOptions(Collection $options = null) {

		if (empty($options)) {
			return $this->getStubText();
		}
	
		$options->each(function($value, $key){

			$this->process($key, $value);

		});

		return $this->getStubText();

	}

	/**
	* Get all available stubs
	*
	* @param void
	*
	* @return object | Illuminate\Support\Collection
	*
	* @author Spencer Jones
	**/
	public function getStubs() {
	
		return $this->stubs;
	
	}	

	/**
	* Sets options collection
	*
	* @param object | Illuminate\Supports\Collection
	*
	* @return void
	*
	* @author Spencer Jones
	**/
	public function setOptions(Collection $options) {

		$this->options = $options;
	
	}
	

	/**
	* Gets options collection
	*
	* @param void
	*
	* @return object | Illuminate\Supports\Collection
	*
	* @author Spencer Jones
	**/
	public function getOptions(Collection $options) {

		return $this->options;
	
	}	

	/**
	* Gets the raw stub text
	*
	* @param string | $raw stub text
	*
	* @return void
	*
	* @author Spencer Jones
	**/
	protected function getRawStub($name = '')
	{
	
		return file_get_contents($this->stubPath() . $name);

	}

	/**
	* Process a variable name and value on stub text
	*
	* @param string | key to process
	* @param string | value to replace key with
	*
	* @return void
	*
	* @author Spencer Jones
	**/
	public function process($key, $value)
	{
	
		// Stubs use {{ $variable }}
		$re = '/\{\{' . $key . '\}\}/';

		// Set new stub text to replaced value
		$this->setStubText(preg_replace($re, $value, $this->getStubText()));

	}


	/**
	* Sets the current stub text
	*
	* @param string | $raw stub text
	*
	* @return void
	*
	* @author Spencer Jones
	**/
	public function setStubText($text = '')
	{
	
		return $this->stubText = $text;

	}


	/**
	* Sets the current stub text
	*
	* @param void
	*
	* @return string | name of current stub
	*
	* @author Spencer Jones
	**/
	public function getStubText($name = '')
	{
	
		return $this->stubText;

	}
	

	/**
	* Sets the current stub name
	*
	* @param void
	*
	* @return string | name of current stub
	*
	* @author Spencer Jones
	**/
	public function stubName($name = '')
	{

		// Convert to studly case
		$name = Str::studly($name);

		// Check for PHP extension
		$name = (!Str::endsWith($name, '.php')) ? $name . '.php' : $name;

		return $name;

	}

	/**
	* Sets the current stub name
	*
	* @param void
	*
	* @return string | name of current stub
	*
	* @author Spencer Jones
	**/
	public function setStubName($name = '')
	{

		$this->stubName = self::stubName($name);

		return $this->stubName;

	}

	/**
	* Gets the current stub name
	*
	* @param void
	*
	* @return string | name of current stub
	*
	* @author Spencer Jones
	**/
	public function getStubName()
	{
	
		return (!empty($this->stubName)) ? $this->stubName : '';

	}


	/**
	* Gets the stub path
	*
	* @param void
	*
	* @return string | path to stubs
	*
	* @author Spencer Jones
	**/
	protected function stubPath()
	{
	
		return __DIR__ . '/../Stubs/';

	}
		

}