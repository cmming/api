<?php
//include './baseModel.php';

spl_autoload_register('autoload1');

$baseObj=new baseModel();

//$base = $baseObj->baselink();
//var_dump($baseObj);

//$base1 = $baseObj->base1Link();
//var_dump($base);

function autoload1($class){
	var_dump($class);
	require __DIR__.'/'.$class.'.php';
}
?>