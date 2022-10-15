<?php

namespace Drupal\farm_map_openweathermap\EventSubscriber;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\farm_map\Event\MapRenderEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * An event subscriber for the MapRenderEvent.
 *
 * This adds the openweathermap behavior and api_key setting to all maps.
 */
class MapRenderEventSubscriber implements EventSubscriberInterface {

  /**
   * The config factory service.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  private $configFactory;

  /**
   * Constructor.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory service.
   */
  public function __construct(ConfigFactoryInterface $config_factory) {
    $this->configFactory = $config_factory;
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    return [
      MapRenderEvent::EVENT_NAME => 'onMapRender',
    ];
  }

  /**
   * React to the MapRenderEvent.
   *
   * @param \Drupal\farm_map\Event\MapRenderEvent $event
   *   The MapRenderEvent.
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  public function onMapRender(MapRenderEvent $event) {

    // Get the openweathermap api_key.
    $api_key = $this->configFactory->get('farm_map_openweathermap.settings')->get('api_key');

    // Set a cache tag on the openweathermap settings in case this ever changes.
    // This is added to all maps since the openweathermap behavior can be added to all
    // maps.
    $event->addCacheTags(['config:farm_map_openweathermap.settings']);

    // If the api key exists, add the openweathermap behavior.
    if (!empty($api_key)) {
      $event->addBehavior('openweathermap', ['api_key' => $api_key]);
    }
  }

}
