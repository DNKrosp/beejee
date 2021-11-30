<?php

namespace core;

use Exception;
use JetBrains\PhpStorm\Pure;

class FileModel implements Model
{
    private static string $dir = __DATA__ . "/models";
    protected static string $entityName = "";
    protected array $required = [];
    protected array $default = [];
    private int $id;
    private array $data;

    final public static function getPathEntity(?int $id = null): string
    {
        return self::$dir . "/" . static::$entityName . "/" . $id ?? "";
    }

    public function __construct(int $id, array $data)
    {
        $this->id = $id;
        $this->data = $data;
    }

    public function __get(string $name)
    {
        if ($name == "id")
            return $this->id;
        return $this->data[$name];
    }

    /**
     * @throws Exception
     */
    public function __set(string $name, $value)
    {
        if (key_exists($name, $this->required) && self::checkType($this->required[$name], $value))
            $this->data[$name] = $value;
        else
            return throw new Exception("param $name not found for this model");
    }

    /**
     * todo: files with sorted info
     * @throws Exception
     */
    public static function list(int $page = 1, array $sorted = []): ?array
    {
        $result = [];
        $entities = self::getAllIds();
        $entitiesChunked = array_chunk($entities, 3, true);
        $resIds = ($page <= count($entitiesChunked))?$entitiesChunked[$page-1]:[];
        foreach ($resIds as $resId)
            $result[] = static::find($resId);

        return $result;
    }

    /**
     * @throws Exception
     */
    public static function find(int $id): Model
    {
        if (file_exists(self::getPathEntity($id))) {
            return new static($id, json_decode(file_get_contents(self::getPathEntity($id)), true));
        }
        return throw new Exception("record not found");
    }

    public function save(): bool
    {
        if ($this->id == 0)
            $this->id = self::getMaxId() + 1;
        foreach ($this->required as $key => $type)
            if (!key_exists($key, $this->data))
                if (key_exists($key, $this->default))
                    $this->data[$key] = $this->default[$key];
                else
                    return false;
        file_put_contents(self::getPathEntity($this->id), json_encode($this->data));
        return true;
    }

    private static function checkType($type, $value): bool
    {
        return match ($type) {
            "str" => mb_strlen($value) <= 255,
            "email" => mb_strlen($value) <= 64 && filter_var($value, FILTER_VALIDATE_EMAIL),
            "text" => true,
            "bool" => filter_var($value, FILTER_VALIDATE_BOOL),
            default => false
        };
    }

    public static function getAllIds(): array
    {
        $path = self::getPathEntity();
        $res = array_diff(explode("\n", `ls $path`), [""]);
        sort($res);
        return $res;
    }

    private static function getMaxId(): int
    {
        $ids = self::getAllIds();
        return (int)max($ids);
    }

    #[Pure] public static function create(): static
    {
        return new static(0, []);
    }
}