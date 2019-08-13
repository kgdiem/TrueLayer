<?php

namespace TrueLayer\Bank;

use TrueLayer\Data\Account;
use TrueLayer\Exceptions\OauthTokenInvalid;
use TrueLayer\Request;

class Accounts extends Request
{
    /**
     * Get all accounts
     *
     * @param array $params
     *
     * @return Account|array
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws OauthTokenInvalid
     */
    public function getAllAccounts($params = [])
    {
        $result = $this->connection
            ->setAccessToken($this->token->getAccessToken())
            ->get("/data/v1/accounts", $params);

        $this->OAuthCheck($result);
        $accounts = json_decode($result->getBody(), true);

        if(array_key_exists('results', $accounts)) {
            array_walk($accounts['results'], function ($value) {
                return new Account($value);
            });

            return $accounts['results'];
        }
    }
}
