<?php

namespace CapsuleB\AmazonAdvertising\Resources;

use CapsuleB\AmazonAdvertising\Client;
use DateTime;
use DateTimeZone;
use Exception;

/**
 * Class Reports
 * @package CapsuleB\AmazonAdvertising\Resources
 * @see https://advertising.amazon.com/API/docs/v2/reference/reports
 *
 * @property Client $client
 */
class Reports {

  const BASE_URL  = 'reporting/reports';
  const BASE_HSA  = 'v2/hsa';

  /**
   * Addons constructor.
   * @param Client $client
   */
  public function __construct(Client $client) {
    $this->client = $client;
  }

  /**
   * @param string $recordType
   * @param string|array $reportDate
   * @param string|array $segment
   * @param array $metrics
   * @return mixed
   * @throws Exception
   */
  private function retrieve($name, $startDate, $endDate, $params = []) {
    $params = empty($params) ? [] : $params;
    if (!empty($name)) $params['name']            = $name;
    if (!empty($startDate)) $params['startDate']  = $startDate;
    if (!empty($endDate)) $params['endDate']      = $endDate;

    return $this->client->post(self::BASE_URL, null, $params);
  }

  /**
   * @param $id
   * @return mixed
   * @throws Exception
   */
  public function download($id) {
    $report = $this->client->get([self::BASE_URL, $id]);

    // If the report is ready, download, format and return it
    if ($report->status == 'COMPLETED') {
      return $this->client->download($report->url);
    }

    // Otherwise return the answer as-is
    return $report;
  }

  /**
   * @see https://advertising.amazon.com/API/docs/v2/reference/reports#Campaigns-reports
   * @param $reportDate
   * @param $segment
   * @param array $metrics
   * @return mixed
   * @throws Exception
   */
  public function getCampaigns($reportDate, $segment = null, $metrics = []) {
    return $this->retrieve(self::BASE_URL, 'campaigns', $reportDate, $segment, $metrics);
  }

  /**
   * @see https://advertising.amazon.com/API/docs/v2/reference/reports#Campaigns-reports
   * @param $reportDate
   * @param $segment
   * @param $metrics
   * @return mixed
   * @throws Exception
   */
  public function getCampaignsHSA($reportDate, $segment = null, $metrics = []) {
    return $this->retrieve(self::BASE_HSA, 'campaigns', $reportDate, $segment, $metrics);
  }

  /**
   * @see https://advertising.amazon.com/API/docs/v2/reference/reports#Ad-Group-reports
   * @param $reportDate
   * @param $segment
   * @param $metrics
   * @return mixed
   * @throws Exception
   */
  public function getAdGroups($startDate, $endDate = null) {
    $endDate = $endDate ?? $startDate;

    $startDate = new DateTime($startDate, new DateTimeZone('America/Los_Angeles'));
    if(!$endDate){
      $endDate = $startDate->modify( '-1 day' )->format('Y-m-d');
    } else {
      $endDate = new DateTime($endDate, new DateTimeZone('America/Los_Angeles'));
      $endDate = $endDate->format('Y-m-d');
    }
    $startDate = $startDate->format('Y-m-d');

    $configuration = [
      "adProduct" => "SPONSORED_PRODUCTS",
      "columns" => [
        "impressions",
        "clicks",
        "cost",
        "purchases1d",
        "purchases7d",
        "purchases14d",
        "purchases30d",
        "purchasesSameSku1d",
        "purchasesSameSku7d",
        "purchasesSameSku14d",
        "purchasesSameSku30d",
        "unitsSoldClicks1d",
        "unitsSoldClicks7d",
        "unitsSoldClicks14d",
        "unitsSoldClicks30d",
        "sales1d",
        "sales7d",
        "sales14d",
        "sales30d",
        "attributedSalesSameSku1d",
        "attributedSalesSameSku7d",
        "attributedSalesSameSku14d",
        "attributedSalesSameSku30d",
        "unitsSoldSameSku1d",
        "unitsSoldSameSku7d",
        "unitsSoldSameSku14d",
        "unitsSoldSameSku30d",
        "kindleEditionNormalizedPagesRead14d",
        "kindleEditionNormalizedPagesRoyalties14d",
        "date",
        "campaignBiddingStrategy",
        "costPerClick",
        "clickThroughRate",
        "spend",
        "campaignName",
        "campaignId",
        "campaignStatus",
        "campaignBudgetType",
        "campaignBudgetAmount",
        "campaignRuleBasedBudgetAmount",
        "campaignApplicableBudgetRuleId",
        "campaignApplicableBudgetRuleName",
        "campaignBudgetCurrencyCode",
        "adGroupName",
        "adGroupId",
        "adStatus",
      ],
      "reportTypeId" => "spCampaigns",
      "format" => "GZIP_JSON",
      "groupBy" => [
        "campaign",
        "adGroup"
      ],
      "timeUnit" => "DAILY"
    ];

    return $this->retrieve('SponsoredProductsCampaignsWithAdGroupDailyReport', $startDate, $endDate, $configuration);
  }

  /**
   * @see https://advertising.amazon.com/API/docs/v2/reference/reports#Ad-Group-reports
   * @param $reportDate
   * @param $segment
   * @param $metrics
   * @return mixed
   * @throws Exception
   */
  public function getAdGroupsHSA($reportDate, $segment = null, $metrics = []) {
    return $this->retrieve(self::BASE_HSA, 'adGroups', $reportDate, $segment, $metrics);
  }

  /**
   * @see https://advertising.amazon.com/API/docs/v2/reference/reports#Keyword-reports
   * @param $reportDate
   * @param $segment
   * @param $metrics
   * @return mixed
   * @throws Exception
   */
  public function getKeywords($reportDate, $segment = null, $metrics = []) {
    return $this->retrieve(self::BASE_URL, 'keywords', $reportDate, $segment, $metrics);
  }

  /**
   * @see https://advertising.amazon.com/API/docs/v2/reference/reports#Keyword-reports
   * @param $reportDate
   * @param $segment
   * @param $metrics
   * @return mixed
   * @throws Exception
   */
  public function getKeywordsHSA($reportDate, $segment = null, $metrics = []) {
    return $this->retrieve(self::BASE_HSA, 'keywords', $reportDate, $segment, $metrics);
  }

  /**
   * @see https://advertising.amazon.com/API/docs/v2/reference/reports#Product-Ads-reports
   * @param $reportDate
   * @param $segment
   * @param $metrics
   * @return mixed
   * @throws Exception
   */
  public function getProductAds($reportDate, $segment = null, $metrics = []) {
    return $this->retrieve(self::BASE_URL, 'productAds', $reportDate, $segment, $metrics);
  }

  /**
   * @see https://advertising.amazon.com/API/docs/v2/reference/reports#Product-Targeting-Reports
   * @param $reportDate
   * @param $segment
   * @param $metrics
   * @return mixed
   * @throws Exception
   */
  public function getProductTargeting($reportDate, $segment = null, $metrics = []) {
    return $this->retrieve(self::BASE_URL, 'targets', $reportDate, $segment, $metrics);
  }
}
