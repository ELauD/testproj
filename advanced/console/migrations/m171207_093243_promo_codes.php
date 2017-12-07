<?php

use yii\db\Migration;

/**
 * Class m171207_093243_promo_codes
 */
class m171207_093243_promo_codes extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        /**
         * Таблица с названиями городов
         */
        $this->createTable('city', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
        ], $tableOptions);

        /**
         * Заполнение таблицы городами
         */
        $this->insert('city', [
            'title' => 'Москва'
        ]);

        $this->insert('city', [
            'title' => 'Санкт-Петербург'
        ]);

        $this->insert('city', [
            'title' => 'Казань'
        ]);

        $this->insert('city', [
            'title' => 'Новосибирск'
        ]);

        $this->insert('city', [
            'title' => 'Волгоград'
        ]);

        /**
         * Таблица-связка промо кодов с городами
         */
        $this->createTable('promo_zone', [
            'id' => $this->primaryKey(),
            'promo_id' => $this->integer()->notNull(),
            'city_id' => $this->integer()->notNull(),
        ], $tableOptions);

        /**
         * Таблица c промо кодами
         */
        $this->createTable('promo_code', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull()->unique(),
            'start_date' => $this->date()->notNull(),
            'end_date' => $this->date()->notNull(),
            'reward' => $this->money()->notNull(),
            'zone_id' => $this->integer()->notNull(),
            'status' => $this->boolean()->notNull()->defaultValue(true),
        ], $tableOptions);

        //Создание индекса для столбца zone_id
        $this->createIndex(
            'idx-promo_code-zone_id',
            'promo_code',
            'zone_id'
        );

        //Добавление внещнего ключа для таблицы 'promo_zone'
        $this->addForeignKey(
            'fk-promo_code-zone_id',
            'promo_code',
            'zone_id',
            'promo_zone',
            'id',
            'CASCADE'
        );

        //Создание индекса для столбца city_id
        $this->createIndex(
            'idx-promo_zone-city_id',
            'promo_zone',
            'city_id'
        );

        //Добавление внещнего ключа для таблицы 'city'
        $this->addForeignKey(
            'fk-promo_zone-city_id',
            'promo_zone',
            'city_id',
            'city',
            'id',
            'CASCADE'
        );

    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        //Удаление внешнего ключа и индекса promo_zone-city_id
        $this->dropForeignKey(
            'fk-promo_zone-city_id',
            'promo_zone'
        );

        $this->dropIndex(
            'idx-promo_zone-city_id',
            'promo_zone'
        );
        
        //Удаление внешнего ключа и индекса promo_code-zone_id
        $this->dropForeignKey(
            'fk-promo_code-zone_id',
            'promo_code'
        );

        $this->dropIndex(
            'idx-promo_code-zone_id',
            'promo_code'
        );

       $this->dropTable('city');
       $this->dropTable('promo_zone');
       $this->dropTable('promo_code');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171207_081920_promo_codes_table cannot be reverted.\n";

        return false;
    }
    */
}
