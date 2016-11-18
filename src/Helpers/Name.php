<?php

namespace SiegeLi\Helpers;


// Laravel
use Illuminate\Support\Str;
use Illuminate\Console\AppNamespaceDetectorTrait;

// Packages
use Carbon\Carbon;

class Name
{

	use AppNamespaceDetectorTrait;

	/**
	* Set PHP file name
	*
	* @param $name | filename
	*
	* @return string | qualified file name
	*
	* @author Spencer Jones
	**/
	public static function file($name = '')
	{

		return self::setEnding($name, '.php');

	}

	/**
	* Sets the current stub name
	*
	* @param $name | filename
	*
	* @return string | qualified file name
	*
	* @author Spencer Jones
	**/
	public static function dir($name = '')
	{

		// Convert to slug case
		return Str::slug($name) . '/';

	}

	/**
	* Sets the current model name
	*
	* @param $name | filename
	*
	* @return string | qualified model file name
	*
	* @author Spencer Jones
	**/
	public static function model($name = '')
	{

		return self::setEnding(Str::studly($name), '.php');

	}

	/**
	* Creates a properly formed stub name
	*
	* @param $name | filename
	*
	* @return string | qualified stub file name
	*
	* @author Spencer Jones
	**/
	public static function stub($name = '')
	{

		// Convert to studly case
		$name = Str::studly($name);

		// Check for PHP extension
		$name = (!Str::endsWith($name, '.php')) ? $name . '.php' : $name;

		// Check for Stub
		$name = (!Str::endsWith($name, 'Stub.php')) ? preg_replace('/\.php/', 'Stub.php', $name) : $name;

		return $name;

	}

	/**
	* Creates a properly formed controller template name
	*
	* @param $name | filename
	*
	* @return string | qualified controller file name
	*
	* @author Spencer Jones
	**/
	public static function controller($name = '')
	{

		return self::setEnding(Str::studly($name), 'Controller.php');

	}

	/**
	* Creates a properly formed blade template name
	*
	* @param $name | filename
	*
	* @return string | qualified blade file name
	*
	* @author Spencer Jones
	**/
	public static function blade($name = '')
	{

		return self::setEnding(Str::slug($name), '.blade.php');

	}
	

	/**
	* Creates a properly formed migration
	*
	* @param $name | filename
	*
	* @return string | qualified migration file name
	*
	* @author Spencer Jones
	**/
	public static function migration($name = '')
	{

		$now = new Carbon();

		$params = [
			'year' => $now->format('Y'),
			'month' => $now->format('m'),
			'day' => $now->format('d'),
			'time' => $now->format('His'),
			'name' => 'create_' . Str::plural(Str::slug($name)) . '_table'
		];

		return self::setEnding(implode($params, '_'), '.php');

	}

	/**
	* Creates a properly formed seeder
	*
	* @param $name | filename
	*
	* @return string | qualified seeder file name
	*
	* @author Spencer Jones
	**/
	public static function seed($name = '')
	{

		return self::setEnding(Str::studly($name), 'Seeder.php');

	}

	/**
	* Creates a properly formed test
	*
	* @param $name | filename
	*
	* @return string | qualified test file name
	*
	* @author Spencer Jones
	**/
	public static function test($name = '')
	{

		return self::setEnding(Str::studly($name), 'Test.php');

	}

	/**
	* Get the application namespace
	*
	* @param void
	*
	* @return string | qualified namespace
	*
	* @author Spencer Jones
	**/
	public static function space()
	{

		$name = new self();

		return preg_replace('/\\\\/', '', Str::studly($name->getAppNamespace()));

	}


	/**
	* Adds the necessary ending to file names
	*
	* @param string | filename
	* @param string | necessary file ending
	* 
	* @return string | qualified filename
	*
	* @author Spencer Jones
	**/
	protected static function setEnding($fileName, $ending) {

		// Check for PHP extension
		$fileName = (!Str::endsWith($fileName, '.php')) ? $fileName . '.php' : $fileName;

	
		return (!Str::endsWith($fileName, $ending)) 
				? preg_replace('/\.php/', $ending, $fileName)
				: $fileName;
	
	}
		

}