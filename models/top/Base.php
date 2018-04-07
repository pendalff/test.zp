<?php

namespace app\models\top;

use yii\base\BaseObject;
use Yii;

/**
 * Class Base - abstraction for
 * @package app\models
 */
abstract class Base extends BaseObject implements IProcess
{
	/**
	 * @var string $tableName
	 */
	protected $tableName = '';
	/**
	 * @var string $primaryKey
	 */
	protected $primaryKey = '';
	/**
	 * @var string $countKey
	 */
	protected $countKey = '';
	/**
	 * @var array $data
	 */
	protected $data = [];

	/**
	 * @param array $items
	 *
	 * @return mixed
	 */
	abstract public function count( array $items );

	/**
	 * @return int
	 * @throws \Exception
	 */
	public function save()
	{
		if (!($count = count($this->data))) {
			return 0;
		}

		$db = Yii::$app->db;
		$transaction = $db->beginTransaction();
		$db->createCommand()->truncateTable($this->tableName)->execute();

		try {
			$sql = $db->queryBuilder->batchInsert($this->tableName, [$this->primaryKey, $this->countKey], $this->prepareData());
			//некоторые ситуаций, например с Е и Ё вызывают колизии ключа
			//$sql .= " ON DUPLICATE KEY UPDATE {$this->countKey} = {$this->countKey} + VALUES({$this->countKey})";
			$db->createCommand($sql)->execute();
			$transaction->commit();

			return $count;
		} catch(\Exception $e) {
			$transaction->rollBack();
			throw $e;
		}
	}

	/**
	 * @return array
	 */
	protected function prepareData()
	{
		return array_map(function($key, $val) {
			return [$key, $val];
		}, array_keys($this->data), array_values($this->data));
	}

	/**
	 * @param string $key
	 */
	protected function increment($key)
	{
		if (!isset($this->data[$key])) {
			$this->data[$key] = 0;
		}
		$this->data[$key]++;
	}
}