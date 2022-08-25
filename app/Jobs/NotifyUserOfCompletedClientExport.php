<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\ClientReportNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;

class NotifyUserOfCompletedClientExport implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public User|Authenticatable $user, public string $filepath)
    {
    }

    public function handle(): void
    {
        $this->user->notify(new ClientReportNotification($this->filepath));
    }
}
