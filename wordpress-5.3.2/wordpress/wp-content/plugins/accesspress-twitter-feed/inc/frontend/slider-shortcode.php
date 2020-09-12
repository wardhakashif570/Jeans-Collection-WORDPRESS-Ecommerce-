<?php
$aptf_settings = $this->aptf_settings;
$username = $aptf_settings['twitter_username'];
$tweets = $this->get_twitter_tweets($username, $aptf_settings['total_feed']);
$template = isset($atts['template'])?esc_attr($atts['template']):'template-1';
$auto_slide = isset($atts['auto_slide'])?esc_attr($atts['auto_slide']):'true';
$slide_controls = isset($atts['controls'])?esc_attr($atts['controls']):'true';
$slide_duration = isset($atts['slide_duration'])?esc_attr($atts['slide_duration']):'3000';
if(isset($atts['follow_button'])){
    if($atts['follow_button']=='true'){
        $aptf_settings['display_follow_button'] = 1;
    }
    else{
        $aptf_settings['display_follow_button'] = 0;
}
    
}
if(isset($tweets->errors)){
    //$this->print_array($tweets);
    $fallback_message = ($aptf_settings['fallback_message']=='')?__('Something went wrong with the twitter.','accesspress-twitter-feed'):esc_attr($aptf_settings['fallback_message']);
    ?>
<p><?php echo $fallback_message;?></p>
        <?php
}
else
{
    include('templates/slider/'.$template.'.php');
//var_dump($tweets);

}
?>

