<?php
return function(array $placeholder = array(), string $layout_file = 'views/layout.php') {

    return include $layout_file;
};