<?php

namespace TrueLayer\Bank\Card;

use TrueLayer\Data\CardTransaction;
use TrueLayer\Exceptions\OauthTokenInvalid;
use TrueLayer\Request;

class PendingTransactions extends Request
{
    /**
     * Get pending transactions
     *
     * @param string $account_id
     * @param array $params
     * @return CardTransaction|array
     * @throws OauthTokenInvalid
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get($account_id, $params = [])
    {
        $result = $this->connection
            ->setAccessToken($this->token->getAccessToken())
            ->get("/data/v1/cards/" . $account_id . "/transactions/pending", $params);

        $this->OAuthCheck($result);

        if ((int)$result->getStatusCode() > 400) {
            throw new OauthTokenInvalid();
        }

        $data = json_decode($result->getBody(), true);

        array_walk($data['results'], function ($value) {
            return new CardTransaction($value);
        });

        return $data['results'];
    }
}
