<?php

// Framework
use Illuminate\Database\Seeder;

// Application
use {{namespace}}\{{model}};

class {{model}}Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory({{model}}::class, 20)->create();
    }
}