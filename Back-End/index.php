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

    require_once 'config/database.php';
    require_once 'routes/router.php';
    require_once 'models/MovieModel.php';
    require_once 'models/RoomModel.php';
    require_once 'models/ScreeningModel.php';
    require_once 'controllers/MovieController.php';
    require_once 'controllers/RoomController.php';
    require_once 'controllers/ScreeningController.php'; 
        // calling my backend files

    $db = new Database(); // initializing database and getting connection and it's a class instance
    $router = new Router();
        // initializing database and router files

    $route = $router->match($_SERVER['REQUEST_METHOD'], $url);
        // matching the route with method and url

    if (!$route) { // if no route matched
        http_response_code(404);
        echo json_encode(["error" => "Route ain't found"]); // 400 to 500 range errors
    exit;
    }
        // handling 404 error route not found

    $controller = new $route['controller']($db->getConnection()); // initializing the controller with database connection
    call_user_func_array([$controller, $route['action']], $route['params']); // static call to a function with an array of parameters
        // calling the controller and action with parameters
