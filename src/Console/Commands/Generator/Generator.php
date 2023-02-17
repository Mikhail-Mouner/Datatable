<?php

namespace MikhailMouner\Datatable\Console\Commands\Generator;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

abstract class Generator implements GeneratorInterface
{
    /**
     * The Filesystem variable.
     *
     * @var Filesystem
     */
    protected Filesystem $files;

    /**
     * The Str variable.
     *
     * @var Str
     */
    protected Str $str;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Filesystem $files, Str $str)
    {
        $this->files = $files;
        $this->str = $str;
    }

    /**
     * Build the directory for the class if necessary.
     *
     * @param string $path
     * @return string
     */
    protected function makeDirectory(string $path): string
    {
        if (!$this->files->isDirectory($path)) {
            $this->files->makeDirectory($path, 0777, true, true);
        }

        return $path;
    }

    /**
     * @param string $path
     * @param mixed $contents
     * @return array
     */
    protected function generateFile(string $path, $contents): array
    {
        if (!$this->files->exists($path)) {
            $this->files->put($path, $contents);
            return ['info', "File : {$path} created"];
        }
        return ['error', "File : {$path} already exits"];
    }

    /**
     * Return the Singular Capitalize Name
     * @param string $name
     * @return string
     */
    public function getSingularFileName(string $name): string
    {
        return $this->str->singular($name);
    }

    /**
     * Return the Class Name
     * @param string $name
     * @return string
     */
    public function getClassName(string $name): string
    {
        return $this->str->studly($this->getSingularFileName($name));
    }

    /**
     * Replace the stub variables(key) with the desire value
     *
     * @param $stub
     * @param array $stubVariables
     * @return bool|mixed|string
     */
    public function getStubContents($stub, array $stubVariables = [])
    {
        $contents = file_get_contents($stub);

        foreach ($stubVariables as $search => $replace) {
            $contents = str_replace('$' . $search . '$', $replace, $contents);
        }

        return $contents;
    }

    /**
     * Return the Migration File Name
     * @param string $name
     * @return string
     */
    public function getTableName(string $name): string
    {
        return Str::snake($this->getClassName($name));
    }

    public function getStubRootPath(): string
    {
        $path = app_path('stubs/');
        if ($this->files->exists($path))
            return $path;
        return __DIR__ . '/../../../../stubs';
    }

    abstract public function getFilePath(string $name): string;

    abstract public function getStubVariables(string $model): array;

    abstract public function getStubPath(): string;
}
