<?php

// Mirrors the .env values from the Node.js project (ADMIN_EMAIL / ADMIN_PASSWORD)
return [
    'admin_email' => env('ADMIN_EMAIL', 'admin@venue.com'),
    'admin_password' => env('ADMIN_PASSWORD', 'admin123'),
];