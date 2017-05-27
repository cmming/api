<?php
////////////////////////////////////////////////////////////////
//所有数据相关 入口文件
///////////////////////////////////////////////////////////////
require_once 'common.inc.php';

//初始化 返回值
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
$logger->setLogFileName(basename(__FILE__));
///////////////////////////////////////////////////////////////////
//接受参数

// 控制类型 admin 和data 种类
$type = Request('type');
// 控制请求种类 
$act = Request('act');
// 具体参数
$params = Request('params',true);
// 控制必传参数 （）不为空的参数
if($type&&$act)
{
    // 管理员类型接口
    if($type === 'admin'){
        $admin = new classAdmin();
        switch($act)
        {
            case 'login':
            {
                $uname=$params['uname'];
                $pwd=$params['pwd'];
                $ad_type=$params['ad_type'];
                $data_arr=$admin->login_confirm($uname,$pwd,$ad_type);
                break;
            }
            case 'loginout':
            {
                $data_arr = loginout();
                break;
            }
            case 'updatePwd':
            {
                $data_arr = $admin->update_admin_pwd($updateid,$formdata);
                break;
            }
        }
        $out_data['code'] = $admin->get_error_code();
		$out_data['msg'] = $admin->get_error_des();
        $out_data['data'] = $data_arr;
    }
	//验证是否登录
	else if($type === 'data'&&check_login())
	{
		$data_arr = array();
		$data_operation = new data_operation();
		switch($act)
		{
			case 'payorder':
			{
				$data_arr = $data_operation->search_order($params);
			}
			break;
			default :
				break;
		}
		$out_data['code'] = $data_operation->get_error_code();
		$out_data['msg'] = $data_operation->get_error_des();
		$out_data['data'] = $data_arr;
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