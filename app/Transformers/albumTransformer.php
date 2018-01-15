<?php

namespace App\Transformers;

use App\album;
use League\Fractal\TransformerAbstract;

class albumTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(album $album)
    {
        return [
            'id' => (integer) $album->id,
            'album' => (string) $album->name,
            'links' => [
                [
                    'rel' => 'albums.singers',
                    'href' => route('albums.singers.index',$album->id),
                ],
                 [
                    'rel' => 'albums.songs',
                    'href' => route('albums.songs.index',$album->id),
                ],
            ],
        ];
    }
}
