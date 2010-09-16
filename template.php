<?php

/*
funciton switchback_breadcrum($breadcrum){
	return 'test';
}
*/


/** * Add frontpage 'active' state handling to menu links * and section 'active' state handling when child is active * and menu-[title] as css id * * modified from code originally posted at * rogerlopez.net/handbook/primary_menu_tweaks * */ 


/*
function phptemplate_menu_item_link($item, $link_item) {
	static $menu; 
	if (!isset($menu)) {
		$menu = menu_get_menu();
	} 
	$mid = $menu['path index'][$link_item['path']];
	$front = variable_get('site_frontpage','node');
	$attribs = isset($item['description']) ? array('title' => $item['description']) : array();
	$attribs['id'] = 'menu-'. str_replace(' ', '-', strtolower($item['title']));
	
	if((($link_item['path']=='<front>') && ($front==$_GET['q'])) || (menu_in_active_trail($mid))) {
		$attribs['class'] = 'active';
	}
	
	return l($item['title'], $link_item['path'], $attribs);	
}
*/


function phptemplate_breadcrumb($breadcrumb) { 
	if (!empty($breadcrumb)) {      
		$path = explode('/', $_SERVER['REQUEST_URI']);
		$title = drupal_get_title();
		if($path[2]) {
 	  		$breadcrumb[] = l(ucfirst($path[1]), $path[1]);
 	  		$breadcrumb[] = $title;
        	}
   		return implode(' › ', $breadcrumb);
  }
}


function dws_preprocess_page(&$vars) {
	$links = $vars['primary_links'];
	foreach ($links as $key => $link) {
		$links[$key]['html'] = true;
		$links[$key]['title'] = '<span>'. $link['title'] . '</span>';
	}
	$vars['primary_links'] = $links;
}

?>