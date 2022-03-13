<?php

namespace Drupal\dynamic_site_location_and_time\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure Dynamic Site location and time settings for this site.
 */
class SettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'dynamic_site_location_and_time_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['dynamic_site_location_and_time.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['dynamic_country'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Country'),
      '#default_value' => $this->config('dynamic_site_location_and_time.settings')->get('dynamic_country'),
      '#required' => TRUE,
    ];
    $form['dynamic_city'] = [
      '#type' => 'textfield',
      '#title' => $this->t('City'),
      '#default_value' => $this->config('dynamic_site_location_and_time.settings')->get('dynamic_city'),
      '#required' => TRUE,
    ];
    $form['dynamic_timezone'] = [
      '#type' => 'select',
      '#title' => $this->t('TimeZone'),
      '#options' => [
        'America/Chicago' => $this->t('America/Chicago'),
        'America/New_York' => $this->t('America/New_York'),
        'Asia/Tokyo' => $this->t('Asia/Tokyo'),
        'Asia/Dubai' => $this->t('Asia/Dubai'),
        'Asia/Kolkata' => $this->t('Asia/Kolkata'),
        'Europe/Amsterdam' => $this->t('Europe/Amsterdam'),
        'Europe/Oslo' => $this->t('Europe/Oslo'),
        'Europe/London' => $this->t('Europe/London'),
      ],
      '#default_value' => $this->config('dynamic_site_location_and_time.settings')->get('dynamic_timezone'),
      '#required' => TRUE,
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('dynamic_site_location_and_time.settings')
      ->set('dynamic_country', $form_state->getValue('dynamic_country'))
      ->set('dynamic_city', $form_state->getValue('dynamic_city'))
      ->set('dynamic_timezone', $form_state->getValue('dynamic_timezone'))
      ->save();
    parent::submitForm($form, $form_state);
  }

}
