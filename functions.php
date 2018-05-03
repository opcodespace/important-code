<?php 
// Sending files through curl
function send_file($contract_id, $file_path){
	// For dev 
	$url = '';
	// For Live
	//$url = '';

	$data = [
		$contract_id => curl_file_create($file_path, mime_content_type($file_path), basename($file_path))
	];

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	return curl_exec($ch);
}
