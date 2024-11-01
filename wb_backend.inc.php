<?php
/* administration */
add_action('admin_menu', 'adminWarningButton');

function adminWarningButton() {
	add_options_page('Warning Button Menu', 'Warning Button', 'manage_options', 'warning_post', 'adminWarningButtonForm');
}

function adminWarningButtonForm() {

	if (!current_user_can('manage_options'))  
	{
		wp_die( __('You do not have sufficient permissions to access this page.', 'warning_button') );
	}
	?>
	<div class="wrap">
	<?php
	if( isset($_POST['submit'])) 
	{
		$wb_admin_email	= $_POST['wb_admin_email'];
		$wb_email_subject 	= $_POST['wb_email_subject'];
		$wb_message 		= $_POST['wb_message'];
		update_option( 'wb_admin_email'	, $wb_admin_email );
		update_option( 'wb_email_subject', $wb_email_subject );
		update_option( 'wb_message'	, $wb_message );
		?>
		<div class="updated"><p><strong><?php _e('settings saved.', 'warning_button' ); ?></strong></p></div>
		<?php
	}
	$wb_admin_email	= get_option('wb_admin_email');
	$wb_email_subject	= get_option('wb_email_subject');
	$wb_message 		= get_option('wb_message');
	if(empty($wb_admin_email))
		$wb_admin_email= get_option('admin_email');
	if(empty($wb_email_subject))
		$wb_email_subject= "Warning // Un contenu incorrecte a été reporté";
	if(empty($wb_message))
		$wb_message	= "Bonjour,\n\nL'utilisateur WBUSER a reporté que l'article WBPOST contenait des informations inappropriées sur le blog WBBLOG.\nPour voir ce contenu, rendez-vous à l'adresse suivante : WBLINK.";
	?>
	<div id="icon-options-general" class="icon32"><br /></div><h2><?php _e('Warning Button Administration', 'warning_button' )?></h2>
	<form name="formWarningButton" method="post" action="">
	<table class="form-table">
		<tr valign="top">
			<th scope="row"><label><?php _e("Email subject", 'warning_button' ); ?>   : </label></th>
			<td><input type="text" name="wb_email_subject" value="<?php echo $wb_email_subject; ?>" size="30" /></td>
		</tr>
		<tr valign="top">
			<th scope="row"><label><?php _e("Administrator email", 'warning_button' ); ?>   : </label></th>
			<td><input type="text" name="wb_admin_email" value="<?php echo $wb_admin_email; ?>" size="30" /></td>
		</tr>
		<tr valign="top">
			<th scope="row"><label><?php _e("Message sent", 'warning_button' ); ?>  : </label><span class="description">
			<br />WBUSER = Utilisateur<br />WBPOST = Titre de l'article<br />WBBLOG = Nom du blog<br />WBLINK = URL de la page.
			</span></th>
			<td><textarea name="wb_message" cols="50" rows="10"><?php echo str_replace("\\","",$wb_message); ?></textarea></td>
		</tr>
	</table>
	<p class="submit">
	<input type="submit" name="submit" class="button-primary" value="<?php esc_attr_e('Save Changes', 'warning_button' ) ?>" />
	</p>

	</form>

	<?php
	echo '</div>';
}
?>