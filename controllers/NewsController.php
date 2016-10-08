<?php

// для того что бы испрользовать модель news в контроллере, ее надор подключить
include_once ROOT. '/models/News.php';

class NewsController {

	// список новостей
	public function actionIndex()
		{
			echo "список новостей";

			$newsList = array();
			//используем методы модели news
			$newsList = News::getNewsList();

			//подключаем вызуальную модель вывода новостей
			require_once (ROOT . '/views/news/index.php');

			/*echo "<pre>";
			print_r($newsList);*/


			return true;
		}

	// Просмотр одной новости
	public function actionView($id)
		{

			$newsItem = array();
			//используем методы модели news
			$newsItem = News::getNewsItemById($id);

			//подключаем вызуальную модель вывода новости
			require_once (ROOT . '/views/news/view.php');

			/*echo "<pre>";
			print_r($newsItem);*/


			return true;
		}
}

?>