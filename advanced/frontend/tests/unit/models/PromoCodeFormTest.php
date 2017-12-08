<?php
namespace frontend\tests\unit\models;

use Yii;
use frontend\models\PromoCode;
use frontend\models\PromoZone;

class PromoCodeFormTest extends \Codeception\Test\Unit
{
    /**
     * @var \frontend\tests\UnitTester
     */
    protected $tester;

    protected function _before()
    {
        $promoCodeModel = new PromoCode();
        $promoCodeModel->scenario = 'create';

        
        $promoCodeModel->title = '1234asdA';
        $promoCodeModel->start_date = '2011-11-11';
        $promoCodeModel->end_date = '2011-11-15';
        $promoCodeModel->reward = '12345.17';
        
        $promoCodeModel->save();
    }

    protected function _after()
    {
    }

    // tests
    public function testCreationPromoCodeModel()
    {
        $this->_before();
        
        $count = PromoCode::find()->where(['title' => '1234asdA'])->count();
        $this->assertEquals(1, $count);
        
        $promoCodeModel = PromoCode::findOne(['title' => '1234asdA']);
        $this->assertEquals('1234asdA', $promoCodeModel->title);
        $this->assertEquals('2011-11-11', $promoCodeModel->start_date);
        $this->assertEquals('2011-11-15', $promoCodeModel->end_date);
        $this->assertEquals('12345.17', $promoCodeModel->reward);
        $this->assertEquals(1, $promoCodeModel->status);
        
    }


    /**
     * @depends testCreationPromoCodeModel
     */
    public function testCreationPromoZoneModel()
    {
        
        $promoCodeModel = PromoCode::findOne(['title' => '1234asdA']);
        
        for ($i = 2; $i <= 4; $i++) {
            $promoZoneModel = new PromoZone();
            $promoZoneModel->city_id = $i;
            $promoZoneModel->promo_id = $promoCodeModel->id;
            $this->assertTrue($promoZoneModel->save());
        }

        $count = PromoZone::find()->where(['promo_id' => $promoCodeModel->id])->count();
        $this->assertEquals(3, $count);

    }

    /**
     * @depends testCreationPromoCodeModel
     */
    public function testUpdatePromoCodeModel()
    {
        $promoCodeModel = PromoCode::findOne(['title' => '1234asdA']);
        $promoCodeModel->scenario = 'update';

        $this->assertEquals(1, $promoCodeModel->status);
        $promoCodeModel->title = 'asd123';
        $promoCodeModel->start_date = '2012-12-11';
        $promoCodeModel->end_date = '2012-12-15';
        $promoCodeModel->reward = '22345.17';
        $promoCodeModel->status = false;
        
        $this->assertTrue($promoCodeModel->save());
        
        $count = PromoCode::find()->where(['title' => 'asd123'])->count();
        $this->assertEquals(1, $count);
        
        $promoCodeModel = PromoCode::findOne(['title' => 'asd123']);
        $this->assertEquals('asd123', $promoCodeModel->title);
        $this->assertEquals('2012-12-11', $promoCodeModel->start_date);
        $this->assertEquals('2012-12-15', $promoCodeModel->end_date);
        $this->assertEquals('22345.17', $promoCodeModel->reward);
        $this->assertEquals(0, $promoCodeModel->status);

    }

    public function testValidationPromoCodeModel()
    {
        $model = new PromoCode();
        $model->scenario = 'create';

        /**
         * Validating title
         */
        $model->title = null;
        $this->assertFalse($model->validate(['title']));

        $model->title = 0;
        $this->assertTrue($model->validate(['title']));

        $model->title = 'ываыва';
        $this->assertFalse($model->validate(['title']));

        $model->title = '/*-++()';
        $this->assertFalse($model->validate(['title']));

        $model->title = '123123123asdsadASDASD';
        $this->assertTrue($model->validate(['title']));

        /**
         * Validating dates
         */
        $model->start_date = null;
        $this->assertFalse($model->validate(['start_date']));

        $model->start_date = '';
        $this->assertFalse($model->validate(['start_date']));

        $model->start_date = '0';
        $this->assertFalse($model->validate(['start_date']));

        $model->start_date = 'ываыва';
        $this->assertFalse($model->validate(['start_date']));

        $model->start_date = '/*-++()';
        $this->assertFalse($model->validate(['start_date']));

        $model->start_date = '123123123asdsadASDASD';
        $this->assertFalse($model->validate(['start_date']));

        $model->start_date = '2011-30-11';
        $this->assertFalse($model->validate(['start_date']));

        $model->start_date = '2011-11-30';
        $model->end_date = '2011-12-30';
        $this->assertTrue($model->validate(['start_date']));

        $model->start_date = '2011-11-30';
        $model->end_date = '2011-11-30';
        $this->assertFalse($model->validate(['start_date']));

        $model->start_date = '2011-12-30';
        $model->end_date = '2011-11-30';
        $this->assertFalse($model->validate(['start_date']));

        $model->start_date = '2011-10-30';
        $model->end_date = '2011-11-30';
        $this->assertTrue($model->validate(['start_date']));


        /**
         * Validating reward
         */
        $model->reward = null;
        $this->assertFalse($model->validate(['reward']));

        $model->reward = 0;
        $this->assertFalse($model->validate(['reward']));

        $model->reward = 'ываыва';
        $this->assertFalse($model->validate(['reward']));

        $model->reward = '/*-++()';
        $this->assertFalse($model->validate(['reward']));

        $model->reward = '123123123asdsadASDASD';
        $this->assertFalse($model->validate(['reward']));

        $model->reward = -10000.00;
        $this->assertFalse($model->validate(['reward']));

        $model->reward = 10020.02;
        $this->assertTrue($model->validate(['reward']));

        /**
         * Validating status
         */
        $model->status = null;
        $this->assertTrue($model->validate(['status']));

        $model->status = '';
        $this->assertTrue($model->validate(['status']));

        $model->status = 0;
        $this->assertTrue($model->validate(['status']));

        $model->status = false;
        $this->assertTrue($model->validate(['status']));

        $model->status = true;
        $this->assertTrue($model->validate(['status']));

        $model->status = 1;
        $this->assertTrue($model->validate(['status']));

        $model->status = '1';
        $this->assertTrue($model->validate(['status']));

        $model->status = 'ываыва';
        $this->assertFalse($model->validate(['status']));

        $model->status = -10000.00;
        $this->assertFalse($model->validate(['status']));

        $model->status = 10020.02;
        $this->assertFalse($model->validate(['status']));
    }

    public function testValidationPromoZoneModel()
    {
        $model = new PromoZone();

        /**
         * Validating city_id
         */
        $model->city_id = null;
        $this->assertFalse($model->validate(['city_id']));

        $model->city_id = 0;
        $this->assertFalse($model->validate(['city_id']));

        $model->city_id = '';
        $this->assertFalse($model->validate(['city_id']));

        $model->city_id = 'ываыва';
        $this->assertFalse($model->validate(['city_id']));

        $model->city_id = '/*-++()';
        $this->assertFalse($model->validate(['city_id']));

        $model->city_id = '123123123asdsadASDASD';
        $this->assertFalse($model->validate(['city_id']));

        $model->city_id = 3;
        $this->assertTrue($model->validate(['city_id']));

        $model->city_id = 93;
        $this->assertFalse($model->validate(['city_id']));

        /**
         * Validating promo_id
         */
        $model->promo_id = null;
        $this->assertFalse($model->validate(['promo_id']));

        $model->promo_id = 0;
        $this->assertFalse($model->validate(['promo_id']));

        $model->promo_id = '';
        $this->assertFalse($model->validate(['promo_id']));

        $model->promo_id = 'ываыва';
        $this->assertFalse($model->validate(['promo_id']));

        $model->promo_id = '/*-++()';
        $this->assertFalse($model->validate(['promo_id']));

        $model->promo_id = '123123123asdsadASDASD';
        $this->assertFalse($model->validate(['promo_id']));

        $promoModel = PromoCode::findOne(['title' => '1234asdA']);
        $model->promo_id = $promoModel->id;
        $this->assertTrue($model->validate(['promo_id']));

        $model->promo_id = 93;
        $this->assertFalse($model->validate(['promo_id']));
    }

    /**
     * @depends testCreationPromoCodeModel
     */
    public function testRemovingPromoCodeModel()
    {
        $model = PromoCode::findOne(['title' => '1234asdA']);
        $model_id = $model->id;
        $this->assertEquals(1, $model->delete());

        $count = PromoCode::find()->where(['id' => $model_id])->count();
        $this->assertEquals(0, $count);

        $count = PromoZone::find()->where(['promo_id' => $model_id])->count();
        $this->assertEquals(0, $count);

    }


}