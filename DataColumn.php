<?php
namespace enigmatix\widgets;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Class DataColumn
 * @package enigmatix\widgets
 * @author Joel Small
 * @email joel.small@biscon.com.au
 *
 * This class wraps each column value in a link if a link is specified in the widget options
 */

class DataColumn extends \yii\grid\DataColumn
{
    protected function renderDataCellContent($model, $key, $index)
    {
        $content = parent::renderDataCellContent($model, $key, $index);
        return Html::a($content,$this->getViewUrl($model),['class' => 'btn-block','data-pjax' => 0]);
    }

    protected function getViewUrl($model)
    {
        
    	$func = ArrayHelper::getValue($this->options, 'getViewLink');
        if (is_callable($func))
            return call_user_func($func, $model);
        
        if (method_exists($model, 'getViewLink')){
            $link = call_user_func([$model, 'getViewLink']);
            if (!empty($link))
                return $link;
        }

       if (method_exists($model, 'getController')){
            $controller = call_user_func([$model, 'getController']);
            return [$controller . '/view', 'id' => $model->id];
        }

        throw new InvalidConfigException("Method getViewLink does not exist in model or in widget options"
        . " and model does not have a 'getController' method to guess the URL");

    }
}
?>
