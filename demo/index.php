<?php
/**
 * 入口文件
 */
define('BASEDIR',__DIR__);

include BASEDIR.'/Com/Loader.php';
include BASEDIR.'/Com/func.php';

spl_autoload_register('\\Com\\Loader::autoload');

//根据不同的参数跳转到不同的地方

$type = Request('type');

switch ($type)
{
	case 'index':
	{
		App\Controller\Index\Index::test($type);
		break;
	}
	case 'main':
	{
		App\Controller\Index\Index::test($type);
		break;
	}
	case 'message':
	{
		App\Controller\Index\Index::test($type);
		break;
	}
}
//var_dump($type);




//App\Controller\Index\Index::test2();
//
//
//Com\Objet::test();



?>