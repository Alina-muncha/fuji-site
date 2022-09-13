<?php
if( !defined('ABSPATH')){
	exit;
}
global $post;
extract($args);
?>
<div id="<?php esc_attr_e( $id ); ?>-container"
     class="yith-plugin-fw-metabox-field-row" <?php echo yith_field_deps_data( $args ); ?> >
	<label for="<?php esc_attr_e( $id ); ?>"><?php esc_html_e( $label ); ?></label>
	<div class="yith-plugin-fw-field-wrapper yith-plugin-fw-field-wrapper-advanced-simple-text"><?php echo $desc;?></div>
	<input type="hidden" id="<?php echo $id;?>" name="yit_metaboxes[_discount_mode]" value="exclude_items">
</div>

