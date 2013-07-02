<?php

//debug($course);
//debug($courseUsers);

$start = strtotime($course['Course']['start']);
$end = strtotime($course['Course']['end']);
$lengthOfCourse = round( abs( $end - $start ) / 60 / 60 / 24 / 7 );
?>
<div class="courses view">
	<h2><?php echo $course['Course']['name'] ?> <small>Grade <?php echo $course['Course']['grade'] ?></small></h2>
	<p><b><?php echo $course['Course']['school'] ?></b></p>
	<div class="row-fluid">
		<div class="span8">
			<p><?php echo $course['Course']['description'] ?></p>

			<?php
			if ( !empty($course['Series']['name']) ) {
				echo $this->Html->tag('p',
					$this->Html->tag('i',
						'This course is part of the series: ' . $this->Html->link($course['Series']['name'], array('controller' => 'series', 'action' => 'view', $course['Series']['id']))
					)
				);
			}
			?>
			<table>
				<tr>
					<td><b>Starts: </b><?php echo $this->Time->niceShort($course['Course']['start']) ?> (<?php echo $lengthOfCourse ?> weeks long)</td>
					<td><b>Language: </b><?php echo $course['Course']['language'] ?></td>
				</tr>
				<tr>
					<td><b>Location: </b><?php echo $course['Course']['location'] ?></td>
					<td><b>Grade Level: </b><?php echo $course['Course']['grade'] ?></td>
				</tr>
			</table>
			<hr />

			<p>
				<?php
				if ( !isset($courseUsers[$this->Session->read('Auth.User.id')]) ) {
					echo $this->Html->link('Register', array('action' => 'register', $course['Course']['id']), array('class' => 'btn btn-primary'));
				} else {
					echo $this->Html->link('Unregister', array('action' => 'unregister', $course['Course']['id']), array('class' => 'btn btn-danger'));
				}
				?>
			</p>
		</div>
		<div class="span4">
			<h3>Instructed by:</h3>
			<?php
			echo $this->element('Users.snpsht', array('useGallery' => true, 'userId' => $course['Teacher']['id'], 'thumbSize' => 'medium', 'thumbLink' => 'default', 'showFirstName' => true, 'showLastName' => true));
			?>
		</div>
	</div>


	
	<hr />
	<div class="related" style="display:none;">
		<h4><?php echo __('Lessons');?></h4>
		<?php if (!empty($course['Lesson'])):?>
			<table cellpadding = "0" cellspacing = "0">
			<tr>
				<th></th>
				<th><?php echo __('Name'); ?></th>
				<th><?php echo __('Description'); ?></th>
			</tr>
			<?php
				$i = 0;
				foreach ($course['Lesson'] as $childCourse): ?>
				<tr>
					<td><i class="icon-time" title="<?php echo $this->Time->niceShort($childCourse['start']);?> to <?php echo $this->Time->niceShort($childCourse['end']);?>"></i></td>
					<td><?php echo $this->Html->link($childCourse['name'], array('controller' => 'lessons', 'action' => 'view', $childCourse['id']));?></td>
					<td><?php echo strip_tags($childCourse['description']);?></td>
				</tr>
			<?php endforeach; ?>
			</table>
		<?php endif; ?>

	</div>


	<?php
//	if ( !empty($course['Media']) ) {
//		echo '<h4>Course Materials</h4>';
//		echo $this->element('Courses.displayMaterialsThumbs', array('media' => $course['Media']));
//	}
//
//	if ( !empty($course['Task']) ) {
//		echo '<h4>Assignments</h4>';
//		foreach ( $course['Task'] as $task ) {
//			echo '<li>'. $this->Html->link($task['name'], array('action' => 'assignment', $task['id'])) . '</li>';
//		}
//	}
//	if ( !empty($course['Form']) ) {
//		echo '<h4>Quizzes / Tests</h4>';
//		foreach ( $course['Form'] as $form ) {
//			echo '<li>'. $this->Html->link($form['name'], array('plugin' => 'forms', 'controller' => 'forms', 'action' => 'view', $form['id'])) . '</li>';
//		}
//	}
	?>

</div>



<?php
$this->set('context_menu', array('sidebar' => array(
	array(
		'heading' => 'Take this Course!',
		'items' => array(
			$this->Html->link(__('Create Your Account'), array('plugin'=>'users', 'controller'=>'users', 'action'=>'register'))
		)
	)
)));
//$this->set('context_menu', array('menus' => array(
//	array(
//		'heading' => $course['Course']['name'],
//		'items' => array(
//			$this->Html->link(__('Edit Course'), array('action' => 'edit', $course['Course']['id'])),
//			$this->Html->link(__('Edit Course Grading Options'), array('controller' => 'grades', 'action' => 'setup', $course['Course']['id'])),
//			$this->Form->postLink(__('Delete this Course'), array('action' => 'delete', $course['Course']['id']), null, __('Are you sure you want to delete %s ?', $course['Course']['name'])),
//			$this->Html->link(__('Create Quiz'), array('plugin' => 'forms', 'controller' => 'forms', 'action' => 'add', 'formanswer', 'Course', $course['Course']['id'])),
//			$this->Html->link(__('Add Course Materials'), array('plugin' => 'media', 'controller' => 'media', 'action' => 'add_resource')),
//			$this->Html->link(__('Create Assignment'), array('action' => 'assign', 'thing', $course['Course']['id'])),
//			),
//		),
//	array(
//		'heading' => 'Lessons',
//		'items' => array(
//			$this->Html->link(__('Create New Lesson'), array('controller' => 'lessons', 'action' => 'add')),
//			),
//		),
//	array(
//		'heading' => 'Courses',
//		'items' => array(
//			$this->Html->link(__('View All Courses'), array('action' => 'dashboard')),
//			$this->Html->link(__('View Your Courses'), array('action' => 'dashboard')),
//			),
//		),
//	)));
