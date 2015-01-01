<?php
namespace enigmatix\widgets;
use kartik\select2\Select2Asset;
use yii\helpers\Html;
use yii\helpers\Json;
use enigmatix\helpers\Parameters;

/**
 * Class Select2
 * @package enigmatix\widgets
 * @author Joel Small
 * @email joel.small@biscon.com.au
 *
 * This class creates a widget that creates a list of tags in the form of a tag cloud.
 */

class Select2 extends \yii\bootstrap\Widget
{
    public $model;
    public $attribute;
    public $tags = [];
    public $name;
    public $pluginOptions;
    public $url;
    public $urlById;
    public $value;
    public $placeholder = "Search";
    public $allowNew = false;
    public $escapeMarkup = 'function (m) { return m; }';
    public $dropdownClass = 'bigdrop';
    public $createSearchChoice = 'function (term){return {id: term, text: term};}';
    public $default;

    protected function getOptions()
    {
        return Parameters::jsonify([
            'placeholder' => $this->placeholder,
            'ajax'  => $this->getAjaxParams(),
            'initSelection' => $this->getInitSelection(),
            'dropdownCssClass' => $this->dropdownClass,
            'escapeMarkup' => $this->escapeMarkup,
            'createSearchChoice' => $this->createSearchChoice,
        ]);
    }

    protected function getAjaxParams()
    {
        return [
            'url' => $this->url,
            'dataType' => 'json',
            'data' => "function (term, page) {return {q: term,};}",
            'results' => ' function (data, page) {return {results: data.results};}',
        ];
    }

    protected function getInitSelection()
    {
        return 'function(element, callback) {
            var id=$(element).val();
            if(id!==""){
                $.ajax("'.$this->urlById.'?id="+id, {dataType: "json"}).done(function(data) { callback(data.results[0]); });}
                }';
    }

    protected function getAppendedItems()
    {
        if(!$this->allowNew) return;
        return <<< SCRIPT
.on("change", function(e)
        {
            $.ajax("$this->allowNew?tag="+e.val,{dataType: "json"}).done(function(data){
                $("#$this->id").val(data.results['id']);
            });
        }
        );
SCRIPT;
    }
    public function run()
    {
        $view = $this->getView();
        $fieldName = $this->attribute;
        $value = $this->model->$fieldName;
        if($value == '')
        {
            $value = $this->default;
        }
        Select2Asset::register($view);
        if($this->model)
        {
            echo Html::activeInput('input', $this->model, $this->attribute,['id' => $this->id,'class' =>'form-control','value' => $value]);
        }else{
            echo Html::input('input', $this->attribute,$value,['id' => $this->id,'class' =>'form-control']);
        }
        $script = "$(\"#$this->id\").select2(".$this->getOptions().")".$this->getAppendedItems().";";
        $view = $this->getView();
        $view->registerJs($script);
    }
}
