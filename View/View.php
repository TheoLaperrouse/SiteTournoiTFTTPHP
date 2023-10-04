<?php
abstract class View
{
	public function setParameters($parameters)
	{
		foreach ($parameters as $key => $value) {
			$sVar = "_".$key;
			$this->$sVar = $value;
		}
	}
}
?>
