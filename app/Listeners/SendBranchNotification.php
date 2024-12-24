<?php
namespace App\Listeners;

use Carbon\Carbon;
use App\Mail\BranchNotificationMail;
use App\Service\NotificationService;
use Illuminate\Support\Facades\Mail;
use App\Events\BranchNotificationEvent;

class SendBranchNotification
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\BranchNotificationEvent  $event
     * @return void
     */
    public function handle(BranchNotificationEvent $event)
    {
        $today = Carbon::now();

        foreach ($event->branches as $branch) {
            $creationDate = Carbon::parse($branch->created_at);
            $owner = $branch->owner;

            if (!$owner) {
                continue; // Skip if no owner
            }

            // Check if the email has already been sent for each notification type
            $emailSent = $branch->email_sent_at;
            $threeMonthSent = $branch->three_month_email_sent_at; // Assuming you've added a specific column
            $oneMonthSent = $branch->one_month_email_sent_at; // Assuming you've added a specific column
            $expiredEmailSent = $branch->expired_email_sent_at; // Assuming you've added a specific column

            // Prepare notification messages
            $message = null;
            $sendEmail = false;

            // Check if the branch has expired, or is about to expire, and ensure emails are not resent
            if ($today->diffInMonths($creationDate) == 3 && !$threeMonthSent) {
                $message = "Your branch '{$branch->name}' will expire in 3 months.";
                $sendEmail = true;
            } elseif ($today->diffInMonths($creationDate) == 5 && !$oneMonthSent) {
                $message = "Your branch '{$branch->name}' will expire in 1 month.";
                $sendEmail = true;
            } elseif ($today->diffInMonths($creationDate) == 6 && !$expiredEmailSent) {
                $message = "Your branch '{$branch->name}' has expired. Please renew your subscription.";
                $sendEmail = true;
            }

            // Send the email if it's time and the email hasn't been sent yet
            if ($sendEmail && $message) {
                // Send the notification email
                Mail::to($owner->email)->send(new BranchNotificationMail($message));

                // Insert notification to database via NotificationService
                NotificationService::sendNotification(
                    $owner->id,
                    $branch->id,
                    'Branch Expiration Reminder',
                    $message,
                    Carbon::now()
                );

                // Mark the email as sent by updating the respective timestamp
                if ($today->diffInMonths($creationDate) == 3) {
                    $branch->three_month_email_sent_at = $today; // Store the 3-month email timestamp
                } elseif ($today->diffInMonths($creationDate) == 5) {
                    $branch->one_month_email_sent_at = $today; // Store the 1-month email timestamp
                } elseif ($today->diffInMonths($creationDate) == 6) {
                    $branch->expired_email_sent_at = $today; // Store the expired email timestamp
                }

                // Save the updated branch data
                $branch->email_sent_at = $today; // Mark general email_sent_at timestamp
                $branch->save();
            }
        }
    }
}
