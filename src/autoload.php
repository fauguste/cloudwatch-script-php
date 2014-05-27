<?php

function autoload($class_name)
{
	$fileExtArr = array('.php', '.class.php');
	
	$includePath = get_include_path();
	$pathDirArr = explode(PATH_SEPARATOR, $includePath);

	foreach ($pathDirArr as $pathDir) {
		foreach ($fileExtArr as $fileExt) {
			$path = $pathDir.'/'.str_replace('\\', '/', $class_name).$fileExt;
			if (file_exists($path)) {
				require_once($path);
        		return;
			}
		}
	}

//  throw new Exception('No matching file for class '.$class_name);
}

spl_autoload_register('autoload');