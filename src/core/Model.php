<?php

namespace core;

interface Model
{
    public static function list(int $page = 1, array $sorted = []):?array;
    public static function find(int $id):Model;
    public static function create();
    public function save():bool;
}