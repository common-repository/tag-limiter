<?php

$wplt_tag_limit_option = 'wplt_tag_limit';
$wplt_tag_limit = get_option($wplt_tag_limit_option);

//Limit number of tags inside widget
function wplt_tag_widget_limiter($args){
    global $wplt_tag_limit;
    if ($wplt_tag_limit && $wplt_tag_limit != 0 ) {
        //Check if taxonomy option inside widget is set to tags
        if(isset($args['taxonomy']) && $args['taxonomy'] == 'post_tag'){
            $args['number'] = $wplt_tag_limit; //Limit number of tags
        }

        return $args;
    }
}

if ($wplt_tag_limit && $wplt_tag_limit != 0 ) {
    add_filter('widget_tag_cloud_args', 'wplt_tag_widget_limiter');
}
