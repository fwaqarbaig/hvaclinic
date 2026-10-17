<?php

require __DIR__.'/articles_data_batch1.php';

$articles = [getArticle1(), getArticle2(), getArticle3()];

foreach ($articles as $idx => $art) {
    $words = str_word_count(strip_tags($art['content']));
    echo 'Article '.($idx + 1).': '.$art['slug'].' -> '.$words." words\n";
}
