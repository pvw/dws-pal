<?php

function dws_menu_item_link($link) {
    if (empty($link['localized_options'])) {
        $link['localized_options'] = array();
    }
    $link['localized_options'] += array('html'=> TRUE);
    return l($link['title'], $link['href'], $link['localized_options']);
}


function dws_preprocess_page(&$vars) {

	// Massage the primary links with "<span>title</span>".
	$links = $vars['primary_links'];
	foreach ($links as $key => $link) {
		$links[$key]['html'] = true;
		$links[$key]['title'] = '<span>'. $link['title'] . '</span>';
	}
	
    // Create the DWS logo item (without <span>)
    $site_path = $base_url . base_path();
    
	$first_link = array("first_item"=> array ());
	$first_link["first_item"]["attributes"] = array("title" => "DWS Logo");
	$first_link["first_item"]["href"] = $base_url . $base_path;
	$first_link["first_item"]["title"] = '<img src="' . $site_path .'themes/dws/logo.png" width="222" height="41" alt="DutchWaterSector" style="margin:0;padding:0;">';	
	$first_link["first_item"]["html"] = true;
    
    // Add the DWS logo item first to the primary links array
	$vars['primary_links'] = $first_link + $links;
}

function phptemplate_breadcrumb($breadcrumb) {
    $title = drupal_get_title();
    
	if (!empty($breadcrumb)) {
		$lastitem = sizeof($breadcrumb);
		$crumbs = '<ul id="breadcrum">';
		$a=1;
        
	    unset($breadcrumb[0]); // Remove the Drupal "home" item
		$crumbs .= '<li><a href="/"><span>Home</span></a></li>'; // Add RSR home item
	
		foreach($breadcrumb as $value) {
			if ($a!=$lastitem) {
				$bits = explode('>', $value);
				$out1 = '';
			
				$a=1;
		    	foreach($bits as $part) {
					if ($a==1) {
						$out1 .= $part . '><span>';
					}
					if ($a==2) {
						$slices = explode('<', $part);

						$out2 = '';
						$b = 1;
						foreach($slices as $fraction) {
							if($b==1) {
								$out2 .= $fraction . '</span></a>';  
							}
							$b++;
						}
						$out1 .= $out2;
					}
					$a++;
				}
				$crumbs .= '<li>' . $out1 . '</li>';
         		$a++;
			}
			else {
				$crumbs .= '<li class="breadcrumb-last">'.$value.'</li>';
			}
		}
		$crumbs .= '<li id="last_breadcrum_item">'.$title.'</li>';
		$crumbs .= '</ul>';
	}
	else {
		$crumbs = '<ul id="breadcrum"><li><a href="/"><span>Home</span></a></li><li id="last_breadcrum_item">' .$title. '</li></ul>';
	}
  	return $crumbs;
}

?>