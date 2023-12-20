<?php

if (!function_exists('delivery_login')) {
  function delivery_login() {
    $client = \Config\Services::curlrequest();

    try{
      // $response = $client->request('POST', getenv('api_delivery_baseUrl') . '/api/auth/token', [
      $response = $client->request('POST', 'http://localhost:8081' . '/api/auth/token', [
        'headers' => [
          'Content-Type' => 'application/json',
          'allow_redirects' => false,
        ],
        'json' => [
          'email' => getenv('api_delivery_email'),
          'password' => getenv('api_delivery_password'),
        ],
        'http_errors' => false,
        'verify' => false,
      ]);

      if ($response->getStatusCode() !== 200) {
        throw new \Exception('Failed to login to delivery service.');
      }

      $body = json_decode($response->getBody(), true);
      $token = $body['data']['token'];

      putenv('api_delivery_token=' . $token);
      log_message('info', 'delivery token: ' . $token);
      putenv('aan_shibal = "' . $response->getStatusCode() . '"');
      print_r($response->getStatusCode());

      return getenv('api_delivery_token') === $token;
    } catch (\Exception $e) {
      throw new \Exception($response->getStatusCode() . ' ' . $response->getReasonPhrase() . ' ' . $response->getBody() . getenv('api_delivery_baseUrl') . '/auth/token');
    }
  }
}
