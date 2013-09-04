<?php $this->Html->css('/courses/css/courses', null, array('inline'=>false)); ?>
<ul class="nav nav-tabs" id="courseDashboards">
	<li <?php echo !$teaches ? 'class="active"' : null; ?>><a href="#learning">Learning</a></li>
	<li <?php echo $teaches ? 'class="active"' : null; ?>><a href="#teaching">Teaching</a></li>
	<li><a href="#messages">Messages (<?php echo $this->requestAction('/messages/messages/count'); ?>)</a></li>
</ul>
<div class="tab-content">

	<!-- LEARNING TAB -->
	<div class="tab-pane <?php echo !$teaches ? 'active' : null; ?>" id="learning">
		
		<?php if (empty($coursesAsStudent)) { ?>
		<div class="row-fluid">
			<div class="alert alert-success span12">
				<h1>Get started by joining a class.</h1>
				<?php
				echo '<hr />';
				echo '<ul class="nav nav-pills">';
					$active = empty($this->params->pass[0]) ? 'active' : 'inactive';
					echo __('<li>%s</li>', $this->Html->link('All', array('action' => 'index')));
					foreach ($categories as $id => $category) {
						echo __('<li>%s</li>', $this->Html->link($category, array('action' => 'index', $id)));
					}
				echo '</ul>'; ?>
			</div>
		</div>
		<?php } else { ?>
		
		
		<div class="row-fluid">
			
			<div class="span6">
				<?php
				echo $this->Html->tag('h4', 'Browse Courses');
				echo '<hr />';
				echo '<ul class="nav nav-pills">';
					$active = empty($this->params->pass[0]) ? 'active' : 'inactive';
					echo __('<li>%s</li>', $this->Html->link('All', array('action' => 'index')));
					foreach ($categories as $id => $category) {
						echo __('<li>%s</li>', $this->Html->link($category, array('action' => 'index', $id)));
					}
				echo '</ul>';
				
				if ( !empty($coursesAsStudent) ) {
					echo $this->Html->tag('h4', 'Active Courses');
					echo '<hr />';
					echo '<div class="row-fluid">';
					echo '<div class="active-course-row span12">';
					foreach ( $coursesAsStudent as $course ) {
	
							echo $this->Html->tag('div',
								// $this->Html->link(
									// $this->Html->image('/courses/img/book-ed2.jpg'),
									// array('action' => 'view', $course['Course']['id']),
									// array('escape' => false, 'title' => 'View')
								// )
								$this->Html->tag('div',
									$this->Html->link(
										$course['Course']['name'],
										array('action' => 'view', $course['Course']['id']),
										array('escape' => false, 'title' => 'View')
									), array('class' => 'course-title')
								)
								, array('class' => 'course-item', 'style' => 'background-image:url("/courses/img/book-ed2.jpg")')
							);
					}
					echo '</div>';
					echo '<div class="clearfix"></div>';
					echo '<div class="shelf">';
					echo '<div class="shelf-middle">';
					echo '<div class="shelf-left"></div>';
					echo '<div class="shelf-right"></div>';
					echo '</div>';
					echo '</div>';
					echo '</div>';
				}	?>
			
				<h4>Courses Starting Soon</h4>
				<hr />
				<?php
				foreach ( $upcomingCourses as $upcomingCourse ) {
					echo $this->Html->tag('div',
							$this->Html->link($upcomingCourse['Course']['name'], array('action' => 'view', $upcomingCourses['Course']['id']))
							. '<p>'.$upcomingCourses['Course']['description'].'</p>'
							);
				}
				echo $this->Html->link('View All Courses', array('action' => 'index')); ?>
			</div>
			
			
			<div class="span6">
				<div class="noBulletsInMe">
					<h4>Upcoming Events</h4>
					<hr />
				</div>
				<div>
<!--					<h4>Your Grades</h4>-->
					<?php
//					echo $this->Html->link(
//									$this->Html->image('/courses/img/1372452108_korganizer.png'),
//									array('controller' => 'gradebooks', 'action' => 'view'),
//									array('escape' => false, 'title' => 'View')
//								);
					?>
				</div>
				
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
				
				if (!empty($tasks)) {
				 	echo '<table>';
					foreach ( $tasks as $task ) {
						if ( in_array($task['Task']['foreign_key'], $courseIdsAsStudent) ) {
							echo $this->Html->tag('tr',
									'<td class="muted">' . $this->Time->niceShort($task['Task']['due_date']) . '</td>' .
									'<td>' . $this->Html->link($task['Task']['name'], array('action' => 'assignment', $task['Task']['id'])) . '</td></tr>'
									);
						}
					}
					echo '</table>';
				} else {
					echo '<p class="muted">no upcoming events</p>';
				} ?>
			</div>
			
			
		</div>
		
			
		<?php } // end no courses check ?>

	</div>
	
	
	<!-- TEACHING TAB -->
	<div class="tab-pane <?php echo $teaches ? 'active' : null; ?>" id="teaching">
		
		<?php if (empty($coursesAsTeacher) && empty($seriesAsTeacher)) { ?>
		<div class="row-fluid">
			<div class="alert alert-success span12">
				<h1>Get started by creating a class.</h1>
				<?php
				echo '<hr />';
				echo '<ul class="nav nav-pills">';
					foreach ($categories as $id => $category) {
						echo __('<li>%s</li>', $this->Html->link($category, array('action' => 'add', $id)));
					}
				echo '</ul>'; ?>
			</div>
		</div>
		<?php } else { ?>
		<div class="row-fluid">
			<ul class="nav nav-pills">
			  <li><?php echo $this->Html->link('Add a Course', array('action' => 'add')); ?></li>
			</ul>
		</div>
		<div class="row-fluid">
			<div class="span12 course-listing">
				<?php
				if ( empty($coursesAsTeacher) && empty($seriesAsTeacher) ) {
					echo 'You haven\'t created any courses yet.  <a href="/courses/courses/add">Start Teaching</a>';
				}

				if ( !empty($seriesAsTeacher) ) {
					echo __('<h4>%s</h4><hr />', __('My Series'));
					foreach ( $seriesAsTeacher as $series ) {
						echo '<div class="row-fluid">';
						echo '<div class="series-row span12">';
						echo $this->Html->tag('h5', $series['CourseSeries']['name']);

						foreach ( $series['Course'] as $seriesCourse ) {
							echo $this->Html->tag('div',
								// $this->Html->link(
									// $this->Html->image('/courses/img/1372387287_tutorials.png'),
									// array('action' => 'view', $seriesCourse['id']),
									// array('escape' => false, 'title' => 'View')
								// )
								$this->Html->link(
									'<i class="icon-edit"></i>',
									array('action' => 'edit', $seriesCourse['id']),
									array('escape' => false, 'title' => 'Edit')
								)
								. $this->Html->tag('div',
									$this->Html->link(
										$seriesCourse['name'],
										array('action' => 'view', $seriesCourse['id']),
										array('escape' => false, 'title' => 'View')
									), array('class' => 'course-title')
								)
								, array('class' => 'course-item', 'style' => 'background-image:url("/courses/img/book-ed2.jpg")')
							);
						}
						
						echo '</div>';
						echo '<div class="clearfix"></div>';
						echo '<div class="shelf">';
						echo '<div class="shelf-middle">';
						echo '<div class="shelf-left"></div>';
						echo '<div class="shelf-right"></div>';
						echo '</div>';
						echo '</div>';
						echo '</div>';
					}
				}
				if ( !empty($coursesAsTeacher) ) {
					// debug($coursesAsTeacher);
					echo '<div class="row-fluid">';
					echo '<div class="course-row span12">';
					echo $this->Html->tag('h4', 'My Courses');
					foreach ( $coursesAsTeacher as $course ) {
						echo $this->Html->tag('div',
							// $this->Html->link(
								// $this->Html->image('/courses/img/book-ed2.jpg'),
								// array('action' => 'view', $course['Course']['id']),
								// array('escape' => false, 'title' => 'View')
							// )
							$this->Html->link(
								'<i class="icon-edit"></i>',
								array('action' => 'edit', $course['Course']['id']),
								array('escape' => false, 'title' => 'Edit')
							)
							. $this->Html->tag('div',
								$this->Html->link(
									$course['Course']['name'],
									array('action' => 'view', $course['Course']['id']),
									array('escape' => false, 'title' => 'View')
								), array('class' => 'course-title')
							)
							, array('class' => 'course-item', 'style' => 'background-image:url("/courses/img/book-ed2.jpg")')
						);
					}
					echo '</div>';
					echo '<div class="clearfix"></div>';
					echo '<div class="shelf">';
					echo '<div class="shelf-middle">';
					echo '<div class="shelf-left"></div>';
					echo '<div class="shelf-right"></div>';
					echo '</div>';
					echo '</div>';
					echo '</div>';
				}
				?>
			</div>
		</div>
		
		<div class="row-fluid">
			<div class="span6 pull-left">
				<div class="noBulletsInMe">
					<h4>Upcoming Events</h4>
					<hr />
					<?php
					$teachingEvents = '<table class="table table-striped">';
					foreach ( $tasks as $task ) {
						if ( in_array($task['Task']['foreign_key'], $courseIdsAsTeacher) ) {
							$teachingEvents .= $this->Html->tag('tr',
									'<td class="muted">' . $this->Time->niceShort($task['Task']['due_date']) . '</td>' .
									'<td>' . $this->Html->link($task['Task']['name'], array('action' => 'assignment', $task['Task']['id'])) . '</td></tr>'
									);
						}
					}
					$teachingEvents .= '</table>';
					
					if ( !empty($tasks) ) {
						echo $teachingEvents;
					} else {
						echo '<p class="muted">no upcoming events </p>';
					} ?>
				</div>
			</div>
			<div class="span6 pull-right">
				<div id="gradeBook">
					<h4>Gradebook</h4>
					<hr />
					<?php
					if ( !empty($coursesAsTeacher) || !empty($seriesAsTeacher) ) {
						echo $this->Html->link(
								$this->Html->image('/courses/img/1372452108_korganizer.png'),
								array('controller' => 'course_gradebooks', 'action' => 'view'),
								array('escape' => false, 'title' => 'View')
								);
					} else {
						echo '<i class="muted">no gradebooks</i>';
					}
					?>
				</div>
			</div>
		</div>
		<?php } // end classes started check ?>

	</div>
	
	<div class="tab-pane" id="messages">
		<div class="row-fluid">
			<div class="span12">
				<h4>Messages</h4>
				<?php echo $this->element('Messages.inbox') ?>
			</div>
		</div>
	</div>
</div>

<style>
	.shelf {
		height: 102px;
	}
	.shelf-middle {
		height: 102px;
		background: url('/upload/1/img/shelf_middle.png') transparent repeat-x bottom;
	}
	.shelf-left {
		float: left;
		width: 90px;
		height: 102px;
		background: url('/upload/1/img/shelf_left.png') transparent no-repeat bottom;
	}
	.shelf-right {
		float: right;
		width: 90px;
		height: 102px;
		background: url('/upload/1/img/shelf_right.png') transparent no-repeat bottom;
	}
	
	.series-row,
	.course-row,
	.active-course-row {
	   overflow-y: hidden;
	   overflow-x: auto;
	   padding: 0 20px;
	   margin-bottom: -8px;
	   position: relative;
       z-index: 2;
	}
	
	.course-row {
		margin-top:-20px;
	}
	
	.course-item {
		float: left;
    	height: 120px;
    	margin: 0 5px;
    	overflow: hidden;
    	width: 100px;
    	background-size: cover;
	}
	
	.course-item [class^="icon-"], [class*=" icon-"] {
    	background-image: url("/img/twitter-bootstrap/glyphicons-halflings-white.png");
	}
	
	.course-item .view {
		float: left;
    	margin-right: -100%;
	}
	
	.course-item .edit {
		display: none;
	}
	
	.course-item .course-title {
		width: 100%;
		background-color:rgba(0,0,0,0.5);
		height: 100%;
		position: relative;
		top: 120px;
	}
	
	.course-item .course-title a {
		color: #fff;
		position: relative;
		top:5px;
		width: 100%;
		text-align: center;
		font-size: 1.0em;
	}
</style>





<script type="text/javascript">
	$('#courseDashboards a').click(function(e) {
		e.preventDefault();
		var hashtag = $(this).attr('href');
		console.log(hashtag);
		window.location.hash = hashtag;
		$(this).tab('show');
	} )
	
	if (window.location.hash.length > 0) {
    	$('#courseDashboards > li > a[href="' + window.location.hash + '"]').tab('show');
	} 
	
	window.addEventListener('popstate', function(event) {
		if (window.location.hash.length > 0) {
	    	$('#courseDashboards > li > a[href="' + window.location.hash + '"]').tab('show');
		} 
	});
	
	$('.course-item').hover(function(e) {
		$(this).find('.course-title').animate({top: '25px'});
		$(this).find('.edit').show('fast');
	}, function (e) {
		$(this).find('.course-title').animate({top: '120px'});
		$(this).find('.edit').hide('fast');
	});
	
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
		array(
			'heading' => 'Quizzes/Tests',
			'items' => array(
				$this->Html->link('<i class="icon-th-list"></i>' . __('View All'), array('plugin' => 'answers', 'controller' => 'answers', 'action' => 'index'), array('escape' => false)),
				$this->Html->link('<i class="icon-plus"></i>' . __('Create New Course'), array('plugin' => 'answers', 'controller' => 'answers', 'action' => 'add'), array('escape' => false))
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