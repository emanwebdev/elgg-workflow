<?php
/**
 *	Elgg-workflow plugin
 *	@package elgg-workflow
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license GNU Affero General Public License, version 3 or late
 *	@link https://github.com/ManUtopiK/elgg-workflow
 *
 *	Elgg-workflow edit card forms
 *
 */

// once elgg_view stops throwing all sorts of junk into $vars, we can use extract()
$title = elgg_extract('title', $vars, '');
$desc = elgg_extract('description', $vars, '');
$duedate = elgg_extract('duedate', $vars, '');
$assignedto = elgg_extract('assignedto', $vars, '');
$tags = elgg_extract('tags', $vars, '');
$access_id = elgg_extract('access_id', $vars, ACCESS_DEFAULT);
$card_guid = elgg_extract('guid', $vars, null);

$card = get_entity($card_guid);
$user_guid = elgg_get_logged_in_user_guid();

?>

<div>
	<label><?php echo elgg_echo('title'); ?></label><br />
	<?php echo elgg_view('input/text', array('name' => 'title', 'value' => $title)); ?>
</div>
<div>
	<label><?php echo elgg_echo('description'); ?></label>
	<?php echo elgg_view('input/longtext', array('name' => 'description', 'value' => $desc)); ?>
</div>
<div>
	<label><?php echo elgg_echo('workflow:duedate'); ?></label>
	<?php echo elgg_view('input/date', array('name' => 'duedate', 'value' => $duedate)); ?>
</div>
<?php if($user_guid != $card->container_guid) { ?>
<div>
	<label><?php echo elgg_echo('workflow:assignedto'); ?></label>
	<?php echo elgg_view('input/userpicker', array('name' => 'assignedto', 'value' => $assignedto)); ?>
</div>
<?php } ?>
<div>
	<label><?php echo elgg_echo('tags'); ?></label>
	<?php echo elgg_view('input/tags', array('name' => 'tags', 'value' => $tags)); ?>
</div>
<?php

$categories = elgg_view('input/categories', $vars);
if ($categories) {
	echo $categories;
}

?>
<?php if($user_guid != $card->container_guid) { ?>
<div>
	<label><?php echo elgg_echo('access'); ?></label><br />
	<?php echo elgg_view('input/access', array('name' => 'access_id', 'value' => $access_id)); ?>
</div>
<?php } ?>
<div class="elgg-foot">
	<?php
	
	echo elgg_view('input/hidden', array('name' => 'entity_guid', 'value' => $card_guid));
	
	echo elgg_view('input/submit', array('value' => elgg_echo("save")));
	
	echo elgg_view('input/button', array('value' => elgg_echo("delete"), 'class' => 'elgg-button-delete'));
	
	?>
	<div class="elgg-subtext">
		<?php
			echo elgg_view('output/url', array(
				'href' => $card->getURL(),
				'text' => elgg_echo('workflow:card:number', array($card_guid)),
				'is_trusted' => true,
			));
			$creator = get_entity($card->owner_guid);
			$creator_link = elgg_view('output/url', array(
				'href' => "profile/$creator->username",
				'text' => $creator->name,
				'is_trusted' => true,
			));
			echo  '<br/>' . elgg_echo('workflow:card:added', array(elgg_view_friendly_time($card->time_created), $creator_link));
		?>
	</div>
</div>
