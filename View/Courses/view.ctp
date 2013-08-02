asdfasdf<?php

//debug($course);
//debug($courseUsers);

$start = strtotime($course['Course']['start']);
$end = strtotime($course['Course']['end']);
$lengthOfCourse = round( abs( $end - $start ) / 60 / 60 / 24 / 7 );

echo $this->Html->tag('div',
	$this->Calendar->renderCalendar(array(
		'sources' => array(
			'/courses/courses/calendar/teacher/'.$course['Course']['id']
		),
		'header' => array('left' => 'title', 'center' => false, 'right' => 'today prev next')
	))
	. $this->element('inbox', array('model' => 'Course', 'foreignKey' => $course['Course']['id']), array('plugin' => 'Messages'))
	, array('class' => 'span5 pull-right')
);

?>
<div class="courses view span7">
	<h2><?php echo $course['Course']['name'] ?> <small>Grade <?php echo $course['Course']['grade'] ?></small></h2>
	<p><b><?php echo $course['Course']['school'] ?></b></p>
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
	<hr />
	<p>
		<b>Starts: </b><?php echo $this->Time->niceShort($course['Course']['start']) ?> (<?php echo $lengthOfCourse ?> weeks long)
	</p>
	<p>
		<b>Location: </b><?php echo $course['Course']['location'] ?>
	</p>
	<p>
		<b>Language: </b><?php echo $course['Course']['language'] ?>
	</p>
	<p>
		<?php
		if ( !isset($courseUsers[$this->Session->read('Auth.User.id')]) ) {
			echo $this->Html->link('Register', array('action' => 'register', $course['Course']['id']), array('class' => 'btn btn-primary'));
		} else {
			echo $this->Html->link('Unregister', array('action' => 'unregister', $course['Course']['id']), array('class' => 'btn btn-danger btn-mini'));
		}
		?>
	</p>
	<hr />
	<?php
	if ( !empty($course['Media']) ) {
		echo '<h4>Course Materials</h4>';
		echo $this->element('Courses.displayMaterialsThumbs', array('media' => $course['Media']));
	}

	if ( !empty($course['Task']) ) {
		echo '<h4>Assignments</h4>';
		foreach ( $course['Task'] as $task ) {
			echo '<li>'. $this->Html->link($task['name'], array('action' => 'assignment', $task['id'])) . '</li>';
			if ( !empty($task['ChildTask']) && $isOwner ) {
				foreach ( $task['ChildTask'] as $childTask ) {
					//echo '<li>'. $this->Html->link($childTask['name'], array('action' => 'assignment', $task['id'])) . '</li>';
					$childTaskCells[] = array(
						$courseUsers[$childTask['assignee_id']]['User']['last_name'] . ', ' . $courseUsers[$childTask['assignee_id']]['User']['first_name'],
						$childTask['completed_date'],
						$this->Html->link('view', array('action' => 'assignment', $childTask['id']))
					);
				}
				echo $this->Html->tag('table', $this->Html->tableHeaders(array('Student', 'Date Completed', 'Actions')) . $this->Html->tableCells($childTaskCells));
			}
		}
	}
	

	if ( !empty($course['Grade']) && $isOwner ) {
		echo '<h4>Submitted Answers</h4>';
		foreach ( $course['Grade'] as $grade ) {
			$studentGradeCells[] = array(
				$this->Html->link($courseUsers[$grade['student_id']]['User']['last_name'].', '.$courseUsers[$grade['student_id']]['User']['first_name'], array('plugin' => 'courses', 'controller' => 'grades', 'action' => 'grade', $grade['form_id'], $grade['student_id'])),
				( $grade['grade'] === null ) ? '&mdash;' : $grade['grade']
			);
		}
		echo $this->Html->tag('table', $this->Html->tableHeaders(array('Student', 'Grade')) . $this->Html->tableCells($studentGradeCells));
	}

	if ( !empty($courseUsers) ) {
		echo '<h4>Course Roster</h4>';
		foreach ( $courseUsers as $user ) {
			$userCells[] = array(
				$this->Html->link($user['User']['last_name'].', '.$user['User']['first_name'], array('plugin' => 'users', 'controller' => 'users', 'action' => 'view', $user['User']['id']))
			);
		}
		echo $this->Html->tag('table', $this->Html->tableHeaders(array('Student Name')) . $this->Html->tableCells($userCells));
	}
	?>


	<dl>
<!--		<dt><?php echo __('Parent Course'); ?></dt>
		<dd>
			<?php echo $this->Html->link($course['ParentCourse']['name'], array('controller' => 'courses', 'action' => 'view', $course['ParentCourse']['id'])); ?>
			&nbsp;
		</dd>-->
	</dl>

</div>

<div class="related pull-left">
	<h4><?php echo __('Lessons');?></h4>
	<?php if (!empty($course['Lesson'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Description'); ?></th>
		<th><?php echo __('Location'); ?></th>
		<th><?php echo __('Language'); ?></th>
		<th><?php echo __('Start'); ?></th>
		<th><?php echo __('End'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($course['Lesson'] as $childCourse): ?>
		<tr>
			<td><?php echo $childCourse['name'];?></td>
			<td><?php echo $childCourse['description'];?></td>
			<td><?php echo $childCourse['location'];?></td>
			<td><?php echo $childCourse['language'];?></td>
			<td><?php echo $this->Time->niceShort($childCourse['start']);?></td>
			<td><?php echo $this->Time->niceShort($childCourse['end']);?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'course_lessons', 'action' => 'view', $childCourse['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'course_lessons', 'action' => 'edit', $childCourse['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'course_lessons', 'action' => 'delete', $childCourse['id']), null, __('Are you sure you want to delete # %s?', $childCourse['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

</div>

<?php
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => $course['Course']['name'],
		'items' => array(
			$this->Html->link(__('View Gradebook'), array('controller' => 'course_gradebooks', 'action' => 'view', $course['Course']['id'])),
			$this->Html->link(__('Add Course Materials'), array('plugin' => 'media', 'controller' => 'media', 'action' => 'add_resource')),
			$this->Html->link(__('Create Assignment'), array('action' => 'assign', 'thing', $course['Course']['id'])),
			$this->Html->link(__('Edit Course'), array('action' => 'edit', $course['Course']['id'])),
			$this->Html->link(__('Edit Course Grading Options'), array('controller' => 'course_grades', 'action' => 'setup', $course['Course']['id'])),
			$this->Form->postLink(__('Delete this Course'), array('action' => 'delete', $course['Course']['id']), null, __('Are you sure you want to delete %s ?', $course['Course']['name']))
			),
		),
	array(
		'heading' => 'Lessons',
		'items' => array(
			$this->Html->link(__('Create New Lesson'), array('controller' => 'course_lessons', 'action' => 'add', $course['Course']['id'])),
			),
		),
	array(
		'heading' => 'Courses',
		'items' => array(
			$this->Html->link(__('View All Courses'), array('action' => 'dashboard')),
			$this->Html->link(__('View Your Courses'), array('action' => 'dashboard')),
			),
		),	
	)));
