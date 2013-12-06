<?
function invite_keys($number){
	if($number == 1){
		return base64_encode(md5(time()) . rand() .  rand());
	}
	else{
		$key = array();
		for($i=0;$i<$number;$i++){
			$key[] = base64_encode(md5(time()) . rand() . rand());
		}
		return $key;
	}
}