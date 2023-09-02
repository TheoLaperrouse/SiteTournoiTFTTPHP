<?php
namespace BDD;

interface IBDD
{
	public function connect();
	
	public function query($sql);
	
	public function fetch_array($resultat);
	
	public function close();
	
	public function execute();
}
?>
