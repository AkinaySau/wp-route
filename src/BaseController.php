<?php
/**
 * Created for WP-Route.
 * User: AkinaySau akinaysau@gmail.ru
 * Date: 25.10.2017
 * Time: 12:06
 */

namespace Sau\WP\Theme\SimpleRouter;

use Sau\Lib\Action;
use Sau\Lib\Filter;

/**
 * Class BaseController
 * @package Sau\WP\Theme\SimpleRouter
 */
abstract class BaseController {
	protected $data;


	protected function setStatus( $status ) {
		add_action( 'wp', function () use ( $status ) {
			status_header( $status );
		} );
	}

	/**
	 * @param array $data
	 */
	public function setData( array $data ) {
		$this->data = $data;
	}

	/**
	 * @return mixed
	 */
	public function getData() {
		return $this->data;
	}

	/**
	 * @param string $title Taking this var for change title in page
	 */
	protected function title( string $title ) {
		Action::init( function () use ( $title ) {
			Filter::preGetDocumentTitle( function () use ( $title ) {
				return $title;
			} );
		} );
	}
}