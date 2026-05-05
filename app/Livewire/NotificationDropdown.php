<?php

namespace App\Livewire;

use Livewire\Component;

class NotificationDropdown extends Component
{
    public function getListeners()
    {
        return [
            'echo:notifications,NotificationSent' => '$refresh',
        ];
    }

    public function markAsRead($id)
    {
        $notification = auth()->user()->unreadNotifications()->where('id', $id)->first();
        if ($notification) {
            $notification->markAsRead();
        }
    }

    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
    }

    public function render()
    {
        $notifications = auth()->check() ? auth()->user()->unreadNotifications : collect([]);

        return view('livewire.notification-dropdown', [
            'notifications' => $notifications
        ]);
    }
}
