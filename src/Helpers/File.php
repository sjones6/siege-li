<?php

namespace SiegeLi\Helpers;

// Laravel
use Illuminate\Support\Facades\File as Storage;

class File
{


	public static function put($path, $contents)
	{

		if (self::alreadyExists($path)) {
			throw new \Exception('File ' . $path . ' already exists');
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

}