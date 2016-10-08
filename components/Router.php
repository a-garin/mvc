<?php

class Router
{

	private $routes;

	public function __construct()
	{
		$routesPath= ROOT.'/config/routes.php';
		$this->routes = include($routesPath);
	}


	//принимает управление от фронтконтроллера
	public function run()
	{

	}
}