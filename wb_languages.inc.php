<?php

function warningButton_localization(){
	load_plugin_textdomain("warning_button", false, dirname( plugin_basename(__FILE__) ). '/languages');
}
add_action ('init', 'warningButton_localization');
?>