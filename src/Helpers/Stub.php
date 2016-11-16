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
	public function makeWithOptions(Collection $options = null)
	{

		// We have no options
		// just return the stub text as is
		if (empty($options)) {
			return $this->getStubText();
		}
	
		// Process all variables first
		// so that included blocks will be 
		// set appropriately
		$options->get('vars')->each(function($value, $key){
			$this->process($key, $value);
		});

		// Process all flags
		if ($options->get('all')) {
			$this->includeAll();
		} else {
			$options->get('flags')->each(function($flag){
				$this->processOption($flag);
			});
		}
		

		return $this->getFinalStubText();

	}

	/**
	* Makes any final cleanup
	* before return stub text
	*
	* @param void
	*
	* @return string | final stub text
	*
	* @author Spencer Jones
	**/
	protected function getFinalStubText() {

		// Stubs use {{ $variable }}
		$re = '/<<<else.*>>>/U';
		$this->setStubText(preg_replace($re, '', $this->getStubText()));

		// Include all the negative
		$re = '/<<<\s*!\w+\s+(.*)>>>/Us';
		$this->setStubText(preg_replace($re, '$1', $this->getStubText()));

		// Delete all others
		$re = '/<<<.*>>>/sU';
		$this->setStubText(preg_replace($re, '', $this->getStubText()));

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
	public function getStubs()
	{
	
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
	* Include all template blocks
	*
	* @param void
	*
	* @return void
	*
	* @author Spencer Jones
	**/
	public function includeAll()
	{
	
		// Remove else statements
		$re = '/<<<\s*else.*>>>/Us';
		$this->setStubText(preg_replace($re, '', $this->getStubText()));

		// Set new stub text to replaced value
		$re = '/<<<\S+\s+(.*)>>>/Us';
		$this->setStubText(preg_replace($re, trim('$1'), $this->getStubText()));

	}


	/**
	* Include a certain template block
	*
	* @param string | key to process
	* @param string | value to replace key with
	*
	* @return void
	*
	* @author Spencer Jones
	**/
	public function processOption($key)
	{
	
		// Grab everything between <<< and >>>
		// where the $key matches
		$re = '/<<<' . $key . '\s*(.*)>>>/Us';

		// Set new stub text to replaced value
		$this->setStubText(preg_replace($re, trim('$1'), $this->getStubText()));

		// Delete everything between <<<!key and >>>
		$re = '/<<<!\s*' . $key . '\s*.*>>>/Us';

		// Set new stub text to replaced value
		$this->setStubText(preg_replace($re, '', $this->getStubText()));

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
	public static function stubName($name = '')
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