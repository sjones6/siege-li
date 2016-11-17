<?php

namespace SiegeLi\Helpers;

// Larvel
use Illuminate\Support\Facades\Config;

// SiegeLi
use SiegeLi\Helpers\Path;

class Group
{

	/**
	* Gets default stub group
	*
	* @param void
	*
	* @return string
	*
	* @author Spencer Jones
	**/
	public static function defaultGroup()
	{

		return Config::get('stubs.default_group');

	}

	/**
	* Gets path to default stub group
	*
	* @param void
	*
	* @return string
	*
	* @author Spencer Jones
	**/
	public static function defaultPath()
	{

		// Get relative path to default group
		$path = Config::get('stubs.groups.' . Config::get('stubs.default_group'));

		// Make qualified path to default stub group
		return Path::make($path, 'stubs');

	}

	/**
	* Gets path to a stub group
	*
	* @param string | $groupName
	*
	* @return string
	*
	* @author Spencer Jones
	**/
	public static function path($groupName)
	{

		// Get relative path to default group
		$path = Config::get('stubs.groups.' . $groupName);

		// Make qualified path to default stub group
		return Path::make($path, 'stub');

	}

	/**
	* Checks if a stub group is definted
	*
	* @param string | group name to search for
	*
	* @return bool | exists / doesnt 
	*
	* @author Spencer Jones
	**/
	public static function exists($group = '') {
	
		return Config::has('stubs.groups.' . $group);
	
	}
		

}