<?php
namespace enigmatix\widgets;
use yii\helpers\Html;
use yii\helpers\Json;
/**
 * Class Select2
 * @package enigmatix\widgets
 * @author Joel Small
 * @email joel.small@biscon.com.au
 *
 * This class creates a widget that creates a list of tags in the form of a tag cloud.
 *
 */

class DatePicker extends \yii\widgets\InputWidget
{
    public $model;
    public $attribute;
    public $tags = [];
    public $name;
    public $url;
    public $urlById;
//    public $value;
    public $label;
    public $placeholder = "Search";
    public $allowNew = false;
    public $escapeMarkup = 'function (m) { return m; }';
    public $dropdownClass = 'bigdrop';
    public $createSearchChoice = 'function (term){return {id: term, text: term};}';
    public $default = '';
    public $valuePrefix = '';
    public $pluginOptions = [
            'format' => 'yyyy-mm-dd',
            'startView' => 'decade',
        ];

    protected function getOptions()
    {
        return Json::encode(
            $this->pluginOptions
        );
    }

    public function run()
    {
        $view       = $this->getView();
        $fieldName  = $this->getFieldName();
        $value      = $this->retrieveValue($fieldName);

        DatepickerAsset::register($view);
        echo "<div class='input-group date' id='{$this->id}'>";
        echo "<span class=\"input-group-addon\">
                        <span class=\"glyphicon glyphicon-calendar\"></span>
                    </span>";
        echo Html::activeTextInput($this->model, $this->attribute,['id' => $this->options['id'],'class' =>'form-control','value' => $value,'readonly' => 'true']);
        echo "</div>";
        $script = "$(\"#{$this->id}\").datepicker({$this->getOptions()}){$this->getAppendedItems()};";

        $view->registerJs($script);
    }

    protected function getAppendedItems()
    {
        return '';
    }

    public function getFieldName(){
        return $this->attribute;
    }

    public function retrieveValue($fieldName){
        if($this->value != null){
            return $this->value;
        }
        $value = $this->model->$fieldName;
        if($value == '')
        {
            $value = $this->default;
        }
        return $value;
    }
}
