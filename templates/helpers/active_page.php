<?php
return function (string $page_file) {
    echo (basename($_SERVER['PHP_SELF']) === $page_file)? 'active' : '';
};