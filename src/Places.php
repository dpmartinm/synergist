<?php

namespace Synergist;

final class Places
{
    const URL = 'place/findplacefromtext/json';

    const INPUT_TYPE = 'textquery';

    const FIELDS = 'photos,formatted_address,name,rating,opening_hours,geometry';

    public function searchPlaces(string $textInput): array
    {
        $query = 'inputtype=' . self::INPUT_TYPE . '&fields=' . self::FIELDS . '&input=' . $textInput;
        $uri = self::URL;
        $client = new GoogleClient();
        $results = $client->search($query, $uri);

        if(isset($results['message']))
        {
            echo $results['message'];
            return $results['message'];
        }

        return $this->mapResults($results);

    }

    private function mapResults(array $results): array
    {
        $locations = [];
        foreach ($results['candidates'] as $candidates)
        {
            $locations[$candidates['name']] = [
                'address' => $candidates['formatted_address'],
                'hours' => $candidates['formatted_address'],
                'rating' => $candidates['rating'],
                'lat' => $candidates['geometry']['location']['lat'],
                'lng' => $candidates['geometry']['location']['lng']
            ];
        }
        return $locations;
    }

}
/*
 *  "candidates" : [
      {
         "formatted_address" : "140 George St, The Rocks NSW 2000, Australia",
         "geometry" : {
            "location" : {
               "lat" : -33.8599358,
               "lng" : 151.2090295
            },
            "viewport" : {
               "northeast" : {
                  "lat" : -33.85824767010727,
                  "lng" : 151.2102470798928
               },
               "southwest" : {
                  "lat" : -33.86094732989272,
                  "lng" : 151.2075474201073
               }
            }
         },
         "name" : "Museum of Contemporary Art Australia",
         "opening_hours" : {
            "open_now" : false,
            "weekday_text" : []
         },
         "photos" : [
            {
               "height" : 2268,
               "html_attributions" : [
                  "\u003ca href=\"https://maps.google.com/maps/contrib/113202928073475129698/photos\"\u003eEmily Zimny\u003c/a\u003e"
               ],
               "photo_reference" : "CmRaAAAAfxSORBfVmhZcERd-9eC5X1x1pKQgbmunjoYdGp4dYADIqC0AXVBCyeDNTHSL6NaG7-UiaqZ8b3BI4qZkFQKpNWTMdxIoRbpHzy-W_fntVxalx1MFNd3xO27KF3pkjYvCEhCd--QtZ-S087Sw5Ja_2O3MGhTr2mPMgeY8M3aP1z4gKPjmyfxolg",
               "width" : 4032
            }
         ],
         "rating" : 4.3
      }
   ],

 */

// https://maps.googleapis.com/maps/api/place/findplacefromtext/json?
//input=Museum%20of%20Contemporary%20Art%20Australia&inputtype=textquery&fields=photos,formatted_address,name,rating,opening_hours,geometry&key=YOUR_API_KEY



