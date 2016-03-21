<?php
/**
 * @project   Nested Set Plus
 * @author    Kirill Gladkiy <kirill.gladkiy@gmail.com>
 * @link      https://github.com/kgladkiy/yii2-nested-set-plus
 * @date      21.01.2015
 * @version   0.2
 */

namespace kgladkiy\behaviors;

use yii\base\Behavior;
use yii\helpers\ArrayHelper;

class NestedSetQueryBehavior extends Behavior
{

    /**
     * @var ActiveQuery the owner of this behavior.
     */
    public $owner;

    /**
     * Gets root node(s).
     * @return ActiveRecord the owner.
     */
    public function roots()
    {
        /** @var $modelClass ActiveRecord */
        $modelClass = $this->owner->modelClass;
        $model = new $modelClass;
        $this->owner->andWhere($modelClass::getDb()->quoteColumnName($model->leftAttribute) . '=1');
        unset($model);
        return $this->owner;
    }

    /**
     * Returns a tree data as array
     *
     * @param bool|ActiveRecord|NestedSetQuery $root Parent item for a tree data (false, if from root item)
     * @param bool|integer $maxLevel Max level for a tree data (false for no limit)
     * @param string $keyAttribute Attribute of model for array key
     * @return array
     */
    public function tree($root = false, $maxLevel = false, $keyAttribute = 'id')
    {

        $tree = [];

        if ($root === false) {
            $ownerClass = $this->owner->modelClass;
            $items = $ownerClass::find()->roots()->all();
        } else {
            if (!$maxLevel || $root->level <= $maxLevel) {
                $items = $root->children()->all();
            } else {
                return $tree;
            }
        }

        foreach ($items as $item) {
            $tree[$item->$keyAttribute] = [
                'id' => $item->id,
                'name' => $item->{$item->titleAttribute},
                'children' => (!$maxLevel || $item->level < $maxLevel) ? $this->tree($item, $maxLevel, $keyAttribute) : null,
            ];
        }

        return $tree;

    }

    public function options($root = false, $maxLevel = false)
    {

        $tree = $this->tree($root, $maxLevel);

        $map = function($items, $parentName) use (&$map) {
            $results = [];
            foreach ($items as $item) {
                $results[$item['id']] = ($parentName) ? $parentName . ' -> ' . $item['name'] : $item['name'];
                if ($item['children']) {
                    $results += $map($item['children'], $results[$item['id']]);
                }
            }
            return $results;
        };

        return $map($tree, false);

    }

}
