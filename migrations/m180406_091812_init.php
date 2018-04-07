<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m180406_091812_init
 *
 * Инициализация структуры БД
 */
class m180406_091812_init extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
	    $this->createTable('{{%topRubrics}}', [
		    'rubric' => Schema::TYPE_STRING . '(255) NOT NULL',
		    'count' => Schema::TYPE_INTEGER,
	    ]);
	    $this->addPrimaryKey('rubric','{{%topRubrics}}', ['rubric']);

	    $this->createTable('{{%topWords}}', [
		    'word' => Schema::TYPE_STRING . '(255) NOT NULL',
		    'count' => Schema::TYPE_INTEGER,
	    ]);
	    $this->addPrimaryKey('word','{{%topWords}}', ['word']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
	    $this->dropTable('{{%topRubrics}}');
	    $this->dropTable('{{%topWords}}');
    }
}