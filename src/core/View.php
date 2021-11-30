<?php

namespace core;

class View
{
    public static function render($data):string
    {
        $tasksRendered = self::taskRender($data["tasks"]);
        $indexPatternRendered = file_get_contents(__PUBLIC__."/index.html");
        $indexPatternRendered = str_replace("{{tasks_pattern}}", implode($tasksRendered), $indexPatternRendered);
        $indexPatternRendered = str_replace("{{currentPage}}", htmlspecialchars($data["currentPage"]), $indexPatternRendered);
        $indexPatternRendered = str_replace("{{max}}", htmlspecialchars($data["countPages"]), $indexPatternRendered);
        $indexPatternRendered = str_replace("{{nextUrl}}", $data["currentPage"]<$data["countPages"]?$data["currentPage"]+1:$data["currentPage"], $indexPatternRendered);
        $indexPatternRendered = str_replace("{{lastUrl}}", $data["currentPage"]>1?$data["currentPage"]-1:$data["currentPage"], $indexPatternRendered);
        return $indexPatternRendered;
    }

    private static function taskRender($tasks): array
    {
        $taskPattern = file_get_contents(__PUBLIC__."/task.html");
        $tasksRendered = [];
        foreach ($tasks as $task)
        {
            $currentPattern = $taskPattern;
            $currentPattern = str_replace("{{taskId}}", htmlspecialchars($task->id), $currentPattern);
            $currentPattern = str_replace("{{username}}", htmlspecialchars($task->username), $currentPattern);
            $currentPattern = str_replace("{{email}}", htmlspecialchars($task->email), $currentPattern);
            $text = self::textRender($task->text);
            $currentPattern = str_replace("{{text_pattern}}", $text, $currentPattern);
            $currentPattern = str_replace("{{completed}}", $task->completed?"ДА":"НЕТ", $currentPattern);
            $tasksRendered[] = $currentPattern;
        }
        return $tasksRendered;
    }

    private static function textRender($text): array|bool|string
    {
        $text = explode("\n", $text);
        $textContainerPattern = file_get_contents(__PUBLIC__."/text.html");
        $textPattern = file_get_contents(__PUBLIC__."/textLine.html");
        $lines = [];
        foreach ($text as $str)
        {
            $pattern = $textPattern;
            $lines[] = str_replace("{{text}}", htmlspecialchars($str), $pattern);
        }
        return str_replace("{{textLine_pattern}}", implode($lines), $textContainerPattern);
    }
}