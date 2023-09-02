<?php session_start();
	require_once __DIR__ . "/../Technique/AutoLoad.php";
	\Technique\AutoLoad::loadTFTT();
	UserInfo::setCookie('TFTTId',0) ;
	UserInfo::destroy();
	\BDD\SGBD::unsetGlobal();
	header('Location: ../index.php');
?>
