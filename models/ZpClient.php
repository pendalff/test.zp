<?php

namespace app\models;

use yii\base\Component;
use yii\httpclient\Client;

/**
 * Class ZpClient
 * @package app\models
 */
class ZpClient extends Component
{
	/**
	 * @var string $url - api url
	 */
	public $url;
	/**
	 * @var int $limit
	 */
	public $limit = 100;
	/**
	 * @var int $offset
	 */
	protected $offset = 0;
	/**
	 * @var int $count
	 */
	protected $count = 0;
	/**
	 * @var Client
	 */
	protected $client;

	/**
	 * {@inheritdoc}
	 */
	public function init()
	{
		$this->client = new Client([
			'baseUrl' => $this->url,
			'responseConfig' => [
				'format' => Client::FORMAT_JSON
			],
		]);

	}

	/**
	 * @return array of vacancies
	 */
	public function getData()
	{
		do {
			$response = $this->client->get('', ['limit' => $this->limit, 'offset' => $this->offset])->send();
			if ($response->isOk) {
				$this->count = $response->data['metadata']['resultset']['count'];
				$this->offset+=$this->limit;

				return $response->data['vacancies'];
			}
		} while ($this->count == 0 || $this->count > $this->offset);
	}
}