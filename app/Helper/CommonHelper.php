<?php

// define custom variables production variables This variable id is from keap
if (!function_exists('getVariablesEx')) {
	function getVariablesEx()
	{

		$custom_variables = [
			'agent' => 20,
			'campaign' => 22,
			'client_id' => 28,
            'start_date' =>36,
			'end_date' => 24,
			'purchase_date' => 30,
            'scheme' => 32,
			'scheme_type' => 34,
			'policy_number'=>26,
			'certificate_status'=>42,
			'last_update'=>38
		];
        
        return $custom_variables;
	}
}

// test keap credentials
// if (!function_exists('getVariablesEx')) {
// 		function getVariablesEx()
// 		{
	
// 			$custom_variables = [
// 				'agent' => 2,
// 				'campaign' => 4,
// 				'client_id' => 6,
// 	            'start_date' =>10,
// 				'end_date' => 12,
// 				'purchase_date' => 8,
// 	            'scheme' => 14,
// 				'scheme_type' => 16,
// 				'policy_number'=>36,
// 				'certificate_status'=>38,
// 				'last_update'=>46
// 			];
			
// 	        return $custom_variables;
// 		}
// 	}
	
// test keap credential end

// production custom field varables
if (!function_exists('getVariablesTT')) {
	function getVariablesTT()
	{

		$custom_variables = [
			'agent' => 1,
			'campaign' => 5,
			'client_id' => 3,
            'start_date' =>11,
			'end_date' => 13,
			'purchase_date' => 9,
            'scheme' => 15,
			'scheme_type' => 17,
			'policy_number'=>7,
			'certificate_status'=>44,
			'last_update'=>40
		];
        
        return $custom_variables;
	}
}

// test custom field varables
// if (!function_exists('getVariablesTT')) {
// 	function getVariablesTT()
// 	{

// 		$custom_variables = [
// 			'agent' => 18,
// 			'campaign' => 20,
// 			'client_id' => 22,
//             'start_date' =>24,
// 			'end_date' => 26,
// 			'purchase_date' => 28,
//             'scheme' => 30,
// 			'scheme_type' => 32,
// 			'policy_number'=>34,
// 			'certificate_status'=>40,
// 			'last_update'=>48
// 		];
        
//         return $custom_variables;
// 	}
// }


if (!function_exists('getHeadsSheet')) {
	function getHeadsSheet()
	{

		return [
			"clientid",
			"title",
			"firstname",
			"lastname",
			"date_of_birth",
			"email",
			"campaign",
			"postcode",
			"certificatereference",
			"purchasedate",
			"startdate",
			"enddate",
			"agent",
			"scheme",
			"schemetype",
			"status",
			"nomail",
			"lastupdated",
			"certificatestatus"
		];
	}
}


// // test tag id 
// if (!function_exists('getTagIdEX')) {
// 	function getTagIdEX()
// 	{

// 		return [
// 			102,
// 			106
// 		];
// 	}
// }


// if (!function_exists('getTagIdTT')) {
// 	function getTagIdTT()
// 	{

// 		return [
// 			102,
// 			104
// 		];
// 	}
// }

// test tag id end


// product tag id


if (!function_exists('getTagIdEX')) {
	function getTagIdEX()
	{

		return [
			158,
			160
		];
	}
}


if (!function_exists('getTagIdTT')) {
	function getTagIdTT()
	{

		return [
			158,
			162
		];
	}
}


// product tag id end

if (!function_exists('getMissingHeader')) {
	function getMissingHeader($heading)
	{  
		$heads=getHeadsSheet();
		$missing_head=[];
		if(isset($heading[0][0])){
			foreach($heading[0][0] as $key => $head){
				if(!in_array($head,$heads)){
					$missing_head[]=$heads[$key];
				}
			}
		}
        return $missing_head;
	}
}


