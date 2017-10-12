<?php
/**
 * return string Class name active or empty string
 */
return function (string $page_name): string {
	return (false === strpos($_SERVER['PHP_SELF'], '/' . $page_name))? '' : 'active';
};