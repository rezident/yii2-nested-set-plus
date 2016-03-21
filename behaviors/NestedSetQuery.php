<?php
/**
 * @project   Nested Set Plus
 * @author    Kirill Gladkiy <kirill.gladkiy@gmail.com>
 * @link      https://github.com/kgladkiy/yii2-nested-set-plus
 * @date      21.01.2015
 * @version   0.2
 */

namespace rezident\nestedsetplus\behaviors;

class NestedSetQuery extends \yii\db\ActiveQuery
{
    public function behaviors()
    {
        return [
            [
                'class' => NestedSetQueryBehavior::className(),
            ]
        ];
    }
}
