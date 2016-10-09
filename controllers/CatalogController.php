<?php

include_once ROOT . '/models/Category.php';
include_once ROOT . '/models/Product.php';
include_once ROOT . '/components/Pagination.php';

class CatalogController
{

    public function actionIndex()
    {
        $categories = array();
        $categories = Category::getCategoriesList();

        $latestProducts = array();
        $latestProducts = Product::getLatestProducts(12);

        require_once(ROOT . '/views/catalog/index.php');

        return true;
    }

    // $page - страница
    public function actionCategory($categoryId, $page = 1)
    {
        /*echo 'Категория: '.$categoryId;
        echo '<br>Страница: '.$page;*/

        $categories = array();
        $categories = Category::getCategoriesList();
        
        $categoryProducts = array();
        // Передаем в метод getProductsListByCategory класса Product параметры индефикатора и страницы
        $categoryProducts = Product::getProductsListByCategory($categoryId, $page);
        
        $total = Product::getTotalProductsinCategory($categoryId);
        
        // Создание экземплярра класса. Создаем объект $pagination класса Pagination - постраничная навигация. Параметры передаются в конструктор
        // Product::SHOW_BY_DEFAULT - константа класса Product. А self::  - константа текущего класса
        $pagination = new Pagination($total, $page, Product::SHOW_BY_DEFAULT, 'page-');
       
        require_once(ROOT . '/views/catalog/category.php');

        return true;
    }

}
