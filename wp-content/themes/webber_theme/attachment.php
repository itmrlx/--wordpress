<?php 
if (!is_front_page() || !is_home()){
  wp_redirect(get_permalink($post->post_parent), 301);
}
?>