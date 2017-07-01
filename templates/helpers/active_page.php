<?php
return function (string $page_file): string {
    return (basename($_SERVER['PHP_SELF']) === $page_file)? 'active' : '';
};