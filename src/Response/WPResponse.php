<?php
/**
 * Created for WP-Route.
 * User: AkinaySau akinaysau@gmail.ru
 * Date: 25.10.2017
 * Time: 11:38
 */

namespace Sau\WP\Theme\SimpleRouter\Response;


use const DIRECTORY_SEPARATOR;
use Exception;

/**
 * Class WPResponse
 * @package Sau\WP\Theme\SimpleRouter
 */
class WPResponse extends BaseResponse {
	/**
	 * Base template for response
	 * @var string
	 */
	public $template = 'index.php';

	public function response() {
		if ( in_array( 'template', $this->data ) ) {
			$this->template = $this->data[ 'template' ];
		}

		$template = get_stylesheet_directory() . DIRECTORY_SEPARATOR . $this->template;
		if ( file_exists( $template ) ) {
			$new_template = $template;
			Action::templateInclude( function ( $template ) use ( $new_template ) {
				return $new_template;
			} );
		} else {
			throw new Exception( $template . ' is not exist' );
		}
	}

	public function isEmptyTemplate() {
		return $this->template === false;
	}


}