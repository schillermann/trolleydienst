<?php
if(!isset($_SESSION) || empty($_SESSION))
    header('location: /');