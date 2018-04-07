<?php

namespace app\models\top;

/**
 * Класс Rubrics для обсчета ТОП рубрик
 *
 * @package app\models\top
 */
class Rubrics extends Base
{
	public function init()
	{
		parent::init();
		$this->tableName = '{{%topRubrics}}';
		$this->primaryKey = '[[rubric]]';
		$this->countKey = '[[count]]';
	}

	/**
	 * @param array $rubrics
	 */
	public function count(array $rubrics)
	{
		foreach ( $rubrics as $rubric ) {
			$this->increment($rubric['title']);
		}
	}
}