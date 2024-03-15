<?php
	require_once('classes/crest.php');
    require_once('classes/help_class.php');
    require_once('classes/request_class.php');
	require_once('classes/db_class.php');

    CONST MODULE_VERTION = '1.0.0.0';
    
    CONST DB_FILE_PATH = 'db/main.db';
	
    CONST CSV_DIVIDER = ";";
    CONST VB_NEW_LINE = "\n";
    CONST SLASH_FORWARD = '/';
    
    // Db library //
	
    require_once('db_class/src/Mysql/Statement.php');
    require_once('db_class/src/Mysql/Mysql.php');
    require_once('db_class/src/Mysql/Exception.php');
    
    use Krugozor\Database\Mysql\Mysql as Mysql;
	

    mysqli_report(MYSQLI_REPORT_ERROR);
    $db =  new mysqli('localhost', 'main_user', 'main_user_pass', 'main_base');
    mysqli_set_charset($db, 'utf8mb4');
    $error = $db -> connect_error;
    
    $db_class = new db_class($db);
    
    if ($db -> connect_error){
        
        die('Ошибка: '.$error);
        
    }
	

    // Telegram app
    Class telegram_class {
        
        public static function send_message ($text, $chat_id, $token) {
            
            try {
                
                $text = urlencode($text);
                $chat_id = str_replace('\'', '', $chat_id);
                $urlQuery = file_get_contents('https://api.telegram.org/bot'.$token.'/sendMessage?chat_id='.$chat_id.'&text='.$text);
                
            }
            
            catch (Exception $e) {
                return -1;
            }
        }
        
        public static function writeLogFile($string, $clear = false){
            $log_file_name = 'src/message.txt';
            if ($clear == false) {
                file_put_contents($log_file_name, ' '.print_r($string, true).'\r\n', FILE_APPEND);
            } 
            else {
                file_put_contents($log_file_name, '');
                file_put_contents($log_file_name, ' '.print_r($string, true).'\r\n', FILE_APPEND);
            }
        }
        
        public static function setSimbols($data){
            
            $data = '\''.$data.'\'';
            return $data;
            
        }
        
    }
    
    $data = file_get_contents('php://input');
    $data = json_decode($data, true);
    
    $token = '';
    $tg_mesaage_inputString = $data['inputString'];
    $tg_mesaage_inputuser = $data['inputUser'];
    
    $db_name = 'Users';

    $db_data = $db -> query('SELECT * FROM `'.$db_name.'`');
    $data_array = $db_class -> read_array_from_table($db_data);
    foreach ($data_array as $row) {
        
        $exist_check = file_get_contents('https://api.telegram.org/bot6726375497:AAH-Fd-lKAN3fOKA7Tf87ixY4BlKFaPDSzo/getChat?chat_id='.$row['chat_id']);
        $exist_check = json_decode($exist_check, true);
        
        if ($exist_check == false) {
            
            $db -> query('DELETE FROM `'.$db_name.'` WHERE `chat_id` = \''.$row['chat_id'].'\'');
            
        } elseif ($exist_check['ok'] != 1) { 
        
            $db -> query('DELETE FROM `'.$db_name.'` WHERE `chat_id` = \''.$row['chat_id'].'\'');
            
        }  
    }
    
    $db_data_2 = $db -> query('SELECT * FROM `'.$db_name.'` WHERE `associated_user` = \''.$tg_mesaage_inputuser.'\'');
    $data_array_2 = $db_class -> read_array_from_table($db_data_2);
    $tg_start2 = telegram_class :: send_message($tg_mesaage_inputString, $data_array_2[0]['chat_id'], $token);

?>