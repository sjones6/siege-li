<?php

namespace SiegeLi\Console;

// Laravel
use Illuminate\Support\Str;
use Illuminate\Support\Collection;

// Siege
use SiegeLi\Helpers\File;
use SiegeLi\Helpers\Path;
use SiegeLi\Helpers\Group;
use SiegeLi\Helpers\Name;
use SiegeLi\Templating\Stub;
use SiegeLi\Console\SiegeCommand as Command;


class MakeViewsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'siege:v {resource} {view}
                            {--a|all : Include all optional blocks}
                            {--g|group= : Which stub group to use}
                            {--o|options= : Comma delimited list of stub options to include}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a resourceful view';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        // Get the path and contents.
        $dirAndFile = Name::dir($this->resource()) . Name::blade($this->argument('view'));
        $path = Path::make($dirAndFile, 'view');
        $model = Stub::get($this->argument('view'), $this->group())->make($this->getOptions());

        // Make the file
        File::put($path, $model);

        $this->info('View made.');
    }

    

}
