<?php

namespace TrueLayer;

use TrueLayer\Exceptions\OauthTokenInvalid;

class Me extends Request
{
    /**
     * Get all providers
     *
     * @param array $params
     * @return mixed
     * @throws OauthTokenInvalid
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getMetaData($params)
    {
        $result = $this->connection
            ->setAccessToken($this->token->getAccessToken())
            ->get("/data/v1/me", $params);

        $this->OAuthCheck($result);
        $data = json_decode($result->getBody(), true);

        return $data;
    }
}
