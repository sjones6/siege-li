<?php

namespace SiegeLi\Helpers;

// Laravel
use Illuminate\Support\Facades\File as Storage;

class File
{


	public static function get($path)
	{

		if (!self::alreadyExists($path)) {
			throw new \Exception('File ' . $path . ' cannot be found');
		}

		return Storage::get($path);

	}

	public static function put($path, $contents)
	{

		if (self::alreadyExists($path)) {
			throw new \Exception('File ' . $path . ' already exists');
		}

		self::makeDirsAndPut($path, $contents);

	}

	protected static function makeDirsAndPut($path, $contents) 
	{

		$dirPath = substr($path, 0, strrpos($path, '/'));

		if (!Storage::exists($dirPath)) {
			Storage::makeDirectory($dirPath);
		}

		Storage::put($path, $contents);
	}


	public static function append($path, $contents)
	{

		if (!self::alreadyExists($path)) {
			return Storage::put($path, $contents);
		}

		Storage::append($path, $contents);

	}

	protected static function alreadyExists($path)
	{

		return Storage::exists($path);

	}

	public static function copy($origin, $destination)
	{

		if (self::alreadyExists($destination)) {
			throw new \Exception('Cannot copy files to ' . $destination . '. Destination already exists');
		}

		Storage::copy($origin, $destination);

	}

	public static function copyDir($origin, $destination)
	{

		if (self::alreadyExists($destination)) {
			throw new \Exception('Cannot copy files to ' . $destination . '. Destination already exists');
		}

		Storage::copyDirectory($origin, $destination);

	}

}