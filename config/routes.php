<?php

// правила проверяются сверху вниз. При соподени, примеяет первый
return array(

	// может содержатся от 1 цифры и больше (паттерн с регул. выражением)
	// ЧПУ типа news/114
	'news/([0-9]+)' => 'news/view/$1',


	'news' => 'news/index', // actionIndex in NewsController
	'products' => 'product/list' // actionList in ProductController
);