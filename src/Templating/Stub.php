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

class Stub
{

	/**
	* @var string | stub name
	**/
	protected $stubName;

	/**
	* @var object | Illuminate\Support\Collection
	**/
	protected $stubs;

	/**
	* @var string | group
	**/
	protected $groupName;

	/**
	* @var object | Symfony\Component\Finder\SplFileInfo
	**/
	protected $stub;

	/**
	* @param string | $group name
	**/
	public function __construct($group = '')
	{

		$this->groupName = (empty($group)) ? Group::defaultGroup() : $group;

		$this->stubs = new Collection(Storage::allFiles($this->stubPath()));

	}

	/**
	* Whether or not a sub exists
	*
	* @param string | name of stub
	*
	* @return boolean | whether or not stub exists or not
	*
	* @author Spencer Jones
	**/
	public function exists($name = '') {
	
		return $this->stubs->contains(function($value, $key) use ($name){
			return $name === $value->getFileName();
		});

	}

	/**
	* Gets the stub template
	*
	* @param void
	*
	* @return
	*
	* @author Spencer Jones
	**/
	public function getStubTemplate() {
	
		return new StubTemplate($this->findRawStub($this->getStubName()));
	
	}
		

	/**
	* Finds template and return raw strub
	*
	* @param string | name of stub to find
	*
	* @return object | SiegeLi\Templating\RawStub
	*
	* @author Spencer Jones
	**/
	public function findRawStub($name = '')
	{

		$this->stubs->search(function($item) use ($name) {
			if ($name === $item->getFileName()) {
				$this->setStub($item);
			}
		});

		return $this->getRawStub(); 
	}


	/**
	* Sets stub var
	*
	* @param object | Symfony\Component\Finder\SplFileInfo
	*
	* @return void
	*
	* @author Spencer Jones
	**/
	protected function setStub(SplFileInfo $stub)
	{

		$this->stub = $stub;

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
	protected function getRawStub()
	{
	
		return new RawStub(File::get($this->stub->getPathName()));

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

		$this->stubName = Name::stub($name);

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

		// If the package has been published
		// use custom, grouped stubs
		if (Storage::exists(Group::path($this->groupName))) {
			return Group::path($this->groupName);
		}
	
		return __DIR__ . '/../Stubs/';

	}

	/******************************************
	|
	| STATIC API
	| 
	******************************************/
	
	/**
	* Gets a stubbed file
	*
	* @param string | $name of stub to get
	* @param string | group name
	* @param array | options to make immediately
	*
	* @return string
	*
	* @author Spencer Jones
	**/
	public static function get($name = '', $group = '', array $options = [])
	{
	
		$stub = new self($group);

		$stub->setStubName($name);

		if ($stub->exists($stub->getStubName())) {

			$template = $stub->getStubTemplate($stub->getStubName());

			// If the options array 
			if (!empty($options)) {

				return $template->makeWithOptions(new Collection($options));

			}

			return $template;

		}

		throw new \Exception('Stub ' . $name . ' not found');

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
	
		return (new self())->stubs->contains(function($value, $key) use ($name){
			return $name === $value->getFileName();
		});

	}
		

}