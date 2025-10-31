<?php

namespace Drupal\vimeo_integration;

use GuzzleHttp\ClientInterface;
use Drupal\Core\Config\ConfigFactoryInterface;

/**
 * Vimeo API Client.
 */
class VimeoClient {

  protected $httpClient;
  protected $config;

  public function __construct(ClientInterface $http_client, ConfigFactoryInterface $config_factory) {
    $this->httpClient = $http_client;
    $this->config = $config_factory;
  }

  /**
   * Get a list of videos.
   */
  public function getVideos($limit = 6) {
    // $token = '4e0088fd72d8147e194b7a32daec833c';
$token = '4e0088fd72d8147e194b7a32daec833c';
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
    }
    catch (\Exception $e) {
      \Drupal::logger('vimeo_integration')->error($e->getMessage());
      return [];
    }
  }

  /**
   * Get single video details.
   */
  public function getVideo($video_id) {
    $token = '42317667d21e5ca32648753a5e3faef1';
    $uri = "https://api.vimeo.com/videos/$video_id";

    try {
      $response = $this->httpClient->request('GET', $uri, [
        'headers' => [
          'Authorization' => "Bearer $token",
          'Accept' => 'application/vnd.vimeo.*+json;version=3.4',
        ],
      ]);

      return json_decode($response->getBody()->getContents(), TRUE);
    }
    catch (\Exception $e) {
      \Drupal::logger('vimeo_integration')->error($e->getMessage());
      return NULL;
    }
  }

}
