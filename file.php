<?php

require_once 'ReviewParser.php';
// URL страницы для сканирования
$url = 'https://wikicity.kz/biz/janym-soul-almaty';

$reviewParser = new ReviewParser();
// Получение отформатированных отзывов
$formatted_reviews = $reviewParser->scrape_reviews($url);

if (!empty($formatted_reviews)) {

    $json_data = json_encode($formatted_reviews, JSON_UNESCAPED_UNICODE); // Преобразование массива в JSON формат

    header("Content-Disposition: attachment; filename=reviews.json");

    // JSON данные - файл
    echo $json_data;

}
