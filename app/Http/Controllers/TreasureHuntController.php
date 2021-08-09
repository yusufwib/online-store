<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helper\ResponseHelper as JsonHelper;

class TreasureHuntController extends Controller
{
    
    public function treasureHunt () {
        $res = new JsonHelper;

        $coordinate = [];
        $clearWay = 0;
        $arr = [
            [
                '#', '#', '#', '#', '#', '#', '#', '#'
            ],
            [
                '#', '.', '.', '.', '.', '.', '.', '#'
            ],
            [
                '#', '.', '#', '#', '#', '.', '.', '#'
            ],
            [
                '#', '.', '.', '.', '#', '.', '#', '#'
            ],
            [
                '#', 'X', '#', '.', '.', '.', '.', '#'
            ],
            [
                '#', '#', '#', '#', '#', '#', '#', '#'
            ]
        ];

        foreach ($arr as $k1 => $v1) {
            foreach ($v1 as $k2 => $v2) {
                if ($v2 == '.') {
                    $clearWay += 1;
                    $arrTemp = [
                        'x' => $k1,
                        'y' => $k2
                    ];
                    array_push($coordinate, $arrTemp);
                }
            }
        }
        // return $;
        $arrResponse = [
            'total' => $clearWay,
            'possible_coordinate' => $coordinate
        ];
        return $res->responseGet(true, 200, $arrResponse, '');

    }
}
