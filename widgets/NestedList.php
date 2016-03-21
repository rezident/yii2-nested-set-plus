<?php
/**
 * @project   Nested Set Plus
 * @author    Kirill Gladkiy <kirill.gladkiy@gmail.com>
 * @link      https://github.com/kgladkiy/yii2-nested-set-plus
 * @date      21.01.2015
 * @version   0.2
 */

namespace rezident\nestedsetplus\widgets;

use yii\base\Widget;
use yii\helpers\Html;


class NestedList extends Widget
{

    public $items = null;

    public $maxDepth = 4;

    public $wrapClass = 'nested';

    public $actions = true;

    public function run()
    {
        $this->registerAssets();
        $this->renderInput();
    }

    protected function renderInput()
    {
        if ( count($this->items) > 0 ) {
            echo Html::tag('div', $this->buildList($this->items), ['class'=>$this->wrapClass]);
        }
    }

    protected function buildList($items)
    {
        if ( count($items) == 0 ) {
            return '';
        }
        $html = Html::beginTag('ul', ['class' => $this->wrapClass . '-list']);
        foreach ($items as $id => $item) {
            $html .= Html::tag('li', $this->buildListItem($item),['class' => $this->wrapClass . '-item', 'data-id' => $id]);
        }
        $html .= Html::endTag('ul');
        return $html;
    }

    protected function buildListItem($item)
    {
        $html = '';
        $html .= Html::tag('div', $item['name'], ['class' => $this->wrapClass . '-handle']);
        if ($this->actions) {
            $html .= $this->buildActionButtons($item['id']);
        }
        if (count($item['children'])>0) {
            $html .= $this->buildList($item['children']);
        }
        return $html;
    }

    protected function buildActionButtons($id)
    {
        $html = Html::beginTag('div', ['class'=>'nested-actions']);
        $html .= Html::a(Html::tag('span', '', ['class'=>'glyphicon glyphicon-pencil text-primary']), [$this->view->context->id . '/update', 'id' => $id], ['class' => 'btn btn-default btn-xs']);
        $html .= Html::a(Html::tag('span', '', ['class'=>'glyphicon glyphicon-remove text-danger']), [$this->view->context->id . '/delete', 'id' => $id], ['class' => 'btn btn-default btn-xs']);
        $html .= Html::endTag('div');
        return $html;
    }

    /**
     * Registers the needed assets
     */
    public function registerAssets()
    {

        $view = $this->getView();

        NestedListAsset::register($view);
        $js = "$('." . $this->wrapClass . "').nestable({'maxDepth':" . $this->maxDepth . "});";
        $view->registerJs($js);

    }

}