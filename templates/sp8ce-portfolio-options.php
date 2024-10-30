<?php
	$tab = 'about';
	if (isset($_GET['tab'])) {
		$tab = $_GET['tab'];
	}
	switch ($tab) {
		case 'about':
		default:
			include('sp8ce-portfolio-about.php');
			break;
		case 'directions':
			include('sp8ce-portfolio-directions.php');
			break;
		case 'choose-theme':
			include('sp8ce-portfolio-choose-theme.php');
			break;
		case 'add-shortcode':
			include('sp8ce-portfolio-add-shortcode.php');
			break;
	}

	?>

<!--
<div class="wrap">
	<h1>Sp8ce Portfolio Options</h1>
	<p>Welcome to Sp8ce Design</p>
	
	<form method="post" action="options.php"> 
		<?php 
			settings_fields('sp8ce-portfolio-settings'); 
			do_settings_sections('sp8ce-portfolio-settings');
			
			$currentSetting = get_option('sp8ce_show_poweredby', false);
		?>
		<p>Show a link to Sp8ce Design below your portfolio?</p>
		<input type="checkbox" name="sp8ce_show_poweredby" value="1" <?php if ($currentSetting == 1): ?>checked="checked"<?php endif; ?> />
		
		<?php submit_button(); ?>
	</form>
</div>		
		-->