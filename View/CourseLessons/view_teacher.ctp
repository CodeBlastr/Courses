<?php
$this->Html->css('/courses/css/courses', null, array('inline'=>false));

$start = strtotime($lesson['CourseLesson']['start']);
$end = strtotime($lesson['CourseLesson']['end']);
$lengthOfCourse = round( abs( $end - $start ) / 60 / 60 / 24 / 7 );
?>
<div class="lessons view">
	<h2><?php echo $lesson['CourseLesson']['name'] ?></h2>
	<p><?php echo $lesson['CourseLesson']['description'] ?></p>
	<hr />
	<p>
		<b>Starts: </b><?php echo $this->Time->niceShort($lesson['CourseLesson']['start']) ?> (<?php echo $lengthOfCourse ?> weeks long)
	</p>
	<p>
		<b>Location: </b><?php echo $lesson['CourseLesson']['location'] ?>
	</p>
	<p>
		<b>Language: </b><?php echo $lesson['CourseLesson']['language'] ?>
	</p>
	<hr />
	
	<?php echo $this->Html->link('Create an Educast', array('plugin' => 'educasts', 'controller' => 'educasts', 'action' => 'add', 'CourseLesson', $lesson['CourseLesson']['id'] ), array('class' => 'btn btn-primary')); ?>
	
	<?php
	if ( !empty($lesson['Form']) ) {
		echo '<h4>Quizzes / Tests</h4>';
		echo '<ul>';
		foreach ( $lesson['Form'] as $form ) {
			echo '<li>'. $this->Html->link($form['name'], array('plugin' => 'forms', 'controller' => 'forms', 'action' => 'view', $form['id'])) . '</li>';
		}
		echo '<ul>';
	}
	
	if ( !empty($lesson['Media']) ) {
		echo '<h4>Lesson Materials</h4>';
		echo '<ul class="thumbnails">';
		foreach($lesson['Media'] as $media) {
			echo '<li class="span2">' . $this->Media->display($media, array('width' => 150, 'height' => 150, 'class' => 'thumbnail')) . '</li>';	
		}
		echo '</ul>';
	}
	?>
</div>


<?php
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => $this->Html->link($lesson['Course']['name'], array('controller' => 'courses', 'action' => 'view', $lesson['Course']['id'])),
//		'items' => array(
//			$this->Html->link(__('Edit Course'), array('action' => 'edit', $course['Course']['id'])),
//			$this->Html->link(__('Edit Course Grading Options'), array('controller' => 'grades', 'action' => 'setup', $course['Course']['id'])),
//			$this->Form->postLink(__('Delete this Course'), array('action' => 'delete', $course['Course']['id']), null, __('Are you sure you want to delete %s ?', $course['Course']['name'])),
//			$this->Html->link(__('Create Quiz'), array('plugin' => 'forms', 'controller' => 'forms', 'action' => 'add', 'formanswer', 'Course', $course['Course']['id'])),
//			$this->Html->link(__('Add Course Materials'), array('plugin' => 'media', 'controller' => 'media', 'action' => 'add_resource')),
//			$this->Html->link(__('Create Assignment'), array('action' => 'assign', 'thing', $course['Course']['id'])),
//			),
		),
	array(
		'heading' => $lesson['CourseLesson']['name'],
		'items' => array(
			$this->Html->link('<i class="icon-folder-open"></i>'.__('Add Lesson Materials'), array('plugin' => 'media', 'controller' => 'media', 'action' => 'add_resource'), array('escape' => false)),
			$this->Html->link('<i class="icon-edit"></i>'.__('Edit this Lesson'), array('action' => 'edit', $lesson['CourseLesson']['id']), array('escape' => false)),
			$this->Form->postLink('<i class="icon-remove-sign"></i>'.__('Delete this Lesson'), array('action' => 'delete', $lesson['CourseLesson']['id']), array('escape' => false), __('Are you sure you want to delete this lesson?')),
			),
		),
	array(
		'heading' => 'Lessons',
		'items' => array(
			$this->Html->link('<i class="icon-facetime-video"></i>'.__('Create New Lesson'), array('controller' => 'lessons', 'action' => 'add'), array('escape' => false)),
			),
		),
	array(
		'heading' => 'Courses',
		'items' => array(
			$this->Html->link('<i class="icon-th-list"></i>' . __('View All Courses'), array('action' => 'index'), array('escape' => false)),
			$this->Html->link('<i class="icon-briefcase"></i>' . __('View Your Courses'), array('action' => 'dashboard'), array('escape' => false)),
		),
		),
	)));
