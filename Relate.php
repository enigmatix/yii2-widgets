<?php
/**
 * Created by PhpStorm.
 * User: Joel Small
 * Date: 29/12/14
 * Time: 6:30 PM
 */

namespace enigmatix\widgets;

use enigmatix\yii2select\Select2;

/**
 * Class Relate
 * @package enigmatix\widgets
 * @author Joel Small
 * @email joel.small@biscon.com.au
 *
 * This class builds  the Select2 widget, programattically defining the values required to build a relate field
 */

class Relate extends Select2
{
    public $controller;

    public function run()
    {
        $this->url = "/rest-".$this->controller."/get-".$this->controller."-list";
        $this->urlById = "/rest-".$this->controller."/get-".$this->controller."-by-id";
        parent::run();
    }

    public function retrieveValue($fieldName){
        $value = parent::retrieveValue($fieldName);
        return $this->valuePrefix . $value;
    }
}
