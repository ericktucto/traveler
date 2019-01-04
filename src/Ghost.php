<?php

namespace Ghost;

class Ghost
{
    protected $namespace = "namespace :namespace;";
    protected $classname = "class :classname { }";
    protected $template =  "";
    protected $file = __DIR__ . "/ghosts.php";

    protected $ghosts = [];

    public function __construct()
    {
        $this->template = "{$this->namespace} {$this->classname}";
        $this->composerLoader = require __DIR__ . '/../vendor/autoload.php';
    }

    public function __destruct()
    {
        $this->deleteFile();
    }

    public function register(array $ghosts)
    {
        foreach ($ghosts as $classname => $class) {
            $this->ghosts[$classname] = $class;
        }
    }

    public function get(string $ghost)
    {
        return $this->ghosts[$ghost];
    }

    protected function deleteFile()
    {
        if (file_exists($this->file)) {
            unlink($this->file);
        }
    }

    public function makeTemplateClass(string $namespace, string $classname)
    {
        return str_replace(
            [':namespace', ':classname'],
            [$namespace, $classname],
            $this->template);
    }

    public function createClass(string $class)
    {
        $tmp = explode("\\", $class);
        $classname = array_pop($tmp);
        $namespace = implode("\\", $tmp);
        return $template = "{$this->makeTemplateClass($namespace, $classname)}";
    }

    public function start()
    {
        $template = "<?php ";
        
        $this->composerLoader->addClassMap($this->ghosts, $this->file);
        foreach ($this->ghosts as $classname => $class) {
            $template .= $this->createClass($classname) . " ";
        }

        file_put_contents(
            $this->file,
            $template
        );

        include $this->file;
    }
}