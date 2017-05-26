<?php
/**
 * Plugin Name: DX Recovery
 * Description: E-Mail users are link to automatically grant them access to their accounts
 * Version: 1.0
 * Author: Bojidar Valchovski
 * Author URI: http://devrix.com/
 * Text Domain: dx_loc
 * Domain Path: /languages
 * GitHub Plugin URI: https://github.com/valchovski/DX-recovery
 */

if ( ! class_exists( 'DX_Recovery' ) ) :
class DX_Recovery {

	public function __construct() {
		add_action( 'lost_password' , array( $this, 'dx_recovery_render_page' ) );
	}

	function dx_recovery_mail( $address ) {
		$address = sanitize_text_field( $address );

		if ( $address ):
			if ( $this->dx_recovery_email_used( $address ) ):
				$security_code = bin2hex( openssl_random_pseudo_bytes( 8 ) );
				var_dump( $security_code ); die();
			else:
			endif;
		endif;
	}


	function dx_recovery_render_page() {
		?> 
		<form action="" method="post">

			<label for="address">Email</label>

			<input type="address" name="address">

			<input type="submit" value="Submit">

		</form>
		<?php
	}

	function dx_recovery_email_used( $address ) {
		$users = new WP_User_Query( array(
		    'search'         => '*'.esc_attr( $address ).'*',
		    'search_columns' => array(
		        'user_login',
		        'user_nicename',
		        'user_email',
		        'user_url',
		    ),
		) );
		return $users->get_results();
	}

}

$dx_recovery = new DX_Recovery();

if ( ! empty( $_POST ) ) {
	$dx_recovery->dx_recovery_mail( $_POST['address'] );
}
endif;