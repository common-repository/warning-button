<?php
/* Fonction permettant d'ajouter un lien hypertexte à la fin du contenu */
function displayWarningButton($content)
{
	/* récupère la variable globale $current_user */
	global $current_user;
	return $content.'<a href="?alert=warningPost&post='.get_the_title().'&user='.$current_user->user_login.'">'.__('Report inappropriate content', 'warning_button' ).'</a>';
}
function WBsuccess($content)
{
	return $content."<div class='updated'>".__('Message success','warning_button')."</div>";
}
function WBerror($content)
{
	return $content."<div class='updated'>".__('Message error','warning_button')."</div>";
}

/* si le bouton est cliqué, on envoie un email */
if($_GET['alert']=="warningPost")
{
	global $wpdb;
	$user_name	= $_GET['user'];
	$id_blog 		= $wpdb->blogid;
	$blog_name	= get_blog_option( $id_blog, 'blogname' );
	$post_name	= $_GET['post'];

	$to			= get_option('wb_admin_email');
	$subject		= get_option('wb_email_subject');
	$remplacement 	= array(
		"\\" => "",
		"WBBLOG" => "<strong>$blog_name</strong>",
		"WBPOST" => "<strong>$post_name</strong>",
		"WBUSER" => "<strong>$user_name</strong>",
		"WBLINK" => "<a href='".$_SERVER['HTTP_REFERER']."'><strong>".$_SERVER['HTTP_REFERER']."</strong></a>"
	);
	$message		= strtr(get_option('wb_message'),$remplacement);
	if(Mail($to,$subject,nl2br($message),"Content-type:text/html; charset=utf8"))
	{
		add_filter('the_content','WBsuccess');
	}
	else
	{
		add_filter('the_content','WBerror');
	}
}
else
{
	/* ajoute un filtre sur la génération du contenu afin d'exécuter la fonction displayWarningButton */
	add_filter('the_content','displayWarningButton');
}
?>