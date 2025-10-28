<?php 


namespace Drupal\dynamic_subprofile\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DynamicSubprofileController extends ControllerBase {

  public function getSubprofiles(Request $request) {
    $profile_id = $request->query->get('profile_id');
    $options = [];

    if ($profile_id) {
      $query = \Drupal::entityQuery('taxonomy_term')
        ->condition('vid', 'subprofile')
        ->accessCheck(true)
        ->condition('field_profile', $profile_id);
      $subprofile_ids = $query->execute();

      foreach ($subprofile_ids as $id) {
        $term = \Drupal\taxonomy\Entity\Term::load($id);
        $options[$id] = $term->label();
      }
    }

    return new JsonResponse($options);
  }
}