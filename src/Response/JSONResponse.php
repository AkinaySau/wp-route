<?php
/**
 * Created by PhpStorm.
 * User: sau
 * Date: 06.06.18
 * Time: 11:39
 */

namespace Sau\WP\Theme\SimpleRouter\Response;


class JSONResponse extends BaseResponse {

	public function response() {
		wp_send_json( $this->data );
	}
}