<?php
/*
* Plugin Name: Wp LimitTags  
* Plugin URI: https://github.com/meumairakram/Wp-tag-limiter
* Description: A simple yet Useful Plugin by Umair Akram to Limit the Number of Tags in TagCloud  
* Author: Umair Akram 
* Author URI: http://www.codeivo.com/umair-akram
* Version: 2.3  
* License: GPLv2 or later 
*/

add_action("admin_menu", "wplt_add_menu");

function wplt_add_menu() {
	add_options_page('WP Tags Limiter', 'WP Tag Limiter','delete_posts','co-wp-tag-limiter','wplt_codeivo_tag_limiter');
}


function wplt_codeivo_tag_limiter() {
	$tag_limit_option = 'wplt_tag_limit';
	$tag_limit_value = get_option($tag_limit_option);
	
	$form_action = htmlspecialchars($_SERVER['PHP_SELF']);
	
	if (empty($_POST)): 
		if (!$tag_limit_value) $tag_limit_value = 0;
		$testing = "<a href='test'>Test</a>";
		$input_form_head = 
<<<EOT
	<div>
		<h1>Wordpress Tag Limiter Plugin </h2>
		<p> Enter the Number of Tags you want to Limit too (Only Number)</p>
		<p>[ Set to '0' to display all tags, or Leave Empty ]</p>

		<form action="$form_action?page=co-wp-tag-limiter" method="POST">
EOT;
			$input_form_nonce = wp_nonce_field('check-input-form', 'form-check-field');
			$input_form_foot = 
<<<EOT
			<input type="text" name="tag_limit_input" value="$tag_limit_value" class="tag_limiter_class" />
			<input type="submit" value="Set Limit" class="button button-primary button-large" >
		</form>
	</div>
EOT;
		echo $input_form_head . $input_form_nonce . $input_form_foot;
	
	else: 
		if (!wp_verify_nonce($_POST['form-check-field'], 'check-input-form')) {
			echo 'Sorry! Something went wrong.';
			die();
		}

		$tag_limit_input = $_POST['tag_limit_input'];

		if (!is_numeric($tag_limit_input)) {
			$input_form_head = 
<<<EOT
	<div>
		<h1>Wordpress Tag Limiter Plugin </h2>
		<p> Enter the Number of Tags you want to Limit too (Only Number)</p>
		<p>[ Set to '0' to display all tags, or Leave Empty ]</p>

		<form action="$form_action?page=co-wp-tag-limiter" method="POST">
EOT;
			$input_form_nonce = wp_nonce_field('check-input-form', 'form-check-field');
			$input_form_foot = 
<<<EOT
			<div class="alert alert-warning">Please enter a valid number!</div>
			<input type="text" name="tag_limit_input" value="$tag_limit_value" class="tag_limiter_class" />
			<input type="submit" value="Set Limit" class="button button-primary button-large" >
		</form>
	</div>
EOT;
			echo $input_form_head . $input_form_nonce . $input_form_foot;
		}
		else {
			$tag_limit_input = trim($tag_limit_input);
			$tag_limit_input = filter_var($tag_limit_input, FILTER_SANITIZE_NUMBER_INT);
			
			update_option($tag_limit_option, $tag_limit_input);
			echo '<p>Tag Limit Updated</p><br><a href="javascript:history.go(-1)"> << Go Back </a>';
		}

	endif; 
}

include 'functions.php';
