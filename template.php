<?php
/*
funciton switchback_breadcrum($breadcrum){
	return 'test';
}
*/


/** * Add frontpage 'active' state handling to menu links * and section 'active' state handling when child is active * and menu-[title] as css id * * modified from code originally posted at * rogerlopez.net/handbook/primary_menu_tweaks * */ 


function dws_menu_item_link($link) {
  if (empty($link['localized_options'])) {
    $link['localized_options'] = array();
  }
  $link['title'] = $link['title'] = '<span class="link">' . check_plain($link['title']) . '</span>';
  $link['localized_options'] += array('html'=> TRUE);
  return l($link['title'], $link['href'], $link['localized_options']);
}


function dws_preprocess_page(&$vars) {
	$links = $vars['primary_links'];
	foreach ($links as $key => $link) {
		$links[$key]['html'] = true;
		$links[$key]['title'] = '<span>'. $link['title'] . '</span>';
	}
	$vars['primary_links'] = $links;
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

/* ---- old 


function phptemplate_breadcrumb($breadcrumb) {
    $title = drupal_get_title();
    
	if (!empty($breadcrumb)) {
		$lastitem = sizeof($breadcrumb);
		$crumbs = '<ul id="breadcrum">';
		$a=1;
        
	    // unset($breadcrumb[0]); // Remove the Drupal "home" item
		// $crumbs .= '<li><a href="/"><span>Home</span></a></li>'; // Add RSR home item
		//$lastitem--;
	
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

*/

?>