<?php

	class db_class  {
        
        CONST CSV_DIVIDER = ";";
        CONST VB_NEW_LINE = "\n";
        CONST SLASH_FORWARD = '/'; 

		public function __construct($db_object) {
		
		}
		
		function read_array_from_table ($table_data) {
			
			$row_count = 0;
			while ($row = $table_data -> fetch_assoc()) {
				$row_array[$row_count] = $row;
				$row_count++;
			}
			
			return $row_array;
			
		}

        public static function array_to_sql_data ($data_array) {
            
            try{
                
                $main_count = 0; $query_data = '';
                foreach ($data_array as $data_key => $data) {
                   $comma = ($main_count == count($data_array) - 1) ? '' : ', ';
                   $query_data .= '`'.$data_key.'` = "'.$data.'"'.$comma;
                   $main_count++;
                }
                
            }
            
            catch (Exception $e) {
                print_r($e -> getMessage());
				return('error');
			}
            
            return $query_data;
        }
        
	}

?>