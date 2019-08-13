<?php

namespace TrueLayer\Bank;

use TrueLayer\Data\Customer;
use TrueLayer\Exceptions\OauthTokenInvalid;
use TrueLayer\Request;

class Identity extends Request
{
    /**
     * Get all providers
     *
     * @param array $params
     * @return mixed
     * @throws OauthTokenInvalid
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getIdentity($params)
    {
        $result = $this->connection
            ->setAccessToken($this->token->getAccessToken())
            ->get("/data/v1/info", $params);

        $this->OAuthCheck($result);
        $data = json_decode($result->getBody(), true);

        if(array_key_exists('results', $data)) {
            return new Customer($data['results']);
        }
    }
}
