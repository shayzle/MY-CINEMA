<?php

// connecting routes to controllers and actions
// need to include this router.php file in index.php and to the controllers


class Router {

    public function match(string $method, string $url): ?array { // returns either an array or null

        $path = parse_url($url, PHP_URL_PATH); // get the path part of the URL

        $path = str_replace('/My_Cinema_Web@cadémie/Back-End', '', $path); // adjust the base path according to your setup
        $path = rtrim($path, '/'); // remove trailing slash for consistency


        
        // MOVIES

        // GET /controllers/movies --> pour tous les movies
            if ($method === 'GET' && $path === '/controllers/movies') { // pour tous les movies without id
                return [ // returning an array with controller, action and params
                    'controller' => 'MovieController', 
                    'action' => 'index', // action comes from the MovieController.php file
                    'params' => [] // no parameters
                ];
            }

        // GET /controllers/movies/ --> pour un seul movie
            if ($method === 'GET' && preg_match('#^/controllers/movies/(\d+)$#', $path, $matches)) { // pour un seul movie with id et preg_match to extract the id from the URL
                return [ // returning an array with controller, action and params
                    'controller' => 'MovieController',
                    'action' => 'show',
                    'params' => [(int) $matches[1]]
                ];
            }

        // POST /controllers/movies --> pour ajouter un movie
            if ($method === 'POST' && $path === '/controllers/movies') { // adding a movie without id
                return [ // returning an array with controller, action and params
                    'controller' => 'MovieController', 
                    'action' => 'store',
                    'params' => [json_decode(file_get_contents('php://input'), true)] // getting the input data from the request body to pass it to the controller and action to create a new movie because POST request has no URL parameters
                ];
            }

        // PUT /controllers/movies/ --> pour modifier un movie
            if ($method === 'PUT' && preg_match('#^/controllers/movies/(\d+)$#', $path, $matches)) { // preg_match to extract the id from the URL and update with id from the URL
                return [
                    'controller' => 'MovieController',
                    'action' => 'update',
                    'params' => [
                        (int) $matches[1], // id from the URL
                        json_decode(file_get_contents('php://input'), true) // input data from the request body
                    ]
                ];
            }

        // DELETE /controllers/movies/ --> pour supprimer un movie
            if ($method === 'DELETE' && preg_match('#^/controllers/movies/(\d+)$#', $path, $matches)) { // delete with id from the URL
                return [
                    'controller' => 'MovieController',
                    'action' => 'destroy',
                    'params' => [(int) $matches[1]] // id from the URL
                ];
            }



        // ROOMS

        // GET /controllers/rooms --> pour tous les rooms
            if ($method === 'GET' && $path === '/controllers/rooms') {
                return [
                    'controller' => 'RoomController',
                    'action' => 'index',
                    'params' => []
                ];
            }

        // POST /controllers/rooms --> pour ajouter un room
            if ($method === 'POST' && $path === '/controllers/rooms') {
                return [
                    'controller' => 'RoomController',
                    'action' => 'store',
                    'params' => [json_decode(file_get_contents('php://input'), true)]
                ];
            };



        // SCREENINGS

        // GET /controllers/screenings --> pour tous les screenings
            if ($method === 'GET' && $path === '/controllers/screenings') {
                return [
                    'controller' => 'ScreeningController',
                    'action' => 'index',
                    'params' => []
                ];
            }

        // POST /controllers/screenings --> pour ajouter un screening
            if ($method === 'POST' && $path === '/controllers/screenings') {
                return [
                    'controller' => 'ScreeningController', // controller name and action name must match the actual class and method names
                    'action' => 'store',
                    'params' => [json_decode(file_get_contents('php://input'), true)]
                ];
            };


        
            return null;
        }
    }
