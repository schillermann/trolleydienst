<?php
return function (array $navigation, string $role = ''): array {

    if(empty($role)) $role = NULL;

    foreach ($navigation as $index => $link) {
        if(isset($link['role'])) {
            if(isset($link['name']) && basename($_SERVER['PHP_SELF']) === $link['link'])
                $navigation[$index]['active'] = true;

            if(strpos($link['role'], $role) === FALSE)
                unset($navigation[$index]);
        }
    }
    return $navigation;
};