<?php
/*------------------------------------------------------------------------
# com_testimonial_fader - Testimonial Fader
# ------------------------------------------------------------------------
# author    Infyways Solutions
# copyright Copyright (C) 2012 Infyways Solutions. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.infyways.com
# Technical Support:  Forum - http://support.infyways/com
-------------------------------------------------------------------------*/
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
function Testimonial_faderBuildRoute(&$query)
{
	$segments = array();
$app	= JFactory::getApplication();
	$menu	= $app->getMenu();
	$params	= JComponentHelper::getParams('com_contact');
	$advanced = $params->get('sef_advanced_link', 0);

	if (empty($query['Itemid'])) {
		$menuItem = $menu->getActive();
	} else {
		$menuItem = $menu->getItem($query['Itemid']);
	}
	$mView	= (empty($menuItem->query['view'])) ? null : $menuItem->query['view'];
	$mCatid	= (empty($menuItem->query['catid'])) ? null : $menuItem->query['catid'];
	$mId	= (empty($menuItem->query['id'])) ? null : $menuItem->query['id'];

	if (isset($query['view']))
	{
		$view = $query['view'];
		if (empty($query['Itemid'])) {
			$segments[] = $query['view'];
		}
		unset($query['view']);
	};

	// are we dealing with a contact that is attached to a menu item?
	if (isset($view) && ($mView == $view) and (isset($query['id'])) and ($mId == intval($query['id']))) {
		unset($query['view']);
		unset($query['id']);
		return $segments;
	}

	if (isset($view) and ($view == 'show' or $view == 'testimonial_fader'or $view == 'testimonialAddShow')) {
		if ($mId != intval($query['id']) || $mView != $view) {
		
			$menuCatid = $mId;
			$categories = JCategories::getInstance('testimonial_fader');
			$category = $categories->get($catid);
			if($category)
			{
				//TODO Throw error that the category either not exists or is unpublished
				$path = array_reverse($category->getPath());

				$array = array();
				foreach($path as $id)
				{
					if((int) $id == (int)$menuCatid)
					{
						break;
					}
					if($advanced)
					{
						list($tmp, $id) = explode(':', $id, 2);
					}
					$array[] = $id;
				}
				$segments = array_merge($segments, array_reverse($array));
			}
			if($view == 'show')
			{
				if($advanced)
				{
					list($tmp, $id) = explode(':', $query['id'], 2);
				} else {
					$id = $query['id'];
				}
				$segments[] = $id;
			}
			if($view == 'testimonialAddShow')
			{
				if($advanced)
				{
					list($tmp, $id) = explode(':', $query['id'], 2);
				} else {
					$id = $query['id'];
				}
				$segments[] = $id;
			}
		}
		unset($query['id']);
		unset($query['catid']);
	}

	

	return $segments;
}

function Testimonial_faderParseRoute($segments)
{
	$vars = array();

	// view is always the first element of the array
	$count = count($segments);

	if ($count)
	{
		$count--;
		$segment = array_shift($segments);
		if (is_numeric($segment)) {
			$vars['id'] = $segment;
		} else {
			$vars['task'] = $segment;
		}
	}

	if ($count)
	{
		$count--;
		$segment = array_shift($segments) ;
		if (is_numeric($segment)) {
			$vars['id'] = $segment;
		}
	}

	return $vars;
}
