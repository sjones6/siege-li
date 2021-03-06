<?php

namespace SiegeLi\Helpers;

// Laravel
use Illuminate\Support\Facades\Config;

// SiegeLi


class Path
{

	/**
	* Gets a path name from configuration
	*
	* @param string | $name of resource to get path
	*
	* @return string | path
	*
	* @author Spencer Jones
	**/
	public static function get($name)
	{

		if ($name === 'view') {
			return self::view();
		}

		if (empty(Config::get('stubs.paths.' . $name))) {
			throw new \Exception('Path not found. Ensure that the package has been published.');
		}

		return Config::get('stubs.paths.' . $name);
	
	}

	/**
	* Gets a path name from configuration for views
	* uses the path defined first in view config
	*
	* @param void
	*
	* @return string | path to views
	*
	* @author Spencer Jones
	**/
	protected static function view()
	{
	
		return collect(Config::get('view.paths'))->first();

	}
		
	/**
	* Makes a path to a resource
	*
	* @param string | unqualified $path to resource
	* @param string | resource type to make path for
	*
	* @return string | qualified path to resource
	*
	* @author Spencer Jones
	**/
	public static function make($path = '', $resourceType)
	{

		return self::get($resourceType) . '/' . $path;
	
	}

	/**
	* Makes a path to a file
	*
	* @param string | unqualified $path to resource
	* @param string | resource type to make path for
	*
	* @return string | qualified path to resource
	*
	* @author Spencer Jones
	**/
	public static function file($file = '', $resourceType)
	{

		return (!empty($file)) ? self::get($resourceType) . '/' . $file : self::get($resourceType);
	
	}

	/**
	* Makes a path to a directory
	*
	* @param string | unqualified $path to resource
	* @param string | resource type to make path for
	*
	* @return string | qualified path to resource
	*
	* @author Spencer Jones
	**/
	public static function dir($path = '', $resourceType)
	{

		return self::get($resourceType) . '/' . $path;
	
	}
		
		

}