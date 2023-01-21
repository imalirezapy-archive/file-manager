<?php

function homeController()
{
    $address = __DIR__ . '/root';
    if (is_null(query('address'))) {
        header('Location: /?address='. $address);
    }

    view('home', ['files' => listDirectory($address)]);
    ;
}