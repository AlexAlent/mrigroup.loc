<?php

/**
 * Created by Evgenii Ioffe
 * @author Evgenii Ioffe <ioffe@umispec.ru>
 * @copyright Copyright (c) 2023, Evgenii Ioffe
 */

global $APPLICATION;

$APPLICATION->IncludeComponent(
	"parfyonov:variable.set", 
	"product_poster", 
	array(
		"COMPONENT_TEMPLATE" => "product_poster",
		"TITLE" => "Комплексное оснащение <span>КТ кабинета</span>",
		"LIST" => array(
			0 => "Типовые планировки",
			1 => "Готовые наборы оборудования",
			2 => "",
		),
		"LINK_HREF" => "/uslugi/complex/kt/",
		"LINK_TEXT" => ""
	),
	false
); ?>