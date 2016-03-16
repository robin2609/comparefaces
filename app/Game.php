<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $table = 'games';

    protected $fillable = [
        'winner',
        'loser'
    ];
    // Calculate the expected score of outcome
    public static function expected($Rb, $Ra)
    {
        return 1 / (1 + pow(10, ($Rb - $Ra) / 400));
    }

    //Calculate the new winner score
    public static function win($score, $expected, $k = 24)
    {
        return $score + $k * (1 - $expected);
    }

    //Calculate the new loser score
    public static function loss($score, $expected, $k = 24)
    {
        return $score + $k * (0 - $expected);
    }
    // Calculate the new rank
    public static function rank($score, $losses, $wins)
    {
        if (($score == 0) || ($losses == 0) || ($wins == 0 ))
        {
            return 0;
        }
        return round($score / (1 + ($losses / $wins)));
    }
}
