<?php

namespace Drupal\employee\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;

/**
 * Provides a employee form.
 */
class EmployeeForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'employee_employee';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['emp_firstname'] = [
      '#type' => 'textfield',
      '#title' => $this->t('First Name'),
      '#required' => TRUE,
      '#maxlength' => 30,
    ];

    $form['emp_lastname'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Last Name'),
      '#required' => TRUE,
      '#maxlength' => 30,
    ];

    $form['emp_email'] = [
      '#type' => 'email',
      '#title' => $this->t('Employee Email'),
      '#required' => TRUE,
      '#maxlength' => 100,
    ];
    
    $form['emp_zipcode'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Employee ZIP code'),
      '#required' => TRUE,
      '#maxlength' => 6,
    ];

    $form['actions'] = [
      '#type' => 'actions',
    ];

    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Save'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $formField = $form_state->getValues();

    $firstName = trim($formField['emp_firstname']);
    $lastName = trim($formField['emp_lastname']);
    $email = trim($formField['emp_email']);
    $zipcode = trim($formField['emp_zipcode']);

    if (!preg_match("/^([a-zA-Z']+)$/", $firstName)) {
      $form_state->setErrorByName('emp_firstname', $this->t('Enter the valid first name'));
    }

    if (!preg_match("/^([a-zA-Z']+)$/", $lastName)) {
      $form_state->setErrorByName('emp_lastname', $this->t('Enter the valid last name'));
    }

    if (!\Drupal::service('email.validator')->isValid($email)) {
      $form_state->setErrorByName('emp_email', $this->t('Enter valid email address'));
    }

    if (!preg_match("/^\d{1,6}$/", $zipcode)) {
      $form_state->setErrorByName('emp_zipcode', $this->t('Enter the valid zip code'));
    }

  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $conn = Database::getConnection();

    $formField = $form_state->getValues();

    $formData['emp_firstname'] = $formField['emp_firstname'];
    $formData['emp_lastname'] = $formField['emp_lastname'];
    $formData['emp_email'] = $formField['emp_email'];
    $formData['emp_zipcode'] = $formField['emp_zipcode'];

    $conn->insert('employee')
      ->fields($formData)->execute();

    $this->messenger()->addStatus($this->t('Employee data has been saved successsfully.'));
    $form_state->setRedirect('employee.employee');
  }

}
