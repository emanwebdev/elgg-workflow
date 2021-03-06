<?php
/**
 *	Elgg-workflow plugin
 *	@package elgg-workflow
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license GNU Affero General Public License, version 3 or late
 *	@link https://github.com/ManUtopiK/elgg-workflow
 *
 *	Elgg-workflow group board view
 *
 */

$group = elgg_get_page_owner_entity();
$user_guid = elgg_get_logged_in_user_guid();

if (!$group || $group->type != 'group') {
	forward('workflow/owner/' . $user_guid);
}

// access check for closed groups
group_gatekeeper();

elgg_push_breadcrumb($group->name);

elgg_register_title_button('workflow', 'add_list');

$title = elgg_echo('workflow:owner', array($group->name));

$lists = elgg_get_entities(array(
	'type' => 'object',
	'subtypes' => 'workflow_list',
	'container_guid' => $group->guid,
	'limit' => 0
));

$sorted_lists = array();
foreach ($lists as $list) {
	$sorted_lists[$list->order] = $list;
}
ksort($sorted_lists);

$num_lists = count($lists);

// add the card popup and add-list popup
$addlist = '<div id="add-list" class="elgg-module elgg-module-popup hidden">' . elgg_view_form('workflow/list/add_list_popup') . '</div>';
$content .= $addlist . "<div id='workflow-card-popup' class='elgg-module elgg-module-popup hidden mbl'></div>";

$content .= "<div class='workflow-lists-container'><div class='workflow-lists'>";
foreach ($sorted_lists as $sorted_list) {
	$content .= elgg_view_entity($sorted_list, array('view_type' => 'group'));
}
$content .= "</div></div>";

if (!$lists) {
	$content = $addlist . '<div class="workflow-lists-container"><p>' . elgg_echo('workflow:list:none') . '</p></div>';
}

$sidebar .= elgg_view('workflow/sidebar');

$params = array(
	'content' => $content,
	'title' => $title,
	'sidebar' => $sidebar,
);
/*
if (elgg_instanceof($owner, 'group')) {
	$params['filter'] = '';
}
*/
$body = elgg_view_layout('workflow', $params);

echo elgg_view_page($title, $body);
