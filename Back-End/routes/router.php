<?php

class Router {

    public function match(string $method, string $url): ?array {

        $path = parse_url($url, PHP_URL_PATH);
        $path = rtrim($path, '/');



        // MOVIES

        // GET all movies
        if ($method === 'GET' && $path === '/api/movies') {
            return [
                'controller' => 'movieController',
                'action' => 'index',
                'params' => []
            ];
        }

        // GET one movie
        if ($method === 'GET' && preg_match('#^/api/movies/(\d+)$#', $path, $m)) {
            return [
                'controller' => 'movieController',
                'action' => 'read',
                'params' => [(int)$m[1]]
            ];
        }

        // POST movie
        if ($method === 'POST' && $path === '/api/movies') {
            return [
                'controller' => 'movieController',
                'action' => 'create',
                'params' => [json_decode(file_get_contents('php://input'), true)]
            ];
        }

        // PUT movie
        if ($method === 'PUT' && preg_match('#^/api/movies/(\d+)$#', $path, $m)) {
            return [
                'controller' => 'movieController',
                'action' => 'update',
                'params' => [
                    (int)$m[1],
                    json_decode(file_get_contents('php://input'), true)
                ]
            ];
        }

        // DELETE movie
        if ($method === 'DELETE' && preg_match('#^/api/movies/(\d+)$#', $path, $m)) {
            return [
                'controller' => 'movieController',
                'action' => 'delete',
                'params' => [(int)$m[1]]
            ];
        }



        // ROOMS

        // GET all rooms
        if ($method === 'GET' && $path === '/api/rooms') {
            return [
                'controller' => 'roomController',
                'action' => 'index',
                'params' => []
            ];
        }

        // GET one room
        if ($method === 'GET' && preg_match('#^/api/rooms/(\d+)$#', $path, $m)) {
            return [
                'controller' => 'roomController',
                'action' => 'read',
                'params' => [(int)$m[1]]
            ];
        }

        // POST room
        if ($method === 'POST' && $path === '/api/rooms') {
            return [
                'controller' => 'roomController',
                'action' => 'create',
                'params' => [json_decode(file_get_contents('php://input'), true)]
            ];
        }

        // PUT room
        if ($method === 'PUT' && preg_match('#^/api/rooms/(\d+)$#', $path, $m)) {
            return [
                'controller' => 'roomController',
                'action' => 'update',
                'params' => [
                    (int)$m[1],
                    json_decode(file_get_contents('php://input'), true)
                ]
            ];
        }

        // DELETE room
        if ($method === 'DELETE' && preg_match('#^/api/rooms/(\d+)$#', $path, $m)) {
            return [
                'controller' => 'roomController',
                'action' => 'delete',
                'params' => [(int)$m[1]]
            ];
        }

        

        // SCREENINGS

        // GET all screenings
        if ($method === 'GET' && $path === '/api/screenings') {
            return [
                'controller' => 'screeningController',
                'action' => 'index',
                'params' => []
            ];
        }

        // GET one screening
        if ($method === 'GET' && preg_match('#^/api/screenings/(\d+)$#', $path, $m)) {
            return [
                'controller' => 'screeningController',
                'action' => 'read',
                'params' => [(int)$m[1]]
            ];
        }

        // POST screening
        if ($method === 'POST' && $path === '/api/screenings') {
            return [
                'controller' => 'screeningController',
                'action' => 'create',
                'params' => [json_decode(file_get_contents('php://input'), true)]
            ];
        }

        // PUT screening
        if ($method === 'PUT' && preg_match('#^/api/screenings/(\d+)$#', $path, $m)) {
            return [
                'controller' => 'screeningController',
                'action' => 'update',
                'params' => [
                    (int)$m[1],
                    json_decode(file_get_contents('php://input'), true)
                ]
            ];
        }

        // DELETE screening
        if ($method === 'DELETE' && preg_match('#^/api/screenings/(\d+)$#', $path, $m)) {
            return [
                'controller' => 'screeningController',
                'action' => 'delete',
                'params' => [(int)$m[1]]
            ];
        }

        return null;
    }
}