<?php

namespace Drupal\hello_world\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\Component\Serialization\Json;
use Drupal\node\Entity\Node;

class APIController extends ControllerBase {
  public function getFact() {
    $client = \Drupal::httpClient();
    $request = $client->get(
      "https://catfact.ninja/fact"  
    );
    $response = $request->getBody()->getContents();
    return $result = json::decode($response);
    echo "<pre>";
    print_r($result);
    exit;    
  }

  public function restApi() {
    $client = \Drupal::httpClient();
    $request = $client->post(
        "https://gorest.co.in/public/v2/graphql", [
            'query' => [
              'query' => 'query{user(id: 198) { id name email gender status }}',
            ],
            'headers' => [
              'Content-Type' => 'application/json',
              'cache-control' => 'no-cache'
            ],
        ]
    );

    $response = $request->getBody()->getContents();
    $result = json::decode($response);
    echo "<pre>";
    print_r($result);
    exit;

  }
  
  public function saveAPIData() {
    $client = \Drupal::httpClient();
    $random = rand(10,1000);
    $request = $client->post(
        "https://gorest.co.in/public/v2/graphql", [
            'query' => [
              'query' => 'query{user(id: ' . $random . ') { id name email gender status }}',
            ],
            'headers' => [
              'Content-Type' => 'application/json',
              'cache-control' => 'no-cache'
            ],
        ]
    );

    $response = $request->getBody()->getContents();
    $result = json::decode($response);
    if(!empty($result['data']['user'])) {
      $id     = $result['data']['user']['id'];
      $name   = $result['data']['user']['name'];
      $email  = $result['data']['user']['email'];
      $gender = $result['data']['user']['gender'];
      $status = $result['data']['user']['status'];

      $node = Node::create([
        'type'     => 'employee_data',
        'title'    => $name,
        'field_id' => $id,
        'field_name' => $name,
        'field_email' => $email,
        'field_gender' => $gender,
        'field_status' => $status
      ]);

      $node->save();
    }
    echo "<pre>";
    print_r($result);
    exit;

  }

}
