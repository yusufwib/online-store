<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TreasureHuntController extends Controller
{
    
    public function treasureHunt () {
        $count = 0;
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
                        $coordinate[0] => $k1,
                        $coordinate[1] => $k2
                    ];
                    array_push($coordinate, $arrTemp);
                }
            }
        }
        return $coordinate;
    }
}
