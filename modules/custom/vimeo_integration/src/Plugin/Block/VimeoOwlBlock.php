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
class VimeoOwlBlock extends BlockBase implements ContainerFactoryPluginInterface
{

  protected $vimeoClient;

  public function __construct(array $configuration, $plugin_id, $plugin_definition, VimeoClient $vimeoClient)
  {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->vimeoClient = $vimeoClient;
  }

  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition)
  {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('vimeo_integration.client')
    );
  }

//   public function build()
//   {
//     $videos = $this->vimeoClient->getVideos(10);

//     if (empty($videos)) {
//       return [
//         '#markup' => '<p>No videos found.</p>',
//       ];
//     }

//     // --- HERO SECTION (latest video) ---
//     $hero = $videos[0];
//     $hero_id = basename($hero['uri']);
//     $hero_title = htmlspecialchars($hero['name']);
//     $hero_desc = htmlspecialchars($hero['description'] ?? '');
// dump($videos);
//     $hero_link = "/vimeo/video/$hero_id";

//     $output = "
//   <div class='vedio__full_first'>
//     <div class='video-container'>
//       <iframe src='https://player.vimeo.com/video/{$hero_id}?autoplay=1&loop=1&muted=0&background=1'
//         frameborder='0'
//         allow='autoplay; fullscreen; picture-in-picture'
//         allowfullscreen>
//       </iframe>
//     </div>

//     <div class='video-overlay container-fluid'>
//       <div class='content'>
//         <h1>{$hero_title}</h1>
//         <p>{$hero_desc}</p>
//         <a href='{$hero_link}' class='btn test'>
//           <svg width='15' height='15' viewBox='0 0 15 15' fill='none' xmlns='http://www.w3.org/2000/svg'>
//             <path
//               d='M13.0568 5.51498C13.417 5.70654 13.7183 5.9925 13.9284 6.34222C14.1385 6.69194 14.2495 7.09224 14.2495 7.50023C14.2495 7.90822 14.1385 8.30852 13.9284 8.65824C13.7183 9.00796 13.417 9.29392 13.0568 9.48548L3.44775 14.7107C1.9005 15.553 0 14.458 0 12.7262V2.27498C0 0.542481 1.9005 -0.551769 3.44775 0.288981L13.0568 5.51498Z'
//               fill='white'/>
//           </svg>
//           REGARDER
//         </a>
//       </div>
//     </div>
//   </div>
//   ";

//     // --- Dernières vidéos carousel ---
//     $output .= '
//   <section class="all_video_owl">
//     <div class="container-fluid">
//       <div class="title__sc mb-4">
//         <h2>Précédent</h2>
//       </div>
//       <div class="slider__owl owl-carousel owl-theme">';

//     foreach ($videos as $video) {
//       $id = basename($video['uri']);
//       $title = htmlspecialchars($video['name']);
//       $thumb = $video['pictures']['sizes'][3]['link'] ?? '';
//       $duration = gmdate("i:s", $video['duration']);
//       $views = $video['stats']['plays'] ?? 0;
//       $link = "/vimeo/video/$id";
//       $category = $video['categories'][0]['name'] ?? 'Highlights';
//       // <img src='{$thumb}' alt='{$title}'>     <span class='video__badge'>{$category}</span>
//       $output .= "
//       <div class='item' >
//       <a href='{$link}' class='video__link remove_link_default'>
//         <div class='wrapper_img'>

//          <img src='{$thumb}' alt='{$title}'>
//           <div class='video__play'>
//             <svg width='58' height='58' viewBox='0 0 58 58' fill='none' xmlns='http://www.w3.org/2000/svg'>
//               <path d='M0 28.8C0 12.8942 12.8943 0 28.8 0C44.7058 0 57.6001 12.8942 57.6001 28.8C57.6001 44.7058 44.7058 57.6 28.8 57.6C12.8943 57.6 0 44.7058 0 28.8Z' fill='#E30613'/>
//               <path d='M23.3999 18L40.1999 28.8L23.3999 39.5999V18Z' fill='white' stroke='white' stroke-width='2.4' stroke-linecap='round' stroke-linejoin='round'/>
//             </svg>
//           </div>
//           <span class='video__duration'>{$duration}</span>
//         </div>

//         <div class='video__info'>

//           <h6>{$title}</h6>
//           <p>Disponible prochainement</p>
//           <span>👁️ {$views} vues</span>
//         </div>
//       </a>
//       </div>";
//     }

//     $output .= '
//       </div>
//         </div>
//       </section>';

//     return [
//       '#type' => 'markup',
//       '#markup' => Markup::create($output),
//       '#attached' => [
//         'library' => [
//           'vimeo_integration/owl_init',
//         ],
//       ],
//     ];
//   }
public function build() {
  $videos = $this->vimeoClient->getVideos(10);

  if (empty($videos)) {
    return [
      '#markup' => '<p>No videos found.</p>',
    ];
  }

  // --- HERO SECTION (latest video) ---
  $hero = $videos[0];
  $hero_id = basename($hero['uri']);
  $hero_title = htmlspecialchars($hero['name']);
  $hero_desc = htmlspecialchars($hero['description'] ?? '');
  $hero_link = "/vimeo/video/$hero_id";

  // Get embed and type
  $hero_embed = $hero['player_embed_url'] ?? '';
  $type = $hero['type'] ?? 'video';

  // Select iframe source based on type dump($videos);
  // if ($type === 'live') {
  //   $iframe_src = "{$hero_embed}?autoplay=1";
  // } else {
  //   $iframe_src = "{$hero_embed}?autoplay=1&loop=1&muted=0&background=1";
  // }
$iframe_src = "{$hero_embed}?autoplay=1&loop=1&muted=0&background=1";
  // --- HERO VIDEO OUTPUT ---
  $output = "
  <div class='vedio__full_first'>
    <div class='video-container'>
      <iframe src='{$iframe_src}'
        frameborder='0'
        allow='autoplay; fullscreen; picture-in-picture'
        allowfullscreen>
      </iframe>
      " . ($type === 'live' ? "<span class='live-badge'>LIVE 🔴</span>" : "") . "
    </div>

    <div class='video-overlay container-fluid'>
      <div class='content'>
        <h1>{$hero_title}</h1>
        <p>{$hero_desc}</p>
        <a href='{$hero_link}' class='btn test'>
          <svg width='15' height='15' viewBox='0 0 15 15' fill='none' xmlns='http://www.w3.org/2000/svg'>
            <path
              d='M13.0568 5.51498C13.417 5.70654 13.7183 5.9925 13.9284 6.34222C14.1385 6.69194 14.2495 7.09224 14.2495 7.50023C14.2495 7.90822 14.1385 8.30852 13.9284 8.65824C13.7183 9.00796 13.417 9.29392 13.0568 9.48548L3.44775 14.7107C1.9005 15.553 0 14.458 0 12.7262V2.27498C0 0.542481 1.9005 -0.551769 3.44775 0.288981L13.0568 5.51498Z'
              fill='white'/>
          </svg>
          REGARDER
        </a>
      </div>
    </div>
  </div>
  ";

  // --- CAROUSEL SECTION ---
  $output .= '
  <section class="all_video_owl">
    <div class="container-fluid">
      <div class="title__sc mb-4">
        <h2>Précédent</h2>
      </div>
      <div class="slider__owl owl-carousel owl-theme">';

  foreach ($videos as $video) {
    $id = basename($video['uri']);
    $title = htmlspecialchars($video['name']);
    $thumb = $video['pictures']['sizes'][3]['link'] ?? '';
    $duration = $video['duration'] > 0 ? gmdate("i:s", $video['duration']) : 'LIVE';
    $views = $video['stats']['plays'] ?? 0;
    $link = "/vimeo/video/$id";
    $category = $video['categories'][0]['name'] ?? 'Highlights';
    $video_type = $video['type'] ?? 'video';

    $badge = $video_type === 'live' ? "<span class='live-badge-small'>LIVE 🔴</span>" : '';

    $output .= "
      <div class='item'>
        <a href='{$link}' class='video__link remove_link_default'>
          <div class='wrapper_img'>
            <img src='{$thumb}' alt='{$title}'>
            {$badge}
            <div class='video__play'>
              <svg width='58' height='58' viewBox='0 0 58 58' fill='none' xmlns='http://www.w3.org/2000/svg'>
                <path d='M0 28.8C0 12.8942 12.8943 0 28.8 0C44.7058 0 57.6001 12.8942 57.6001 28.8C57.6001 44.7058 44.7058 57.6 28.8 57.6C12.8943 57.6 0 44.7058 0 28.8Z' fill='#E30613'/>
                <path d='M23.3999 18L40.1999 28.8L23.3999 39.5999V18Z' fill='white' stroke='white' stroke-width='2.4' stroke-linecap='round' stroke-linejoin='round'/>
              </svg>
            </div>
            <span class='video__duration'>{$duration}</span>
          </div>

          <div class='video__info'>
            <h6>{$title}</h6>
            <p>" . ($video_type === 'live' ? 'En direct maintenant' : 'Disponible prochainement') . "</p>
            <span>👁️ {$views} vues</span>
          </div>
        </a>
      </div>";
  }

  $output .= '
      </div>
    </div>
  </section>';

  // --- RETURN RENDER ARRAY ---
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
