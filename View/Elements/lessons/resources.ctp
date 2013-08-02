<?php

if ( !empty($lesson['Media']) ) {
	echo '<h4>Lesson Materials</h4>';
	echo $this->element('Courses.displayMaterialsThumbs', array('media' => $lesson['Media']));
}
