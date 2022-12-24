<?php

namespace Drupal\hello_world\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\hello_world\Controller\APIController;

/**
 * Provides "hello world" block
 * 
 * @Block(
 *   id = "hello_world_block",
 *   admin_label = @Translation("Hello World Block"),
 *   category = @Translation("Custom block for hello world")
 * )
 */

 class HelloWorldBlock extends BlockBase {
    /**
     * {@inheritdoc}
     */
    public function build() {
      $catFactObj = new APIController;
      $factData =  $catFactObj->getFact(); 
      return [
        '#type' => 'markup',
        '#markup' => $factData['fact'],
        '#cache' => [
            'max-age' => 0,
        ]
      ];  
    }

 }
