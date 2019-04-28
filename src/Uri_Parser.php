<?php

namespace WP_Router;

class Uri_Parser {
    /**
     * Separate class namespace and it's method from a given string.
     *
     * @param  string $str (This contains a class namespace and a method
     * name. These two things are separated by @ symbol in the string.)
     *
     * @return array (Array of two elements where first element is a class namespace
     * and second element is a method name if the given name is in valid format;
     * otherwise throws exception.)
     */
    public function class_method_separation( $str ) {
        $handler = explode( '@', $str );

        if (count( $handler ) === 2) {
            return $handler;
        }

        if (count( $handler ) === 1 && function_exists($handler[0])) {
            return [null, $handler[0]];
        }
        return new \WP_Error( 'WP_Router', __( str_replace( '/', '\\', $str ) . " is not a valid route handler", "wp_router" ) );
    }

    /**
     * Make class from the given string and check for it's existence.
     *
     * @param  string $str (Namespace for a class given as string.)
     *
     * @return string (Callable namespace of the given string of a class
     * if exists; otherwise throws exception.)
     */
    public function get_controller( $str = null ) {
        if ($str == null) {
            return null;
        }
        $class = str_replace( '/', '\\', $str );

        if ( class_exists( $class ) ) {
            return $class;
        }

        return new \WP_Error( 'WP_Router', __( $class . " is not found", "wp_router" ) );
    }

    /**
     * Check for existence of a method in a class.
     *
     * @param  string $controller (Namespace for a class.)
     *
     * @param  string $method (Method name in a class.)
     *
     * @return string (Valid method name of the given class if exists;
     * otherwise throws exception.)
     */
    public function get_method( $controller, $method ) {
        if ($controller == null && function_exists($method)) {
            return $method;
        }
        $obj = new $controller();

        if ( method_exists( $obj, $method ) ) {
            return $method;
        }

        return new \WP_Error( 'WP_Router', __( 'Method, ' . $method . ', is not defined ' . 'in ' . $controller, "wp_router" ) );
    }

    /**
     * Convert uri string (of route files) to WP rest api url.
     *
     * @param  string $uri (This will look like uris defined in the route files.)
     *
     * @return string (WP rest api url like string.)
     */
    public function convert_to_wp_uri( $uri ) {
        // pattern for valid identifier name enclosed by {}
        $pattern = '/\{[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]+\}/';

        $uri = preg_replace_callback( $pattern, function ( $matches ) {
            return '(?P<' . trim( $matches[0], '{}' ) . '>\d+)';
        }, $uri );

        return $uri;
    }
}