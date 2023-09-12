<?php

namespace App\Console\Commands;

use Exception;
use File;
use Illuminate\Console\Command;
use Str;

class MakeCrud extends Command
{
    protected string $entity;

    protected string $entityUcFirst;

    protected string $stub;

    protected string $table;

    protected string $tableComponentName;

    protected string $entityPtBr;

    protected string $formModalComponentName;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:crud';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'CRUD creator';

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
     * @return int
     */
    public function handle()
    {
        try {
            $this->askEntityName();
            $this->askTableName();
            $this->askEntityPtBrName();
            $this->createFiles();
            $this->output->newLine();
            $this->output->writeln('Success!');

        } catch (Exception $e) {
            $this->error($e->getMessage());

            return self::FAILURE;
        }
    }

    protected function askEntityName(): void
    {
        $this->entity = strval($this->ask('Entity name: (Ex., <comment>user</comment>)', 'user'));

        if (empty(trim(strval($this->entity))) || !is_string($this->entity)) {
            throw new Exception('Entity name is required!');
        }

        $this->entity = str_replace(['.', '\\'], '/', (string) $this->entity);

        preg_match('/(.*)(\/|\.|\\\\)(.*)/', $this->entity, $matches);

        if (!is_array($matches)) {
            throw new Exception('Format is incorrect!');
        }

        $this->entityUcFirst = ucfirst($this->entity);

    }

    protected function askEntityPtBrName(): void
    {
        $this->entityPtBr = strval($this->ask('PT-BR name: (Ex., <comment>usuario</comment>)', 'usuario'));

        if (empty(trim(strval($this->entityPtBr))) || !is_string($this->entityPtBr)) {
            throw new Exception('Entity PT-BR name is required!');
        }

        $this->entityPtBr = ucfirst(str_replace(['.', '\\'], '/', (string) $this->entityPtBr));

        preg_match('/(.*)(\/|\.|\\\\)(.*)/', $this->entityPtBr, $matches);

        if (!is_array($matches)) {
            throw new Exception('Format is incorrect!');
        }
    }

    protected function askTableName(): void
    {
        $this->table = strval($this->ask('Database table name: (Ex., <comment>users</comment>)', 'users'));

        if (empty(trim(strval($this->table))) || !is_string($this->table)) {
            throw new Exception('Database table name is required!');
        }

        $this->table = str_replace(['.', '\\'], '/', (string) $this->table);

        preg_match('/(.*)(\/|\.|\\\\)(.*)/', $this->table, $matches);

        if (!is_array($matches)) {
            throw new Exception('Format is incorrect!');
        }
    }

    protected function createFiles(): void
    {
        $this->createController();
        $this->createTableView();
        $this->createRepository();
        $this->createTableComponentBackEnd();
        $this->createTableComponentFrontEnd();
        $this->createFormModalComponentBackEnd();
        $this->createFormModalComponentFrontEnd();
    }

    private function createController()
    {
        $path = 'Http/Controllers/';

        $path = app_path($path . ucfirst($this->entity) . 'Controller.php');

        $this->stub = File::get(app_path() . '/stubs/crud/controller.stub');

        $this->stub = str_replace('{{ entity }}', $this->entity, $this->stub);

        $this->stub = str_replace('{{ entityUcFirst }}', $this->entityUcFirst, $this->stub);

        File::put($path, $this->stub);
    }

    private function createTableView()
    {
        $path = base_path() . '\\resources\\views\\parent\\' . Str::kebab($this->entity) . '-table.blade.php';

        $this->stub = File::get(app_path() . '/stubs/crud/table-view.stub');

        $this->stub = str_replace('{{ entity }}', $this->entity, $this->stub);

        File::put($path, $this->stub);
    }

    private function createRepository()
    {
        $path = '//Repositories/';

        $path = app_path($path . ucfirst($this->entity) . 'Repository.php');

        $this->stub = File::get(app_path() . '/stubs/crud/repository.stub');

        $this->stub = str_replace('{{ table }}', $this->table, $this->stub);

        $this->stub = str_replace('{{ entityUcFirst }}', $this->entityUcFirst, $this->stub);

        File::put($path, $this->stub);
    }

    private function createTableComponentBackEnd()
    {
        $this->tableComponentName = ucfirst($this->entity) . 'Table';

        $livewirePath = 'Http/Livewire/';

        $path = app_path($livewirePath . $this->tableComponentName . '.php');

        $this->stub = File::get(app_path() . '/stubs/crud/table-backend.stub');

        $this->stub = str_replace('{{ tableComponentName }}', $this->tableComponentName, $this->stub);
        $this->stub = str_replace('{{ entity }}', $this->entity, $this->stub);
        $this->stub = str_replace('{{ entityUcFirst }}', $this->entityUcFirst, $this->stub);
        $this->stub = str_replace('{{ entityPtBr }}', $this->entityPtBr, $this->stub);
        $this->stub = str_replace('{{ tableViewName }}', Str::kebab($this->tableComponentName), $this->stub);

        File::put($path, $this->stub);
    }

    private function createTableComponentFrontEnd(): void
    {
        $path = base_path() . '\\resources\\views\\livewire\\' . Str::kebab($this->entity) . '-table.blade.php';

        $this->stub = File::get(app_path() . '/stubs/crud/table-frontend.stub');
        $this->stub = str_replace('{{ entity }}', $this->entity, $this->stub);
        $this->stub = str_replace('{{ entityUcFirst }}', $this->entityUcFirst, $this->stub);

        File::put($path, $this->stub);
    }

    private function createFormModalComponentBackEnd(): void
    {
        $this->formModalComponentName = ucfirst($this->entity) . 'FormModal';

        $path = 'Http/Livewire/';
        $path = app_path($path . $this->formModalComponentName . '.php');

        $this->stub = File::get(app_path() . '/stubs/crud/form-modal-backend.stub');

        $this->stub = str_replace('{{ formModalComponentName }}', $this->formModalComponentName, $this->stub);
        $this->stub = str_replace('{{ formModalViewName }}', Str::kebab($this->formModalComponentName), $this->stub);
        $this->stub = str_replace('{{ entity }}', $this->entity, $this->stub);
        $this->stub = str_replace('{{ entityPtBr }}', $this->entityPtBr, $this->stub);
        $this->stub = str_replace('{{ entityUcFirst }}', $this->entityUcFirst, $this->stub);

        File::put($path, $this->stub);
    }

    private function createFormModalComponentFrontEnd(): void
    {
        $path = base_path() . '\\resources\\views\\livewire\\' . Str::kebab($this->formModalComponentName) . '.blade.php';

        $this->stub = File::get(app_path() . '/stubs/crud/form-modal-frontend.stub');

        File::put($path, $this->stub);

        $this->stub = File::get(app_path() . '/stubs/crud/form-modal-fields.stub');

        $path = base_path() . '\\resources\\views\\partials\\forms\\' . Str::kebab($this->entity) . '.blade.php';

        $this->stub = str_replace('{{ entity }}', $this->entity, $this->stub);
        $this->stub = str_replace('{{ entityUcFirst }}', $this->entityUcFirst, $this->stub);

        File::put($path, $this->stub);
    }

}
