<?php
function Request($params,$is_json_decode=false){
	$result = isset($_REQUEST[$params])?$_REQUEST[$params]:'';
	if($is_json_decode){
		return json_decode($result,true);
	}else{
		return $result;
	}
}
?>