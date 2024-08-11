<?php

use App\Models\User;

function isAdmin() {
    return auth()?->user()->role === User::ADMIN;
}

function isVendor() {
    return auth()?->user()?->role === User::VENDOR;
}

function isUser() {
    return auth()?->user()?->role === User::USER;
}

function isLoggedin() {
    return isAdmin() || isUser() || isVendor();
}

function unauthorized($message = 'Unauthorized Action') {
    $data = [
        'message' => $message
    ];
    
    return response($data, 403);
}

function emptyResponse() {
    return response('', 204);
}

function notFoundResponse($message = "Not Found") {
    $data = [
        'message' => $message
    ];
    
    return response($data, 404);
}

function paymentFailed($message = "Payment Failed") {
    $data = [
        'message' => $message
    ];

    return response($data, 402);
}