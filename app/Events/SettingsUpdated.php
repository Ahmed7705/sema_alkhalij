<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SettingsUpdated
{
    use Dispatchable, SerializesModels;

    public string $key;
    public $value;
    public ?int $userId;

    public function __construct(string $key, $value, ?int $userId = null)
    {
        $this->key = $key;
        $this->value = $value;
        $this->userId = $userId;
    }
}
