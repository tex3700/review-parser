<?php

require_once 'ReviewParser.php';
// URL страницы для сканирования
$url = 'https://wikicity.kz/biz/janym-soul-almaty';

$reviewParser = new ReviewParser();
// Получение отформатированных отзывов
$reviews = $reviewParser->scrape_reviews($url);

if (!empty($reviews)) {

    $json_data = json_encode($reviews, JSON_UNESCAPED_UNICODE);

    header("Content-Type: application/json");

// Возврата JSON данных в ответе
    echo $json_data;

}