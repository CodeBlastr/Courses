
<ul class="nav nav-tabs" id="courseDashboards">
	<li class="active"><a href="#dashboard">Dashboard</a></li>
	<li><a href="#learning">Learning</a></li>
	<li><a href="#teaching">Teaching</a></li>
</ul>
<div class="tab-content">
	<div class="tab-pane active " id="dashboard">

		<div class="row-fluid">
			<div class="span6">
				<div>
					<h4>Upcoming `Tasks`</h4>
					<?php
					foreach ( $tasks as $task ) {
						echo $this->Html->tag('li',
								$this->Html->link($task['Task']['name'], array('plugin' => 'tasks', 'controller' => 'tasks', 'action' => 'view', $task['Task']['id']))
								. ' - ' . $this->Time->niceShort($task['Task']['due_date'])
								);
					}
					?>
				</div>
				<div>
					<h4>Upcoming Courses</h4>
					<?php
					foreach ( $upcomingCourses as $upcomingCourse ) {
						echo $this->tag('div',
								$this->Html->link($upcomingCourse['Course']['name'], array('action' => 'view', $upcomingCourses['Course']['id']))
								. '<p>'.$upcomingCourses['Course']['description'].'</p>'
								);
					}
					echo $this->Html->link('View All Courses', array('action' => 'index'));
					?>
				</div>
			</div>
			<div class="span6">
				<div>
					<?php
					// calendar
					if ( !empty($allCourseIds) ) {
						//debug($allCourseIds);
						foreach ( $allCourseIds as $courseId ) {
							$sources[] = '/courses/courses/calendar/teacher/' . $courseId;
						}
					}
					echo $this->Calendar->renderCalendar(array(
						'sources' => $sources,
						'header' => array('left' => 'title', 'center' => false, 'right' => 'today prev next')
					));
					// calendar action links
					echo $this->Html->link('<i class="icon-plus"></i>', array('plugin' => 'tasks', 'controller' => 'tasks', 'action' => 'add'), array('escape' => false, 'title' => 'Add a Task'));
					?>
				</div>
				<div>
					<h4>Messages</h4>
					<?php echo $this->element('Messages.inbox') ?>
				</div>
			</div>
		</div>


	</div>

	<!-- TEACHING TAB -->
	<div class="tab-pane " id="teaching">

		<div class="row-fluid">
			<div class="span6">
				<div>
					<h4>Upcoming `Tasks`</h4>
					<?php
					foreach ( $tasks as $task ) {
						if ( in_array($task['Task']['foreign_key'], $courseIdsAsTeacher) ) {
							echo $this->Html->tag('li',
								$this->Html->link($task['Task']['name'], array('plugin' => 'tasks', 'controller' => 'tasks', 'action' => 'view', $task['Task']['id']))
								. ' - ' . $this->Time->niceShort($task['Task']['due_date'])
								);
						}
					}
					?>
				</div>
				<div>
					<h4>Gradebook</h4>
					<?php
					echo $this->Html->link(
							$this->Html->image('/courses/img/1372452108_korganizer.png'),
							array('controller' => 'gradebooks', 'action' => 'view'),
							array('escape' => false, 'title' => 'View')
							);
					?>
				</div>
			</div>
			<div class="span6">
				<?php
				if ( empty($coursesAsTeacher) && empty($seriesAsTeacher) ) {
					echo 'You haven\'t created any courses yet. <a href="/courses/courses/add">Start Teaching</a>';
				}

				if ( !empty($seriesAsTeacher) ) {
					//debug($seriesAsTeacher);
					foreach ( $seriesAsTeacher as $series ) {
						//debug($series);
						echo '<div class="row-fluid">';
						echo $this->Html->tag('h4', $series['Series']['name']);
						foreach ( $series['Course'] as $seriesCourse ) {
							echo $this->Html->tag('div',
								$this->Html->link(
									$this->Html->image('/courses/img/1372387287_tutorials.png'),
									array('action' => 'view', $seriesCourse['id']),
									array('escape' => false, 'title' => 'View')
								)
								. $this->Html->link(
									'<i class="icon-edit"></i>',
									array('action' => 'edit', $seriesCourse['id']),
									array('escape' => false, 'title' => 'Edit')
								)
								. $this->Html->tag('p',
									$this->Html->link(
										$seriesCourse['name'],
										array('action' => 'view', $seriesCourse['id']),
										array('escape' => false, 'title' => 'View')
									)
								)
								, array('class' => 'span3')
							);
						}
						echo '</div>';
					}
				}
				if ( !empty($coursesAsTeacher) ) {
					#debug($coursesAsTeacher);
					foreach ( $coursesAsTeacher as $course ) {

							echo $this->Html->tag('h4', 'Courses');
							echo $this->Html->tag('div',
								$this->Html->link(
									$this->Html->image('/courses/img/1372387287_tutorials.png'),
									array('action' => 'view', $course['Course']['id']),
									array('escape' => false, 'title' => 'View')
								)
								. $this->Html->link(
									'<i class="icon-edit"></i>',
									array('action' => 'edit', $course['Course']['id']),
									array('escape' => false, 'title' => 'Edit')
								)
								. $this->Html->tag('p',
									$this->Html->link(
										$course['Course']['name'],
										array('action' => 'view', $course['Course']['id']),
										array('escape' => false, 'title' => 'View')
									)
								)
								, array('class' => 'span3')
							);
					}
				}
				?>
			</div>
		</div>

	</div>

	<!-- LEARNING TAB -->
	<div class="tab-pane " id="learning">

		<div class="row-fluid">
			<div class="span6">
				<div>
					<h4>Upcoming `Tasks`</h4>
					<?php
					foreach ( $tasks as $task ) {
						if ( in_array($task['Task']['foreign_key'], $courseIdsAsStudent) ) {
							echo $this->Html->tag('li',
								$this->Html->link($task['Task']['name'], array('plugin' => 'tasks', 'controller' => 'tasks', 'action' => 'view', $task['Task']['id']))
								. ' - ' . $this->Time->niceShort($task['Task']['due_date'])
								);
						}
					}
					?>
				</div>
				<div>
					<h4>Your Grades</h4>
					<?php
					echo $this->Html->link(
									$this->Html->image('/courses/img/1372452108_korganizer.png'),
									array('controller' => 'gradebooks', 'action' => 'view'),
									array('escape' => false, 'title' => 'View')
								);
					?>
				</div>
			</div>
			<div class="span6">
				<?php
				if ( empty($coursesAsStudent) ) {
					echo 'You haven\'t signed up for any courses yet. <a href="/courses/courses/">Start Learning</a>';
				} else {
					echo $this->Html->tag('h4', 'Active Courses');
					foreach ( $coursesAsStudent as $course ) {
						echo $this->Html->tag('div',
								$this->Html->link(
									$this->Html->image('/courses/img/1372387287_tutorials.png'),
									array('action' => 'view', $course['Course']['id']),
									array('escape' => false, 'title' => 'View')
								)
								. $this->Html->tag('p',
									$this->Html->link(
										$course['Course']['name'],
										array('action' => 'view', $course['Course']['id']),
										array('escape' => false, 'title' => 'View')
									)
								)
								, array('class' => 'span3')
							);
					}
				}
				?>
			</div>
		</div>

	</div>
</div>






<script>
	$( '#courseDashboards a' ).click( function( e ) {
		e.preventDefault();
		$( this ).tab( 'show' );
	} )
</script>


<?php
$this->set('context_menu', array('menus' => array(
		array(
			'heading' => 'Series',
			'items' => array(
				$this->Html->link('<i class="icon-th-list"></i>' . __('View All Series'), array('controller' => 'series', 'action' => 'index'), array('escape' => false)),
				$this->Html->link('<i class="icon-plus"></i>' . __('Create New Series'), array('controller' => 'series', 'action' => 'add'), array('escape' => false))
			),
		),
		array(
			'heading' => 'Courses',
			'items' => array(
				$this->Html->link('<i class="icon-th-list"></i>' . __('View All Courses'), array('action' => 'index'), array('escape' => false)),
				$this->Html->link('<i class="icon-plus"></i>' . __('Create New Course'), array('action' => 'add'), array('escape' => false))
			),
		),
)));

//$this->append('sidebar');
//echo $this->Html->tag('li', 'Series', array('class' => 'nav-header'));
//echo $this->Html->tag('li', $this->Html->link(__('View All Series'), array('controller' => 'series', 'action' => 'index')));
//echo $this->Html->tag('li', $this->Html->link(__('Create New Series'), array('controller' => 'series', 'action' => 'add')));
//echo $this->Html->tag('li', 'Courses', array('class' => 'nav-header'));
//echo $this->Html->tag('li', $this->Html->link(__('Create New Course'), array('action' => 'add')));
//$this->end();