<?php

namespace Drupal\site_api_hooks\Plugin\rest\resource;

use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * Provides a resource to get view modes by entity and bundle.
 *
 * @RestResource(
 *   id = "api_key_rest_resource",
 *   label = @Translation("Api key rest resource"),
 *   uri_paths = {
 *     "canonical" = "/page_json/{key}/{nid}"
 *   }
 * )
 */
class ApiKeyResource extends ResourceBase {

  /**
   * Responds to GET requests.
   *
   * Returns a list of bundles for specified entity.
   *
   * @param mixed $data
   *   Data.
   *
   * @return \Drupal\rest\ResourceResponse
   *   Throws exception expected.
   */
  public function get($id = null) {

    $current_uri = explode('/', \Drupal::request()->getRequestUri());
    
    $api_key = $current_uri[2]; // Api key value
    $nid = $current_uri[3]; // Node id value
    
    $config = \Drupal::service('config.factory')->getEditable('system.site'); // getting the Api key from the sytem config variables.
    $stored_key = $config->get('siteapikey');
    $node_load = \Drupal::entityManager()->getStorage('node')->load($nid);

    if (($stored_key == $api_key) &&  !empty($node_load) && $node_load->getType() == 'page') {
      
      // Returning node id, title and description in response.
      $response = [
        'nid'=> $node_load->get('nid')->getValue()[0]['value'],
        'title'=> $node_load->getTitle(),
        'description'=> strip_tags($node_load->get('body')->getValue()[0]['value'])
      ];

      return new ResourceResponse($response);

    }
    else {
    // if Api key is invalid OR node id is invalid, below exception will be thrown.
     throw new AccessDeniedHttpException('Access denied');
    }
  }
}