# SiegeLI

This package allows for editing of stub templates, stub groups (to switch in and out of stubs), and generating resourceful stubs (i.e., route, controller, model, views, model factory, migration, seeder, and test) with one command.

The center of SiegeLi is the resource and the mvc command. It generates all the boilerplate for resourceful interaction (CRUD) and persisting that resource to your database.

## Installation

Require the package into your project.

Add the service provider to your providers array in `config/app.php`:

```php
// Package Providers
SiegeLi\SiegeLiServiceProvider::class,

//
```

Publish the package: `artisan vendor:publish`. This will add a `stubs` directory to your `resources` directory, and a configuration file called `stubs.php` in your `config` directory.

SiegeLi will work even if you don't publish the package. However, you will not be able to customize templates or configure the package for your project. But if you need to get up and running quickly on a standard Laravel install, you can skip this step. 

## Configuration

If you're using a standard Laravel 5.3 file structure, SiegeLi should work out of the box. However, if anything is non-standard, edit the `config/stubs.php` to reflect this. Specifically, you may need to indicate the path to your controllers or routes file.

## Usage

### Commands

For the resource name, it is best to use snake_case or spinal-case. The name will be converted to accepted standards (e.g., model name in StudlyCase). 

* `artisan siege:m {resource-name}`
* `artisan siege:v {resource-name}`
* `artisan siege:c {resource-name}`
* `artisan siege:mvc {resource-name}`
* `artisan siege:group group-directory`

### Stub Templates

When you publish the package, you will have a `stubs` folder in your `resources` directory. You can edit these at will.

### Stub Syntax

Stubs use a simple syntax for populating variables and include/excluding template blocks.


##### Stub Variables

Variables are wrapped in double curly braces, without spaces, and without dollar sign.

```php
use {{namespace}}\User;
```

##### Stub Blocks

Stub template blocks are between `<<<block-name` and `>>>`. Blocks can be included or excluded conditionally using `-o|--option` parameter. For instance, running a stub command with `-o siege` on the following would include all `siege` blocks and exclude all `!siege` blocks:

```php
<<<siege
protected function thisWillBeIncluded()
{
//
}
>>>

<<<!siege
protected function thisWillBeExcluded()
{
//
}
>>>
```

You can also pass the `-a|--all` option to include all optional template blocks.

### Stub Groups

Groups provide a convenient way switch between stub templates given the needs of your project or individual preferences. 

Generate a stub group with, for instance, `artisan siege:group test`. This will create a directory `resources/stubs/test` populated with stubs. If you want to use another group as the base for this new stub group, add the `-f|--from` option.

You then will need to add the stub group to `config/stubs.php` file.

```php
	'siege' => 'base/',
	'test-group' => 'test/'
```

Now you can use the name `test-group` to access all of the stubs in the `test` directory.

You can set a default template group in `config/stubs.php` or indicate which group by passing a group name with the `-g|--group` option, like so:

```bash
php artisan siege:mvc Test -g test-group
```