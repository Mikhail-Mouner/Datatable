<?php

namespace MikhailMouner\Datatable\Console\Commands;

use Illuminate\Console\Command;
use MikhailMouner\Datatable\Console\Commands\Generator\Datatable;

class CreateDatatable extends Command
{
    protected $signature = 'make:datatable {model}';

    protected $description = 'Create Datatable Files';

    private Datatable $datatable;

    /**
     * Create a new command instance.
     *
     */
    public function __construct(Datatable $datatable)
    {
        parent::__construct();
        $this->datatable = $datatable;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $model = $this->argument('model');
        list($type, $message) = $this->datatable->execute($model);
        $this->$type($message);
        $this->createFiles();
    }

    private function createFiles()
    {
        $this->call('make:model', ['name' => $this->argument('model')]);
        $this->call('make:resource', ['name' => $this->argument('model') . 'Resource']);
    }

}
