<?php 
    $mainSidebarMenu = require getConfig('app_root_dir').'/configs/sidebar.php';
    $current_route = router()->currentRoute;
    echo "<nav class='nav nav-col'><ul>";	
	foreach( $mainSidebarMenu  as $item) {
		$text = $item['text'];
		$link = $item['link'];
		$icon = $item['icon'];
        $active =  $current_route == $item['route']  ? 'active' : '';
		if( !is_null($link)) {
			$linkText = "href='$link'";
		}else {
			$linkText = '';
		}		
		$icon_tag = !is_null($icon) ? "<i class='fa fa-$icon' aria-hidden='true'></i>" : '';

		if($item['link'] == null) {
			echo  "<li class='nav-item $active'><span $linkText >$icon_tag $text</span></li>";
		}else{
			echo "<li class='nav-item $active'><a $linkText >$icon_tag $text</a></li>";
		}
	}
	echo "</ul></nav>";
?>
