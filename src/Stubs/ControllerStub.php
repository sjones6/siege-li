<?php

namespace {{namespace}}\Http\Controllers;

// Framework
use Log;
use Session;
use Illuminate\Http\Request;
use {{namespace}}\Http\Controllers\Controller;

// Packages

// Application
use {{namespace}}\{{model}};

class {{class_name}} extends Controller
{

<<<index
	/**
	* The public front of the controller
	*
	* @param object | Illuminate\Http\Request
	*
	* @return object | view
	*
	**/
	protected function index(Request $request) {
	
		${{model_camel}}s =  {{model}}::paginate(25);

		return view('{{slug}}.index', ['{{model_camel}}s' => ${{model_camel}}s]);

	}
>>>
<<<create
	/**
	* Show form to create a new instance
	*
	* @param object | Illuminate\Http\Request
	*
	* @return object | view
	*
	**/
	protected function create(Request $request) {
	
		return view('{{slug}}.create');

	}
>>>
<<<store
	/**
	* Store a fresh instance
	*
	* @param object | Illuminate\Http\Request
	*
	* @return object | view
	*
	**/
	protected function store(Request $request) {
	
		try
		{

			${{slug}} = {{model}}::create($request->all());

		} catch (\Exception $e) {

			Log::error($e);

			Session::flash('error', 'Unable to update {{slug}}');

			return redirect()->back()->withInput();

		}

		Session::flash('success', 'Created new {{slug}}');

		return redirect()->route('{{slug}}.edit', ['{{slug}}' => ${{slug}}->getKey()]);

	}
>>>
<<<show
	/**
	* Show a single instance
	*
	* @param object | Illuminate\Http\Request
	*
	* @return object | view
	*
	**/
	protected function show(Request $request) {

		${{slug}} = {{model}}::findOrFail($request->get('{{slug}}'));
	
		return view('{{slug}}.show', ['{{slug}}' => ${{slug}}]);

	}
>>>
<<<edit
	/**
	* Show a single instance for editing
	*
	* @param object | Illuminate\Http\Request
	*
	* @return object | view
	*
	**/
	protected function edit(Request $request) {
	
		${{slug}} = {{model}}::findOrFail($request->get('{{slug}}'));
	
		return view('{{slug}}.edit', ['{{slug}}' => ${{slug}}]);

	}
>>>
<<<update
	/**
	* Update an instance
	*
	* @param object | Illuminate\Http\Request
	*
	* @return object | view
	*
	**/
	protected function update(Request $request) {
	
		${{slug}} = {{model}}::findOrFail($request->get('{{slug}}'));

		try
		{

			${{slug}}->update($request->all());

		} catch (\Exception $e) {

			Log::error($e);

			Session::flash('error', 'Unable to update {{slug}}');

			return redirect()->back()->withInput();

		}

		Session::flash('success', 'Updated {{slug}}');

		return redirect()->route('{{slug}}.edit', ['{{slug}}' => ${{slug}}->getKey()]);

	}
>>>
<<<destroy
	/**
	* Delete an instance
	*
	* @param object | Illuminate\Http\Request
	*
	* @return object | view
	*
	**/
	protected function destroy(Request $request) {
	
		${{slug}} = {{model}}::findOrFail($request->get('{{slug}}'));

		try
		{

			${{slug}}->destroy();

		} catch (\Exception $e) {

			Log::error($e);

			Session::flash('error', 'Unable to destroy {{slug}}');

			return redirect()->back();

		}

		Session::flash('success', 'Deleted {{slug}}');

		return redirect()->route('{{slug}}.index');

	}
>>>
}