<?php
get_header();
while(have_posts()){
	the_post();
  pageBanner();
	?>
	

  <div class="container container--narrow page-section">
<?php 
$parentId = wp_get_post_parent_id(get_the_ID());
if ($parentId){ ?>

	<div class="metabox metabox--position-up metabox--with-home-link">
      <p><a class="metabox__blog-home-link" href="<?php echo get_the_permalink($parentId)?>"><i class="fa fa-home" aria-hidden="true"></i> Back to <?php echo get_the_title($parentId)?></a> <span class="metabox__main"><?php the_title()?></span></p>
    </div>
<?php }?>
    
    <?php
    $testArray = get_pages(array(
    	'child_of' => get_the_ID()));

    if ($parentId or $testArray){ ?>

    <div class="page-links">
      <h2 class="page-links__title"><a href="<?php echo get_permalink($parentId); ?>"><?php echo get_the_title($parentId); ?></a></h2>
      <ul class="min-list">
        <?php 
        if ($parentId){
        	$childrenOf = $parentId;
        } else {
        	$childrenOf = get_the_ID();
        }
        wp_list_pages(array(
        	'title_li' => NULL,
        	'child_of' => $childrenOf
        )); 
        ?>
      </ul>
    </div>
<?php }?>

    <?php get_search_form(); ?>

 
	<?php  
	get_footer();
	
}

?>