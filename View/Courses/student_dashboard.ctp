<h2>Courses Dashboard</h2>

<ul><h3>My Courses</h3>
	<?php
	if ( empty($courses) ) {
		echo 'You haven\'t signed up for any courses yet. <a href="/courses/courses/">Browse Courses</a>';
	}
	foreach ($courses as $course) {	
		echo $this->Html->tag('div',
				$this->Html->tag('div',
						$this->Html->link($course['Course']['name'], array('plugin' => 'courses', 'controller' => 'courses', 'action' => 'view', $course['Course']['id']))
						, array('class' => 'span9')
				)
				. $this->Html->tag('div',
						$this->Time->niceShort($course['Course']['start'])
						. '<br />- ' . $this->Time->niceShort($course['Course']['end'])
						, array('class' => 'span3')
				),
				array( 'class' => 'row-fluid' )
		);
	}
	?>
</ul>

<ul><h3>My Notes <small>(populated automatically from SyncTutor)</small></h3>
	<li>one</li>
	<li>two</li>
	<li>three</li>
</ul>

<?php
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Courses',
		'items' => array(
			$this->Html->link(__('View All Courses'), array('action' => 'dashboard')),
			$this->Html->link(__('View Your Courses'), array('action' => 'dashboard')),
			),
		),
	)));
