<?php
/**
 * Created by PhpStorm.
 * User: sau
 * Date: 11.05.18
 * Time: 13:53
 */

namespace Sau\WP\Theme\SimpleRouter;


use Sau\Lib\Base\BaseAction;

class RouteAction extends BaseAction {
	/**
	 * Hook for Route
	 * @param callable $callback First callable param it`s object RouteCollector
	 */
	public static function sauSimpleRoute( $callback ) {
		self::action( 'sau_simple_route', $callback );
	}
}