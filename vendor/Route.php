<?php

class Route {
    
    private static $routes = array();

    public static function register($key, $rules, $map = array())
    {
        $element_count = count($rules);
        if ($element_count < 2) throw new RouteException('Route Register Error!');
        list($match, $route) = $rules;
        if (substr($match, 0, 1) != '#') {
            $match = '#' . $match; 
        }
        if (substr($match, -1, 1) != '#') {
            $match .= '#'; 
        }
        // Dispatch Controller与Action
        $route = explode('@', $route);
        $route = array('controller' => $route[0], 'action' => $route[1]);
        // self::$routes[$key] = new Yaf\Route\Regex($match, $route, $map); 
        self::$routes[$key] = array($match, $route, $map); 

    }
    
    public static function getRoute()
    {
        return self::$routes; 
    }
    

    public static function setRoute($key, $rule)
    {
        self::$routes[$key] = $rule; 
    }

}
class RouteException extends Exception {}
# Route::register('apc', array('#exapmple#', 'model@rmv'));
# Route::register('apc1', array('#exapmple#', 'model@rmv'));
# Route::register('apc2', array('#exapmple#', 'model@rmv'));

Route::register('example', array('#example_1#', 'Example@index'), array());

$routes = Route::getRoute();

print_r($routes);

