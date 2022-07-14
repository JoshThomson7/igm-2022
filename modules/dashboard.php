<?php
/*
	DASHBOARD
	Author: FL1 Group - www.fl1group.com
	
	Version: 1.5 (Last update: 6 Sep 2013)
	-------------------------------------------------------------------------
		1. REMOVE MENU ITEMS
		2. ROBOTS BLOCKED ALERT
*/

/* ===============================================================================================================*/
/*                                                                                                                */
/*                                            1. REMOVE MENU ITEMS                                                */
/*                                                                                                                */             
/* ===============================================================================================================*/
function remove_menus () {
global $menu;
	$restricted = array(__('Links'));
	end ($menu);
	while (prev($menu)){
		$value = explode(' ',$menu[key($menu)][0]);
		if(in_array($value[0] != NULL?$value[0]:"" , $restricted)){unset($menu[key($menu)]);}
	}
}
add_action('admin_menu', 'remove_menus');


/* ===============================================================================================================*/
/*                                                                                                                */
/*                                            2. ROBOTS BLOCKED ALERT                                             */
/*                                                                                                                */             
/* ===============================================================================================================*/
function addAlert() { 
	if(get_option('blog_public') == 0):
?>
<script type="text/javascript">
jQuery(document).ready(function($) {
	jQuery('.wrap > h2').parent().prev().after('<div class="update-nag"><strong>Robots blocked</strong>. Remember to change this setting when going live under <strong>Settings > Reading</strong> by unchecking the <strong>Discourage search engines from indexing this site</strong> option.</div>');
});
</script>
<?php 
	endif;
} add_action('admin_head','addAlert');
?>