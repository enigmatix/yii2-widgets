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
        $view   = $this->getView();
        $script = "$('#{$this->id}').datepicker({$this->getOptions()}){$this->getAppendedItems()};";
        $view->registerJs($script);
        DatepickerAsset::register($view);
        $this->outputField();

    }

    protected function outputField(){
        echo "<div class='input-group date' id='{$this->id}'>";
        echo "<span class=\"input-group-addon\">
                        <span class=\"glyphicon glyphicon-calendar\"></span>
                    </span>";
        echo Html::activeTextInput($this->model, $this->attribute,
            [
                'id'        => $this->options['id'],
                'class'     =>'form-control',
                'value'     => $this->retrieveValue(),
                'readonly'  => 'true'
            ]);
        echo "</div>";
    }

    protected function getAppendedItems()
    {
        return '';
    }

    public function getFieldName(){
        return Html::getAttributeName($this->attribute);
    }

    public function retrieveValue(){

        $fieldName  = $this->getFieldName();

        if($this->value != null){
            return $this->value;
        }

        $value      = $this->model->$fieldName;

        return $value;
    }
}
