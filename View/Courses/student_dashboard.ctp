<h2>Overview of My Courses</h2>

<ul><h3>Courses</h3>
	<?php
	if ( $userRoleId === '8' || $userRoleId === '1' ) {
		echo $this->Html->tag('li',
				$this->Html->link('<i class="icon-plus"></i>', array('plugin' => 'courses', 'controller' => 'courses', 'action' => 'add'), array('title' => 'add', 'class' => 'btn btn-mini', 'escape' => false))
		);
	}
	
	if ( empty($courses) ) {
		echo 'You haven\'t signed up for any courses yet. <a href="/courses/courses/">Browse Courses</a>';
	}
	foreach ($courses as $course) {
		
		if ( $userRoleId === '8' || $userRoleId === '1' ) {
			$editLinks = $this->Html->link('<i class="icon-edit"></i>', array('plugin' => 'courses', 'controller' => 'courses', 'action' => 'edit', $course['Course']['id']), array('title' => 'edit', 'class' => 'btn btn-mini', 'escape' => false));
		} else { $editLinks = ''; }
		
		echo $this->Html->tag('li',
				$this->Html->tag('div',
						$this->Html->link($course['Course']['name'], array('plugin' => 'courses', 'controller' => 'courses', 'action' => 'view', $course['Course']['id'])) . '<br />'
						. $editLinks
						, array('class' => 'span9')
				)
				. $this->Html->tag('div',
						$this->Time->niceShort($course['Course']['start']). ' -<br />'
						. $this->Time->niceShort($course['Course']['end'])
						, array('class' => 'span3')
				),
				array( 'class' => 'row-fluid' )
		);
	}
	?>
</ul>

<ul><h3>edUCASTs</h3>
	<li><a href="/media/media/record">teacher: add eduCast</a></li>
	<li><a href="/courses/educasts/edit/1">teacher: edit eduCast</a></li>
	<li><a href="/courses/educasts/view/1">student: view eduCast</a></li>
</ul>

<ul><h3>Series</h3>
	<li><a href="/courses/series/add">teacher: add series</a></li>
	<li><a href="/courses/series/edit/1">teacher: edit series</a></li>
	<li><a href="/courses/series/view/1">student: view series</a></li>
</ul>

<ul><h3>Notes <small>(populated automatically from SyncTutor)</small></h3>
	<li>one</li>
	<li>two</li>
	<li>three</li>
</ul>