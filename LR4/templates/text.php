<?php
require_once '../logic/presets.php';
$preset = isset($_GET['preset']) ? get_preset($_GET['preset']) : '';

require_once '../logic/text.php';

$text = get_text();
?>
<!DOCTYPE html>
<html lang="ru">
<?php require_once 'head.php'?>
<body>
<?php require_once 'header.php'?>
<main class="content">
    <div class="container">
        <div class="dropdown">
            <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton1" data-toggle="dropdown" aria-expanded="false">
                Пресеты
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                <li><a class="dropdown-item" href="text.php?preset=1">1</a></li>
                <li><a class="dropdown-item" href="text.php?preset=2">2</a></li>
                <li><a class="dropdown-item" href="text.php?preset=3">3</a></li>
            </ul>
        </div>
        <form class="m-5" action="text.php" method="post">
            <label class="form-label" style="width: 100%;">
                Введите текст
                <textarea class="form-control" name="text"><?php
                        if ($preset) { echo $preset; }
                        elseif (isset($_POST['text'])) { echo htmlspecialchars($text); }
                        else { echo ''; }
                    ?></textarea>
            </label>
            <button class="btn btn-dark mt-2">Отправить</button>
        </form>
        <?php if ($text):?>
            <div class="container">
                <div class="hyphens">
                    <p>Задание 4. Расставить дефисы в обезличенных местоимениях и междометиях.</p>
                    <?php $text = task_4($text)?>
                </div>
                <div class="spaces">
                    <p>Задание 9. Удалить лишние пробелы между дефисом в местоимениях и наречиях (напр.: кто- то, заменится на кто-то). Удаление пробелов перед точками, запятыми и двоеточиями в тексте. Добавить пробел после этих знаков препинания.</p>
                    <?php $text = task_9($text)?>
                </div>
                <div class="word-count">
                    <p>Задание 15. Предметный указатель.</p>
                    <?php
                    $res = task_15($text);
                    $word_count = $res[0];
                    $text = $res[1];
                    $words = array_keys($word_count);
//                    print_r($words);
//                    print_r($word_count);
                    ?>
                    <ol>
                        <?php for ($i = 0; $i < 100; $i++):?>
                            <?php if (isset($words[$i])):?>
                                <li><a href="#subj<?=$i?>"><?=$words[$i]?></a><?=' - '.$word_count[$words[$i]]?></li>
                            <?php else:?>
                                <?php break?>
                            <?php endif?>
                        <?php endfor?>
                    </ol>
                </div>
                <div class="clean_html">
                    <p>Задание 19. Чистка форматирования.</p>
                    <?php $text = task_19($text)?>
                </div>
                <div class="text">
                    <h1>Введенный текст после преобразований.</h1>
                    <?=$text?>
                </div>
            </div>
        <?php endif?>
    </div>
</main>
</body>