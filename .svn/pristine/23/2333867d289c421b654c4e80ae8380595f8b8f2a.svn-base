<?php 
function ajax_error_response($reason) {
	$ajax_response['success'] = false;
	$ajax_response['data'] = $reason;

	$resultToReturn = json_encode($ajax_response);
	echo $resultToReturn;
	exit;
}
function ajax_error_response_with_array($reason, $array) {
	$ajax_response['success'] = false;
	$ajax_response['data'] = $reason;
	$ajax_response['array'] = $array;
	
	echo json_encode($ajax_response);
	exit;
}
function ajax_success_response($message, $id = null) {
	$ajax_response['success'] = true;
	$ajax_response['data'] = $message;
	
	if ($id != null){
		$ajax_response['id'] = $id;
	}
	
	echo json_encode($ajax_response);
	exit;
}

function ajax_success_response_with_array($message, $array) {
	$ajax_response['success'] = true;
	$ajax_response['data'] = $message;
	$ajax_response['array'] = $array;
	
	echo json_encode($ajax_response);
	exit;
}

function tarihdenDonustur($veri,$format=''){
	if($veri!=""){
	    if ($format=="" or $format=="d.m.Y"){
	        $tarih=explode(".",$veri);
	        return mktime("0","0","0",$tarih[1],$tarih[0],$tarih[2]);
	    }
	} else {
		return null;
	}
}

function tariheDonustur($time,$tip="saatsiz"){
    if ($tip=="saatsiz"){
        return date("d.m.Y",$time);
    } else {
        return date("d.m.Y H:i:s",$time);
    }
}

?>