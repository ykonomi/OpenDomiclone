<?php

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

Broadcast::channel('to-entry-game', function ($user) {
    return ['id' => $user->id, 'name' => $user->name];
});

Broadcast::channel('game', function ($user) {
    return ['id' => $user->id, 'name' => $user->name];
});

//    if ($user->canJoinRoom($roomId)) {
//        return ['id' => $user->id, 'name' => $user->name];
//    } else {
//        return false;
//    }
