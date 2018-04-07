<?php

namespace app\models\top;

/**
 * Класс Words для обсчета ТОП рубрик
 *
 * @package app\models\top
 */
class Words extends Base
{
	/**
	 * @var array $excludedWords
	 */
	public $excludedWords = [];

	public function init()
	{
		parent::init();
		$this->tableName = '{{%topWords}}';
		$this->primaryKey = '[[word]]';
		$this->countKey = '[[count]]';
	}

	/**
	 * @param array $words
	 */
	public function count(array $words)
	{
		foreach ( $words as $word ) {
			$this->increment($word);
		}
	}

	/**
	 * Готовим слова из строки заголовка
	 *
	 * @param string $header
	 *
	 * @return array
	 */
	public function prepareWords($header)
	{
		$words = [];
		$header = preg_replace("/[^[:alnum:][:space:]\-\.]/u", "", $header);
		$header = str_replace("ё", "е", $header);
		$allWords = explode(" ", $header);
		foreach ($allWords as $word) {
			$word = mb_strtolower($word);
			if (in_array($word, $this->excludedWords)) {
				continue;
			}
			$words[] = $word;
		}

		return $words;
	}
}