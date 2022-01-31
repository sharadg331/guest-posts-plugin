<?php 
/*
Template Name: Custom Template  
*/

get_header();
 ?>
<?php 
if ( have_posts() ) {

	// Load posts loop.
	while ( have_posts() ) {
				the_post();
				the_content();
	}

}

?>

<?php get_footer(); ?>