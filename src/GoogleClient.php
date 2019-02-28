<?php

namespace Synergist;

use GuzzleHttp\Client;
use GuzzleHttp\TransferStats;

final class GoogleClient
{
    const BASE_URL = 'https://maps.googleapis.com/maps/api/';

    const KEY = 'AIzaSyAeHVIww0KJxJY0NefKSTzpVLB0FqGWPf0';

    public function search(string $query, string $uri): array
    {
        $client = new Client([
            'query'  => $query.'&key=' .self::KEY,
        ]);


        try {
            $response = $client->request('GET', self::BASE_URL . $uri . '?');
        } catch (Exception $exception)
        {
            throw new Exception('could not get any response from maps api');
        }

        if($response->getStatusCode() == '200')
        {
            $result = json_decode($response->getBody(), true);

            switch ($result['status'])
            {
                case 'REQUEST_DENIED':
                    return ['message' => 'check if the api key is valid'];
                case 'INVALID_REQUEST':
                    return ['message' => 'check the fields'];
                case 'OVER_QUERY_LIMIT':
                    return $result['error_message'];
                case 'UNKNOWN_ERROR':
                    return ['message' => 'try again'];
                case 'ZERO_RESULTS':
                    return ['message' => 'No results where found'];
                case 'OK';
                    return $result;
            }

        }

    }

}
