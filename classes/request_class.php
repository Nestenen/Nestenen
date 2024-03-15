<?php
	
	class requests_class{
		
		const CLASS_VERTION = '1.0.0.7';
	
		static function get_sender($input_url, $params_array, $header_array) {
			
			$get_url = $input_url;
            
            try {

                $main_count = 0;
                foreach ($params_array as &$param) {
                    $get_url = $get_url.(($main_count == 0) ? '?' : '&').array_search($param, $params_array).'='.$param;
                    $main_count++;
                }
                unset($param);

                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, $get_url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_HTTPHEADER, $header_array);
                $resp = curl_exec($curl);
                curl_close($curl);
                return $resp;
                
            }
            catch (Exception $e) {
                return $e -> getMessage();
            }
			
		}
        
		static function post_sender($input_url, $data_array, $header_array) {
            
            try {

                $curl = curl_init();
                
                curl_setopt($curl, CURLOPT_URL, $input_url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data_array));
                curl_setopt($curl, CURLOPT_HTTPHEADER, $header_array);
                $resp = curl_exec($curl);
                curl_close($curl);
                return $resp;
                
            }
            catch (Exception $e) {
                return $e -> getMessage();
            }
			
		}

		static function put_sender($input_url, $data_array, $header_array) {
            
            try {
            
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, $input_url);
                curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($data_array)));
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data_array);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                $response  = curl_exec($curl);
                curl_close($curl);
                return $response;
                
            }
            catch (Exception $e) {
                return $e -> getMessage();
            }
		}
		
	}
	
	class RequestsClass{
		
		const class_vertion = '1.0.0.6';
        
		function get_sender($input_url, $params_array, $header_array) {
			
			$get_url = $input_url;
            
            try {

                $main_count = 0;
                foreach ($params_array as &$param) {
                    $get_url = $get_url.(($main_count == 0) ? '?' : '&').array_search($param, $params_array).'='.$param;
                    $main_count++;
                }
                unset($param);

                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, $get_url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_HTTPHEADER, $header_array);
                $resp = curl_exec($curl);
                curl_close($curl);
                return $resp;
                
            }
            catch (Exception $e) {
                return $e -> getMessage();
            }
			
		}
        
		function post_sender($input_url, $data_array, $header_array) {
            
            try {

                $curl = curl_init();
                
                curl_setopt($curl, CURLOPT_URL, $input_url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data_array));
                curl_setopt($curl, CURLOPT_HTTPHEADER, $header_array);
                $resp = curl_exec($curl);
                echo $out;
                curl_close($curl);
                return $resp;
                
            }
            catch (Exception $e) {
                return $e -> getMessage();
            }
			
		}

		function put_sender($input_url, $data_array, $header_array) {
            
            try {
            
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, $input_url);
                curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($data_array)));
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data_array);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                $response  = curl_exec($curl);
                curl_close($curl);
                return $response;
                
            }
            catch (Exception $e) {
                return $e -> getMessage();
            }
		}
		
		// Get url former //
		
		function GETUrlFormer($input_url, $params_array) {
			
			$get_url = $input_url;
			
            try {
            
                $main_count = 0;
                foreach ($params_array as &$param) {
                    $get_url = $get_url.(($main_count == 0) ? '?' : '&').array_search($param, $params_array).'='.$param;
                    $main_count++;
                }
                unset($param);

                return $get_url;
            
            }
            catch (Exception $e) {
                return $e -> getMessage();
            }
		}	
			
		// Метод отправки POST запроса через curl //
			
		function GETSenderWithParams($input_url, $params_array, $header_array) {
			
			$get_url = $input_url;
			
            try{
            
                $main_count = 0;
                foreach ($params_array as &$param) {
                    $get_url = $get_url.(($main_count == 0) ? '?' : '&').array_search($param, $params_array).'='.$param;
                    $main_count++;
                }
                unset($param);

                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, $get_url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_HTTPHEADER, $header_array);
                $resp = curl_exec($curl);
                curl_close($curl);
                return $resp;
                
            }
            catch (Exception $e) {
                return $e -> getMessage();
            }
			
		}
		
		// GET Url former //
		
		function GETUrlByParamsArrayFormer($input_url, $params_array) {
			
			$get_url = $input_url;
			
            try{
            
                $main_count = 0;
                foreach ($params_array as &$param) {
                    $get_url = $get_url.(($main_count == 0) ? '?' : '&').array_search($param, $params_array).'='.$param;
                    $main_count++;
                }
                unset($param);
                return $get_url;
            
            }
            catch (Exception $e) {
                return $e -> getMessage();
            }
			
		}
		
		// Отправка POST запроса через curl //
				
		function POSTSenderWithParams($input_url, $data_array, $header_array) {
				
            $curl = curl_init();
			
            try{
            
                curl_setopt($curl, CURLOPT_URL, $input_url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data_array);
                curl_setopt($curl, CURLOPT_HTTPHEADER, $header_array);
                $resp = curl_exec($curl);
                echo $out;
                curl_close($curl);
                return $resp;

            }
            catch (Exception $e) {
                return $e -> getMessage();
            }
			
		}
        
		// Отправка POST запроса через file_get_contents //
				
		function POSTSenderFGC($input_url, $data_array, $header_array) {
				
            try {    
                
                $result = file_get_contents($input_url, false, stream_context_create(array(
                    'http' => array(
                        'method'  => 'POST',
                        'header'  => $header_array,
                        'content' => http_build_query($data_array)
                    )
                )));
                return $result;
            
            }
            catch (Exception $e) {
                return $e -> getMessage();
            }
            
		}
        
        // Формирование url для GET-запроса //
        
        function GetUrlFormerByArray($get_link, $params_array) {
            
            $get_url = $get_link;
            
            try { 
            
                $for_count = '0';
                foreach ($params_array as &$param) {
                    $get_url = $get_url.(($for_count == 0) ? '?' : '&').array_search($param, $params_array).'='.$param;
                    $for_count++;
                }
                unset($param);
            
                return $get_url;
            
            }
            catch (Exception $e) {
                return $e -> getMessage();
            }
        }	        
		
	}
	
?>