<?php
	require_once __DIR__ . "/Technique/AutoLoad.php";
	\Technique\AutoLoad::loadTFTT();
	$row = \BDD\SGBD::QueryInstance("select * from param_tournoi where Nom='DateCloture'",true,true);
	
	if (date('Y-m-d H:i:s')<$row["Valeur"]) {
		include('Template/ouvert.html');
	} else {
		include('Template/finInscript.html');
	}
	
	\Technique\AutoLoad::exitTFTT();
?>