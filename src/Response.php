<?php
/**
 * Created for WP-Route.
 * User: AkinaySau akinaysau@gmail.ru
 * Date: 25.10.2017
 * Time: 11:38
 */

namespace Sau\WP\Theme\SystemFrontendPages;


use const DIRECTORY_SEPARATOR;

class Response {
	private $template;
	private $data;

	/**
	 * Template constructor.
	 *
	 * @param string $template
	 * @param array  $data
	 */
	function __construct( string $template = '', array $data = [] ) {
		$this->data = $data;
		$template   = get_stylesheet_directory() . DIRECTORY_SEPARATOR . $template;
		if ( file_exists( $template ) )
		{
			$this->template = $template;
		}

		return false;
	}

	public function __toString() {
		return $this->template;
	}

	public function isEmptyTemplate() {
		return $this->template === false;
	}

	function setupData() {
		global $sau_system;
		$sau_system = $this->data;
	}
}