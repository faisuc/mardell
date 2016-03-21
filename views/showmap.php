<?php

global $wpdb;
$taxonomies = array(
	'mardell-map-tax'
);

$taxonomy_name = 'mardell-map-tax';

$categories = get_terms( $taxonomy_name, array( 'hide_empty' => 0 ) );

$i = 0;
$count = count($categories);
foreach ($categories as $category)
{
	$setimage = get_field('set_as_the_main_image', $category->taxonomy . '_' . $category->term_id);
	$image = get_field('image', $category->taxonomy . '_' . $category->term_id);
	$width = get_field('width' , $category->taxonomy . '_' . $category->term_id);
	$height = get_field('height' , $category->taxonomy . '_' . $category->term_id);
	$coords = get_field('coordinates' , $category->taxonomy . '_' . $category->term_id);
	if ($setimage == 1)	
	{
		echo "<img class='mardell_main_image' src='" . $image['url'] . "' width='$width' height='$height' border='0' usemap='#map' />";
	}

	?>

	<?php
		if ($i == 0)
		{
	?>
			<map name="map" id="map">
	<?php 
		}
	?>

		<area class="mardell_coords" shape="poly" coords="<?php echo $coords; ?>" id="<?php echo $category->term_id; ?>" />
		
	

	<?php
		if ($i == ($count-1))
		{
	?>
			</map>
	<?php 
		}
	?>

	<?php

	$i++;
}
?>

<div id="mardell_location_content">

</div>
<input type="hidden" id="ajaxUrl" value="<?php echo admin_url('admin-ajax.php'); ?>" />