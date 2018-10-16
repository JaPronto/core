<?php

if (!function_exists('makeRequest')) {
    function makeRequest($url, $method = 'GET', $data = [])
    {
        $request = \Request::create($url, $method, $data);
        $response = \Route::dispatch($request);

        return $response;
    }
}

if (!function_exists('oauthLogin')) {
    function oauthLogin($username, $password)
    {
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

if (!function_exists('uploadFile')) {
    function uploadFile(\Illuminate\Http\UploadedFile $file, $path = '', $storage = 'public', $customName = null)
    {
        try {
            $fileName = $customName ? $customName : $file->hashName();
            $fileName = date('Y_m_d_H_i_s_') . $fileName;

            $filePath = $file->storePubliclyAs($path, $fileName, $storage);

            return $filePath;
        } catch (\Exception $exception) {
            return '';
        }
    }
}