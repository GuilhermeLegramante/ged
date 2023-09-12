<?php

namespace App\Console\Commands;

use Exception;
use File;
use Illuminate\Console\Command;
use Str;

class MakeTableComponent extends Command
{

    protected string $componentName;

    protected string $stub;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:table';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make a Livewire custom table component';

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
            $this->askComponentName();
            $this->createFiles();
            $this->output->newLine();
            $this->output->writeln('Tabela criada com sucesso!');

        } catch (Exception $e) {
            $this->error($e->getMessage());

            return self::FAILURE;
        }
    }

    protected function askComponentName(): void
    {
        $this->componentName = strval($this->ask('Qual o nome da Tabela? (Ex., <comment>UserTable</comment>)', 'ExampleTable'));

        if (empty(trim(strval($this->componentName))) || !is_string($this->componentName)) {
            throw new Exception('É necessário informar um nome para a Tabela!');
        }

        $this->componentName = str_replace(['.', '\\'], '/', (string) $this->componentName);

        preg_match('/(.*)(\/|\.|\\\\)(.*)/', $this->componentName, $matches);

        if (!is_array($matches)) {
            throw new Exception('Formato incorreto para o nome!');
        }
    }

    protected function createFiles(): void
    {
        $this->createBackEndFile();
        $this->createFrontEndFile();

    }

    private function createBackEndFile(): void
    {
        $livewirePath = 'Http/Livewire/';
        $path = app_path($livewirePath . $this->componentName . '.php');

        $this->stub = File::get(app_path() . '/stubs/table.back.stub');

        $this->stub = str_replace('{{ componentName }}', $this->componentName, $this->stub);
        $this->stub = str_replace('{{ viewName }}', Str::kebab($this->componentName), $this->stub);

        File::put($path, $this->stub);
    }

    private function createFrontEndFile(): void
    {
        $path = base_path() . '\\resources\\views\\livewire\\' . Str::kebab($this->componentName) . '.blade.php';

        $this->stub = File::get(app_path() . '/stubs/table.front.stub');

        File::put($path, $this->stub);
    }
}
