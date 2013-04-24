<?php

//debug($lessons);break;

$start = strtotime($lessons['Lesson']['start']);
$end = strtotime($lessons['Lesson']['end']);
$lengthOfCourse = round( abs( $end - $start ) / 60 / 60 / 24 / 7 );
?>
<div class="lessons view">
	<h2><?php echo $lessons['Lesson']['name'] ?></h2>
	<p><?php echo $lessons['Lesson']['description'] ?></p>
	<hr />
	<p>
		<b>Starts: </b><?php echo $this->Time->niceShort($lessons['Lesson']['start']) ?> (<?php echo $lengthOfCourse ?> weeks long)
	</p>
	<p>
		<b>Location: </b><?php echo $lessons['Lesson']['location'] ?>
	</p>
	<p>
		<b>Language: </b><?php echo $lessons['Lesson']['language'] ?>
	</p>
	<p><a href="#" class="btn btn-primary">Join</a></p>
	<hr />
	<?php
	if ( !empty($lessons['Form']) ) {
		echo '<h4>Quizzes / Tests</h4>';
		foreach ( $lessons['Form'] as $form ) {
			echo '<li>'. $this->Html->link($form['name'], array('plugin' => 'forms', 'controller' => 'forms', 'action' => 'view', $form['id'])) . '</li>';
		}
	}
	
	if ( !empty($lessons['Media']) ) {
		echo '<h4>Lesson Materials</h4>';
		foreach ( $lessons['Media'] as $media ) {
			echo '<li>'. $this->Html->link($media['title'], array('plugin' => 'media', 'controller' => 'media', 'action' => 'view', $media['id'])) . '</li>';
		}
	}
	?>
</div>


<?php
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => $course['Course']['name'],
		'items' => array(
			$this->Html->link(__('Edit Course'), array('action' => 'edit', $course['Course']['id'])),
			$this->Html->link(__('Edit Course Grading Options'), array('controller' => 'grades', 'action' => 'setup', $course['Course']['id'])),
			$this->Form->postLink(__('Delete this Course'), array('action' => 'delete', $course['Course']['id']), null, __('Are you sure you want to delete %s ?', $course['Course']['name'])),
			$this->Html->link(__('Create Quiz'), array('plugin' => 'forms', 'controller' => 'forms', 'action' => 'add', 'formanswer', 'Course', $course['Course']['id'])),
			$this->Html->link(__('Add Course Materials'), array('plugin' => 'media', 'controller' => 'media', 'action' => 'add_resource')),
			$this->Html->link(__('Create Assignment'), array('action' => 'assign', 'thing', $course['Course']['id'])),
			),
		),
	array(
		'heading' => 'Lessons',
		'items' => array(
			$this->Html->link(__('Create New Lesson'), array('controller' => 'lessons', 'action' => 'add')),
			$this->Html->link(__('Edit Lesson'), array('action' => 'edit', $lessons['Lesson']['id'])),
			$this->Html->link(__('Add Lesson Materials'), array('plugin' => 'media', 'controller' => 'media', 'action' => 'add_resource')),
			$this->Form->postLink(__('Delete Lesson'), array('action' => 'delete', $lessons['Lesson']['id']), null, __('Are you sure you want to delete # %s?', $lessons['Lesson']['id'])),
			),
		),
	array(
		'heading' => 'Courses',
		'items' => array(
			$this->Html->link(__('View All Courses'), array('controller' => 'courses')),
			$this->Html->link(__('View Your Courses'), array('controller' => 'courses', 'action' => 'dashboard')),
			),
		),
	)));
