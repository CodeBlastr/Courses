<?php
echo $this->Html->tag('h1', $series['CourseSeries']['name']);
echo $this->Html->tag('p', $series['CourseSeries']['description']);
echo $this->Html->tag('hr');

echo $this->Html->tag('p', 'This series consists of the following courses:');
$seriesCourses = '';
foreach ( $series['Course'] as $course ) {
	$seriesCourses .= $this->Html->tag('li', $this->Html->link($course['name'], array( 'controller' => 'courses', 'action' => 'view', $course['id'] )));
}
echo $this->Html->tag('ol', $seriesCourses);

/**
 * Menus !
 */
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Series',
		'items' => array(
			$this->Html->link(__('Edit this Series'), array('controller' => 'courseSeries', 'action' => 'edit', $series['CourseSeries']['id'])),
			$this->Html->link(__('Create New Series'), array('controller' => 'courseSeries', 'action' => 'add'))
			),
		),
	array(
		'heading' => 'Courses',
		'items' => array(
			$this->Html->link(__('View All Courses'), array('controller' => 'courses', 'action' => 'index')),
			$this->Html->link(__('View Your Courses'), array('controller' => 'cousres', 'action' => 'dashboard')),
			$this->Html->link(__('Create New Course'), array('controller' => 'courses', 'action' => 'add'))
			),
		),
	)));

$this->set('guest_menu', array('menus' => array(
	array(
		'heading' => 'Series',
		'items' => array(
			$this->Html->link(__('Edit this Series'), array('controller' => 'courseSeries', 'action' => 'edit', $series['CourseSeries']['id'])),
			$this->Html->link(__('Create New Series'), array('controller' => 'courseSeries', 'action' => 'add'))
			),
		),
	array(
		'heading' => 'Courses',
		'items' => array(
			$this->Html->link(__('View All Courses'), array('controller' => 'courses', 'action' => 'index')),
			$this->Html->link(__('View Your Courses'), array('controller' => 'courses', 'action' => 'dashboard')),
			$this->Html->link(__('Create New Course'), array('controller' => 'courses', 'action' => 'add'))
			),
		),
	)));

$this->set('owner_menu', array('menus' => array(
	array(
		'heading' => 'Series',
		'items' => array(
			$this->Html->link(__('Edit this Series'), array('controller' => 'courseSeries', 'action' => 'edit', $series['CourseSeries']['id'])),
			$this->Html->link(__('Create New Series'), array('controller' => 'courseSeries', 'action' => 'add'))
			),
		),
	array(
		'heading' => 'Courses',
		'items' => array(
			$this->Html->link(__('View All Courses'), array('controller' => 'couses', 'action' => 'index')),
			$this->Html->link(__('View Your Courses'), array('controller' => 'couses', 'action' => 'dashboard')),
			$this->Html->link(__('Create New Course'), array('controller' => 'couses', 'action' => 'add'))
			),
		),
	)));
