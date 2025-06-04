<?php
function auth_set($key, $value) {
    $auth = Session::has('auth') ? Session::get('auth') : [];
    $auth[$key] = $value;
    Session::set('auth', $auth);
}

function auth_get($key = null) {
    if (!Session::has('auth')) return null;
    return $key ? Session::get('auth')[$key] : Session::get('auth');
}

function auth_destroy() {
    Session::delete('auth');
}