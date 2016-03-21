<?php
/**
 * @project   Nested Set Plus
 * @author    Kirill Gladkiy <kirill.gladkiy@gmail.com>
 * @link      https://github.com/kgladkiy/yii2-nested-set-plus
 * @date      21.01.2015
 * @version   0.2
 */

namespace rezident\nestedsetplus\widgets;

/**
 * Asset bundle for Nestable Widget
 */
class NestedListAsset extends \yii\web\AssetBundle
{

    public function init()
    {
        $this->sourcePath = __DIR__ . '/../assets';
        $this->css = ['css/nestable.css'];
        $this->js = ['js/jquery.nestable.js'];
        $this->depends = ['yii\web\JqueryAsset'];
        parent::init();
    }

}