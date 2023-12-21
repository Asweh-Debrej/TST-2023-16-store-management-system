<?php

if (!function_exists('delivery_login')) {
  function delivery_login() {
    $client = \Config\Services::curlrequest();

    try{
      $response = $client->request('POST', getenv('api_delivery_baseUrl') . '/auth/token', [
        'headers' => [
          'Content-Type' => 'application/json',
          'allow_redirects' => false,
        ],
        'json' => [
          'email' => getenv('api_delivery_email'),
          'password' => getenv('api_delivery_password'),
        ],
        // 'debug' => true,
        // 'verify' => false,
        'http_errors' => false,
      ]);

      if ($response->getStatusCode() !== 200) {
        throw new \Exception('Failed to login to delivery service.');
      }

      $body = json_decode($response->getBody(), true);
      $token = $body['data']['token'];

      putenv('api_delivery_token=' . $token);

      return getenv('api_delivery_token');
    } catch (\Exception $e) {
      throw new \Exception('Failed to login to delivery service.');
    }
  }
}
