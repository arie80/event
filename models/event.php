<?php
class Event extends EventAppModel{
	var $name = 'Event';
	var $useDbConfig = 'social';

	var $belongsTo = array(
		'Node' => array(
			)
	);
}
?>
