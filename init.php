<?php
/**
 * Created for WP-Route.
 * User: AkinaySau akinaysau@gmail.ru
 * Date: 25.10.2017
 * Time: 15:32
 */

use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;
use Sau\Lib\Action;
use Sau\WP\Theme\SimpleRouter\Response;
use Sau\WP\Theme\SimpleRouter\BaseController;
use Sau\WP\Theme\SimpleRouter\SHelper;

Action::afterSetupTheme( function () {
	$dispatcher = simpleDispatcher( function ( RouteCollector $r ) {
		/** @var RouteCollector $r */
		do_action( 'sau_simple_route', $r );
	} );

	$httpMethod = $_SERVER[ 'REQUEST_METHOD' ];
	$uri        = $_SERVER[ 'REQUEST_URI' ];

	$routeInfo = $dispatcher->dispatch( $httpMethod, $uri );
	switch ( $routeInfo[ 0 ] ) {
		case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
			throw new Exception( '405: method not allowed' );
			break;
		case FastRoute\Dispatcher::FOUND:
			//			try {
			$handler = explode( '.', $routeInfo[ 1 ] );
			$handler = [
				'controller' => $handler[ 0 ],
				'method'     => $handler[ 1 ],
			];
			$vars    = $routeInfo[ 2 ];


			if ( file_exists( $file = get_stylesheet_directory() . '/controllers/' . $handler[ 'controller' ] . '.php' ) ) {
				include $file;
				$controller = new $handler[ 'controller' ];
				if ( ! $controller instanceof BaseController ) {
					$error_message = 'Controller "%s" is not instance of BaseController';
					throw new Exception( sprintf( $error_message, $handler[ 'controller' ] ) );
				}
			} else {
				$error_message = 'Controller "%s" is not exist';
				throw new Exception( sprintf( $error_message, $handler[ 'controller' ] ) );
			}

			if ( method_exists( $controller, $handler[ 'method' ] ) ) {
				$response = $controller->{$handler[ 'method' ]}( $vars );
			} else {
				$error_message = 'Controller %1$s: method %2$s is not exist';
				throw new Exception( sprintf( $error_message, $handler[ 'controller' ], $handler[ 'method' ] ) );
			}

			if ( ! $response instanceof Response ) {
				$error_message = '%1$s.%2$s is not return Response';
				throw new Exception( sprintf( $error_message, $handler[ 'controller' ], $handler[ 'method' ] ) );
			} else {
				$response->setupData();
				if ( ! $response->isEmptyTemplate() ) {
					$new_template = $response;
					Action::templateInclude( function ( $template ) use ( $new_template ) {
						return $new_template;
					} );
				}
			}
			break;
	}
} );

