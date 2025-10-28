<?php

namespace Drupal\sii_map\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\sii_map\Services\MapService;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Controller for handling map data requests.
 */
class MapController extends ControllerBase {

  /**
   * The map service.
   *
   * @var \Drupal\sii_map\Services\MapService
   */
  protected $mapService;

  /**
   * Constructs a new MapController instance.
   *
   * @param \Drupal\sii_map\Services\MapService $map_service
   *   The map service.
   */
  public function __construct(MapService $map_service) {
    $this->mapService = $map_service;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('sii_map.map_service')
    );
  }

  /**
   * Returns JSON data for the agency map.
   *
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   *   A JSON response containing map data.
   */
  public function getMapData() {
    die("rrrr");
    $map_data = $this->mapService->getMapData();
    return new JsonResponse($map_data);
  }
}
