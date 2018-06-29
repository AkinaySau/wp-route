<?php
/**
 * Created by PhpStorm.
 * User: sau
 * Date: 13.06.18
 * Time: 17:16
 */

namespace Sau\WP\Theme\SimpleRouter\Response;

use Exception;

class TwigResponse extends BaseResponse {
	protected $template = null;

	/**
	 * TwigResponse constructor.
	 *
	 * @param       $template
	 * @param array $data
	 *
	 * @throws Exception
	 */
	public function __construct( $template, array $data ) {
		if ( ! class_exists( 'Sau\WP\Theme\Extension\Twig\SauTwig' ) ) {
			throw new Exception( "Class 'Sau\WP\Theme\Extension\Twig\SauTwig' is not exist" );
		}

		$this->template = $template;
		parent::__construct( $data );
	}

	public function response() {
		$response = SauTwig::render( $this->template, $this->data );
		die( $response );

	}
}