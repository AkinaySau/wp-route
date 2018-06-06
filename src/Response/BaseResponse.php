<?php
/**
 * Created by PhpStorm.
 * User: sau
 * Date: 04.06.18
 * Time: 17:52
 */

namespace Sau\WP\Theme\SimpleRouter\Response;


abstract class BaseResponse {
	protected $data;

	final public function __construct( array $data ) {
		$this->data = $data;
	}

	abstract public function response();

	function setupData() {
		global $sau_system;
		$sau_system = $this->data;
	}
}