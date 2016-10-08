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


				//Получем внутренний путь из внешнего согласия по правилу
				//$uriPattern - определенный шаблон в routes.php
				//$path - подставляем параметры за место $1 и $2 в файле routes.php
				//$uri - входящий путь страницы
				// на выходе получем контроллер, экшен, и параметры
				$internalRoute = preg_replace("~$uriPattern~", $path, $uri);

				echo $internalRoute;

				//разделяем строку на 2 части (1-ая к контроллеру, 2 к экшену)
				$segments = explode('/', $internalRoute);

				/*echo '<pre>';
				print_r($segments);*/

				//Получаем имя контлоллера (класса). array_shift - получает первый элемент массива, и удаляет его из массива
				$controllerName = array_shift($segments).'Controller';

				//делаем первую букву заглавной
				$controllerName = ucfirst($controllerName);

				// получаем название экшена (название метода)
				$actionName = 'action'.ucfirst(array_shift($segments));

				/*echo 'Класс: '.$controllerName.'<br>';
				echo 'Метод: '.$actionName.'<br>';*/

				$paramreters = $segments;

				/*echo '<pre>';
				print_r($paramreters);*/

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
				//передаем параметры (массив) методу экшену
				//$result = $controllerObject->$actionName($paramreters);
				
				// ызываем $actionName у $controllerObject, при этом передаем массив параметрами $paramreters
				//параметры $paramreters будут переданны как переменные - $category и $id
				$result = call_user_func_array(array($controllerObject, $actionName),$paramreters);
				
				
				if ($result != null){
					break;
				}

			}
		}

	}
}