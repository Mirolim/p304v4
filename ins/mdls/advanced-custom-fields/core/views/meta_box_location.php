<?php

/*
*  Meta Box: Location
*
*  @description: 
*  @created: 23/06/12
*/

// global
global $post;
		
		
// vars
$location = $this->parent->get_acf_location($post->ID);


// at lease 1 location rule
if( empty($location['rules']) )
{
	$location['rules'] = array(
		array(
			'param'		=>	'post_type',
			'operator'	=>	'',
			'value'		=>	'',
		)
	);
}

?>
<table class="acf_input widefat" id="acf_location">
	<tbody>
	<tr>
		<td class="label">
			<label for="post_type"><?php _e("Rules",'acf'); ?></label>
			<p class="description"><?php _e("Create a set of rules to determine which edit screens will use these advanced custom fields",'acf'); ?></p>
		</td>
		<td>
			<div class="location_rules">
				<table class="acf_input widefat" id="location_rules">
					<tbody>
						<?php foreach($location['rules'] as $k => $rule): ?>
						<tr>
						<td class="param"><?php 
							
							$choices = array(
								__("Basic",'acf') => array(
									'post_type'		=>	__("Post Type",'acf'),
									'user_type'		=>	__("Logged in User Type",'acf'),
								),
								__("Page Specific",'acf') => array(
									'page'			=>	__("Page",'acf'),
									'page_type'		=>	__("Page Type",'acf'),
									'page_parent'	=>	__("Page Parent",'acf'),
									'page_template'	=>	__("Page Template",'acf'),
								),
								__("Post Specific",'acf') => array(
									'post'			=>	__("Post",'acf'),
									'post_category'	=>	__("Post Category",'acf'),
									'post_format'	=>	__("Post Format",'acf'),
									'taxonomy'		=>	__("Post Taxonomy",'acf'),
								),
								__("Other",'acf') => array(
									'ef_taxonomy'	=>	__("Taxonomy (Add / Edit)",'acf'),
									'ef_user'		=>	__("User (Add / Edit)",'acf'),
									'ef_media'		=>	__("Media (Edit)",'acf')
								)
							);
							

							// validate
							if($this->parent->is_field_unlocked('options_page'))
							{
								$choices[__("Options Page",'acf')]['options_page'] = __("Options Page",'acf');
							}
							
							
							$args = array(
								'type'	=>	'select',
								'name'	=>	'location[rules]['.$k.'][param]',
								'value'	=>	$rule['param'],
								'choices' => $choices,
								'optgroup' => true,
							);
							
							$this->parent->create_field($args);							
							
						?></td>
						<td class="operator"><?php 	
							
							$this->parent->create_field(array(
								'type'	=>	'select',
								'name'	=>	'location[rules]['.$k.'][operator]',
								'value'	=>	$rule['operator'],
								'choices' => array(
									'=='	=>	__("is equal to",'acf'),
									'!='	=>	__("is not equal to",'acf'),
								)
							)); 	
							
						?></td>
						<td class="value"><?php 
							
							$this->ajax_acf_location(array(
								'key' => $k,
								'value' => $rule['value'],
								'param' => $rule['param'],
							)); 
							
						?></td>
						<td class="buttons">
							<a href="javascript:;" class="remove"></a>
							<a href="javascript:;" class="add"></a>
						</td>
						</tr>
						<?php endforeach; ?>
					</tbody>
					
				</table>
				<ul class="hl clearfix">
					<li style="padding:4px 4px 0 0;"><?php _e("match",'acf'); ?></li>
					<li><?php $this->parent->create_field(array(
									'type'	=>	'select',
									'name'	=>	'location[allorany]',
									'value'	=>	$location['allorany'],
									'choices' => array(
										'all'	=>	__("all",'acf'),
										'any'	=>	__("any",'acf'),							
									),
					)); ?></li>
					<li style="padding:4px 0 0 4px;"><?php _e("of the above",'acf'); ?></li>
				</ul>
			</div>
			
			
		</td>
		
	</tr>

	</tbody>
</table>
<script type="text/html" id="acf_location_options_deactivated">
	<optgroup label="<?php _e("Options",'acf'); ?>" disabled="true">
		<option value="" disabled="true"><?php _e("Unlock options add-on with an activation code",'acf'); ?></option>
	</optgroup>
</script>