<?php
namespace enigmatix\widgets;
use enigmatix\widgets\Select2Asset;
use yii\helpers\Html;

/**
 * Class Tags
 * @package frontend\widgets
 * @author Joel Small
 * @email joel.small@biscon.com.au
 *
 * This class creates a widget that creates a list of tags in the form of a tag cloud.
 */

class Tags extends \yii\widgets\InputWidget
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
        if($this->value === ''){
            $this->value = [];
        }

        if(!is_array($this->value))
        {
            $this->value[$this->value] = $this->value;
        }
        $tags = json_encode($this->tags);
        echo Html::dropDownList($this->name, $this->value, $this->tags, ['class' =>'form-control','multiple' => true,'id' => $this->options['id']]);

        $script =   <<< SCRIPT
        $("#{$this->options['id']}").select2({
            placeholder: "$this->placeholder",
            tags: $tags,

        })

SCRIPT;

        if($this->onChange){$script .= '.on("change", function(e){ $.ajax("'.$this->onChange.'&" + $("#'.$this->options['id'].'").serialize());})';}
        if($this->disabled){$script .= '.prop("disabled", true)';}
        $script .= ';';
        $view = $this->getView();
        $view->registerJs($script);

    }
}
