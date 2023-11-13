<?php
function get_preset(int $number): string {
//    вырезать body
    $html = match ($number) {
        1 => file_get_contents('https://ru.wikipedia.org/wiki/%D0%9A%D0%B8%D0%BD%D0%BE%D1%80%D0%B8%D0%BD%D1%85%D0%B8'),
        2 => file_get_contents('https://www.gazeta.ru/culture/2021/12/16/a_14322589.shtml'),
        3 => file_get_contents('https://mishka-knizhka.ru/skazki-dlay-detey/zarubezhnye-skazochniki/skazki-alana-milna/vinni-puh-i-vse-vse-vse/#glava-pervaya-v-kotoroj-my-znakomimsya-s-vinni-puhom-i-neskolkimi-pchy'),
        default => '',
    };
    $html = str_replace('</textarea>', '', $html);
    return $html;
}
