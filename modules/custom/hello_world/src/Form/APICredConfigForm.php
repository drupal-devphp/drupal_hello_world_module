<?php

namespace Drupal\hello_world\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class APICredConfigForm extends ConfigFormBase {
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'api_admin_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
        'hello_world.setting',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('hello_world.setting');
    $form['dev_api_url'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Dev API URL'),
      '#default_value' => $config->get('dev_api_url'),
    ];

    $form['prod_api_url'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Prod API URL'),
      '#default_value' => $config->get('prod_api_url'),
      ];
    
      return parent::buildForm($form, $form_state);
  }

   /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('hello_world.setting')
      ->set('dev_api_url', $form_state->getValue('dev_api_url'))
      ->set('prod_api_url', $form_state->getValue('prod_api_url'))
      ->save();
      parent::submitForm($form, $form_state);
  }

}
