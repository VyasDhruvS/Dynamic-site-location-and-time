<?php

namespace Drupal\dynamic_site_location_and_time\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Cache\Cache;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\dynamic_site_location_and_time\LocationTimeService;

/**
 * Provides a block for location and time.
 *
 * @Block(
 *   id = "dynamic_site_location_and_time_block",
 *   admin_label = @Translation("Dynamic Location and Time"),
 *   category = @Translation("Dynamic Site location and time")
 * )
 */
class LocationTimeBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * {@inheritdoc}
   *
   * This method defines form elements for custom block configuration. Standard
   * block configuration fields are added by BlockBase::buildConfigurationForm()
   * (block title and title visibility) and BlockFormController::form() (block
   * visibility settings).
   *
   * @see \Drupal\block\BlockBase::buildConfigurationForm()
   * @see \Drupal\block\BlockFormController::form()
   */
  public function blockForm($form, FormStateInterface $form_state) {

    $form = parent::blockForm($form, $form_state);

    return $form;

  }

  /**
   * Constructor.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\dynamic_site_location_and_time\LocationTimeService $location_time_manager
   *   LocationTime service.
   */
  public function __construct(array $configuration,
                              $plugin_id,
                              $plugin_definition,
                              LocationTimeService $location_time_manager) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->locationTimeManager = $location_time_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('dynamic_site_location_and_time.service'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {

    $locationTime = $this->locationTimeManager->getLocationTime();

    $build['content'] = [
      '#theme' => 'current_location_time',
      '#country' => $locationTime['country'],
      '#city' => $locationTime['city'],
      '#time' => $locationTime['time'],
      '#timezone' => $locationTime['timezone'],
      '#cache' => [
        'tags' => $this->getCacheTags(),
      ],
    ];
    return $build;
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheTags() {
    return Cache::mergeTags(parent::getCacheTags(), ['config:dynamic_site_location_and_time.settings']);
  }

}
