<?php
namespace enigmatix\widgets;
use yii\helpers\Html;
use yii\helpers\Json;
use enigmatix\helpers\Parameters;
use yii\web\AssetBundle;
use enigmatix\widgets\Select2Asset;
/**
 * Class Select2
 * @package enigmatix\widgets
 * @author Joel Small
 * @email joel.small@biscon.com.au
 *
 * This class creates a widget that creates a list of tags in the form of a tag cloud.
 */

class Select2 extends \yii\widgets\InputWidget
{
    public $model;
    public $attribute;
    public $tags = [];
    public $name;
    public $pluginOptions;
    public $url;
    public $urlById;
//    public $value;
    public $label;
    public $placeholder = "Search";
    public $allowNew = false;
    public $escapeMarkup = 'function (m) { return m; }';
    public $dropdownClass = 'bigdrop';
    public $createSearchChoice = 'function (term){return {id: term, text: term};}';
    public $default;
    public $valuePrefix = '';

    protected function getOptions()
    {
        return Parameters::jsonify([
            'placeholder' => $this->placeholder,
            'ajax'  => $this->getAjaxParams(),
//            'initSelection' => $this->getInitSelection(),
//            'dropdownCssClass' => $this->dropdownClass,
            'escapeMarkup' => $this->escapeMarkup,
            'createSearchChoice' => $this->createSearchChoice,
            'dropdownAutoWidth' => 'true'
        ]);
    }

    protected function getAjaxParams()
    {
        return [
            'url' => $this->url,
            'dataType' => 'json',
            'data' => "function (term, page) {return {q: term,};}",
            'results' => $this->getResultQuery(),
        ];
    }

    protected function getResultQuery(){
        if($this->valuePrefix == ''){
             return  ' function (data, page) {return {results: data.results};}';
        }else{
            $string = 'data.results.map(function(item){return item["id"] = "'. $this->valuePrefix . '" + item["id"];});';
            $string = "function (data, page) {".$string." return {results: data.results};}";
            return $string;
        }
    }
    protected function getInitSelection()
    {
        return 'function(element, callback) {
            var id=$(element).val();
            if(id.substr('.strlen($this->valuePrefix).') !==""){
                $.ajax("'.$this->urlById.'?id="+id.substr('.strlen($this->valuePrefix).'), {dataType: "json"}).done(function(data) { callback(data.results[0]); });}
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
        $label = $this->label == null ? $this->value : $this->label;
        $view = $this->getView();
        $fieldName = $this->getFieldName();
        if(isset($this->model) && $fieldName != '')
        $value = $this->retrieveValue($fieldName);
        Select2Asset::register($view);
        if($this->model)
        {
            echo Html::activeDropDownList($this->model, $this->attribute,[$value => $this->label],['id' => $this->options['id'],'class' =>'form-control','value' => $value]);
        }else{
            die();
  //          echo Html::input('select', $this->attribute,$value,['id' => $this->id,'class' =>'form-control']);
        }
        $script = "$(\"#{$this->options['id']}\").select2(".$this->getOptions().")".$this->getAppendedItems().";";
        $view = $this->getView();
        $view->registerJs($script);
    }

    public function getFieldName(){
        return str_replace('[]','',$this->attribute);
    }

    public function retrieveValue($fieldName){
        if($this->value != null){
            return $this->value;
        }
        if(strpos($fieldName,'[') !== false){

            $parts = explode('[', $fieldName);

            $key = substr($parts[1], 0, -1);
            $varName = $parts[0];
            $array = $this->model->$varName;
            $value = $array[$key];
        } else{
            $value = $this->model->$fieldName;
        }
        if($value == '')
        {
            $value = $this->default;
        }
        return $value;
    }
}
