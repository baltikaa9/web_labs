<?php

require_once 'html2text.php';

function get_text(): string {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        return $_POST['text'];
    }
    return '';
}

function task_4(string $text): string {
//    $text = Html2Text::convert($text, ['ignore_errors' => true, 'drop_links' => true]);

    $pattern = '/(что|кто|где|как|когда|почему|зачем|какой|чей|сколько|куда|откуда|насколько|то)\s+(то|либо|нибудь)/iu';
    $replacement = '$1-$2';
    $text = preg_replace($pattern, $replacement, $text);

    $pattern = '/(кое|кой)\s+(что|кто|где|как|когда|почему|зачем|какой|чей|сколько|куда|откуда|насколько)/iu';
    $text = preg_replace($pattern, $replacement, $text);

    $pattern = '/(\w+)\s+(таки|де|ка|тка|кась)(\W+)/iu';
    $replacement = '$1-$2$3';
    $text = preg_replace($pattern, $replacement, $text);

    $text = str_ireplace('из за', 'из-за', $text);
    $text = str_ireplace('из под', 'из-под', $text);

    return $text;
}

function task_9(string $text): string {
//    $text = Html2Text::convert($text, ['ignore_errors' => true, 'drop_links' => true]);

    $pattern = '/(что|кто|где|как|когда|почему|зачем|какой|чей|сколько|куда|откуда|насколько|то)\s*-\s*(то|либо|нибудь)/iu';
    $replacement = '$1-$2';
    $text = preg_replace($pattern, $replacement, $text);

    $pattern = '/(кое|кой)\s*-\s*(что|кто|где|как|когда|почему|зачем|какой|чей|сколько|куда|откуда|насколько)/iu';
    $text = preg_replace($pattern, $replacement, $text);

    $text = str_ireplace(' .', '.', $text);
    $text = str_ireplace(' ,', ',', $text);
    $text = str_ireplace(' ;', ';', $text);
    $text = str_ireplace(' :', ':', $text);
    $text = str_ireplace(' !', '!', $text);
    $text = str_ireplace(' ?', '?', $text);

    $pattern = '/([\.,;:!?]+)([^\s\.,;:!?]+)/';
    $replacement = '$1 $2';
    $text = preg_replace($pattern, $replacement, $text);

    return $text;
}

function task_15(string $text): array {
    $prepositions = [
        'в', 'к', 'до', 'по', 'через', 'после', 'в течение', 'в продолжение', 'в заключение',
        'из-за', 'за', 'над', 'под', 'перед', 'у', 'возле', 'мимо', 'около',
        'от', 'ради', 'благодаря', 'в силу', 'ввиду', 'вследствие',
        'для', 'на', 'ради', 'в целях', 'с целью',
        'о', 'об', 'обо', 'про', 'насчёт', 'при',
        'с', 'вроде', 'наподобие', 'как', 'без', 'из'
    ];

    $unions = [
        'что', 'чтобы', 'как', 'когда', 'ибо', 'пока', 'будто', 'словно', 'если',
        'и', 'или', 'тоже', 'также', 'либо', 'а', 'но', 'зато', 'однако',
    ];

    $text = task_4($text);
    $text = task_9($text);

    $text_replaced = Html2Text::convert($text, ['ignore_errors' => true, 'drop_links' => true]);

    $text_replaced = str_ireplace('.', '', $text);
    $text_replaced = str_ireplace(',', '', $text);
    $text_replaced = str_ireplace(';', '', $text);
    $text_replaced = str_ireplace(':', '', $text);
    $text_replaced = str_ireplace('!', '', $text);
    $text_replaced = str_ireplace('?', '', $text);
    $text_replaced = str_ireplace(' — ', ' ', $text);
    $text_replaced = str_ireplace(' - ', ' ', $text);

    $text_split = explode(' ', $text_replaced);
    $word_count = [];
    foreach ($text_split as $word) {
        $word = mb_strtolower($word);
        $word = trim($word);
        if (!in_array($word, $prepositions) && !in_array($word, $unions) && preg_match('/^[абвгдеёжзийклмнопрстуфхцчшщъыьэюя]+-*[абвгдеёжзийклмнопрстуфхцчшщъыьэюя]+$/i', $word)) {
            if (!isset($word_count[$word])) {
                $word_count[$word] = 1;
            }
            else {
                $word_count[$word]++;
            }
        }
    }
    arsort($word_count);

    $words = array_keys($word_count);
    for ($i = 0; $i < count($words); $i++) {
        $text = str_ireplace(" $words[$i] ", ' <span id=' . "subj$i" . ">$words[$i]</span> ", $text);
    }
    return [$word_count, $text];
}

function task_19($html) {
    // Создаем объект DOMDocument
    $dom = new DOMDocument;

    // Загружаем HTML в DOMDocument, игнорируя ошибки (например, некорректные теги)
    libxml_use_internal_errors(true);
    $dom->loadHTML('<?xml encoding="UTF-8">' . $html);

    // Создаем объект XPath для поиска элементов
    $xpath = new DOMXPath($dom);

    $script_tags = $xpath->query('*//*[self::script or self::style]');

    foreach ($script_tags as $tag) {
        $tag->parentNode->removeChild($tag);
    }

    // Получаем все элементы, которые не являются одним из разрешенных тегов
    $non_allowed_tags = $xpath->query('*//*[not(self::h1 or self::h2 or self::h3 or self::h4 or self::h5 or self::h6 or self::p or self::div or self::a or self::table or self::tr or self::td or self::th or self::span)]');

    // Удаляем найденные элементы
    foreach ($non_allowed_tags as $tag) {
        $text_content = $tag->textContent;
        $replacement = $dom->createTextNode($text_content);
        $tag->parentNode->replaceChild($replacement, $tag);
    }

    // Удаляем атрибуты у оставшихся тегов
    $allowed_tags = $xpath->query('*//*[not(self::span or self::a)]');
    foreach ($allowed_tags as $tag) {
        while ($tag->hasAttributes()) {
            $tag->removeAttributeNode($tag->attributes->item(0));
        }
    }

    // Получаем отформатированный HTML без лишних тегов и атрибутов
    $cleaned_html = $dom->saveHTML();

    // Убираем тег <html> и <body>, чтобы получить только содержимое
    $cleaned_html = str_replace(['<html>', '</html>', '<body>', '</body>'], '', $cleaned_html);

    return $cleaned_html;
}
