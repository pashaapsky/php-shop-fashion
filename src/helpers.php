<?php

namespace helpers;

function declOfNum($number, $titles)
{
    $cases = array (2, 0, 1, 1, 1, 2);
    $format = $titles[ ($number%100 > 4 && $number %100 < 20) ? 2 : $cases[min($number%10, 5)] ];
    return sprintf($format, $number);
}

function getModelsCount($number) {
    $titles = array('%d </span> модель', '%d </span> модели', '%d </span> моделей');

    return declOfNum($number, $titles);
}