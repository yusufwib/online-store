<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TreasureHuntController extends Controller
{
    public function treasureHunt () {
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
        
    }
}
