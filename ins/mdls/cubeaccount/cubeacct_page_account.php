<?php
/**
 * CubeAccount Login Page
 * Builds the login pages
 * 
 * @package cubeaccount
 */

/**
 * Functions for various pages
 *
 * @return array
 */
function cubeacct_page_login(){
	return cubeacct_page_account('login');
}
function cubeacct_page_logout(){
	return cubeacct_page_account('logout');
}
function cubeacct_page_lostpassword(){
	return cubeacct_page_account('lostpassword');
}
function cubeacct_page_register(){
	return cubeacct_page_account('register');
}

/**
 * Builds the various pages that used to be handled by wp-login.php
 *
 * @return array
 */
function cubeacct_page_account($action=null) {

// use ob functions to capture output
ob_start();

$action = isset($action) ? $action : 'login';
$errors = new WP_Error();

if ( isset($_REQUEST['key']) )
	$action = 'resetpass';

// validate action so as to default to the login screen
if ( !in_array($action, array('logout', 'lostpassword', 'retrievepassword', 'resetpass', 'rp', 'register', 'login'), true) && false === has_filter('login_form_' . $action) )
	$action = 'login';

nocache_headers();

//Set a cookie now to see if they are supported by the browser.
setcookie(TEST_COOKIE, 'WP Cookie check', 0, COOKIEPATH, COOKIE_DOMAIN);
if ( SITECOOKIEPATH != COOKIEPATH )
	setcookie(TEST_COOKIE, 'WP Cookie check', 0, SITECOOKIEPATH, COOKIE_DOMAIN);

// allow plugins to override the default actions, and to add extra actions if they want
do_action( 'login_init' );
do_action( 'login_form_' . $action );

$http_post = ('POST' == $_SERVER['REQUEST_METHOD']);
switch ($action) {

case 'logout' :
	check_admin_referer('log-out');
	wp_logout();

	$redirect_to = !empty( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : 'wp-login.php?loggedout=true';
	wp_safe_redirect( $redirect_to );
	exit();

break;

case 'lostpassword' :
case 'retrievepassword' :

	if ( $http_post ) {
		$errors = retrieve_password();
		if ( !is_wp_error($errors) ) {
			$redirect_to = !empty( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : 'wp-login.php?checkemail=confirm';
			wp_safe_redirect( $redirect_to );
			exit();
		}
	}

	if ( isset($_REQUEST['error']) && 'invalidkey' == $_REQUEST['error'] ) $errors->add('invalidkey', __('Sorry, that key does not appear to be valid.'));
	$redirect_to = apply_filters( 'lostpassword_redirect', !empty( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : '' );

	do_action('lost_password');
	login_header(__('Lost Password'), '<p class="message">' . __('Please enter your username or email address. You will receive a link to create a new password via email.') . '</p>', $errors);

	$user_login = isset($_POST['user_login']) ? stripslashes($_POST['user_login']) : '';

?>

<form name="lostpasswordform" id="lostpasswordform" action="<?php echo site_url('wp-login.php?action=lostpassword', 'login_post') ?>" method="post">
	<p>
		<label><?php _e('Username or E-mail:') ?><br />
		<input type="text" name="user_login" id="user_login" class="input" value="<?php echo esc_attr($user_login); ?>" size="20" tabindex="10" /></label>
	</p>
<?php do_action('lostpassword_form'); ?>
	<input type="hidden" name="redirect_to" value="<?php echo esc_attr( $redirect_to ); ?>" />
	<p class="submit"><input type="submit" name="wp-submit" id="wp-submit" class="button-primary" value="<?php esc_attr_e('Get New Password'); ?>" tabindex="100" /></p>
</form>

<p id="nav">
<a href="<?php echo site_url('wp-login.php', 'login') ?>"><?php _e('Log in') ?></a>
<?php if (get_option('users_can_register')) : ?>
 | <a href="<?php echo site_url('wp-login.php?action=register', 'login') ?>"><?php _e('Register') ?></a>
<?php endif; ?>
</p>

<?php
login_footer('user_login');
break;

case 'resetpass' :
case 'rp' :
	$user = check_password_reset_key($_REQUEST['key'], $_REQUEST['login']);

	if ( is_wp_error($user) ) {
		wp_redirect( site_url('wp-login.php?action=lostpassword&error=invalidkey') );
		exit;
	}

	$errors = '';

	if ( isset($_POST['pass1']) && $_POST['pass1'] != $_POST['pass2'] ) {
		$errors = new WP_Error('password_reset_mismatch', __('The passwords do not match.'));
	} elseif ( isset($_POST['pass1']) && !empty($_POST['pass1']) ) {
		reset_password($user, $_POST['pass1']);
		login_header(__('Password Reset'), '<p class="message reset-pass">' . __('Your password has been reset.') . ' <a href="' . site_url('wp-login.php', 'login') . '">' . __('Log in') . '</a></p>');
		login_footer();
		// instead of exiting, we return
		global $cubeacct_page_title;
		$html .= ob_get_contents();
		ob_end_clean();
		$data['title'] = $cubeacct_page_title;
		$data['content'] = $html;
		return $data;
	}

	wp_enqueue_script('utils');
	wp_enqueue_script('user-profile');

	login_header(__('Reset Password'), '<p class="message reset-pass">' . __('Enter your new password below.') . '</p>', $errors );

?>
<form name="resetpassform" id="resetpassform" action="<?php echo site_url('wp-login.php?action=resetpass&key=' . urlencode($_REQUEST['key']) . '&login=' . urlencode($_REQUEST['login']), 'login_post') ?>" method="post">
	<input type="hidden" id="user_login" value="<?php echo esc_attr( $_REQUEST['login'] ); ?>" autocomplete="off" />

	<p>
		<label><?php _e('New password') ?><br />
		<input type="password" name="pass1" id="pass1" class="input" size="20" value="" autocomplete="off" /></label>
	</p>
	<p>
		<label><?php _e('Confirm new password') ?><br />
		<input type="password" name="pass2" id="pass2" class="input" size="20" value="" autocomplete="off" /></label>
	</p>

	<div id="pass-strength-result" class="hide-if-no-js"><?php _e('Strength indicator'); ?></div>
	<p class="description indicator-hint"><?php _e('Hint: The password should be at least seven characters long. To make it stronger, use upper and lower case letters, numbers and symbols like ! " ? $ % ^ &amp; ).'); ?></p>

	<br class="clear" />
	<p class="submit"><input type="submit" name="wp-submit" id="wp-submit" class="button-primary" value="<?php esc_attr_e('Reset Password'); ?>" tabindex="100" /></p>
</form>

<p id="nav">
<a href="<?php echo site_url('wp-login.php', 'login') ?>"><?php _e('Log in') ?></a>
<?php if (get_option('users_can_register')) : ?>
 | <a href="<?php echo site_url('wp-login.php?action=register', 'login') ?>"><?php _e('Register') ?></a>
<?php endif; ?>
</p>

<?php
login_footer('user_pass');
break;

case 'register' :
	if ( is_multisite() ) {
		// Multisite uses wp-signup.php
		wp_redirect( apply_filters( 'wp_signup_location', site_url('wp-signup.php') ) );
		exit;
	}

	if ( !get_option('users_can_register') ) {
		wp_redirect( site_url('wp-login.php?registration=disabled') );
		exit();
	}

	$user_login = '';
	$user_email = '';
	if ( $http_post ) {
		$user_login = $_POST['user_login'];
		$user_email = $_POST['user_email'];
		$errors = register_new_user($user_login, $user_email);
		if ( !is_wp_error($errors) ) {
			$redirect_to = !empty( $_POST['redirect_to'] ) ? $_POST['redirect_to'] : 'wp-login.php?checkemail=registered';
			wp_safe_redirect( $redirect_to );
			exit();
		}
	}

	$redirect_to = apply_filters( 'registration_redirect', !empty( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : '' );
	login_header(__('Registration Form'), '<p class="message register">' . __('Register For This Site') . '</p>', $errors);
?>

<form name="registerform" id="registerform" action="<?php echo site_url('wp-login.php?action=register', 'login_post') ?>" method="post">
	<p>
		<label><?php _e('Username') ?><br />
		<input type="text" name="user_login" id="user_login" class="input" value="<?php echo esc_attr(stripslashes($user_login)); ?>" size="20" tabindex="10" /></label>
	</p>
	<p>
		<label><?php _e('E-mail') ?><br />
		<input type="text" name="user_email" id="user_email" class="input" value="<?php echo esc_attr(stripslashes($user_email)); ?>" size="25" tabindex="20" /></label>
	</p>
<?php do_action('register_form'); ?>
	<p id="reg_passmail"><?php _e('A password will be e-mailed to you.') ?></p>
	<br class="clear" />
	<input type="hidden" name="redirect_to" value="<?php echo esc_attr( $redirect_to ); ?>" />
	<p class="submit"><input type="submit" name="wp-submit" id="wp-submit" class="button-primary" value="<?php esc_attr_e('Register'); ?>" tabindex="100" /></p>
</form>

<p id="nav">
<a href="<?php echo site_url('wp-login.php', 'login') ?>"><?php _e('Log in') ?></a> |
<a href="<?php echo site_url('wp-login.php?action=lostpassword', 'login') ?>" title="<?php _e('Password Lost and Found') ?>"><?php _e('Lost your password?') ?></a>
</p>

<?php
login_footer('user_login');
break;

case 'login' :
default:
	$secure_cookie = '';
	$interim_login = isset($_REQUEST['interim-login']);

	// If the user wants ssl but the session is not ssl, force a secure cookie.
	if ( !empty($_POST['log']) && !force_ssl_admin() ) {
		$user_name = sanitize_user($_POST['log']);
		if ( $user = get_userdatabylogin($user_name) ) {
			if ( get_user_option('use_ssl', $user->ID) ) {
				$secure_cookie = true;
				force_ssl_admin(true);
			}
		}
	}

	if ( isset( $_REQUEST['redirect_to'] ) ) {
		$redirect_to = $_REQUEST['redirect_to'];
		// Redirect to https if user wants ssl
		if ( $secure_cookie && false !== strpos($redirect_to, 'wp-admin') )
			$redirect_to = preg_replace('|^http://|', 'https://', $redirect_to);
	} else {
		$redirect_to = admin_url();
	}

	$reauth = empty($_REQUEST['reauth']) ? false : true;

	// If the user was redirected to a secure login form from a non-secure admin page, and secure login is required but secure admin is not, then don't use a secure
	// cookie and redirect back to the referring non-secure admin page.  This allows logins to always be POSTed over SSL while allowing the user to choose visiting
	// the admin via http or https.
	if ( !$secure_cookie && is_ssl() && force_ssl_login() && !force_ssl_admin() && ( 0 !== strpos($redirect_to, 'https') ) && ( 0 === strpos($redirect_to, 'http') ) )
		$secure_cookie = false;

	$user = wp_signon('', $secure_cookie);

	$redirect_to = apply_filters('login_redirect', $redirect_to, isset( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : '', $user);

	if ( !is_wp_error($user) && !$reauth ) {
		if ( $interim_login ) {
			$message = '<p class="message">' . __('You have logged in successfully.') . '</p>';
			login_header( '', $message ); ?>
			<script type="text/javascript">setTimeout( function(){window.close()}, 8000);</script>
			<p class="alignright">
			<input type="button" class="button-primary" value="<?php esc_attr_e('Close'); ?>" onclick="window.close()" /></p>
			</div></body></html>
<?php		exit;
		}

		if ( ( empty( $redirect_to ) || $redirect_to == 'wp-admin/' || $redirect_to == admin_url() ) ) {
			// If the user doesn't belong to a blog, send them to user admin. If the user can't edit posts, send them to their profile.
			if ( is_multisite() && !get_active_blog_for_user($user->id) && !is_super_admin( $user->id ) )
				$redirect_to = user_admin_url();
			elseif ( is_multisite() && !$user->has_cap('read') )
				$redirect_to = get_dashboard_url( $user->id );
			elseif ( !$user->has_cap('edit_posts') )
				$redirect_to = admin_url('profile.php');
		}
		wp_safe_redirect($redirect_to);
		exit();
	}

	$errors = $user;
	// Clear errors if loggedout is set.
	if ( !empty($_REQUEST['loggedout']) || $reauth )
		$errors = new WP_Error();

	// If cookies are disabled we can't log in even with a valid user+pass
	if ( isset($_POST['testcookie']) && empty($_COOKIE[TEST_COOKIE]) )
		$errors->add('test_cookie', __("<strong>ERROR</strong>: Cookies are blocked or not supported by your browser. You must <a href='http://www.google.com/cookies.html'>enable cookies</a> to use WordPress."));

	// Some parts of this script use the main login form to display a message
	if		( isset($_REQUEST['loggedout']) && TRUE == $_REQUEST['loggedout'] )
		$errors->add('loggedout', __('You are now logged out.'), 'message');
	elseif	( isset($_REQUEST['registration']) && 'disabled' == $_REQUEST['registration'] )
		$errors->add('registerdisabled', __('User registration is currently not allowed.'));
	elseif	( isset($_REQUEST['checkemail']) && 'confirm' == $_REQUEST['checkemail'] )
		$errors->add('confirm', __('Check your e-mail for the confirmation link.'), 'message');
	elseif	( isset($_REQUEST['checkemail']) && 'newpass' == $_REQUEST['checkemail'] )
		$errors->add('newpass', __('Check your e-mail for your new password.'), 'message');
	elseif	( isset($_REQUEST['checkemail']) && 'registered' == $_REQUEST['checkemail'] )
		$errors->add('registered', __('Registration complete. Please check your e-mail.'), 'message');
	elseif	( $interim_login )
		$errors->add('expired', __('Your session has expired. Please log-in again.'), 'message');

	// Clear any stale cookies.
	if ( $reauth )
		wp_clear_auth_cookie();

	login_header(__('Log In'), '', $errors);

	if ( isset($_POST['log']) )
		$user_login = ( 'incorrect_password' == $errors->get_error_code() || 'empty_password' == $errors->get_error_code() ) ? esc_attr(stripslashes($_POST['log'])) : '';
	$rememberme = ! empty( $_POST['rememberme'] );
?>

<form name="loginform" id="loginform" action="<?php echo site_url('wp-login.php', 'login_post') ?>" method="post">
	<p>
		<label><?php _e('Username') ?><br />
		<input type="text" name="log" id="user_login" class="input" value="<?php echo esc_attr($user_login); ?>" size="20" tabindex="10" /></label>
	</p>
	<p>
		<label><?php _e('Password') ?><br />
		<input type="password" name="pwd" id="user_pass" class="input" value="" size="20" tabindex="20" /></label>
	</p>
<?php do_action('login_form'); ?>
	<p class="forgetmenot"><label><input name="rememberme" type="checkbox" id="rememberme" value="forever" tabindex="90"<?php checked( $rememberme ); ?> /> <?php esc_attr_e('Remember Me'); ?></label></p>
	<p class="submit">
		<input type="submit" name="wp-submit" id="wp-submit" class="button-primary" value="<?php esc_attr_e('Log In'); ?>" tabindex="100" />
<?php	if ( $interim_login ) { ?>
		<input type="hidden" name="interim-login" value="1" />
<?php	} else { ?>
		<input type="hidden" name="redirect_to" value="<?php echo esc_attr($redirect_to); ?>" />
<?php 	} ?>
		<input type="hidden" name="testcookie" value="1" />
	</p>
</form>

<?php if ( !$interim_login ) { ?>
<p id="nav">
<?php if ( isset($_REQUEST['checkemail']) && in_array( $_REQUEST['checkemail'], array('confirm', 'newpass') ) ) : ?>
<?php elseif ( get_option('users_can_register') ) : ?>
<a href="<?php echo site_url('wp-login.php?action=register', 'login') ?>"><?php _e('Register') ?></a> |
<a href="<?php echo site_url('wp-login.php?action=lostpassword', 'login') ?>" title="<?php _e('Password Lost and Found') ?>"><?php _e('Lost your password?') ?></a>
<?php else : ?>
<a href="<?php echo site_url('wp-login.php?action=lostpassword', 'login') ?>" title="<?php _e('Password Lost and Found') ?>"><?php _e('Lost your password?') ?></a>
<?php endif; ?>
</p>
<?php } ?>

<script type="text/javascript">
function wp_attempt_focus(){
setTimeout( function(){ try{
<?php if ( $user_login || $interim_login ) { ?>
d = document.getElementById('user_pass');
d.value = '';
<?php } else { ?>
d = document.getElementById('user_login');
<?php if ( 'invalid_username' == $errors->get_error_code() ) { ?>
if( d.value != '' )
d.value = '';
<?php
}
}?>
d.focus();
d.select();
} catch(e){}
}, 200);
}

<?php if ( !$error ) { ?>
wp_attempt_focus();
<?php } ?>
if(typeof wpOnload=='function')wpOnload();
</script>

<?php
login_footer();
break;
} // end action switch

// put ob into a string and return data
global $cubeacct_page_title;
$html .= ob_get_contents();
ob_end_clean();
$data['title'] = $cubeacct_page_title;
$data['content'] = $html;
return $data;

}

?>