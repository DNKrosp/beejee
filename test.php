<?php

use model\Task;

require_once("vendor/autoload.php");

$task = Task::create();
$task->username = "adm";
$task->email = "adm@mail.ru";
$task->text = "hello world";
$task->save();