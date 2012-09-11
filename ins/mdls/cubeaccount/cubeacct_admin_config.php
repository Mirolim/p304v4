<?php
/**
 * CubeAccount Admin - Config.
 * Admin configuration page for CubeAccount.
 * @package cubeaccount
 */


/**
 * CubeAccount Admin Settings Page
 * 
 * @return null
 */
function cubeacct_admin_config(){
	
	if(isset($_POST['cubeacct_admin_update']) && check_admin_referer('cubeacct_admin_config_update', 'cubeacct_admin_config_nonce')){
		$errors = array();
		$cubeacct_hide_adminbar_from = (array) $_POST['cubeacct_hide_adminbar_from'];
		$cubeacct_hide_dashboard_from = (array) $_POST['cubeacct_hide_dashboard_from'];

		if(count($errors)>0){
			foreach($errors as $error){
				echo '<div class="error"><p><strong>' . $error . '</strong></p></div>';
			}
		}
		else{
			update_option('cubeacct_hide_adminbar_from', $cubeacct_hide_adminbar_from);
			update_option('cubeacct_hide_dashboard_from', $cubeacct_hide_dashboard_from);
			echo '<div class="updated"><p><strong>' . __('Settings saved.', 'cubeacct') . '</strong></p></div>';
		}
	}
	
	$cubeacct_hide_adminbar_from = (array) get_option('cubeacct_hide_adminbar_from');
	$cubeacct_hide_dashboard_from = (array) get_option('cubeacct_hide_dashboard_from');
?>
<div class="wrap"> 
	<div id="icon-options-general" class="icon32"><br /></div> 
<h2>CubeAccount - <?php _e('Configure', 'cubeacct'); ?></h2> 
 
<form method="post">
<input type='hidden' name='cubeacct_admin_update' value='1' />
<?php wp_nonce_field('cubeacct_admin_config_update','cubeacct_admin_config_nonce'); ?>

<h3 class="title"><?php _e('Hide Admin Bar', 'cubeacct'); ?></h3>
<table class="form-table"> 

<tr valign="top"> 
<th scope="row"><?php _e('Hide WordPress admin bar from', 'cubeacct'); ?>:</th> 
<td><fieldset>
<p>

<label><input name="cubeacct_hide_adminbar_from[]"  type="checkbox" value="editor" <?php echo in_array('editor', $cubeacct_hide_adminbar_from) ? 'checked="checked"' : ''  ; ?> /> <?php _e('Editors', 'cubeacct'); ?></label><br />
<label><input name="cubeacct_hide_adminbar_from[]"  type="checkbox" value="author" <?php echo in_array('author', $cubeacct_hide_adminbar_from) ? 'checked="checked"' : ''  ; ?> /> <?php _e('Authors', 'cubeacct'); ?></label><br />
<label><input name="cubeacct_hide_adminbar_from[]"  type="checkbox" value="contributor" <?php echo in_array('contributor', $cubeacct_hide_adminbar_from) ? 'checked="checked"' : ''  ; ?> /> <?php _e('Contributors', 'cubeacct'); ?></label><br />
<label><input name="cubeacct_hide_adminbar_from[]"  type="checkbox" value="subscriber" <?php echo in_array('subscriber', $cubeacct_hide_adminbar_from) ? 'checked="checked"' : ''  ; ?> /> <?php _e('Subscribers', 'cubeacct'); ?></label>
</p> 
</fieldset></td> 
</tr>

<tr valign="top"> 
<th scope="row"><?php _e('Hide WordPress dashboard from', 'cubeacct'); ?>:</th> 
<td><fieldset>
<p>
<label><input name="cubeacct_hide_dashboard_from[]"  type="checkbox" value="editor" <?php echo in_array('editor', $cubeacct_hide_dashboard_from) ? 'checked="checked"' : ''  ; ?> /> <?php _e('Editors', 'cubeacct'); ?></label><br />
<label><input name="cubeacct_hide_dashboard_from[]"  type="checkbox" value="author" <?php echo in_array('author', $cubeacct_hide_dashboard_from) ? 'checked="checked"' : ''  ; ?> /> <?php _e('Authors', 'cubeacct'); ?></label><br />
<label><input name="cubeacct_hide_dashboard_from[]"  type="checkbox" value="contributor" <?php echo in_array('contributor', $cubeacct_hide_dashboard_from) ? 'checked="checked"' : ''  ; ?> /> <?php _e('Contributors', 'cubeacct'); ?></label><br />
<label><input name="cubeacct_hide_dashboard_from[]"  type="checkbox" value="subscriber" <?php echo in_array('subscriber', $cubeacct_hide_dashboard_from) ? 'checked="checked"' : ''  ; ?> /> <?php _e('Subscribers', 'cubeacct'); ?></label>
</p> 
</fieldset></td> 
</tr>

</table>
 
<p class="submit"><input type="submit" name="submit" id="submit" class="button-primary" value="<?php _e('Save Changes', 'cubeacct'); ?>"  /></p></form> 
 
</div>
<?php
}
?>