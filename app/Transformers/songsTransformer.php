<?php

namespace App\Transformers;

use App\songs;
use League\Fractal\TransformerAbstract;

class songsTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(songs $song)
    {
       return [
            'id' => (integer) $song->id, 
            'song' => (string) $song->name,
            'genre' => (string) $song->genre,
            'links' => [
                [
                    'rel' => 'songs.singers',
                    'href' => route('songs.singers.index',$song->id),
                ],
                 [
                    'rel' => 'songs.albums',
                    'href' => route('songs.albums.index',$song->id),
                ],
            ],
        ];
    }
}
