<?php
require_once '../src/Controllers/MatchController.php';

class Router
{
    public function run()
    {
        $controller = new MatchController();
        if (isset($_GET['action']) && $_GET['action'] === 'search' && (isset($_GET['team']) && !empty($_GET['team']))) {
            $controller->searchTeam();
        } else {
            $controller->index();
        }
    }
}