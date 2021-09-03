<?php

// Install Controller
$installController = __DIR__.'/InstallController.php';
$newInstallController = __DIR__.'/../app/Http/Controllers/InstallController.php';

// Move Install Controller
if(is_readable($installController)) {
  rename($installController, $newInstallController);
}

// Redirect to URL for Install
function url(){
  return sprintf(
    "%s://%s%s",
    isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
    $_SERVER['SERVER_NAME'],
    $_SERVER['REQUEST_URI']
  );
}

$url = preg_replace('/bulk-upload\//', '', url());

header('Location: '.$url.'install/bulk-upload');
