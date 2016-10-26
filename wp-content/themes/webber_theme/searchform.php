<?php 
// Stop direct call
if (preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) {
    die('You are not allowed to call this page directly.');
}


?>
<!-- Just sample -->
<form method="get" id="searchform" action="/">
	<input type="text" value="<?php the_search_query(); ?>" name="s" id="s" class="findText" />
	<input type="submit" id="searchsubmit" value="Найти" class="findButton" />
</form>