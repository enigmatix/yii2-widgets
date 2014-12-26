<?php
namespace frontend\widgets;
use kartik\widgets\Select2Asset;
use yii\helpers\Html;

/**
 * Class Tags
 * @package frontend\widgets
 * @author Joel Small
 * @email joel.small@biscon.com.au
 *
 * This class creates a widget that creates a list of tags in the form of a tag cloud.
 */

class ListGroup extends \yii\bootstrap\Widget
{
    public $model;
    public $attribute;
    public $title;
    public $name;
    public $pluginOptions;
    public $items = [];
    public $defaultClass = 'list-group-item list-group-item-text list-group-item-info bottom-buffer';
    public $titleClass = 'panel-primary';

    private $content = '';


    public function run()
    {
        $this->content = $this->buildItems($this->items);
        $this->content = $this->buildContent();
        echo $this->content;
    }

    private function buildContent()
    {
        return $this->htmlWrap();
    }

    private function htmlWrap()
    {
        return Html::tag('div',$this->panelBody(),['class' => 'row']);
    }

    private function panelBody()
    {
        return Html::tag('div', $this->listGroup(), ['class' => 'panel-body']);
    }

    private function listGroup()
    {
        return Html::tag('div', $this->content,['class' => 'list-group']);
    }

    private function buildItems($items)
    {
        $content = '';
        foreach ($items as $value)
        {
            $content .= $this->buildItem($value);
        }
        return $content;
    }

    private function buildItem($value)
    {
        $key = '';
        $titleSuffix = '';
        $class = $this->defaultClass;
        if(array_key_exists('class', $value) && $value['class'] != '')
        {
            $class .= " " .$value['class'];
        }
        $value['class'] = $class;
        if(array_key_exists('small', $value))
        {
            $titleSuffix = Html::tag('small',Html::encode($value['small']),['class' => 'pull-right']);
            unset($value['small']);
        }
        if(array_key_exists('title', $value))
        {
            $key .= Html::tag('p',"From: ".Html::encode($value['title']).$titleSuffix).Html::tag("hr");
            unset($value['title']);
        }
        if(array_key_exists('content', $value))
        {
            $key .= $value['content'];
            unset($value['content']);
        }
        return Html::tag('div', $key, $value);
    }
}
