<?php

namespace TrueLayer\Bank;

use TrueLayer\Request;

class Supported extends Request
{
    /**
     * Get all providers
     *
     * @param array $params
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getProviders($params = [])
    {
        $result = $this->connection
            ->get("/api/providers", $params);

        $providers = json_decode($result->getBody(), true);

        return $providers;
    }
}
