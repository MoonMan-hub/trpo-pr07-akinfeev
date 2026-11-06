<?php

// Экранирование текста перед выводом в HTML
function e($text): string
{
    return htmlspecialchars((string)$text, ENT_QUOTES, 'UTF-8');
}
