<?php

namespace Program1;

use Program1\Classes\Content;
use BracketsParser\BracketsParser;

require_once __DIR__ . "/vendor/autoload.php";
$filename = __DIR__ . "/data/data.txt";
if (BracketsParser::run(Content::get($filename))) {
    echo 'Строка валидна';
} else {
    echo 'Строка невалидна';
}