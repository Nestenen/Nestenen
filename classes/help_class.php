<?php

	class help_class{
		
		CONST MODULE_VERTION = '1.0.1.1';
		
		public static function utf_8_for_web_printer($text_for_print) {
			
			try {
				
				$header_text = '<html><head><meta charset="UTF-8"></head>';
				$footer_text = '<body></body></html>';
				
				print_r($header_text);  print_r('<pre>'); print_r($text_for_print); print_r('</pre>'); print_r($footer_text); 
			}
			catch (Exception $e) {
                return -1;
            }
			
		}
        
        public static function zero_adder($input_string, $symbol_amount, $symbol, $dir_flag){
			try {
				$input_string_tmp = $input_string;
				while(strlen($input_string_tmp) < $symbol_amount) {
					$input_string_tmp = ($dir_flag == 0) ? $input_string_tmp.$symbol : $symbol.$input_string_tmp;
				}
				return $input_string_tmp;
			}
			catch (Exception $e) {
                return -1;
            }
        }
        
        public static function translit_2_rus($string) {
            
            try {
            
                $converter = array(
                    'a' => 'а',   'b' => 'б',   'v' => 'в',
                    'g' => 'г',   'd' => 'д',   'e' => 'е',
                    /*'e44' => 'ё44',*/ 'zh' => 'ж',  'z' => 'з',
                    'i' => 'и',   'y' => 'й',   'k' => 'к',
                    'l' => 'л',   'm' => 'м',   'n' => 'н',
                    'o' => 'о',   'p' => 'п',   'r' => 'р',
                    's' => 'с',   't' => 'т',   'u' => 'у',
                    'f' => 'ф',   'h' => 'х',   'c' => 'ц',
                    'ch' => 'ч',  'sh' => 'ш',  'sch' => 'щ',
                    '\'' => 'ь',  'y' => 'ы',   /*'\'' => 'ъ',*/
                    /*'e' => 'э',*/   'yu' => 'ю',  'ya' => 'я',
                    
                    'A' => 'А',   'B' => 'Б',   'V' => 'В',
                    'G' => 'Г',   'D' => 'Д',   'E' => 'Е',
                    /*'Ё' => 'E',*/   'Zh' => 'Ж',  'Z' => 'З',
                    'I' => 'И',   'Y' => 'Й',   'K' => 'К',
                    'L' => 'Л',   'M' => 'М',   'N' => 'Н',
                    'O' => 'О',   'P' => 'П',   'R' => 'Р',
                    'S' => 'С',   'T' => 'Т',   'U' => 'У',
                    'F' => 'Ф',   'H' => 'Х',   'C' => 'Ц',
                    'Ch' => 'Ч',  'Sh' => 'Ш',  'Sch' => 'Щ',
                    /*'\'' => 'Ь',*/  'Y' => 'Ы',   /*'\'' => 'Ъ',*/
                    /*'E' => 'Э',*/   'Yu' => 'Ю',  'Ya' => 'Я'
                );
                return strtr($string, $converter);
                
            } catch (Exception $e) {
                return -1;
            }
        }
        
        public static function rus_2_translit($string) {
			
			try {
			
				$converter = array(
					'а' => 'a',   'б' => 'b',   'в' => 'v',
					'г' => 'g',   'д' => 'd',   'е' => 'e',
					'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
					'и' => 'i',   'й' => 'y',   'к' => 'k',
					'л' => 'l',   'м' => 'm',   'н' => 'n',
					'о' => 'o',   'п' => 'p',   'р' => 'r',
					'с' => 's',   'т' => 't',   'у' => 'u',
					'ф' => 'f',   'х' => 'h',   'ц' => 'c',
					'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
					'ь' => '\'',  'ы' => 'y',   'ъ' => '\'',
					'э' => 'e',   'ю' => 'yu',  'я' => 'ya',
					
					'А' => 'A',   'Б' => 'B',   'В' => 'V',
					'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
					'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
					'И' => 'I',   'Й' => 'Y',   'К' => 'K',
					'Л' => 'L',   'М' => 'M',   'Н' => 'N',
					'О' => 'O',   'П' => 'P',   'Р' => 'R',
					'С' => 'S',   'Т' => 'T',   'У' => 'U',
					'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
					'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
					'Ь' => '\'',  'Ы' => 'Y',   'Ъ' => '\'',
					'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
				);
				return strtr($string, $converter);
			
            }
			
			catch (Exception $e) {
                return -1;
            }
        }
        
        public static function write_data_to_file($file_path, $data_array) {

			try {

				$data_array = serialize($data_array);
				file_put_contents($file_path, $data_array);
				$fp = fopen ($file_path, "w"); // Открытие файла на чтение
				fwrite($fp, $data_array);
				fclose($fp);
				return $data_array;
			
            }
			
			catch (Exception $e) {
                return -1;
            }
            
        }        
        
        public static function read_data_from_file($file_path, $serial_mode) {    

			try {

				$data = file_get_contents($file_path);
				$data_array = ($serial_mode == 0) ? ($data) : unserialize($data);
				return $data_array;

            }
			
			catch (Exception $e) {
                return -1;
            }
            
        }
		
		public static function html_wrap_former($hedader_or_footer) {
			
			$header_html = '
			<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
			<!--<meta http-equiv="refresh" content="15">-->
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			</head>
			<body style="background: #FFFFFF; color: #000000;"><!--color: #00FF90;">-->
			';
			
			$footer_html = '
			</body>
			</html>';
			
			if ($hedader_or_footer == '0') {
				print_r($header_html);
			}
			else if($hedader_or_footer =='1'){
				print_r($footer_html);
			}	
			
			return true;
		}
    
    }

    class HelpClass{
		
		CONST MODULE_VERTION = '1.0.0.9';
		
		function utf_8_for_web_printer($text_for_print) {
			
		    $header_text = '<html><head><meta charset="UTF-8"></head>';
			$footer_text = '<body></body></html>';
			
			print_r($header_text);  print_r('<pre>'); print_r($text_for_print); print_r('</pre>'); print_r($footer_text); 
			
		}
        
        function zero_adder($input_string, $symbol_amount, $symbol, $dir_flag){
            $input_string_tmp = $input_string;
            while(strlen($input_string_tmp) < $symbol_amount) {
                $input_string_tmp = ($dir_flag == 0) ? $input_string_tmp.$symbol : $symbol.$input_string_tmp;
            }
            return $input_string_tmp;
        }
        
        function translit_2_rus($string) {
            
            try {
            
                $converter = array(
                    'a' => 'а',   'b' => 'б',   'v' => 'в',
                    'g' => 'г',   'd' => 'д',   'e' => 'е',
                    /*'e44' => 'ё44',*/ 'zh' => 'ж',  'z' => 'з',
                    'i' => 'и',   'y' => 'й',   'k' => 'к',
                    'l' => 'л',   'm' => 'м',   'n' => 'н',
                    'o' => 'о',   'p' => 'п',   'r' => 'р',
                    's' => 'с',   't' => 'т',   'u' => 'у',
                    'f' => 'ф',   'h' => 'х',   'c' => 'ц',
                    'ch' => 'ч',  'sh' => 'ш',  'sch' => 'щ',
                    '\'' => 'ь',  'y' => 'ы',   /*'\'' => 'ъ',*/
                    /*'e' => 'э',*/   'yu' => 'ю',  'ya' => 'я',
                    
                    'A' => 'А',   'B' => 'Б',   'V' => 'В',
                    'G' => 'Г',   'D' => 'Д',   'E' => 'Е',
                    /*'Ё' => 'E',*/   'Zh' => 'Ж',  'Z' => 'З',
                    'I' => 'И',   'Y' => 'Й',   'K' => 'К',
                    'L' => 'Л',   'M' => 'М',   'N' => 'Н',
                    'O' => 'О',   'P' => 'П',   'R' => 'Р',
                    'S' => 'С',   'T' => 'Т',   'U' => 'У',
                    'F' => 'Ф',   'H' => 'Х',   'C' => 'Ц',
                    'Ch' => 'Ч',  'Sh' => 'Ш',  'Sch' => 'Щ',
                    /*'\'' => 'Ь',*/  'Y' => 'Ы',   /*'\'' => 'Ъ',*/
                    /*'E' => 'Э',*/   'Yu' => 'Ю',  'Ya' => 'Я'
                );
                return strtr($string, $converter);
                
            } catch (Exception $e) {
                return('error');
            }
        }
        
        function rus_2_translit($string) {
            $converter = array(
                'а' => 'a',   'б' => 'b',   'в' => 'v',
                'г' => 'g',   'д' => 'd',   'е' => 'e',
                'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
                'и' => 'i',   'й' => 'y',   'к' => 'k',
                'л' => 'l',   'м' => 'm',   'н' => 'n',
                'о' => 'o',   'п' => 'p',   'р' => 'r',
                'с' => 's',   'т' => 't',   'у' => 'u',
                'ф' => 'f',   'х' => 'h',   'ц' => 'c',
                'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
                'ь' => '\'',  'ы' => 'y',   'ъ' => '\'',
                'э' => 'e',   'ю' => 'yu',  'я' => 'ya',
                
                'А' => 'A',   'Б' => 'B',   'В' => 'V',
                'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
                'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
                'И' => 'I',   'Й' => 'Y',   'К' => 'K',
                'Л' => 'L',   'М' => 'M',   'Н' => 'N',
                'О' => 'O',   'П' => 'P',   'Р' => 'R',
                'С' => 'S',   'Т' => 'T',   'У' => 'U',
                'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
                'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
                'Ь' => '\'',  'Ы' => 'Y',   'Ъ' => '\'',
                'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
            );
            return strtr($string, $converter);
        }
        
        function write_data_to_file($file_path, $data_array) {

            $data_array = serialize($data_array);
            file_put_contents($file_path, $data_array);
            $fp = fopen ($file_path, "w"); // Открытие файла на чтение
            fwrite($fp, $data_array);
            fclose($fp);
            return $data_array;
            
        }        
        
        function read_data_from_file($file_path, $serial_mode) {    

            $data = file_get_contents($file_path);
            $data_array = ($serial_mode == 0) ? ($data) : unserialize($data);
            return $data_array;
            
        }

        function GETRequestSaverToFile($file_name, $data_array) {    

            $data_array = serialize($data_array);
            
            // Запись в файл общий файл //

            file_put_contents($file_name, $data_array);
            // Запись в уникальный файл //
            $fp = fopen ($file_name, "w"); // Открытие файла на чтение
            fwrite($fp, $data_array);
            fclose($fp);
            
        } 
        
        function ReadDataFromFile($file_path) {    

            // Чтение.
            $data = file_get_contents($file_path);
            $data_array = unserialize($data);
            
            return $data_array;
            
        }
		
		function html_wrap_former($hedader_or_footer) {
			
			$header_html = '
			<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
			<!--<meta http-equiv="refresh" content="15">-->
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			</head>
			<body style="background: #FFFFFF; color: #000000;"><!--color: #00FF90;">-->
			';
			
			$footer_html = '
			</body>
			</html>';
			
			if ($hedader_or_footer == '0') {
				print_r($header_html);
			}
			else if($hedader_or_footer =='1'){
				print_r($footer_html);
			}	
			
			return true;
		}
    
    }

?>

