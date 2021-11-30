<?php

namespace model;

use core\FileModel;


class Task extends FileModel
{
    protected static string $entityName = "task";
    protected array $required = ["username"=>"str", "email"=>"email", "text"=>"text", "completed"=>"bool"];
    protected array $default = ["completed"=>false];
}