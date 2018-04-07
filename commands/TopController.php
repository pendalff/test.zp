<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\log\Logger;
use app\models\top\Rubrics;
use app\models\top\Words;

/**
 * Report TOP rubrics and title words in today vacancies
 */
class TopController extends Controller
{
	/**
	 * @var Rubrics $rubrics
	 */
	protected $rubrics;
	/**
	 * @var Words $words
	 */
	protected $words;

	public function init()
	{
		$this->rubrics = new Rubrics();
		$this->words = new Words([
			'excludedWords' => Yii::$app->params['excludedWords'],
		]);
	}

	public function actionIndex()
	{
		while ($vacansies = Yii::$app->zpClient->getData()) {
			foreach ( $vacansies as $vacancy ) {
				$this->words->count(
					$this->words->prepareWords($vacancy['header'])
				);
				$this->rubrics->count($vacancy['rubrics']);
			}
		}

		try
		{
			$res = [];
			$res['words'] = $this->words->save();
			$res['rubrics'] = $this->rubrics->save();
			Yii::$app->log->getLogger()->log($res, Logger::LEVEL_INFO);

			return ExitCode::OK;
		} catch (\Exception $e) {
			Yii::$app->log->getLogger()->log($e->getMessage(), Logger::LEVEL_ERROR);

			return ExitCode::UNSPECIFIED_ERROR;
		}
	}
}