<?php
	session_start();
	$pathToRoot = './../';
	session_destroy();
	header("location: $pathToRoot");
?>