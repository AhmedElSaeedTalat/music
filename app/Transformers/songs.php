<?php

namespace App\Transformers;

use App\songs;
use League\Fractal\TransformerAbstract;

class theSongs extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(songs $song)
    {
        return [
            'song' => (string) $song->name,
        ];
    }
}
