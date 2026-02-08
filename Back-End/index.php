<?php  
    $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); 
        // get requested URL path and parse it with parse_url function to extract the path component

    if (strpos($url, '/api') !== 0) {
        $file = __DIR__ . '/../Front-End' . ($url === '/' ? '/index.html' : $url); // map to FrontEnd directory and default to index.html
        if (is_file($file)) { // if the file exists
            header('Content-Type: ' . mime_content_type($file)); // set the correct content type
            readfile($file); // serve the file
            exit;
        }
    }

    header('Content-Type: application/json');
        // force json for api responses

    require_once __DIR__ . '/config/database.php';
    require_once __DIR__ . '/routes/router.php';
    require_once __DIR__ . '/models/movieModel.php';    
    require_once __DIR__ . '/models/roomModel.php';
    require_once __DIR__ . '/models/screeningModel.php';
    require_once __DIR__ . '/controllers/movieController.php';
    require_once __DIR__ . '/controllers/roomController.php';
    require_once __DIR__ . '/controllers/screeningController.php';
        // calling my backend files

    $db = new Database(); // initializing database and getting connection and it's a class instance
    $pdo = $db->getConnection(); 

    $router = new Router();
    $route = $router->match($_SERVER['REQUEST_METHOD'], $url);

    if (!$route) { // if no route matched
        http_response_code(404);
        echo json_encode(["error" => "Route ain't found"]); // 400 to 500 range errors
        exit;
    }
        // handling 404 error route not found

    $controller = new $route['controller']($pdo); // initializing the controller with database connection
    call_user_func_array([$controller, $route['action']], $route['params']); // static call to a function with an array of parameters
        // calling the controller and action with parameters
