<?php
namespace enigmatix\widgets;
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

class Panel extends \yii\bootstrap\Widget
{
    public $model;
    public $attribute;
    public $title;
    public $name;
    public $pluginOptions;
    public $links = [];
    public $defaultClass = 'list-group-item ';
    public $titleClass = 'panel-primary';
    public $panelClass = 'col-lg-4';


    public function run()
    {
        $content = $this->buildLinks($this->links);
        $content = $this->htmlWrap($content);
        echo $content;
    }

    private function htmlWrap($content)
    {
        return '
        <div class="'.$this->panelClass.'">
            <div class="panel '.$this->titleClass.'">
                <div class="panel-heading">
                    <h3 class="panel-title">'.$this->title.'</h3>
                </div>
                <div class="panel-body">
                    <div class="list-group">' . $content .'
                    </div>
                </div>
            </div>
        </div>
        ';
    }

    private function buildLinks($links)
    {
        $content = '';
        foreach ($this->links as $key => $value)
        {
            if(!array_key_exists('class', $value))
            {
                $value['class'] = $this->defaultClass;
            }
            if(array_key_exists('title', $value))
            {
                $key = $value['title'];
            }

            if(array_key_exists('content', $value))
            {
                $key = "<h4 class='list-group-item-heading'>$key</h4>
                <p class='list-group-item-text'>".$value['content']."</p>";
                unset($value['content']);
            }
            $content .= Html::tag('a', $key, $value);
        }
        return $content;
    }
}
