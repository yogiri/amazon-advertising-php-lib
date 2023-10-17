<?php

namespace Yogiri\AmazonAdvertising\Resources;

use Yogiri\AmazonAdvertising\Client;
use Exception;

/**
 * Class Stores
 * @package Yogiri\AmazonAdvertising\Resources
 * @see https://advertising.amazon.com/API/docs/v2/reference/stores
 *
 * @property Client $client
 */
class Stores {

  const BASE_URL = 'v2/stores';

  /**
   * Addons constructor.
   * @param Client $client
   */
  public function __construct(Client $client) {
    $this->client = $client;
  }

  /**
   * @see https://advertising.amazon.com/API/docs/v2/reference/stores#listStores
   * @return array
   * @throws Exception
   */
  public function list() {
    return $this->client->get(self::BASE_URL);
  }

  /**
   * @see https://advertising.amazon.com/API/docs/v2/reference/stores#getStore
   * @param $brandEntityId
   * @return array
   * @throws Exception
   */
  public function get($brandEntityId) {
    return $this->client->get([self::BASE_URL, $brandEntityId]);
  }
}
