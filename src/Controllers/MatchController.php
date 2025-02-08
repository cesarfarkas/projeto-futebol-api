<?php
require_once '../src/Models/MatchModel.php';

class MatchController
{
    private $model;

    public function __construct()
    {
        $this->model = new MatchModel();
    }

    public function index()
    {
        $championships = $this->model->getChampionships();
        $matches = $this->model->getUpcomingMatches();
        require '../src/Views/home.php';
    }

    public function searchTeam()
    {
        $teamName = $_GET['team'] ?? '';
        $matches = $this->model->getTeamMatches($teamName);
        require '../src/Views/home.php';
    }
}