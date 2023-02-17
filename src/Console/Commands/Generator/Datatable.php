<?php

namespace MikhailMouner\Datatable\Console\Commands\Generator;

class Datatable extends Generator
{
    /**
     * Execute the console command.
     *
     * @param string $name
     * @return array
     */
    public function execute(string $name): array
    {

        $filePath = $this->getFilePath($name);
        $this->makeDirectory(dirname($filePath));

        $contents = $this->getSourceFile($name);

        return $this->generateFile($filePath, $contents);
    }

    /**
     * Get the stub path and the stub variables
     *
     * @param string $name
     * @return bool|mixed|string
     */
    public function getSourceFile(string $name)
    {
        return $this->getStubContents($this->getStubPath(), $this->getStubVariables($name));
    }

    /**
     * Get the full path of model file
     *
     * @param string $name
     * @return string
     */
    public function getFilePath(string $name): string
    {
        return 'app\\DataTables\\' . $this->getClassName($name) . '\\' . $this->getClassName($name) . 'Datatable.php';
    }

    /**
     **
     * Map the stub variables present in stub to its value
     *
     * @param string $model
     * @return array
     */
    public function getStubVariables(string $model): array
    {
        return [
            'MODEL_NAME' => $this->getClassName($model),
        ];
    }

    /**
     * Return the stub file path
     * @return string
     */
    public function getStubPath(): string
    {
        return $this->getStubRootPath() . '/datatable.stub';
    }
}
