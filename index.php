<?php

require_once 'ReviewParser.php';
// URL страницы для сканирования
$url = 'https://wikicity.kz/biz/janym-soul-almaty';

$reviewParser = new ReviewParser();
// Получение отформатированных отзывов
$formatted_reviews = $reviewParser->scrape_reviews($url);

if (!empty($formatted_reviews)) {

    foreach ($formatted_reviews as $review) {
        echo '<pre>';
        print_r($review);
        echo '</pre>';
    }

}









