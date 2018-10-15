<?php

if (!function_exists('makeRequest')) {
    function makeRequest($url, $method = 'GET', $data = []) {
        $request = \Request::create($url, $method, $data);
        $response = \Route::dispatch($request);

        return $response;
    }
}

if (!function_exists('oauthLogin')) {
    function oauthLogin($username, $password) {
        $oauthPasswordClient = resolve('OAUTH_PASSWORD_CLIENT');

        return resolve('api')->post('/oauth/token', [
            'grant_type' => 'password',
            'client_id' => $oauthPasswordClient->id,
            'client_secret' => $oauthPasswordClient->secret,
            'username' => $username,
            'password' => $password,
            'scope' => '*'
        ]);
    }
}