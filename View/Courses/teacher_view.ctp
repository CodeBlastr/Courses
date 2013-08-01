<div class="row-fluid">
	<?php
	$start = strtotime($course['Course']['start']);
	$end = strtotime($course['Course']['end']);
	$lengthOfCourse = round(abs($end - $start) / 60 / 60 / 24 / 7);
	?>
	<div class="courses view span8">
		<h2><?php echo $course['Course']['name'] ?></h2>
		<p><b><?php echo $course['Course']['school'] ?></b></p>
		<!-- <p><?php echo $course['Course']['description'] ?></p> -->

		<?php
		if ( !empty($course['CourseSeries']['name']) ) {
			echo $this->Html->tag('p', $this->Html->tag('i',
					'This course is part of the series: ' . $this->Html->link($course['CourseSeries']['name'],
							array('controller' => 'courseSeries', 'action' => 'view', $course['CourseSeries']['id']))
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

			<div class="related">
				<?php if (!empty($course['Lesson'])):?>
					<h4><?php echo __('Lessons'); ?></h4>
					<table cellpadding = "0" cellspacing = "0">
					<tr>
						<th></th>
						<th><?php echo __('Name'); ?></th>
						<th><?php echo __('Description'); ?></th>
						<th><?php echo __('Actions'); ?></th>
					</tr>
					<?php
						$i = 0;
						foreach ($course['Lesson'] as $childCourse): ?>
						<tr>
							<td><i class="icon-time" title="<?php echo $this->Time->niceShort($childCourse['start']);?> to <?php echo $this->Time->niceShort($childCourse['end']);?>"></i></td>
							<td><?php echo $this->Html->link($childCourse['name'], array('controller' => 'lessons', 'action' => 'view', $childCourse['id']));?></td>
							<td><?php echo strip_tags($childCourse['description']);?></td>
							<td><?php echo $this->Html->link(__('Edit'), array('controller' => 'lessons', 'action' => 'edit', $childCourse['id'])); ?></td>
						</tr>
					<?php endforeach; ?>
					</table>
				<?php endif; ?>
			</div>

			<?php


			if ( !empty($course['Task']) ) {
				echo '<h4>Assignments</h4>';
				foreach ( $course['Task'] as $task ) {
					// count up completions
					$completionCount = count($task['ChildTask']);
					// build tr for this Assignment
					$assignmentCells[] = array(
						$this->Html->link($task['name'], array('action' => 'editAssignment', $task['id'])),
						$this->Time->niceShort($task['due_date']),
						$completionCount
					);
				}
				echo $this->Html->tag('table', $this->Html->tableHeaders(array('Name', 'Due Date', 'Completions')) . $this->Html->tableCells($assignmentCells));
			}


			// Ungraded Items
			if ( !empty($course['Grade']) ) {
				echo '<h5>Ungraded Quizzes / Tests</h5>';
				foreach ( $course['Grade'] as $grade ) {
					if ( $grade['grade'] === null ) {
						$studentGradeCells[] = array(
							$this->Html->link($courseUsers[$grade['student_id']]['User']['last_name'] . ', ' . $courseUsers[$grade['student_id']]['User']['first_name'], array('plugin' => 'courses', 'controller' => 'grades', 'action' => 'grade', $grade['foreign_key'], $grade['student_id'])),
							( $grade['grade'] === null ) ? '&mdash;' : $grade['grade']
						);
					}
				}
				if ( empty($studentGradeCells) ) {
					$studentGradeCells[] = array('<i class="muted">no items to grade</i>');
					$studentGradeHeader = false;
				} else {
					$studentGradeHeader = array('Student', 'Grade');
				}
				echo $this->Html->tag('table', $this->Html->tableHeaders($studentGradeHeader) . $this->Html->tableCells($studentGradeCells));
			}

			if ( !empty($course['Media']) ) {
				echo '<h4>Course Materials</h4>';
				foreach($course['Media'] as $media) {
					echo '<div class="span3">'.$this->Media->display($media, array('width' => 100, 'height' => 100)).'</div>';
				}
				
			}
			?>

	</div>

	<div class="span4 pull-right">

		<h5>Course Calendar</h5>
		<?php
		echo $this->Calendar->renderCalendar(array(
			'sources' => array(
				'/courses/courses/calendar/teacher/' . $course['Course']['id']
			),
			'header' => array('left' => 'title', 'center' => false, 'right' => 'today prev next')
		));
		?>

		<h5><?php echo $this->Html->link('Group Wall', array('plugin' => 'users', 'controller' => 'userGroups', 'action' => 'view', $course['UserGroup']['id'])) ?></h5>
		<?php echo $this->element('groupActivity', array('id' => $course['UserGroup']['id']), array('plugin' => 'Users')); ?>

		<h5>Course Messages</h5>
		<?php
		echo $this->element('inbox', array('model' => 'Course', 'foreignKey' => $course['Course']['id']), array('plugin' => 'Messages'));
		?>

		<h5>Roster</h5>
		<?php
		if ( !empty($courseUsers) ) {
			foreach ( $courseUsers as $user ) {
				$userCells[] = array(
					$this->Html->link($user['User']['last_name'] . ', ' . $user['User']['first_name'], array('plugin' => 'users', 'controller' => 'users', 'action' => 'view', $user['User']['id']))
				);
			}
			echo $this->Html->tag('table', $this->Html->tableCells($userCells));
		} else {
			echo '<i>no students</i>';
		}
		?>
	</div>
</div>


<?php
$this->set('context_menu', array('menus' => array(
		array(
			'heading' => $course['Course']['name'],
			'items' => array(
				$this->Html->link('<i class="icon-book"></i>' . __('View Gradebook'), array('controller' => 'course_gradebooks', 'action' => 'view', $course['Course']['id']), array('escape' => false)),
				//$this->Html->link('<i class="icon-list"></i>' . __('Create Quiz'), array('plugin' => 'answers', 'controller' => 'answers', 'action' => 'add', 'Course', $course['Course']['id']), array('escape' => false)),
				$this->Html->link('<i class="icon-folder-open"></i>' . __('Add Course Materials'), array('plugin' => 'media', 'controller' => 'media', 'action' => 'add_resource'), array('escape' => false)),
				//$this->Html->link('<i class="icon-calendar"></i>' . __('Create Assignment'), array('action' => 'assign', 'thing', $course['Course']['id']), array('escape' => false)),
				$this->Html->link('<i class="icon-calendar"></i>' . __('Create Assignment'), array('plugin' => 'tasks', 'controller' => 'tasks', 'action' => 'add'), array('escape' => false)),
				$this->Html->link('<i class="icon-pencil"></i>' . __('Send Message to Students'), array('action' => 'message', $course['Course']['id']), array('escape' => false)),
				$this->Html->link('<i class="icon-envelope"></i>' . __('Invite Students'), array('plugin' => 'invites', 'controller' => 'invites', 'action' => 'invitation', $course['Course']['id']), array('escape' => false)),
				$this->Html->link('<i class="icon-edit"></i>' . __('Edit Course'), array('action' => 'edit', $course['Course']['id']), array('escape' => false)),
				$this->Html->link('<i class="icon-cog"></i>' . __('Edit Course Grading Options'), array('controller' => 'course_grades', 'action' => 'setup', $course['Course']['id']), array('escape' => false)),
				$this->Form->postLink('<i class="icon-remove-sign"></i>' . __('Delete this Course'), array('action' => 'delete', $course['Course']['id']), array('escape' => false), __('Are you sure you want to delete %s ?', $course['Course']['name']))
			),
		),
		array(
			'heading' => 'Lessons',
			'items' => array(
				$this->Html->link('<i class="icon-facetime-video"></i>' . __('Create New Lesson'), array('controller' => 'course_lessons', 'action' => 'add', $course['Course']['id']), array('escape' => false)),
			),
		),
		array(
			'heading' => 'Courses',
			'items' => array(
				$this->Html->link('<i class="icon-th-list"></i>' . __('View All Courses'), array('action' => 'index'), array('escape' => false)),
				$this->Html->link('<i class="icon-briefcase"></i>' . __('View Your Courses'), array('action' => 'dashboard'), array('escape' => false)),
			),
		),
		array(
			'heading' => 'Quizzes/Tests',
			'items' => array(
				$this->Html->link('<i class="icon-th-list"></i>' . __('View All'), array('plugin' => 'answers', 'controller' => 'answers', 'action' => 'index'), array('escape' => false)),
				$this->Html->link('<i class="icon-plus"></i>' . __('Create New Quiz'), array('plugin' => 'answers', 'controller' => 'answers', 'action' => 'add'), array('escape' => false))
			),
		),
)));
