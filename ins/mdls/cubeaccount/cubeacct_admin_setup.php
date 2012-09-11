<?php
/**
 * CubeAccount Admin - Setup.
 * Admin setupuration page for CubeAccount.
 * @package cubeaccount
 */


/**
 * CubeAccount Admin Settings Page
 * 
 * @return null
 */
function cubeacct_admin_setup(){
	
	if(isset($_POST['cubeacct_admin_update']) && check_admin_referer('cubeacct_admin_setup_update', 'cubeacct_admin_setup_nonce')){
		$errors = array();
		
		$cubeacct_login_pageid = (int) $_POST['cubeacct_login_pageid'];
		$cubeacct_register_pageid = (int) $_POST['cubeacct_register_pageid'];
		$cubeacct_profile_pageid = (int) $_POST['cubeacct_profile_pageid'];
		$cubeacct_forgetpass_pageid = (int) $_POST['cubeacct_forgetpass_pageid'];
		$cubeacct_login_hide = (bool) $_POST['cubeacct_login_hide'];
		$cubeacct_register_hide = (bool) $_POST['cubeacct_register_hide'];
		$cubeacct_profile_hide = (bool) $_POST['cubeacct_profile_hide'];
		$cubeacct_forgetpass_hide = (bool) $_POST['cubeacct_forgetpass_hide'];
		update_option('cubeacct_login_pageid', $cubeacct_login_pageid);
		update_option('cubeacct_register_pageid', $cubeacct_register_pageid);
		update_option('cubeacct_profile_pageid', $cubeacct_profile_pageid);
		update_option('cubeacct_forgetpass_pageid', $cubeacct_forgetpass_pageid);
		update_option('cubeacct_login_hide', $cubeacct_login_hide);
		update_option('cubeacct_register_hide', $cubeacct_register_hide);
		update_option('cubeacct_profile_hide', $cubeacct_profile_hide);
		update_option('cubeacct_forgetpass_hide', $cubeacct_forgetpass_hide);

		if(count($errors)>0){
			foreach($errors as $error){
				echo '<div class="error"><p><strong>' . $error . '</strong></p></div>';
			}
		}
		else{
			echo '<div class="updated"><p><strong>' . __('Settings saved.', 'cubeacct') . '</strong></p></div>';
		}
	}
	
	$cubeacct_pages = get_pages();
	
?>
<div class="wrap"> 
	<div id="icon-options-general" class="icon32"><br /></div> 
<h2>CubeAccount - <?php _e('Setup', 'cubeacct'); ?></h2> 
 
<form method="post">
<input type='hidden' name='cubeacct_admin_update' value='1' />
<?php wp_nonce_field('cubeacct_admin_setup_update','cubeacct_admin_setup_nonce'); ?>

<h3 class="title"><?php _e('Permalinks', 'cubeacct'); ?></h3>
<p><?php _e('Select pages to be used by CubeAccount as login, registration, forget-password and profile page.', 'cubeacct'); ?></p>
<table class="form-table">

<tr valign="top">
<th scope="row"><label for="cubeacct_login_pageid"><?php _e('Login Page:', 'cubeacct'); ?></label></th>
<td>
<select name="cubeacct_login_pageid" id="cubeacct_login_pageid" class="regular-text">
<option value=""><?php _e('Select a page', 'cubeacct'); ?>...</option>
<?php
foreach($cubeacct_pages as $page){
	echo '<option value="' . $page->ID . '" ' . ((get_option('cubeacct_login_pageid')==$page->ID)?'selected="selected"':'') . '>' . $page->post_title . '</option>';
}
?>
</select>
<br />
<label><input name="cubeacct_login_hide" id="" type="checkbox" value="1" <?php echo (get_option('cubeacct_login_hide')?'checked="checked"':''); ?> /> <?php _e('Hide this page from main navigation menu', 'cubepm'); ?></label>
</td>
<td></td>
</tr>

<tr valign="top">
<th scope="row"><label for="cubeacct_register_pageid"><?php _e('Registration Page:', 'cubeacct'); ?></label></th>
<td>
<select name="cubeacct_register_pageid" id="cubeacct_register_pageid" class="regular-text">
<option value=""><?php _e('Select a page', 'cubeacct'); ?>...</option>
<?php
foreach($cubeacct_pages as $page){
	echo '<option value="' . $page->ID . '" ' . ((get_option('cubeacct_register_pageid')==$page->ID)?'selected="selected"':'') . '>' . $page->post_title . '</option>';
}
?>
</select>
<br />
<label><input name="cubeacct_register_hide" id="" type="checkbox" value="1" <?php echo (get_option('cubeacct_register_hide')?'checked="checked"':''); ?> /> <?php _e('Hide this page from main navigation menu', 'cubepm'); ?></label>
</td>
<td></td>
</tr>

<tr valign="top">
<th scope="row"><label for="cubeacct_profile_pageid"><?php _e('Profile Page:', 'cubeacct'); ?></label></th>
<td>
<select name="cubeacct_profile_pageid" id="cubeacct_profile_pageid" class="regular-text">
<option value=""><?php _e('Select a page', 'cubeacct'); ?>...</option>
<?php
foreach($cubeacct_pages as $page){
	echo '<option value="' . $page->ID . '" ' . ((get_option('cubeacct_profile_pageid')==$page->ID)?'selected="selected"':'') . '>' . $page->post_title . '</option>';
}
?>
</select>
<br />
<label><input name="cubeacct_profile_hide" id="" type="checkbox" value="1" <?php echo (get_option('cubeacct_profile_hide')?'checked="checked"':''); ?> /> <?php _e('Hide this page from main navigation menu', 'cubepm'); ?></label>
</td>
<td></td>
</tr>

<tr valign="top">
<th scope="row"><label for="cubeacct_forgetpass_pageid"><?php _e('Forget Password Page:', 'cubeacct'); ?></label></th>
<td>
<select name="cubeacct_forgetpass_pageid" id="cubeacct_forgetpass_pageid" class="regular-text">
<option value=""><?php _e('Select a page', 'cubeacct'); ?>...</option>
<?php
foreach($cubeacct_pages as $page){
	echo '<option value="' . $page->ID . '" ' . ((get_option('cubeacct_forgetpass_pageid')==$page->ID)?'selected="selected"':'') . '>' . $page->post_title . '</option>';
}
?>
</select>
<br />
<label><input name="cubeacct_forgetpass_hide" id="" type="checkbox" value="1" <?php echo (get_option('cubeacct_forgetpass_hide')?'checked="checked"':''); ?> /> <?php _e('Hide this page from main navigation menu', 'cubepm'); ?></label>
</td>
<td></td>
</tr>

</table>
 
<p class="submit"><input type="submit" name="submit" id="submit" class="button-primary" value="<?php _e('Save Changes', 'cubeacct'); ?>"  /></p></form> 
 
</div>
<?php
}
?>