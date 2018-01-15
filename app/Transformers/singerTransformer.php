<?php

namespace App\Transformers;

use App\singers;
use League\Fractal\TransformerAbstract;

class singerTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(singers $singer)
    {
        return [
            'id' => (integer)$singer->id,
            'singer' => (string)$singer->singerName,
            'description' => (string)$singer->bio,
            'birth' => $singer->dateOB,
            'links' => [
              [  'rel' => 'singers.songs',
                'href' => route('singers.songs.index',$singer->id),
              ],
              [  'rel' => 'singers.albums',
                  'href' => route('singers.albums.index',$singer->id),
              ],
            ],
        ];
    }
    public static function index($index){
        $values = [
            'name' => 'singerName'
        ];
        return $values[$index];
    }
}
