<?php

namespace App\Transformers;

use App\tickets;
use League\Fractal\TransformerAbstract;

class ticketTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(tickets $ticket)
    {
        return [
            'adultsPrice' =>(integer)$ticket->price_adult,
             'childrenPrice' =>(string)$ticket->price_child,
        ];
    }
    public static function index($index){

        $indexes = [
            'precio' => 'price',
            'serial' => 'ticketNumber'  
        ];
        return $indexes[$index];
    }
}
