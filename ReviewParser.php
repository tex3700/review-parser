<?php

class ReviewParser
{
    // Функция для парсинга страницы и извлечения отзывов
    function scrape_reviews($url): ?array
    {
        // Получение HTML-код страницы
        $html = file_get_contents($url);

        if ($html !== false) { // Если удалось получить HTML-код

            $dom = new DOMDocument();       // Создание объекта DOMDocument
            @$dom->loadHTML($html);         // Загрузка HTML-кода
            $xpath = new DOMXPath($dom);    // Создание объекта DOMXPath

            $formatted_reviews = [];
            $count = 0;

            do {
                // Получение все элементов отзывов на странице
                $reviews = $xpath->query("//div[starts-with(@class,'review ')]");

                // Проходимся по каждому отзыву и извлекаем необходимую информацию
                foreach ($reviews as $review) {

                    $date_time = trim($xpath->query(".//span[@class='rating-qualifier']", $review)->item(0)->nodeValue);

                    $author = trim($xpath->query(".//*[contains(@class, 'user-name')]", $review)->item(0)->nodeValue);

                    $rating = trim($xpath->query(".//*[contains(@class, 'biz-rating')]/div[contains(@class, 'stars')]")
                        ->item(0)->getAttribute('aria-label'));

                    $text = trim($xpath->query(".//*[contains(@class, 'review-content')]/p", $review)->item(0)->nodeValue);

//                $count ++;
                    // Массив из полученных данных
                    $formatted_review = [
                        'Дата и время' => trim($date_time),
                        'Автор' => trim($author),
                        'Оценка' => trim($rating),
                        'Текст отзыва' => trim($text),
//                    'Review №' => $count,
                    ];


                    $formatted_reviews[] = $formatted_review;
                }

                // Поиск ссылки на следующую страницу пагинации с отзывами
                $next_page_link = $xpath->query("//a[contains(@class, ' next ')]")->item(0);

                if ($next_page_link) {
                    $next_page_url = $next_page_link->getAttribute('href');

                    $html = file_get_contents($next_page_url);  // Загрузка следующей страницы
                    @$dom->loadHTML($html);
                    $xpath = new DOMXPath($dom);
                }
            } while ($next_page_link); // Пока есть ссылка пагинации

            return $formatted_reviews;

        } else {
            echo 'Не удалось получить доступ к странице';
            return null;
        }
    }

}