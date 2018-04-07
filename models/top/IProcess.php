<?php

namespace app\models\top;

/**
 * Интерфейс IProcess для моделей, обсчитывающих рейтинг
 *
 * @package app\models\top
 */
interface IProcess
{
	public function count(array $items);
	public function save();
}