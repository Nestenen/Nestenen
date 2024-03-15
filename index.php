<?php
    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);

    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST');
    header("Access-Control-Allow-Headers: X-Requested-With");
	
	require_once('classes/crest.php');
    require_once('classes/help_class.php');
    require_once('classes/request_class.php');
	require_once('classes/db_class.php');

    CONST MODULE_VERTION = '1.0.0.0';
    
    CONST DB_FILE_PATH = 'db/main.db';
	
    CONST CSV_DIVIDER = ";";
    CONST VB_NEW_LINE = "\n";
    CONST SLASH_FORWARD = '/';

	use Psr\Http\Message\ResponseInterface as Response;
	use Psr\Http\Message\ServerRequestInterface as Request;
	
	use Slim\Factory\AppFactory;
	use Slim\Views\Twig;
	use Slim\Views\TwigMiddleware;
    use Slim\Routing\RouteCollectorProxy;
	
    
    
	use Slim\Views\PhpRenderer;
	
	require_once('slim/autoload.php');
    
	
    // Db library //
	
    require_once('db_class/src/Mysql/Statement.php');
    require_once('db_class/src/Mysql/Mysql.php');
    require_once('db_class/src/Mysql/Exception.php');
    
    use Krugozor\Database\Mysql\Mysql as Mysql;
	
    $help_class = new HelpClass;
    $requests_class = new requests_class;
    

    
    mysqli_report(MYSQLI_REPORT_ERROR);
    $db =  new mysqli('localhost', 'main_user', 'main_user_pass', 'main_base');
    mysqli_set_charset($db, 'utf8mb4');
    $error = $db -> connect_error;
    
    if ($db -> connect_error){
        
        die('Ошибка: '.$error);
        
    }
	
    $db_class = new db_class($db);

    // Slim app params //

	$app = AppFactory :: create();
	$app -> addErrorMiddleware(true, true, true);
	$app -> setBasePath(preg_replace('/(.*)\/.*/', '$1', $_SERVER['SCRIPT_NAME']));

	$twig = Slim\Views\Twig :: create('src/templates/', ['cache' => false]); // Create Twig //
	$app -> add(TwigMiddleware :: create($app, $twig)); // Add Twig-View Middleware //
    
    $app -> addBodyParsingMiddleware();
    $app -> addRoutingMiddleware();
    $app -> addErrorMiddleware(true, true, true);

	
    // Routs //
    
    // Main route //

    $app -> post('/', function(request $post_request, response $response) use($db, $db_class) {});

    $app -> get('/', function(request $post_request, response $response) use($db, $db_class) {
		$header = '<div style="margin: 50px 30% 0 30%; min-width: 350px; border: 1px dotted black;"><h2 style="padding: 10px; margin: 10px auto 10px auto; text-align: center;">Наше новое приложение</h2></div>';
		$response -> getBody() -> write($header);
		return $response;
		
    });
	
	// Templates //
    
    $app -> get('/telegram_app', function (request $request, response $response) use($help_class, $requests_class, $db, $db_class) {
		$params['title'] = 'Полноценное приложение';
		$php_view = new PhpRenderer('src/templates/');
		return $php_view -> render($response, 'telegram_app.phtml', ['params' => $params]);
	});
	
	$app -> post('/telegram_app', function (request $request, response $response) use($help_class, $requests_class, $db, $db_class) {
		$params['title'] = 'Полноценное приложение';
		$php_view = new PhpRenderer('src/templates/');
		return $php_view -> render($response, 'telegram_app.phtml', ['params' => $params]);
	});
    
    $app -> get('/telegram_install', function (Request $request, Response $response, $args) use($db, $db_class) {
		$params['title'] = 'Установка приложения';
		$php_view = new PhpRenderer('src/templates/');
		return $php_view -> render($response, 'telegram_install.phtml', ['params' => $params]);
	});
    
    $app -> post('/telegram_install', function (Request $request, Response $response, $args) use($db, $db_class) {
		$params['title'] = 'Установка приложения';
		$php_view = new PhpRenderer('src/templates/');
		return $php_view -> render($response, 'telegram_install.phtml', ['params' => $params]);
	});
    
    $app -> get('/database', function (Request $request, Response $response, $args) use($help_class, $requests_class, $db, $db_class) {
        
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
        
        $db_data = $db -> query('SELECT * FROM `'.$db_name.'`');
        $data_array = $db_class -> read_array_from_table($db_data);
        print_r(json_encode ($data_array));
        
        return $response;
        
    });
    
    $app -> post('/telegram', function (Request $request, Response $response, $args) use($db, $db_class) {
		
        

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
        
        $request_array = $request -> getParsedBody();
        $log = telegram_class :: writeLogFile($request_array, false);
        $tg_mesaage = file_get_contents('php://input');
        $json_decode = json_decode($tg_mesaage);
        $token = '';
        $tg_mesaage_inputString = $json_decode['inputString'];
        $tg_mesaage_inputuser = $json_decode['inputUser'];
        
        $db_name = 'Users';
        
        $log = telegram_class :: writeLogFile($tg_mesaage_inputString, false);
        
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
        print_r(json_encode ($data_array_2));
        
        return $response;
        
	});
    
    $app -> post('/replace', function (Request $request, Response $response, $args) use($help_class, $requests_class, $db, $db_class) {
        
        $replace_array = $request -> getParsedBody();
        print_r('<pre>');  print_r('replace_array: '); print_r($replace_array); print_r('</pre>');
        $user_id = $replace_array['id'];
        $associated_user = $replace_array['associated_user'];
        
        
        if (!empty(trim($associated_user))) {
            
            $update_array['associated_user'] = $associated_user;
            
        }
        
        if (!empty(trim($associated_user))) {
            
            $db_name = 'Users';
            $db_update = $db -> query('UPDATE `'.$db_name.'` SET '.db_class :: array_to_sql_data($update_array).' WHERE `id` = '.$user_id);
        }

        print_r('<pre>');  print_r('response: '); print_r($db_update); print_r('</pre>');
        return $response;
    });



	// App start //

	try {
		$app -> run();
	} catch (Exception $e) {
	  	die(['status' => 'failed', 'message' => 'This action is not allowed']);
	}


?>