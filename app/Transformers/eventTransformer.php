<?php

namespace App\Transformers;

use App\Events;
use League\Fractal\TransformerAbstract;

class eventTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Events $event)
    {
        return [
           'event' => (string)$event->event_name,
           'date' => (string)$event->date,
           'location' => (string)$event->location,
           'numberOfTickets' => (integer)$event->availableTickets,
           'links'=>[
                [
                    'rel'=>'self',
                    'href' => route('events.index',$event->id),
                ],
                [
                    'rel'=> 'events.singers',
                    'href' => route('events.singers.index',$event->id)
                ],
                [
                    'rel' => 'events.tickets',
                    'href' => route('events.tickets.index',$event->id),
                ],

           ]
        ];
    }

    public function index($index)
    {
        $indexes =[
            'event' => 'event_name',
        ] ;

    }
}
