<?php

namespace TrueLayer\Bank\Card;

use TrueLayer\Data\CardBalance;
use TrueLayer\Exceptions\OauthTokenInvalid;
use TrueLayer\Request;

class Balance extends Request
{
    /**
     * Get card balance
     *
     * @param string $account_id
     * @param array $params
     * @return CardBalance
     * @throws OauthTokenInvalid
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get($account_id, $params)
    {
        $result = $this->connection
            ->setAccessToken($this->token->getAccessToken())
            ->get("/data/v1/cards/" . $account_id . "/balance", $params);

        $this->OAuthCheck($result);
        $data = json_decode($result->getBody(), true);

        return new CardBalance($data['results']);
    }
}
