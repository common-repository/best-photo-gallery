<div class="wrap sp8ce-portfolio">
	<h1>Sp8ce.Design - Directions</h1>
	<h3>Add any of the following shortcodes to a page or post and your portfolio will display.  Change the user name to your user name on Sp8ce.Design.  For this example, rykenconstructioncorporation is the user.  <a href="https://sp8ce.design/contact-us/" target=“_blank”>Click here</a> if you have questions or need help.  Support is FREE!<br><br>Fried Theme = [sp8ce-portfolio username="rykenconstructioncorporation" theme="fried"]<br>Collis Theme = [sp8ce-portfolio username="rykenconstructioncorporation" theme="collis"]<br>Graham Theme = [sp8ce-portfolio username="rykenconstructioncorporation"]</h3>

	<?php include('tabs.php'); ?>
	
	<div class="tab-content tab-directions">
		<iframe width="560" 
				height="315" 
				src="https://www.youtube.com/embed/u0Ik60kLzas" 
				frameborder="0" 
				allowfullscreen
		></iframe>
		<form method="post" action="options.php"> 
		<?php 
			settings_fields('sp8ce-portfolio-settings'); 
			do_settings_sections('sp8ce-portfolio-settings');
			
			$currentSetting = get_option('sp8ce_show_poweredby', true);
			$showCategories = get_option('sp8ce_show_categories', false);
		?>
		<p>Show a link to Sp8ce Design below your portfolio?</p>
		<input type="checkbox" name="sp8ce_show_poweredby" value="1" <?php if ($currentSetting == 1): ?>checked="checked"<?php endif; ?> />
		
		<p>Allow filtering of the portfolio by category?</p>
		<input type="checkbox" name="sp8ce_show_categories" value="1" <?php if ($showCategories == 1): ?>checked="checked"<?php endif; ?> />
		<?php submit_button(); ?>
	</form>
		
	</div>
</div>