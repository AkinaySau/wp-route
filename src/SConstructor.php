<?php
/**
 * Created for WP-Route.
 * User: AkinaySau akinaysau@gmail.ru
 * Date: 25.10.2017
 * Time: 12:06
 */

namespace Sau\WP\Theme\SystemFrontendPages;

use Sau\Lib\Filter;

class SConstructor {
	/**
	 * @param string $title Taking this var for change title in page
	 */
	private function title( string $title ) {
		Filter::preGetDocumentTitle( function () use ( $title ) {
			return $title;
		} );
	}
}