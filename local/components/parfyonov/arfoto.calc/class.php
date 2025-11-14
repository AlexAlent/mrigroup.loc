<?php

use Bitrix\Main\Context;
use Bitrix\Main\Engine\Contract\Controllerable;

class ArfotoCalc extends \CBitrixComponent implements Controllerable
{
    public function executeComponent()
    {
        $this->includeComponentTemplate();
    }

    public function configureActions()
    {
        return [
            'calc' => [
                'prefilters' => [],
            ],
        ];
    }

    public function calcAction($post)
    {
        var_dump($post); die();
    }
}