<?php

namespace Drupal\dynamic_site_location_and_time;

use Drupal\Core\Config\ConfigFactory;
use Drupal\Core\Datetime\DateFormatter;
use Drupal\Core\Datetime\DrupalDateTime;

/**
 * Class LocationTimeService to give location and time.
 */
class LocationTimeService {

  /**
   * Config Factory.
   *
   * @var Drupal\Core\Config\ConfigFactory
   */
  protected $config;

  /**
   * Date Formatter.
   *
   * @var Drupal\Core\Datetime\DateFormatter
   */
  protected $dateFormatter;

  /**
   * Constructs a new LocationTimeService object.
   *
   * @param \Drupal\Core\Config\ConfigFactory $config
   *   Config Factory.
   * @param \Drupal\Core\Datetime\DateFormatter $dateFormatter
   *   Date Formatter.
   */
  public function __construct(ConfigFactory $config, DateFormatter $dateFormatter) {
    $this->config = $config;
    $this->dateFormatter = $dateFormatter;
  }

  /**
   * Get current location and time.
   */
  public function getLocationTime() {
    $config = $this->config->getEditable('dynamic_site_location_and_time.settings');

    $timeZone = $config->get('dynamic_timezone');
    $date = new DrupalDateTime();

    $time = $this->dateFormatter->format(
      $date->getTimeStamp(), 'custom', 'dS M Y - h:i A', $timeZone
    );
    $locationTime = [
      'country' => $config->get('dynamic_country'),
      'city' => $config->get('dynamic_city'),
      'time' => $time,
      'timezone' => $timeZone,
    ];

    return $locationTime;
  }

}
