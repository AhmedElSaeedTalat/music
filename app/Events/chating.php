<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class chating implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $data;
    public $user;
    public $userWithComplaint;
    public $chat_id;
    /**
     * Create a new event instance.
     *
     * @return void
     */

    public function __construct($data,$userWithComplaint="",$user,$chat_id)
    {
        $this->data = $data;
        $this->user = $user;
        $this->userWithComplaint = $userWithComplaint;
        $this->chat_id = $chat_id;
        $this->dontBroadcastToCurrentUser();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('customerService',$this->data,$this->userWithComplaint,$this->user,$this->chat_id);
    }
}
