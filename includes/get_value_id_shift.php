<?php
return (isset($_GET['id_shift']) && !empty($_GET['id_shift'])) ? (int)$_GET['id_shift'] : 0;