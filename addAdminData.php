<?php
////////////////////////////////////////////////////////////////
//增加数据接口，平台管理员操作
//wl 2016-11-04
///////////////////////////////////////////////////////////////
require_once 'common.inc.php';

$out_data['code'] = Core_Exception::CODE_UNKNOW_ERROR;
$out_data['msg'] = Core_Exception::getErrorDes(Core_Exception::CODE_UNKNOW_ERROR);
$out_data['data'] = array();

//创建日志类
$logger = Core_Logger::getInstance();

//////////////////////////////////////////////////////////////////////
//设置日志输出级别
//$logger->setLogLevel(Core_Logger::LOG_LEVL_NO);		//无日志
$logger->setLogLevel(Core_Logger::LOG_LEVL_DEBUG|Core_Logger::LOG_LEVL_ERROR|Core_Logger::LOG_LEVL_WARNING|Core_Logger::LOG_LEVL_DATA);	//仅输出错误,警告日志,数据记录日志
//设置针对每个应用设置日志文件，方便查询
$logger->setLogPath(PATH_SYS_LOG);
//设置日志文件路径
$logger->setLogFileName("addData");
///////////////////////////////////////////////////////////////////
//接受参数
$request_data = file_get_contents('php://input', true);
$request_data = json_decode($request_data,true);
$type = isset($request_data['type'])?$request_data['type']:'';
$formdata = isset($request_data['formdata'])?$request_data['formdata']:'';
//$type = isset($_REQUEST['type'])?$_REQUEST['type']:'';
//$formdata = isset($_REQUEST['formdata'])?$_REQUEST['formdata']:'';
if($type&&$formdata)
{
	//验证是否登录
	//$admin = new classAdmin();
	if(check_login())
	{
		//判断是否有权限操作本接口
		if(check_admin())
		{
			$formdata = json_decode($formdata,true);
			//实例化功能操作类
			$admin = new classAdmin();
			switch($type)
			{
				case 'merchant':
					$admin->add_merchant($formdata);
					break;
				case 'admin':
					$admin->add_admin($formdata);
					break;
				case 'addTerm':
					$admin->add_term($formdata);
					break;
				case 'addPackage':
					$admin->add_package($formdata);
					break;
				default :
					break;
			}
			$out_data['code'] = $admin->get_error_code();
			$out_data['msg'] = $admin->get_error_des();
		}
		else
		{
			$out_data['code'] = Core_Exception::CODE_NO_POWER;
			$out_data['msg'] = Core_Exception::getErrorDes(Core_Exception::CODE_NO_POWER);
		}
	}
	else
	{
		$out_data['code'] = Core_Exception::CODE_USER_NOT_LOGIN;
		$out_data['msg'] = Core_Exception::getErrorDes(Core_Exception::CODE_USER_NOT_LOGIN);
	}
}
else
{
	$out_data['code'] = Core_Exception::CODE_BAD_PARAM;
	$out_data['msg'] = Core_Exception::getErrorDes(Core_Exception::CODE_BAD_PARAM);
}
echo json_encode($out_data);
?>