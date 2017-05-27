<?php
namespace App\Controller\Index;

//导入一个全局的类
use Com\Objet as Obj;
use Com\Core_DBOper as mysql;

class Index
{
	public function test($id){
		echo 'index'.$id;
	}
	//命名空间之间的引用
	public function test2(){
		Obj::test();
	}


}
?>