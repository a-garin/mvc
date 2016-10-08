<?php

class News
{
    
    // метов возвращает одну новость по индефикатору
    public static function getNewsItemById($id)
    {
        $id = intval($id);

        if ($id) {
            //статический метод getConnection класса Db где скрыты подкление
            $db = Db::getConnection();

            $result = $db->query('SELECT * FROM news WHERE id = ' . $id);

            // вывод идексов в виде номеров
            // $result->setFetchMode(PDO::FETCH_NUM);

            // вывод идексов в виде названия
            $result->setFetchMode(PDO::FETCH_ASSOC);

            $newsItem = $result->fetch();

            return $newsItem;
        }
    }
    
    // возвращает список новостей
    public static function getNewsList()
    {

        //статический метод getConnection класса Db где скрыты подкление
        $db = Db::getConnection();

        $newsList = array();
        
        //метод query - замена mysql_query
        $result = $db->query('SELECT id, title, date, short_content '
            . 'FROM news '
            . 'ORDER BY date DESC '
            . 'LIMIT 10');

        //проверям что вернул резултьтат - булево значение
        //var_dump($result);
        
        $i = 0;
        //Далее обраещаемся к методу fetch объектов переменной $result  - замена mysql_fetch_array
        //записываем в массив результата
        while ($row = $result->fetch()) {
            $newsList[$i]['id'] = $row['id'];
            $newsList[$i]['title'] = $row['title'];
            $newsList[$i]['date'] = $row['date'];
            $newsList[$i]['short_content'] = $row['short_content'];
            $i++;
        }
        return $newsList;


    }
    
    
}