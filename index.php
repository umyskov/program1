<?php

namespace Program1;

require_once __DIR__ . "/vendor/autoload.php";
$filename = __DIR__ . "/data/data.txt";
if (\BracketsParser\BracketsParser::run(Classes\Content::get($filename))) {
    echo 'Строка валидна';
} else {
    echo 'Строка невалидна';
}