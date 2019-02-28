<?php

namespace Synergist;

final class PlayWithGoogle
{

    public static function run(string $cmd): string
    {
        $places = new Places();

        $search = $places->searchPlaces($cmd);

        $geocode = new Geocode();

        $result = [];
        foreach ($search as $sear)
        {
            $result[] = $sear['data'] = $geocode->searchLocation($sear['lat'], $sear['lng']);

        }

        return json_encode($result);

    }

}
