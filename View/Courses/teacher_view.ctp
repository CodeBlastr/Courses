<div class="row-fluid">
	<?php
	$start = strtotime($course['Course']['start']);
	$end = strtotime($course['Course']['end']);
	$lengthOfCourse = round(abs($end - $start) / 60 / 60 / 24 / 7);
	?>
	<div class="courses view span8">
		<h2><?php echo $course['Course']['name'] ?></h2>
		<p><b><?php echo $course['Course']['school'] ?></b></p>
		<p><?php echo $course['Course']['description'] ?></p>

<?php
if ( !empty($course['Series']['name']) ) {
	echo $this->Html->tag('p', $this->Html->tag('i', 'This course is part of the series: ' . $this->Html->link($course['Series']['name'], array('controller' => 'series', 'action' => 'view', $course['Series']['id']))
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
			<?php


			if ( !empty($course['Task']) ) {
				echo '<h4>Assignments</h4>';
				foreach ( $course['Task'] as $task ) {
					echo '<li>' . $this->Html->link($task['name'], array('action' => 'assignment', $task['id'])) . '</li>';
					if ( !empty($task['ChildTask']) ) {
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
			if ( !empty($course['Form']) ) {
				echo '<h4>Quizzes / Tests</h4>';
				foreach ( $course['Form'] as $form ) {
					echo '<li>' . $this->Html->link($form['name'], array('plugin' => 'forms', 'controller' => 'forms', 'action' => 'view', $form['id'])) . '</li>';
				}
			}

			if ( !empty($course['Grade']) ) {
				echo '<h4>Submitted Answers</h4>';
				foreach ( $course['Grade'] as $grade ) {
					$studentGradeCells[] = array(
						$this->Html->link($courseUsers[$grade['student_id']]['User']['last_name'] . ', ' . $courseUsers[$grade['student_id']]['User']['first_name'], array('plugin' => 'courses', 'controller' => 'grades', 'action' => 'grade', $grade['form_id'], $grade['student_id'])),
						( $grade['grade'] === null ) ? '&mdash;' : $grade['grade']
					);
				}
				echo $this->Html->tag('table', $this->Html->tableHeaders(array('Student', 'Grade')) . $this->Html->tableCells($studentGradeCells));
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

	<div class="span4 pull-right">
		<?php
		// calendar
		echo $this->Calendar->renderCalendar(array(
			'sources' => array(
				'/courses/courses/calendar/teacher/' . $course['Course']['id']
			),
			'header' => array('left' => 'title', 'center' => false, 'right' => 'today prev next')
		));
		
		// messages
		echo $this->element('inbox', array('model' => 'Course', 'foreignKey' => $course['Course']['id']), array('plugin' => 'Messages'));

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
<div class="related row">
	<h4><?php echo __('Lessons'); ?></h4>
	<?php if ( !empty($course['Lesson']) ): ?>
		<table cellpadding = "0" cellspacing = "0">
			<tr>
				<th><?php echo __('Name'); ?></th>
				<th><?php echo __('Description'); ?></th>
				<th><?php echo __('Location'); ?></th>
				<th><?php echo __('Language'); ?></th>
				<th><?php echo __('Start'); ?></th>
				<th><?php echo __('End'); ?></th>
				<th><?php echo __('Is Published'); ?></th>
				<th><?php echo __('Is Private'); ?></th>
				<th><?php echo __('Is Persistant'); ?></th>
				<th><?php echo __('Is Sequential'); ?></th>
				<th class="actions"><?php echo __('Actions'); ?></th>
			</tr>
	<?php
	$i = 0;
	foreach ( $course['Lesson'] as $childCourse ):
		?>
				<tr>
					<td><?php echo $childCourse['name']; ?></td>
					<td><?php echo $childCourse['description']; ?></td>
					<td><?php echo $childCourse['location']; ?></td>
					<td><?php echo $childCourse['language']; ?></td>
					<td><?php echo $childCourse['start']; ?></td>
					<td><?php echo $childCourse['end']; ?></td>
					<td><?php echo $childCourse['is_published']; ?></td>
					<td><?php echo $childCourse['is_private']; ?></td>
					<td><?php echo $childCourse['is_persistant']; ?></td>
					<td><?php echo $childCourse['is_sequential']; ?></td>
					<td class="actions">
		<?php echo $this->Html->link(__('View'), array('controller' => 'lessons', 'action' => 'view', $childCourse['id'])); ?>
		<?php echo $this->Html->link(__('Edit'), array('controller' => 'lessons', 'action' => 'edit', $childCourse['id'])); ?>
		<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'lessons', 'action' => 'delete', $childCourse['id']), null, __('Are you sure you want to delete # %s?', $childCourse['id'])); ?>
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
						$this->Html->link('<i class="icon-book"></i>' . __('View Gradebook'), array('controller' => 'gradebooks', 'action' => 'view', $course['Course']['id']), array('escape' => false)),
						$this->Html->link('<i class="icon-list"></i>' . __('Create Quiz'), array('plugin' => 'forms', 'controller' => 'forms', 'action' => 'add', 'formanswer', 'Course', $course['Course']['id']), array('escape' => false)),
						$this->Html->link('<i class="icon-folder-open"></i>' . __('Add Course Materials'), array('plugin' => 'media', 'controller' => 'media', 'action' => 'add_resource'), array('escape' => false)),
						$this->Html->link('<i class="icon-calendar"></i>' . __('Create Assignment'), array('action' => 'assign', 'thing', $course['Course']['id']), array('escape' => false)),
						$this->Html->link('<i class="icon-envelope"></i>' . __('Invite Students'), array('plugin' => 'invites', 'controller' => 'invites', 'action' => 'invitation', $course['Course']['id']), array('escape' => false)),
						$this->Html->link('<i class="icon-edit"></i>' . __('Edit Course'), array('action' => 'edit', $course['Course']['id']), array('escape' => false)),
						$this->Html->link('<i class="icon-cog"></i>' . __('Edit Course Grading Options'), array('controller' => 'grades', 'action' => 'setup', $course['Course']['id']), array('escape' => false)),
						$this->Form->postLink('<i class="icon-remove-sign"></i>' . __('Delete this Course'), array('action' => 'delete', $course['Course']['id']), array('escape' => false), __('Are you sure you want to delete %s ?', $course['Course']['name']))
					),
				),
				array(
					'heading' => 'Lessons',
					'items' => array(
						$this->Html->link('<i class="icon-facetime-video"></i>' . __('Create New Lesson'), array('controller' => 'lessons', 'action' => 'add'), array('escape' => false)),
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
