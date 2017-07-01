<?php
return  array(
    array(
        'name' => 'Trolley',
        'link' => 'shift.php',
        'role' => Enum\UserRole::USER . ','. Enum\UserRole::ADMIN
    ),
    array(
        'name' => 'Infos',
        'link' => 'info.php',
        'role' => Enum\UserRole::USER . ','. Enum\UserRole::ADMIN
    ),
    array(
        'name' => 'Profil',
        'link' => 'profile.php',
        'role' => Enum\UserRole::USER . ','. Enum\UserRole::ADMIN
    ),
    array(
        'name' => 'Teilnehmer',
        'link' => 'user.php',
        'role' => Enum\UserRole::ADMIN
    ),
    array(
        'name' => 'E-Mail',
        'link' => 'email.php',
        'role' => Enum\UserRole::ADMIN
    )
);