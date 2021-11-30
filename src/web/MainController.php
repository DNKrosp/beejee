<?php

namespace web;

use core\Controller;
use Exception;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\NoReturn;
use model\Task;

class MainController extends Controller
{
    /**
     * @throws Exception
     */
    #[ArrayShape(["tasks" => "array", "countPages" => "int"])] public function indexAction($page=1): ?array
    {
        $maxPages = $this->getCountOfPagesAction();
        if ($maxPages < $page || $page < 1)
            return null;

        return [
            "tasks"=>$this->listTasksAction($page),
            "countPages"=>$maxPages,
            "currentPage"=>$page
        ];
    }

    #[NoReturn] public function newTaskAction(string $username, string $email, string $text)
    {
        try {
            $task = Task::create();
            $task->username = urldecode($username);
            $task->email = urldecode($email);
            $task->text = urldecode($text);
            $ok = $task->save();
            if ($ok)
                $_SESSION["flash"]["created"]=true;
            else
                $_SESSION["flash"]["created"]=false;
            header('Location: '.$_SERVER["HTTP_REFERER"]);
            exit();
        }catch (Exception $e) {
            file_put_contents(__DATA__."/log/web.log", $e->__toString(), FILE_APPEND );
        }
    }

    /**
     * @throws Exception
     */
    #[ArrayShape(["tasks" => "array", "countPages" => "int"])] public function listTasksAction($page): array
    {
        return Task::list($page);
    }

    private function getCountOfPagesAction(): int
    {
        $taskIds = Task::getAllIds();
        return ceil(count($taskIds)/3);
    }
}