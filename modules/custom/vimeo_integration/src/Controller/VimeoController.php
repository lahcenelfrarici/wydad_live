<?php

namespace Drupal\vimeo_integration\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\vimeo_integration\VimeoClient;
use Drupal\Core\Render\Markup;

class VimeoController extends ControllerBase {

  protected $vimeoClient;

  public function __construct(VimeoClient $vimeoClient) {
    $this->vimeoClient = $vimeoClient;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('vimeo_integration.client')
    );
  }

  public function videosPage() {
    $videos = $this->vimeoClient->getVideos(6);

    $output = '<div class="container my-5">';
    $output .= '<div class="row gy-4">';

    foreach ($videos as $video) {
      $title = htmlspecialchars($video['name'] ?? '', ENT_QUOTES, 'UTF-8');
      $iframe = $video['embed']['html'] ?? '';
      $description = htmlspecialchars($video['description'] ?? '', ENT_QUOTES, 'UTF-8');
      $views = $video['stats']['plays'] ?? 0;
      $duration = $video['duration'] ?? 0;
      $categories = $video['categories'] ?? [];

      // Convert duration from seconds → minutes:seconds
      $minutes = floor($duration / 60);
      $seconds = $duration % 60;
      $formatted_duration = sprintf('%02d:%02d', $minutes, $seconds);

      // Format views count
      if ($views >= 1000000) {
        $views_formatted = round($views / 1000000, 1) . 'M';
      } elseif ($views >= 1000) {
        $views_formatted = round($views / 1000, 1) . 'K';
      } else {
        $views_formatted = $views;
      }

      // Extract category names
      $category_names = [];
      foreach ($categories as $cat) {
        $category_names[] = htmlspecialchars($cat['name'], ENT_QUOTES, 'UTF-8');
      }
      $category_list = !empty($category_names) ? implode(', ', $category_names) : 'No category';

      $output .= "
        <div class='col-lg-4 col-md-6 col-sm-12'>
          <div class='vimeo-item text-center border p-3 rounded shadow-sm h-100'>
            <div class='ratio ratio-16x9 mb-3'>
              {$iframe}
            </div>
            <h4 class='h6 mt-2 mb-1'>{$title}</h4>
            <p class='text-muted small mb-1'>
              <i class='bi bi-eye'></i> {$views_formatted} views &nbsp;•&nbsp; ⏱ {$formatted_duration}
            </p>
            <p class='text-secondary small mb-1'>
              <strong>Category:</strong> {$category_list}
            </p>
            <p class='small text-muted'>{$description}</p>
          </div>
        </div>
      ";
    }

    $output .= '</div></div>';

    return [
      '#type' => 'markup',
      '#markup' => Markup::create($output),
      '#attached' => [
        'library' => [],
      ],
    ];
  }

}
