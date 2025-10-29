<?php

namespace Drupal\vimeo_integration\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\vimeo_integration\VimeoClient;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Render\Markup;

/**
 * Provides a Vimeo Owl Carousel block.
 *
 * @Block(
 *   id = "vimeo_owl_block",
 *   admin_label = @Translation("Vimeo - Dernières vidéos (Owl Carousel)")
 * )
 */
class VimeoOwlBlock extends BlockBase implements ContainerFactoryPluginInterface {

  protected $vimeoClient;

  public function __construct(array $configuration, $plugin_id, $plugin_definition, VimeoClient $vimeoClient) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->vimeoClient = $vimeoClient;
  }

  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('vimeo_integration.client')
    );
  }

  public function build() {
    $videos = $this->vimeoClient->getVideos(10);

    $output = '
    <section class="all_video_owl">
      <div class="container-fluid">
        <div class="title__sc mb-4">
          <h2>DERNIÈRES VIDÉOS</h2>
        </div>
        <div class="slider__owl owl-carousel owl-theme">';

    foreach ($videos as $video) {
      $id = basename($video['uri']);
      $title = htmlspecialchars($video['name']);
      $thumb = $video['pictures']['sizes'][3]['link'] ?? '';
      $duration = gmdate("i:s", $video['duration']);
      $views = $video['stats']['plays'] ?? 0;
      $link = "/vimeo/video/$id";
      $category = $video['categories'][0]['name'] ?? 'Highlights';

      $output .= "
      <div class='item'>
        <a href='{$link}' class='video__link'>
          <div class='wrapper_img'>
            <img src='{$thumb}' alt='{$title}'>
            <div class='video__play'>
              <svg width='58' height='58' viewBox='0 0 58 58' fill='none' xmlns='http://www.w3.org/2000/svg'>
                <path d='M0 28.8C0 12.8942 12.8943 0 28.8 0C44.7058 0 57.6001 12.8942 57.6001 28.8C57.6001 44.7058 44.7058 57.6 28.8 57.6C12.8943 57.6 0 44.7058 0 28.8Z' fill='#E30613'/>
                <path d='M23.3999 18L40.1999 28.8L23.3999 39.5999V18Z' fill='white' stroke='white' stroke-width='2.4' stroke-linecap='round' stroke-linejoin='round'/>
              </svg>
            </div>
            <span class='video__duration'>
              <svg width='12' height='12' viewBox='0 0 12 12' fill='none' xmlns='http://www.w3.org/2000/svg'>
                <g clip-path='url(#clip0_2013_14)'>
                  <path d='M6 3V6L8 7' stroke='white' stroke-linecap='round' stroke-linejoin='round'/>
                  <path d='M6 11C8.76142 11 11 8.76142 11 6C11 3.23858 8.76142 1 6 1C3.23858 1 1 3.23858 1 6C1 8.76142 3.23858 11 6 11Z' stroke='white' stroke-linecap='round' stroke-linejoin='round'/>
                </g>
                <defs><clipPath id='clip0_2013_14'><rect width='12' height='12' fill='white'/></clipPath></defs>
              </svg>{$duration}
            </span>
          </div>
          <span class='video__badge'>{$category}</span>
          <div class='video__info'>
            <h6>{$title}</h6>
            <span>👁️ {$views} vues</span>
          </div>
        </a>
      </div>";
    }

    $output .= '
        </div>
      </div>
    </section>';

    return [
      '#type' => 'markup',
      '#markup' => Markup::create($output),
      '#attached' => [
        'library' => [
          'vimeo_integration/owl_init',
        ],
      ],
    ];
  }
}
