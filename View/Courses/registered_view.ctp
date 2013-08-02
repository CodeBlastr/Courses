<div class="row-fluid">
<?php

//debug($course);
//debug($courseUsers);

$start = strtotime($course['Course']['start']);
$end = strtotime($course['Course']['end']);
$lengthOfCourse = round( abs( $end - $start ) / 60 / 60 / 24 / 7 );

?>
<div class="courses view span8">
	<h2><?php echo $course['Course']['name'] ?> <small>Grade <?php echo $course['Course']['grade'] ?></small></h2>
	<p><b><?php echo $course['Course']['school'] ?></b></p>
	<p><?php echo $course['Course']['description'] ?></p>

	<?php
	if ( !empty($course['CourseSeries']['name']) ) {
		echo $this->Html->tag('p',
			$this->Html->tag('i',
				'This course is part of the series: ' . $this->Html->link($course['CourseSeries']['name'], array('controller' => 'courseSeries', 'action' => 'view', $course['CourseSeries']['id']))
			)
		);
	}
	?>
		
	<?php 
	
	if (!empty($courseUsers[$this->Session->read('Auth.User.id')]['CourseUser']['is_complete'])) {
		echo $this->Rating->display(array(
			'item' => $course['Course']['id'],
			'type' => 'radio',
			'stars' => 5,
			'value' => $item['rating'],
			'createForm' => array('url' => array(/*$this->passedArgs, */'rate' => $course['Course']['id'], 'redirect' => true))));
	} ?>

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
	<p>
		<?php
		if ( !empty($course['CourseSeries']) && ($course['CourseSeries']['is_sequential'] === true) ) {
			// (un)register from a sequential Series
			if ( !isset($courseUsers[$this->Session->read('Auth.User.id')]) ) {
				echo $this->Html->link('Register for ' . $course['CourseSeries']['name'], array('controller' => 'courseSeries', 'action' => 'register', $course['CourseSeries']['id']), array('class' => 'btn btn-primary'));
			} else {
				echo $this->Html->link('Drop ' . $course['CourseSeries']['name'], array('controller' => 'courseSeries', 'action' => 'unregister', $course['CourseSeries']['id']), array('class' => 'btn btn-danger'));
			}
		} else {
			// (un)register from a normal Course
			if ( !isset($courseUsers[$this->Session->read('Auth.User.id')]) ) {
				echo $this->Html->link('Register', array('action' => 'register', $course['Course']['id']), array('class' => 'btn btn-primary'));
			} else {
				echo $this->Html->link('Drop Course', array('action' => 'unregister', $course['Course']['id']), array('class' => 'btn btn-danger'));
			}
		}
		?>
	</p>
	<hr />

	<div class="related row span12">
		<h4><?php echo __('Lessons');?></h4>
		<?php if (!empty($course['CourseLesson'])):?>
			<table cellpadding = "0" cellspacing = "0">
			<tr>
				<th></th>
				<th><?php echo __('Name'); ?></th>
				<th><?php echo __('Description'); ?></th>
			</tr>
			<?php
				$i = 0;
				foreach ($course['CourseLesson'] as $childCourse): ?>
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

	// Assignments
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

	if ( !empty($course['Media']) ) {
				echo '<h4>Course Materials</h4>';
				foreach($course['Media'] as $media) {
					echo $this->Media->display($media, array('width' => 100, 'height' => 100));
				}
				
			}

	?>


</div>
	<div class="span4 pull-right">
		<?php
		// calendar
		echo $this->Calendar->renderCalendar(array(
			'sources' => array(
				'/courses/courses/calendar/teacher/' . $course['Course']['id']
			),
			'header' => array('left' => 'title', 'center' => false, 'right' => 'today prev next')
		));
		?>

		<h5>Group Wall</h5>
		<?php echo $this->Html->link('view all', array('plugin' => 'users', 'controller' => 'userGroups', 'action' => 'view', $course['UserGroup']['id'])); ?>
		<?php echo $this->element('groupActivity', array('id' => $course['UserGroup']['id']), array('plugin' => 'Users')); ?>

		<h5>Course Messages</h5>
		<?php echo $this->element('inbox', array('model' => 'Course', 'foreignKey' => $course['Course']['id']), array('plugin' => 'Messages')); ?>

		<?php
		// roster
		if ( !empty($courseUsers) ) {
			echo '<h5>Roster</h5>';
			foreach ( $courseUsers as $user ) {
				$userCells[] = array(
					$this->Html->link($user['User']['last_name'] . ', ' . $user['User']['first_name'], array('plugin' => 'users', 'controller' => 'users', 'action' => 'view', $user['User']['id']))
				);
			}
			echo $this->Html->tag('table', $this->Html->tableCells($userCells));
		}
		?>
	</div>

</div>

<?php
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => $course['Course']['name'],
		'items' => array(
			$this->Html->link('<i class="icon-book"></i>'.__('View Gradebook'), array('controller' => 'gradebooks', 'action' => 'view', $course['Course']['id']), array('escape' => false)),
			$this->Form->postLink('<i class="icon-remove"></i>'.__('Drop this Course'), array('action' => 'unregister', $course['Course']['id']), array('escape' => false), __('Are you sure you want to drop %s ?', $course['Course']['name']))
			),
		),
	)));
