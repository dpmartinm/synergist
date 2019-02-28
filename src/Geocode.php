<?php

namespace Synergist;

final class Geocode
{
    const URL = 'geocode/json';

    public function searchLocation(string $lon,string $lat): array
    {

        $query = 'latlng=' . $lon. ',' . $lat . '&sensor=false';
        $uri = self::URL;
        $client = new GoogleClient();
        $results = $client->search($query, $uri);

        if(isset($results['message']))
        {
            echo $results['message'];
            return $results['message'];
        }

        $results = $this->mapResults($results['results']);


        return  $results;
    }

    private function mapResults(array $results): array
    {
        $result = array_map(function ($components)
        {
           return [$components['types'][0] => $components['long_name']];
        }, $results[0]['address_components']);


        return $result;

    }

}

//http://maps.googleapis.com/maps/api/geocode/json?latlng=40.714224,-73.961452&sensor=false
