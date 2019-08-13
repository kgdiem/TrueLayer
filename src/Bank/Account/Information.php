<?php

namespace TrueLayer\Bank\Account;

use TrueLayer\Data\Account;
use TrueLayer\Exceptions\OauthTokenInvalid;
use TrueLayer\Request;

class Information extends Request
{
    /**
     * Get account information
     *
     * @param string $account_id
     * @param array $params
     *
     * @throws OauthTokenInvalid
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return Account
     */
    public function get($account_id, $params = [])
    {
        $result = $this->connection
            ->setAccessToken($this->token->getAccessToken())
            ->get("/data/v1/accounts/" . $account_id, $params);

        $this->OAuthCheck($result);
        $data = json_decode($result->getBody(), true);

        if(array_key_exists('results', $data)) {
            return new Account($data["results"]);
        }
    }
}
