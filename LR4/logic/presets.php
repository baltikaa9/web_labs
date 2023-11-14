<?php
function get_preset(int $number): string {
    $html = match ($number) {
        1 => file_get_contents('../preset1.html'),
        2 => file_get_contents('../preset2.html'),
        3 => file_get_contents('../preset3.html'),
        default => '',
    };
    $html = str_replace('</textarea>', '', $html);
    return $html;
}
