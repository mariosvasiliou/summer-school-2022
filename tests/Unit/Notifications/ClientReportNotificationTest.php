<?php

namespace Tests\Unit\Notifications;

use App\Models\User;
use App\Notifications\ClientReportNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Storage;
use Tests\TestCase;

/**
 * @coversDefaultClass \App\Notifications\ClientReportNotification
 */
class ClientReportNotificationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @date   25/8/2022
     * @author MariosV
     */
    public function given_user_dispatches_notification_email_success(): void
    {
        Notification::fake();
        $user     = User::factory()->createOneQuietly();
        $fileName = sprintf('clients-%s.pdf', now()->format('d_m_Y_H_i_s'));
        Storage::fake('exports');
        $subject = 'Clients Report - ' . now()->format('d.m.Y');

        $user->notify(new ClientReportNotification($fileName));

        Notification::assertSentTo($user, ClientReportNotification::class, function ($notification, $channels) use ($user, $subject) {
            $this->assertContains('mail', $channels);

            $mailNotification = (object)$notification->toMail($user);
            $this->assertEquals($subject, $mailNotification->subject,);

            $this->assertEquals('The report you have been requested is attached bellow.', $mailNotification->introLines[0]);

            return true;
        });
    }
}
