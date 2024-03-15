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
    $chat_id = telegram_class :: setSimbols ($data['message']['chat']['id']);
    $user_id = telegram_class :: setSimbols ($data['message']['from']['id']);
    $username = telegram_class :: setSimbols ($data['message']['from']['username']);
    $first_name = telegram_class :: setSimbols ($data['message']['from']['first_name']);
    $chat_type = $data['message']['chat']['type'];
    $incoming_text = $data['message']['text'];
    
    $textStart2 = 'Вы уже зарегистрированы в системе';
    $textStart1 = 'Регистрация прошла успешно';
    $textStartError = 'Обратитесь к админу, произошла ошибка: ';
    $helpMessage = 'Здесь лишь две команды, /help и /start, первая для вывода команд, вторая для регистрации и начала работы';
    
    $db_name = 'Users';

    $sql_registration = 'INSERT INTO `'.$db_name.'`(`chat_id`, `user_id`, `username`, `first_name`) VALUES ('.$chat_id.','.$user_id.','.$username.','.$first_name.')';
    $sql_group_registration = 'INSERT INTO `'.$db_name.'`(`chat_id`, `user_id`, `username`, `first_name`, `is_group`) VALUES ('.$chat_id.','.$user_id.','.$username.','.$first_name.',\''.$chat_type.'\')';
    $sql_select = 'SELECT * FROM `'.$db_name.'` WHERE `chat_id` = '.$chat_id;
    
    if ($chat_type == 'private') {
    
        switch($incoming_text) {
            
            case '/start':
            $result = $db -> query($sql_select);
            
            if ($result -> num_rows > 0) {
                
                $tg_start2 = telegram_class :: send_message($textStart2, $chat_id, $token);
                
            } else {
                
                if ($db -> query($sql_registration)) {
                    
                    $tg_start1 = telegram_class :: send_message($textStart1, $chat_id, $token);
                    
                } else { 
                
                    $tg_start_error = telegram_class :: send_message($textStartError.$db->error, $chat_id, $token);
                    
                }
            }
            break;
            
            case '/help':
            
            $tg_help = telegram_class :: send_message($helpMessage, $chat_id, $token);
            
            break;
        }
        
    } else {
        
        $result = $db -> query($sql_select);
        
        if ($result -> num_rows == 0) {
            
            $group_registration = $db -> query($sql_group_registration); 
            
        }
    }

?>