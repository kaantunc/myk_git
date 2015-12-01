<?php 
function ajax_error_response($reason) {
	$ajax_response['success'] = false;
	$ajax_response['data'] = $reason;

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
?>