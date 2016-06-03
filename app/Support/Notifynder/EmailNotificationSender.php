<?php namespace App\Support\Notifynder;

use Fenos\Notifynder\Contracts\Sender;
use Fenos\Notifynder\Contracts\NotifynderSender;
use Fenos\Notifynder\Models\Notification;
use Mail;

class EmailNotificationSender implements Sender
{
    /**
     * @var array
     */
    protected $notification;

    /**
     * Create a new email notification sender instance.
     *
     * @param  array  $notification
     * @param  Mailer  $mailer
     */
    public function __construct($notification)
    {
        $this->notification = $notification;
    }

    /**
     * Send the notification.
     *
     * @param  NotifynderSender  $sender
     * @return void
     */
    public function send(NotifynderSender $sender)
    {
        // Only send the notification if the triggering and receiving users are
        // different
        if ($this->notification['from_id'] != $this->notification['to_id']) {
            $notification = $sender->sendOne($this->notification);

            if ($notification->to->preference('email_notifications')) {
                $this->sendEmail($notification);
            }
        }
    }

    /**
     * Send an email notification.
     *
     * @param  Notification  $notification
     * @return void
     */
    public function sendEmail(Notification $notification) {
        $user = $notification->to;

        Mail::send(
            'user.account.emails.notification',
            compact('user', 'notification'),
            function ($message) use ($user) {
                return $message->to($user->email)->subject('RNA Notification');
            }
        );
    }
}
