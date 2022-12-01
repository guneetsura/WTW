<?php
	require 'config.php';
	session_destroy();

	header('Location: weather.php');
?>