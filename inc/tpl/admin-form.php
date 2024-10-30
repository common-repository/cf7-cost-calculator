		<h2><?php echo esc_html( __( 'Form', 'contact-form-7' ) ); ?></h2>

		<fieldset>
		  <legend><?php echo $description; ?></legend>
    		<?php
    			$tag_generator = WPCF7_TagGenerator::get_instance();
    			$tag_generator->print_buttons();

                $cf7wpms_enable = get_post_meta($post->id, '_cf7wpms_enable', true);
    		?>
    		<div class="cf7ms-wrap<?php if($cf7wpms_enable) { echo ' active';}?>">
                <div class="toggleWrapper">

                    <input type="checkbox" id="cf7wpms-enable" name="cf7wpms_enable" value="1" class="cf7wpms-enable"<?php checked( $cf7wpms_enable, 1 ); ?>>
                    <label for="cf7wpms-enable" class="is-cf7wpms-toggle"><span class="toggle__handler"></span></label>
                </div>
                <div class="cf7wpms-area">
                    <?php
                    $_cf7wpms = get_post_meta($post->id, '_cf7wpms', true);
                    if( $_cf7wpms && is_array($_cf7wpms) ) {?>
                        <ul id="sortable-list" class="cf7ms-tab clearfix">
                            <?php
                            foreach ($_cf7wpms as $key => $wpms) {
                                $reset_key = $key + 1;
                                ?>
                                <li<?php if($key == 0) { echo ' class="active"';}?>>
                                    <a href="#cf7wpms-tab<?php echo $reset_key;?>" contenteditable="false"><?php echo esc_attr($wpms['tab']);?></a><input type="hidden" class="input-cf7wpms-tab" name="wpcf7-form-tab[<?php echo $reset_key;?>]" value="<?php echo esc_attr($wpms['tab']);?>">
                                    <i class="icon-remove"></i>

                                </li>
                                <?php
                            }
                            ?>
                            <li class="cf7ms-addtab"><a href="#"><i class="icon-plus"></i></a></li>
                        </ul>

                    <div class="cf7wpms-content">
                        <textarea id="wpcf7-form" cols="100" rows="24" class="large-text code" data-config-field="form.body" name="wpcf7-form"><?php echo esc_textarea( $post->prop( 'form' ) ); ?></textarea>
                        <?php foreach ($_cf7wpms as $key => $wpms) {
                            $reset_key = $key + 1;
                            $cf7wpms_content = str_replace('\\', '', base64_decode( $wpms['content'] ) ); ?>
                        <div id="cf7wpms-tab<?php echo $reset_key;?>" class="cf7wpms-panel<?php if($key == 0 && $cf7wpms_enable) { echo ' active';}?>">
                            <textarea<?php if($key == 0) { echo ' id="wpcf7-form"';}?> name="wpcf7-form-content[<?php echo $reset_key;?>]" cols="100" rows="24" class="large-text code" data-config-field="form.body"><?php echo esc_attr($cf7wpms_content);?></textarea>
                        </div>
                        <?php }?>
                    </div>
                    <?php } else { ?>
        			<ul class="cf7ms-tab clearfix">
        				<li class="active"><a href="#cf7wpms-tab1" contenteditable="false"><?php echo __('Tab 1', 'cf7-save2data-pro');?></a><input type="hidden" class="input-cf7wpms-tab" name="wpcf7-form-tab[1]" value="<?php echo __('Tab 1', 'cf7-save2data-pro');?>"><i class="icon-remove"></i></li>
        				<li><a href="#cf7wpms-tab2" contenteditable="false"><?php echo __('Tab 2', 'cf7-save2data-pro');?></a><input type="hidden" class="input-cf7wpms-tab" name="wpcf7-form-tab[2]" value="<?php echo __('Tab 2', 'cf7-save2data-pro');?>"><i class="icon-remove"></i></li>
        				<li class="cf7ms-addtab"><a href="#"><i class="icon-plus"></i></a></li>
        			</ul>

        			<div class="cf7wpms-content">
        				<textarea id="wpcf7-form" cols="100" rows="24" class="large-text code" data-config-field="form.body" name="wpcf7-form"><?php echo esc_textarea( $post->prop( 'form' ) ); ?></textarea>
        				<div id="cf7wpms-tab1" class="cf7wpms-panel active">
        					<textarea name="wpcf7-form-content[1]" cols="100" rows="24" class="large-text code" data-config-field="form.body"><?php echo esc_textarea( $post->prop( 'form' ) ); ?></textarea>
        				</div>

        				<div id="cf7wpms-tab2" class="cf7wpms-panel">
        					<textarea name="wpcf7-form-content[2]" cols="100" rows="24" class="large-text code" data-config-field="form.body"></textarea>
        				</div>
        			</div>
                    <?php }?>
                </div>
    		</div>
		</fieldset>