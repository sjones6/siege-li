<?php

namespace SiegeLi\Console;

// Laravel
use Illuminate\Console\Command;

class MakeModelCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'siege:m';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a model';

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
        echo('testing');
    }
}
