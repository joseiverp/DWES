<?php
declare(strict_types=1);

namespace 

function iniciarSesion(): void {
    session_name('biblioteca');
    ini_set('session.use_strict_mode', '1');
    ini_set('session.use_only_cookies', '1');
    session_start([
        'cookie_path' => '/'
        'cookie_path' => '/'
        'cookie_path' => '/'
        'cookie_path' => '/'
    ])
}