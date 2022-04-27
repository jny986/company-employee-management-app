<?php

namespace App\Notifications;

use App\Models\Company;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CompanyAdded extends Notification implements ShouldQueue
{
    use Queueable;

    public $company;

    public function __construct(Company $company)
    {
        $this->company = $company;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('A Company Has Beem Added!')
            ->action('View the Company', route('companies.show', $this->company->id));
    }
}
