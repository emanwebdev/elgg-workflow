<?php
/**
 *	Elgg-workflow plugin
 *	@package elgg-workflow
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license GNU Affero General Public License, version 3 or late
 *	@link https://github.com/ManUtopiK/elgg-workflow
 *
 *	Elgg-workflow view for workflow_card object
 *
 */

$workflow_card = elgg_extract('entity', $vars, FALSE);

if (!$workflow_card) {
	return TRUE;
}

$view_type = elgg_extract('view_type', $vars, FALSE);
$container = $workflow_card->getContainerEntity();
$user = elgg_get_logged_in_user_entity();

if ($view_type == 'group') {

	$workflow_card_id = "workflow-card-$workflow_card->guid";
	$workflow_card_class = "workflow-card mrs";

	$edit_area = '';
	if (is_group_member($container->guid, $user->guid) || $container->guid == $user->guid) {/*
		$controls = elgg_view('object/workflow_list/elements/controls', array(
			'workflow_list' => $workflow_list,
			'show_edit' => $edit_area != '',
			));
		$edit_area = elgg_view('object/workflow_list/elements/settings', array(
			'workflow_list' => $workflow_list,
		));
		$workflow_list_footer = elgg_view('object/workflow_list/elements/footer', array(
			'workflow_list' => $workflow_list,
		));*/

		$workflow_card_class .= " elgg-state-draggable";
	} else {
		$workflow_card_class .= " elgg-state-fixed";
	}

	$title = "<a class='workflow-edit-card' href='" . elgg_get_site_url() . "ajax/view/workflow/edit_card_popup?card_guid=$workflow_card->guid'>" . $workflow_card->title . "</a>";

$workflow_card_header = <<<HEADER
	<div class="workflow-card-handle clearfix"><h3>$title</h3>
	$controls
	</div>
HEADER;

$workflow_card_body = elgg_view('object/workflow_card/elements/body', array(
		'workflow_card' => $workflow_card,
	));

	echo elgg_view('page/components/module', array(
		'class' => $workflow_card_class,
		'id' => $workflow_card_id,
		'body' => $workflow_card_body,
		'header' => $workflow_card_header,
		'footer' => $workflow_card_footer,
	));

}
