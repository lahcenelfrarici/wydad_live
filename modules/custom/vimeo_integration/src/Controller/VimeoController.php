<?php

namespace Drupal\vimeo_integration\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\vimeo_integration\VimeoClient;

/**
 * Controller for Vimeo video list and detail pages.
 */
class VimeoController extends ControllerBase
{

  /**
   * Vimeo client service.
   *
   * @var \Drupal\vimeo_integration\VimeoClient
   */
  protected $vimeoClient;

  /**
   * Construct the Vimeo controller.
   */
  public function __construct(VimeoClient $vimeoClient)
  {
    $this->vimeoClient = $vimeoClient;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container)
  {
    return new static(
      $container->get('vimeo_integration.client')
    );
  }

  /**
   * Displays a list of Vimeo videos.
   */
  public function listVideos()
  {
    $videos = $this->vimeoClient->getVideos(12);

    $items = [];
    foreach ($videos as $video) {
      $duration = gmdate("i:s", $video['duration']);
      $items[] = [
        'id' => basename($video['uri']),
        'title' => $video['name'],
        'thumbnail' => $video['pictures']['sizes'][3]['link'] ?? '',
        'duration' => $duration,
        'description' => $video['description'] ?? '',
        'category' => $video['categories'][0]['name'] ?? 'General',
        'url' => '/vimeo/video/' . basename($video['uri']),
      ];
    }

    return [
      '#theme' => 'vimeo_list',
      '#videos' => $items,
      '#attached' => [
        'library' => ['vimeo_integration/styles'],
      ],
    ];
  }

  /**
   * Displays the detail page for a single Vimeo video.
   */
  public function videoDetail($video_id)
  {
    $video = $this->vimeoClient->getVideo($video_id);

    // Safety check if video not found or invalid.
    if (empty($video) || isset($video['error'])) {
      return [
        '#markup' => '<p>Video not found.</p>',
      ];
    }

    $duration = gmdate("i:s", $video['duration']);
    $related = $this->vimeoClient->getVideos(6);

    return [
      '#theme' => 'vimeo_detail',
      '#video' => [
        'id' => $video_id,
        'title' => $video['name'],
        'description' => $video['description'],
        'duration' => gmdate("i:s", $video['duration']),
        'player' => "https://player.vimeo.com/video/$video_id",
        'created' => date('d M Y', strtotime($video['created_time'] ?? '')),
      ],

      '#related' => $related,
      '#attached' => [
        'library' => ['vimeo_integration/styles'],
      ],
    ];
  }

}
