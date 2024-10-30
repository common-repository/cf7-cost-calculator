<div id="cf7wpms-admin-settings">
	 <h2><?php echo esc_html_e('Settings', 'cf7wpms');?></h2>
	 <p class="description"><label for="wpcf7-shortcode">Copy this shortcode and paste it into your post, page, or text widget content:</label></p>
	 <table class="form-table">
	    <tr>
			<th scope="row">
				<label for="multistep_cf7_steps_next">
					<?php _e('Background Button', 'cf7wpms'); ?>
				</label>
			</th>
			<td>
				<input type="text" class="cf7wpms-color-field" name="wpcf7-ms[bg_button]" value="<?php echo $_cf7wpms_settings['cf7wpms_bg_button']; ?>" />
			</td>
		</tr>
	    <tr>
			<th scope="row">
				<label for="multistep_cf7_steps_next">
					<?php _e('Text color Button', 'cf7wpms'); ?>
				</label>
			</th>
			<td>
				<input type="text" class="cf7wpms-color-field" name="wpcf7-ms[text_button]" value="<?php echo $_cf7wpms_settings['cf7wpms_text_button']; ?>" />
			</td>
		</tr>
	    <tr>
			<th scope="row">
				<label for="multistep_cf7_steps_next">
					<?php _e('Background Button Hover', 'cf7wpms'); ?>
				</label>
			</th>
			<td>
				<input type="text" class="cf7wpms-color-field" name="wpcf7-ms[bg_button_hover]" value="<?php echo $_cf7wpms_settings['cf7wpms_bg_button_hover']; ?>" />
			</td>
		</tr>
	    <tr>
			<th scope="row">
				<label for="multistep_cf7_steps_next">
					<?php _e('Text color Button Hover', 'cf7wpms'); ?>
				</label>
			</th>
			<td>
				<input type="text" class="cf7wpms-color-field" name="wpcf7-ms[text_button_hover]" value="<?php echo $_cf7wpms_settings['cf7wpms_text_button_hover']; ?>" />
			</td>
		</tr>
	    <tr>
			<th scope="row">
				<label for="multistep_cf7_steps_next">
					<?php _e('Background Nav', 'cf7wpms'); ?>
				</label>
			</th>
			<td>
				<input type="text" class="cf7wpms-color-field" name="wpcf7-ms[bg_nav]" value="<?php echo $_cf7wpms_settings['cf7wpms_bg_nav']; ?>" />
			</td>
		</tr>
	    <tr>
			<th scope="row">
				<label for="multistep_cf7_steps_next">
					<?php _e('Color Nav', 'cf7wpms'); ?>
				</label>
			</th>
			<td>
				<input type="text" class="cf7wpms-color-field" name="wpcf7-ms[color_nav]" value="<?php echo $_cf7wpms_settings['cf7wpms_color_nav']; ?>" />
			</td>
		</tr>
	</table>
	<a href="http://bit.ly/2q4FX7B" target="_blank" class="cf7wpms-premium-link">This options only available for Premium version. <strong>Upgrade Now</strong></a>
</div>