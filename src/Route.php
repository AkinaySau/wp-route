<?php
/**
 * Created for WP-Route.
 * User: AkinaySau akinaysau@gmail.ru
 * Date: 24.10.2017
 * Time: 11:30
 */

namespace Sau\WP\Theme\SystemFrontendPages;

use Exception;
use Sau\Lib\Action;
use function array_key_exists;

final class Route {
	private static $routes = [];
	private $route;

	function __construct() {
		//add routers in global WP_Query
		Action::parseQuery( function ( $query ) {
			set_query_var( 'route', self::$routes );
			$this->route = $query->query['pagename'];
		} );
		Action::templateInclude( function ( $template ) {
			if ( $construct = array_search( $this->route, static::$routes ) )
			{
				$construct = explode( '.', $construct );
				try
				{
					include get_stylesheet_directory() . '/controllers/' . $construct[0] . '.php';
					$controller = new $construct[0];
					if ( method_exists( $controller, $construct[1] ) )
					{
						$response = $controller->{$construct[1]}();
					}
					else
					{
						$error_message = __( 'Controller %1$s: method %2$s is not exist', 'sau_system' );
						throw new Exception( sprintf( $error_message, SHelper::textStrong( $construct[0] ), SHelper::textStrong( $construct[1] ) ) );
					}
					if ( ! $response instanceof Response )
					{
						$error_message = __( '%1$s.%2$s is not return Response', 'sau_system' );
						throw new Exception( sprintf( $error_message, $construct[0], $construct[1] ) );
					}
					else
					{
						$response->setupData();
						if ( ! $response->isEmptyTemplate() )
						{
							$template = $response;
						}

					}
				}
				catch ( Exception $exception )
				{
					wp_die( $exception->getMessage() );
				}
			}

			return $template;
		} );
	}

	/**
	 * Added fixing route in project.
	 *
	 * @param string $name  Key route it`s name controller and action in it.
	 *                      Sample: controller.action
	 *
	 *                      controller - file and class must have one name
	 *
	 * @param string $route Route for call in controller.
	 *                      Sample: user/login
	 */
	static function add( $name, $route ) {
		Action::init( function () use ( $name, $route ) {
			if ( ! array_key_exists( $name, self::$routes ) )
			{
				self::$routes[$name] = $route;
			}
		} );

	}

	static function remove( $name ) {
		Action::init( function () use ( $name ) {
			if ( array_key_exists( $name, self::$routes ) )
			{
				unset ( self::$routes[$name] );
			}
		} );

	}

	static function get( $name ) {
		if ( array_key_exists( $name, self::$routes ) )
		{
			return self::$routes[$name];
		}

		return false;
	}

}