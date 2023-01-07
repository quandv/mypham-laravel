<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;

    /**
     * Create a notification instance.
     *
     * @param  string  $token
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's channels.
     *
     * @param  mixed  $notifiable
     * @return array|string
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Cập nhật mật khẩu mới')
            ->greeting('Xin chào!')
            ->line('Chúng tôi đã nhận được yêu cầu cập nhật mật khẩu mới từ tài khoản này. Vui lòng truy cập vào link bên dưới để thiết lập mật khẩu mới')
            ->action('Đặt lại mật khẩu', url('admin/password/reset', $this->token))
            ->line('Nếu bạn không yêu cầu cập nhật mật khẩu mới, bạn có thể bỏ qua thư này.');
    }
}
