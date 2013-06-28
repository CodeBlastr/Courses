
<ul class="nav nav-tabs" id="courseDashboards">
	<li class="active"><a href="#dashboard">Dashboard</a></li>
	<li><a href="#teaching">Teaching</a></li>
	<li><a href="#learning">Learning</a></li>
</ul>
<div class="tab-content">
	<div class="tab-pane active " id="dashboard">

		<div class="row-fluid">
			<div class="span5">
				<div>
					<h4>Upcoming `Tasks`</h4>
					<li></li>
					<li></li>
					<li></li>
					<li></li>
					<li></li>
				</div>
				<div>
					<h4>Upcoming Courses</h4>
					<li></li>
					<li></li>
					<li></li>
					<li></li>
					<li></li>
				</div>
			</div>
			<div class="span7">
<!--				<div>
					<?php echo $this->Html->image('http://placehold.it/300&text=300x250+callout+or+ad+spot') ?>
				</div>-->
				<div>
					<h4>Messages</h4>
					<?php echo $this->element('Messages.inbox') ?>
				</div>
			</div>
		</div>


	</div>

	<!-- TEACHING TAB -->
	<div class="tab-pane " id="teaching">

		<h3>Teaching</h3>

		<div class="row-fluid">
			<div class="span5">
				<div>
					<h4>Upcoming `Tasks`</h4>
					<li></li>
					<li></li>
					<li></li>
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
			<div class="span7">
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
		<h3>Learning</h3>


		<div class="row-fluid">
			<div class="span5">
				<div>
					<h4>Upcoming `Tasks`</h4>
					<li></li>
					<li></li>
					<li></li>
				</div>
				<div>
					<h4>Grades</h4>
					<?php
					echo $this->Html->link(
									$this->Html->image('/courses/img/1372452108_korganizer.png'),
									array('controller' => 'gradebooks', 'action' => 'view'),
									array('escape' => false, 'title' => 'View')
								);
					?>
				</div>
			</div>
			<div class="span7">
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