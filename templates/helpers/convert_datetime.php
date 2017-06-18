<?php
return function (string $datetime, string $format = 'H:i'): string {
    $datetime_convert = new \DateTime($datetime);
    return $datetime_convert->format($format);
};