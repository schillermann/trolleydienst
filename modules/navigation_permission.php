<?php
return function (array $navigation, string $role = ''): array {

    if(empty($role)) $role = null;

    foreach ($navigation as $index => $link) {
        if(isset($link['role'])) {
            if(isset($link['name']) && basename($_SERVER['PHP_SELF']) === $link['link'])
                $navigation[$index]['active'] = true;

            if(strpos($link['role'], $role) === false)
                unset($navigation[$index]);
        }
    }
    return $navigation;
};