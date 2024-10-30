<?php
/*
Plugin Name: Cool Web Resources
Plugin URI: http://www.w3resources.com/
Description: Add the coolest web resources on your blog and entertain your visitors.
Version: 1.0
*/

function webresources_widget_init()
{
		if (!get_option('web_resources_title')) update_option("web_resources_title", "Cool Web Resources");
		if (!get_option('web_resources_total')) update_option("web_resources_total", "7");
	
    if ( function_exists('register_sidebar_widget') )
        register_sidebar_widget('Web Resources Widget', 'webresources_sidebar_widget');
}

function webresources_sidebar_widget($args) 
{
    extract($args);
    echo $before_widget; 
    echo $before_title . $after_title . webresources_social_widget('', true);
    echo $after_widget;
}

function webresources_social_widget($content, $sidebar = false)
{

    $content .= "\n<!-- WebResources BEGIN -->\n";
    $content .= '<div><script type="text/javascript" src="http://www.netvibes.com/js/UWA/load.js.php?env=BlogWidget2"></script><script type="text/javascript">';
		$content .= "var BW = new UWA.BlogWidget({moduleUrl:'http://www.netvibes.com/modules/feedReader/feedReader.php?feedUrl=http%3A%2F%2Fw3resources.com%2Ffeed'}); BW.setPreferencesValues({'nbTitles':'7', 'view':''}); BW.setConfiguration({'title':'".get_option('web_resources_title')."'});</script></div>";

    $content .= "\n<!-- WebResources END -->";
    return $content;
}

add_action('widgets_init', 'webresources_widget_init');
add_filter('admin_menu', 'web_resources_menu');

// Adding Admin Menu
add_action('admin_menu', 'web_resources_menu');

function web_resources_menu() {
	add_options_page('Cool Web Resources Setup', 'Web Resources', 10, __FILE__, 'web_resources_setup');
}

function web_resources_setup() {

	if ($_POST['action']) {
		if ($_POST['web_resources_title']) { 
    		update_option("web_resources_title", $_POST['web_resources_title']);
    } else { 
    		update_option("web_resources_title", "Cool Web Resources");
    }
		
		if ($_POST['web_resources_total']) { 
    		update_option("web_resources_total", $_POST['web_resources_total']);
    } else { 
    		update_option("web_resources_total", "7");
    }
  }

?>
<div class="wrap">
<div class="icon32" id="icon-options-general"><br/></div>
<h2>Cool Web Resources - Options</h2>
<div class="greenBox">
	<strong>Getting Started</strong>
  <ol>
    <li>Configure the settings below.</li>
    <li>Go to the <a href="<?php echo get_bloginfo('wpurl')."/wp-admin/widgets.php"; ?>">Widgets Section</a> of your WordPress and add the "Web Resources Widget" to your sidebar.</li>
    <li>Coolest web resources are now available to your readers through your blog.</li>
  </ol>
</div>

<form method="post" action="">
Widget Title: <input type="text" id="web_resources_title" name="web_resources_title" style="border: 1px solid #CCC; width: 200px;" value="<?php if (get_option('web_resources_title')) { echo get_option('web_resources_title'); } else { echo "Cool Web Resources"; } ?>">
<br /><br />
No. of resources to show: <input type="text" id="web_resources_total" name="web_resources_total" style="border: 1px solid #CCC; width: 50px;" maxlength="2" value="<?php if (get_option('web_resources_total')) { echo get_option('web_resources_total'); } else { echo "7"; } ?>">
<br />
<p class="submit">
	<input type="hidden" name="action" value="update" />
	<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
</p>
</form>
<?php  
}
?>