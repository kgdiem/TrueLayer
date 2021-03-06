<?php

namespace TrueLayer\Bank\Account;

use TrueLayer\Data\Transaction;
use TrueLayer\Exceptions\OauthTokenInvalid;
use TrueLayer\Request;

class PendingTransactions extends Request
{
    /**
     * Get pending transactions
     *
     * @param string $account_id
     * @param array $params
     * @return Transaction|array
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws OauthTokenInvalid
     */
    public function get($account_id, $params = [])
    {
        $result = $this->connection
            ->setAccessToken($this->token->getAccessToken())
            ->get("/data/v1/accounts/" . $account_id . "/transactions/pending", $params);

        $this->OAuthCheck($result);
        $data = json_decode($result->getBody(), true);

        if(array_key_exists('results', $data)) {
            array_walk($data['results'], function ($value) {
                return new Transaction($value);
            });

            return $data['results'];
        }
    }
}
