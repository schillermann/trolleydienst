<?php
return filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);