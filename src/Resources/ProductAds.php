<?php

namespace CapsuleB\AmazonAdvertising\Resources;

use CapsuleB\AmazonAdvertising\Client;
use Exception;

/**
 * Class ProductAds
 * @package CapsuleB\AmazonAdvertising\Resources
 *
 * @property Client $client
 */
class ProductAds {

  const BASE_URL = 'productAds';

  /**
   * Addons constructor.
   * @param Client $client
   */
  public function __construct(Client $client) {
    $this->client = $client;
  }

  /**
   * @param array $query
   * @return array
   * @throws Exception
   */
  public function list($query = []) {
    return $this->client->get(self::BASE_URL, $query);
  }

  /**
   * @param array $query
   * @return array
   * @throws Exception
   */
  public function listExtended($query = []) {
    return $this->client->get([self::BASE_URL, 'extended'], $query);
  }

  /**
   * @param string $adId
   * @return array
   * @throws Exception
   */
  public function get($adId) {
    return $this->client->get(self::BASE_URL, $adId);
  }

  /**
   * @param string $adId
   * @return array
   * @throws Exception
   */
  public function getExtended($adId) {
    return $this->client->get([self::BASE_URL, 'extended', $adId]);
  }

  /**
   * @param array $params
   * @return array
   * @throws Exception
   */
  public function create($params = []) {
    return $this->client->post(self::BASE_URL, null, $params);
  }

  /**
   * @param array $params
   * @return array
   * @throws Exception
   */
  public function update($params = []) {
    return $this->client->put(self::BASE_URL, null, $params);
  }

  /**
   * @param string $adId
   * @return array
   * @throws Exception
   */
  public function archive($adId) {
    return $this->client->delete(self::BASE_URL, $adId);
  }

}