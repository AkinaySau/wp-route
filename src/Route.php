<?php
/**
 * Created for WP-Route.
 * User: AkinaySau akinaysau@gmail.ru
 * Date: 24.10.2017
 * Time: 11:30
 */

namespace Sau\WP\Theme\SystemFrontendPages;

use Exception;
use function print_r;
use Sau\Lib\Action;
use function array_key_exists;
use function array_search;
use function explode;
use function get_stylesheet_directory;
use function method_exists;
use function set_query_var;
use function sprintf;
use function wp_die;

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
						$error_message = __( 'Controller $s%1: method $s%2 is not exist', 'sau_system' );
						throw new Exception( sprintf( $error_message, SHelper::textStrong( $controller[0] ), SHelper::textStrong( $controller[1] ) ) );
					}
					if ( ! $response instanceof Response )
					{
						throw new Exception( __( 'Controller is not return Response', 'sau_system' ) );
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
				catch ( Exception$exception )
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

}