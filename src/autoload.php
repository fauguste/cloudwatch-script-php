<?php

class NoClassFoundException extends \Exception
{

    public function __construct($className)
    {
        $this->message = "No matching file for class $className in " .
             get_include_path();
    }
}

function autoload($className)
{
    $prefix = 'CloudWatchScript';
    $len = strlen($prefix);
    if (strncmp($prefix, $className, $len) !== 0) {
        // no, move to the next registered autoloader
        return;
    }
    $fileExtArr = array(
        '.php',
        '.class.php'
    );
    $includePath = get_include_path();
    $pathDirArr = explode(PATH_SEPARATOR, $includePath);
    
    foreach ($pathDirArr as $pathDir) {
        foreach ($fileExtArr as $fileExt) {
            $path = $pathDir . '/' . str_replace('\\', '/', $className) .
                 $fileExt;
            if (file_exists($path)) {
                require_once ($path);
                
                return;
            }
        }
    }
    throw new NoClassFoundException($className);
}

spl_autoload_register('autoload');
