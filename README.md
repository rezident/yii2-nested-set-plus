Nested Set behavior and Nested Draggable List widget for Yii 2
=============================

This extension is a fork of [wbraganca/yii2-nested-set-behavior](https://github.com/wbraganca/yii2-nested-set-behavior).

It is developed for use in our internal project, but you can use and/or modify it on your own.

Just like [Nested Set behavior by wbraganca](https://github.com/wbraganca/yii2-nested-set-behavior), this extension 
allows you to get functional for nested set trees and also includes a widget for show Drag & drop hierarchical list 
with mouse and touch compatibility based on [dbushell/Nestable](https://github.com/dbushell/Nestable) jQuery plugin.

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```sh
php composer.phar require rezident/yii2-nested-set-plus "*"
```

or add

```json
"rezident/yii2-nested-set-plus": "*"
```

to the require section of your `composer.json` file.

Configuring
--------------------------

First you need to configure model as follows:

```php
use kgladkiy\behaviors\NestedSetBehavior;
use kgladkiy\behaviors\NestedSetQuery; 

class Category extends ActiveRecord
{
    public function behaviors()
    {
        return [
            [
                'class' => NestedSetBehavior::className(),
                // 'rootAttribute' => 'root',
                // 'levelAttribute' => 'level',
                // 'hasManyRoots' => true
            ],
        ];
    }

    public static function find()
    {
        return new NestedSetQuery(get_called_class());
    }
}
```

There is no need to validate fields specified in `leftAttribute`,
`rightAttribute`, `rootAttribute` and `levelAttribute` options. Moreover,
there could be problems if there are validation rules for these. Please
check if there are no rules for fields mentioned in model's rules() method.

In case of storing a single tree per database, DB structure can be built with
`schema/schema.sql`. If you're going to store multiple trees you'll need
`schema/schema-many-roots.sql`.

By default `leftAttribute`, `rightAttribute` and `levelAttribute` values are
matching field names in default DB schemas so you can skip configuring these.

There are two ways this behavior can work: one tree per table and multiple trees
per table. The mode is selected based on the value of `hasManyRoots` option that
is `false` by default meaning single tree mode. In multiple trees mode you can
set `rootAttribute` option to match existing field in the table storing the tree.

Work with Nested Set behavior
-----------------------------

Please read the [original plugin documentation](https://github.com/wbraganca/yii2-nested-set-behavior#selecting-from-a-tree) 
for get an information about work with the nested data.

Note that method for fetch and prepare data for use with Fancytree was removed from `NestedSetQueryBehavior` class.

Instead of was added method `NestedSetQueryBehavior::tree()` that returns tree data for Nested Draggable List widget.

Using Nested Draggable List widget
----------------------------------

```php
use kgladkiy\widgets\NestedList;

echo NestedList::widget([
    'items' => $treeData, // $treeData = Category::find()->tree();
    'actions' => true, // set to false for disable 'edit' and 'delete' buttons
]);
```

