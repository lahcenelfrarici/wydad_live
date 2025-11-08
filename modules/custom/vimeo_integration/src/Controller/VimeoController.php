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
  // public function videoDetail($video_id)
  // {
  //   $video = $this->vimeoClient->getVideo($video_id);

  //   // Safety check if video not found or invalid.
  //   if (empty($video) || isset($video['error'])) {
  //     return [
  //       '#markup' => '<p>Video not found.</p>',
  //     ];
  //   }

  //   $duration = gmdate("i:s", $video['duration']);
  //   $related = $this->vimeoClient->getVideos(6);

  //   return [
  //     '#theme' => 'vimeo_detail',
  //     '#video' => [
  //       'id' => $video_id,
  //       'title' => $video['name'],
  //       'description' => $video['description'],
  //       'duration' => gmdate("i:s", $video['duration']),
  //       'player' => "https://player.vimeo.com/video/$video_id",
  //       'created' => date('d M Y', strtotime($video['created_time'] ?? '')),

  //     ],

  //     '#related' => $related,
  //     '#attached' => [
  //       'library' => ['vimeo_integration/styles'],
  //     ],
  //   ];
  // }
/**
 * Displays the detail page for a single Vimeo video.
 */
// public function videoDetail($video_id)
// {
//     $video = $this->vimeoClient->getVideo($video_id);

//     if (empty($video) || isset($video['error'])) {
//         return [
//             '#markup' => '<p>Video not found.</p>',
//         ];
//     }

//     // Use the embed URL directly from Vimeo
//     $player_embed_url = $video['player_embed_url'] ?? "https://player.vimeo.com/video/$video_id";
//     $hero_link = "/vimeo/video/$video_id";

//     return [
//         '#theme' => 'vimeo_detail',
//         '#video' => [
//             'id' => $video_id,

//             'title' => $video['name'],
//             'description' => $video['description'] ?? '',
//             'duration' => gmdate("i:s", $video['duration'] ?? 0),
//             'created' => isset($video['created_time']) ? date('d M Y', strtotime($video['created_time'])) : '',
//             'player_embed_url' => $player_embed_url,
//             'hero_link' => $hero_link,
//             'type' => $video['type'] ?? 'video',
//         ],
//         '#attached' => [
//             'library' => ['vimeo_integration/styles'],
//         ],
//     ];
// }
 public function videoDetail($video_id) {
    $video = $this->vimeoClient->getVideo($video_id);

    if (empty($video) || isset($video['error'])) {
      return [
        '#markup' => '<p>Video not found.</p>',
      ];
    }

    // Map related videos
    $related_raw = $this->vimeoClient->getVideos(6);
    $related = [];
    foreach ($related_raw as $item) {
      $related[] = [
        'id' => basename($item['uri']),
        'uri' => $item['uri'],
        'name' => $item['name'],
        'description' => $item['description'] ?? '',
        'duration' => $item['duration'] ?? 0,
        'pictures' => $item['pictures'] ?? [],
        'player_embed_url' => $item['player_embed_url'] ?? "https://player.vimeo.com/video/" . basename($item['uri']),
        'type' => $item['type'] ?? 'video',
      ];
    }

    return [
      '#theme' => 'vimeo_detail',
      '#video' => [
        'id' => $video_id,
        'title' => $video['name'],
        'description' => $video['description'] ?? '',
        'duration' => gmdate("i:s", $video['duration'] ?? 0),
        'created' => isset($video['created_time']) ? date('d M Y', strtotime($video['created_time'])) : '',
        'player_embed_url' => $video['player_embed_url'] ?? "https://player.vimeo.com/video/$video_id",
        'hero_link' => "/vimeo/video/$video_id",
        'type' => $video['type'] ?? 'video',
      ],
      '#related' => $related,
      '#attached' => [
        'library' => ['vimeo_integration/styles'],
      ],
    ];
  }

}
