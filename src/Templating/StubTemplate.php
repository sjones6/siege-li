<?php

namespace SiegeLi\Templating;

// Laravel
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File as Storage;

// Packages
use Symfony\Component\Finder\SplFileInfo;

// Siege
use SiegeLi\Helpers\Group;
use SiegeLi\Helpers\Path;
use SiegeLi\Helpers\File;
use SiegeLi\Helpers\Name;
use SiegeLi\Templating\RawStub;
use SiegeLi\Templating\StubTemplate;


class StubTemplate
{

	/**
	* @var string | stub template string
	**/
	protected $stubText = '';


	public function __construct(RawStub $raw)
	{

		$this->setStubText($raw->getStub());

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
	public function make(array $options = [])
	{
	
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
	* Makes any final cleanup
	* before returning stub text
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

}