<?php

// Framework
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

// Application
use {{namespace}}\{{model}};

class {{class_name}} extends TestCase
{

	use DatabaseTransactions;

<<<index
	public function test_index_{{slug}}() {
	
		factory({{model}}::class, 10)->create();	

		return $this->visitRoute('{{slug}}.index');

	}
>>>
<<<create
	public function test_create_{{slug}}() {

		return $this->visitRoute('{{slug}}.create');

	}
>>>
<<<store
	public function test_store_{{slug}}() {

		return $this->visitRoute('{{slug}}.create');

	}
>>>
<<<show
	public function test_show_{{slug}}() {

		${{model_camel}} = factory({{model}}::class)->create();

		return $this->visitRoute('{{slug}}.show', ['{{slug}}' => ${{model_camel}}->getKey()]);

	}
>>>
<<<edit
	public function test_edit_{{slug}}() {

		${{model_camel}} = factory({{model}}::class)->create();

		return $this->visitRoute('{{slug}}.edit', ['{{slug}}' => ${{model_camel}}->getKey()]);

	}
>>>
<<<update
	public function test_update_{{slug}}() {

		${{model_camel}} = factory({{model}}::class)->create();

		return $this->visitRoute('{{slug}}.edit', ['{{slug}}' => ${{model_camel}}->getKey()]);

	}
>>>
<<<destroy
	public function test_destroy_{{slug}}() {

		${{model_camel}} = factory({{model}}::class)->create();

		return $this->visitRoute('{{slug}}.destroy', ['{{slug}}' => ${{model_camel}}->getKey()]);

	}
>>>
}
