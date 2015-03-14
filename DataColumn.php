<?php
namespace enigmatix\widgets;
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
        $options = $this->grid->options;
        if(array_key_exists('href', $options) && $options['href'] != null)
        {
            $field = $options['field'];
            $content = Html::tag('a',$content,['href' => $options['href']."?".$field."=".$model->$field,'class' => 'btn-block']);
        }
        return $content;
    }
}
?>