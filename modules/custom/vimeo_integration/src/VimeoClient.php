<?php

namespace Drupal\vimeo_integration;

use GuzzleHttp\ClientInterface;
use Drupal\Core\Config\ConfigFactoryInterface;

class VimeoClient {

  protected $httpClient;
  protected $config;

  public function __construct(ClientInterface $http_client, ConfigFactoryInterface $config_factory) {
    $this->httpClient = $http_client;
    $this->config = $config_factory;
  }

  /**
   * Récupère les vidéos depuis l’API Vimeo.
   */
  public function getVideos($limit = 6) {
    // Remplacez 'TON_TOKEN_VIMEO_ICI' par votre token personnel Vimeo.
    $token = '42317667d21e5ca32648753a5e3faef1';
    $uri = "https://api.vimeo.com/me/videos?per_page=$limit";

    try {
      $response = $this->httpClient->request('GET', $uri, [
        'headers' => [
          'Authorization' => "Bearer $token",
          'Accept' => 'application/vnd.vimeo.*+json;version=3.4',
        ],
      ]);

      $data = json_decode($response->getBody()->getContents(), TRUE);
      return $data['data'] ?? [];
      dump($data);
    }
    catch (\Exception $e) {
      \Drupal::logger('vimeo_integration')->error($e->getMessage());
      return [];
    }
  }

}
