<?php
require_once '../src/Cache.php';
require_once '../config.php';

class MatchModel
{
    private $apiUrl;
    private $apiKey;
    private $championshipId;
    private $season;
    private $cache;
    
    public function __construct() {
        $this->apiUrl = getenv('API_URL');
        $this->apiKey = getenv('API_KEY');
        $this->championshipId = getenv('CHAMPIONSHIP_ID');
        $this->season = getenv('SEASON');
        $this->cache = new Cache();
    }

    private function makeRequest($endpoint, $params = []) 
    {
        $cacheKey = $endpoint . '?' . http_build_query($params);
        $cachedData = $this->cache->getCache($cacheKey);

        if ($cachedData) {
            return $cachedData;
        }

        $url = $this->apiUrl . $endpoint . '?' . http_build_query($params);
        $headers = [
            "x-rapidapi-key: {$this->apiKey}",
            "x-rapidapi-host: api-football-v1.p.rapidapi.com"
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        curl_close($ch);

        $decodedResponse = json_decode($response, true);
        $this->cache->setCache($cacheKey, $decodedResponse);

        return $decodedResponse;
    }

    public function getChampionships()
    {
        return $this->makeRequest('/leagues');
    }

    public function getUpcomingMatches()
    {
        return $this->makeRequest('/fixtures', [
            'league' => $this->championshipId,
            'season' => $this->season,
        ])['response'] ?? [];
    }

    public function getTeamMatches($teamName)
    {
        $teamResponse = $this->makeRequest('/teams', [
            'name' => $teamName, 
            'league' => $this->championshipId,
            'season' => $this->season,
        ])['response'] ?? [];

        if (empty($teamResponse)) {
            return [];
        }

        $teamId = $teamResponse[0]['team']['id'] ?? null;
        if ($teamId) {
            return $this->getTeamUpcomingMatches($teamId);
        }

        return [];
    }

    private function getTeamUpcomingMatches($teamId)
    {
        return $this->makeRequest('/fixtures', [
            'team' => $teamId, 
            'league' => $this->championshipId,
            'season' => $this->season,
        ])['response'] ?? [];
    }
}