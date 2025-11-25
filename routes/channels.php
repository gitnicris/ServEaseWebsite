<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

// Private chat channel for each booking
Broadcast::channel('booking.{bookingId}', function ($user, $bookingId) {

    // Authorize: only customer or provider can join this chat
    $booking = \App\Models\Booking::find($bookingId);

    if (!$booking) {
        return false;
    }

    return $user->id === $booking->customer_id || $user->id === $booking->provider_id;
});
