<?php
/*
Plugin Name: Picasa Slideshow
Plugin URI: http://www.none.com/
Description: Embeds Google Picasa Flash Slideshow as Widget on Sidebar
Author: Trey Griffin
Version: 1.0
Author URI: http://www.none.com/
*/

function widget_picasaSlideshow($args)
{
	// Grab the Wordpress theme args, which are used to display the widget 
	extract($args);

	// Check for and retrieve any preset options  
	$options = get_option("widget_picasaSlideshow");
	
	// If no options have been set, set them 
	if (!is_array( $options ))
	{
		$options = array(
			'title' => 'Slideshow',
			'username' => 'Username',
			'albumid' => 'Album ID',
			'width' => '200',
			'height' => '150',
			'backgroundcolor' => 'FFFFFF'
		);
	}      

	echo $before_widget;
	echo $before_title;
	echo $options['title'];
	echo $after_title;
	
	// Our Widget Content
	$content  = "<embed type=\"application/x-shockwave-flash\" ";
	$content .= "src=\"http://picasaweb.google.com/s/c/bin/slideshow.swf\" ";
	$content .= "width=\"" . $options['width'] . "\" ";
	$content .= "height=\"" . $options['height'] . "\" ";
	$content .= "flashvars=\"host=picasaweb.google.com&RGB=0x" . $options['backgroundcolor'];
	$content .= "&feed=http%3A%2F%2Fpicasaweb.google.com%2Fdata%2Ffeed%2Fapi%2Fuser%2F";
	$content .= $options['username'] . "%2Falbumid%2F" . $options['albumid'];
	$content .= "%3Fkind%3Dphoto%26alt%3Drss\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\"></embed>";
	echo $content;
	
	echo $after_widget;
} // end of widget_picasaSlideshow


function picasaSlideshow_control()
{
	// Check for and retrieve any preset options  
	$options = get_option("widget_picasaSlideshow");

	// If no options have been set, set them 
	if (!is_array( $options ))
	{
		$options = array(
			'title' => 'Slideshow',
			'username' => 'Username',
			'albumid' => 'Album ID',
			'width' => '200',
			'height' => '150',
			'backgroundcolor' => 'FFFFFF'
		);
	}      

	// If the user has set the options and clicked save, then grab them using the $_POST function. 
	if ($_POST['picasaSlideshow-Submit'])
	{
		$options['title'] = htmlspecialchars($_POST['picasaSlideshow-Title']);
		$options['username'] = htmlspecialchars($_POST['picasaSlideshow-Username']);
		$options['albumid'] = htmlspecialchars($_POST['picasaSlideshow-Albumid']);
		$options['width'] = htmlspecialchars($_POST['picasaSlideshow-Width']);
		$options['height'] = htmlspecialchars($_POST['picasaSlideshow-Height']);
		$options['backgroundcolor'] = htmlspecialchars($_POST['picasaSlideshow-Backgroundcolor']);
		// Update the options in the Wordpress Database   
		update_option("widget_picasaSlideshow", $options);
	}
	
	// Display user form for input
?>
	<p>
		<label for="picasaSlideshow-Title">Slideshow Title</label>
		<br>
		<input type="text" id="picasaSlideshow-Title" name="picasaSlideshow-Title" value="<?php echo $options['title'];?>" />
		<br>
		<label for="picasaSlideshow-Username">Google Picasa Username</label>
		<br>
		<input type="text" id="picasaSlideshow-Username" name="picasaSlideshow-Username" value="<?php echo $options['username'];?>" />
		<br>
		<label for="picasaSlideshow-Albumid">Google Picasa Album ID</label>
		<br>
		<input type="text" id="picasaSlideshow-Albumid" name="picasaSlideshow-Albumid" value="<?php echo $options['albumid'];?>" />
		<br>
		<label for="picasaSlideshow-Width">Width:&nbsp&nbsp&nbsp&nbsp</label>		
		<input type="text" id="picasaSlideshow-Width" name="picasaSlideshow-Width" maxlength="4" size="6" value="<?php echo $options['width'];?>" />
		<br>
		<label for="picasaSlideshow-Height">Height:&nbsp&nbsp</label>
		<input type="text" id="picasaSlideshow-Height" name="picasaSlideshow-Height" maxlength="4" size="6" value="<?php echo $options['height'];?>" />
		<br>
		<label for="picasaSlideshow-Backgroundcolor">Background Color (Hex):&nbsp&nbsp</label>
		<input type="text" id="picasaSlideshow-Backgroundcolor" name="picasaSlideshow-Backgroundcolor" maxlength="6" size="6" value="<?php echo $options['backgroundcolor'];?>" />
		<input type="hidden" id="picasaSlideshow-Submit" name="picasaSlideshow-Submit" value="1" />
	</p>

<?php
} // end of picasaSlideshow_control


function picasaSlideshow_init()
{
	// These are the Wordpress functions which will register the widget, 
	// and also the widget control (options). 
	register_sidebar_widget(__('Picasa Slideshow'), 'widget_picasaSlideshow');
	register_widget_control(   'Picasa Slideshow', 'picasaSlideshow_control');
}

add_action("plugins_loaded", "picasaSlideshow_init");

?>
