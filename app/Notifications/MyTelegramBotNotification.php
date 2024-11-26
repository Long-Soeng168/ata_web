<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramMessage;
use App\Models\User;

class MyTelegramBotNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $videoPlaylistUserCreated;

    /**
     * Create a new notification instance.
     *
     * @param  mixed  $videoPlaylistUserCreated
     */
    public function __construct($videoPlaylistUserCreated)
    {
        // Store the passed data in a property for later use
        $this->videoPlaylistUserCreated = $videoPlaylistUserCreated;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['telegram'];
    }

    /**
     * Get the Telegram representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \NotificationChannels\Telegram\TelegramMessage
     */
    public function toTelegram($notifiable)
    {
        // Extract data from the $videoPlaylistUserCreated object
        $playlistsId = $this->videoPlaylistUserCreated->playlists_id;
        $price = $this->videoPlaylistUserCreated->price;
        $userId = $this->videoPlaylistUserCreated->user_id;
        $user = User::find($userId);
        $transactionImageUrl = url('assets/images/video_playlists_order_transactions/thumb/' . $this->videoPlaylistUserCreated->transaction_image); // Update with your image path

        $url = url('/playlists/' . $playlistsId); // Link to playlist details or relevant page

        // Build the Telegram message with dynamic content
        return TelegramMessage::create()
            ->line("🎉 New Video Training Purchased!")
            ->line("User: *{$user->name}*")
            ->line("Playlist IDs: *{$playlistsId}*")
            ->line("Total Price: *${price}*")
            ->line("Transaction Image: [View Image]({$transactionImageUrl})")
            ->button('View Purchase', $url);
            // ->button('Download App', 'https://example.com/download'); // Replace with actual URL if needed
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'playlists_id' => $this->videoPlaylistUserCreated->playlists_id,
            'price' => $this->videoPlaylistUserCreated->price,
            'user_id' => $this->videoPlaylistUserCreated->user_id,
        ];
    }
}
