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

class Tags extends \yii\bootstrap\Widget
{
    public $model;
    public $attribute;
    public $tags = [];
    public $name;
    public $pluginOptions;
    public $url;
    public $urlById;
    public $value = [];
    public $placeholder;
    public $onChange;
    public $disabled = false;

    public function run()
    {
        $view = $this->getView();
        Select2Asset::register($view);

        if(is_array($this->value))
        {
            $this->value = implode(',', $this->value);
        }
        $tags = json_encode($this->tags);
        echo Html::input('input', $this->name, $this->value, ['id' => $this->id,'class' =>'form-control']);
        $script =   <<< SCRIPT
        $("#$this->id").select2({
            placeholder: "$this->placeholder",
            tags: $tags,

        })

SCRIPT;

        if($this->onChange){$script .= '.on("change", function(e){ $.ajax("'.$this->onChange.'&'.$this->name.'=" + e.val);})';}
        if($this->disabled){$script .= '.prop("disabled", true)';}
        $script .= ';';
        $view = $this->getView();
        $view->registerJs($script);

    }
}
