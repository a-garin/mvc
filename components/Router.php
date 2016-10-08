<?php

class Router
{

	private $routes;

	public function __construct()
	{
		$routesPath= ROOT.'/config/routes.php';
		$this->routes = include($routesPath);
	}

	/**
	 * Return request string
	 * @return string
	 */

	// private - работаем только в этом классе
	private  function  getURL()
	{
		if (!empty($_SERVER['REQUEST_URI'])) {
			return trim($_SERVER['REQUEST_URI'], '/');
		}
	}

	//принимает управление от фронтконтроллера
	public function run()
	{
		//получаем строку запросу
		$uri = $this->getURL();

		// проверить наличие такого запроса в routes.php
		foreach ($this->routes as $uriPattern=> $path) {
			//echo "<br>$uriPattern -> $path";

			// Сравниваем $uriPatter и $uri
			if (preg_match("~$uriPattern~", $uri)) {

				//разделяем строку на 2 части (1-ая к контроллеру, 2 к экшену)
				$segments = explode('/', $path);

				//Получаем имя контлоллера (класса). array_shift - получает первый элемент массива, и удаляет его из массива
				$controllerName = array_shift($segments).'Controller';

				//делаем первую букву заглавной
				$controllerName = ucfirst($controllerName);

				// получаем название экшена (название метода)
				$actionName = 'action'.ucfirst(array_shift($segments));

				/*echo 'Класс: '.$controllerName.'<br>';
				echo 'Метод: '.$actionName.'<br>';*/

				// Определяем путь файла классa-контроллера
				$controllerFile = ROOT . '/controllers/'.$controllerName.'.php';

				// Определяем есть ли данный файл
				if (file_exists($controllerFile)){
					//Подключаем файл классa-контроллера
					include_once ($controllerFile);
				}

				// Создаем объект нашего класса по имени $controllerName (полиморфизм)
				$controllerObject = new $controllerName;
				// вызываем метод $actionName объекта $controllerObject
				$result = $controllerObject->$actionName();
				if ($result != null){
					break;
				}

			}
		}

	}
}