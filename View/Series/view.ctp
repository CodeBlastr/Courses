<?php
echo $this->Html->tag('h1', $series['Series']['name']);
echo $this->Html->tag('p', $series['Series']['description']);
echo $this->Html->tag('hr');

echo $this->Html->tag('p', 'This series consists of the following courses:');
$seriesCourses = '';
foreach ( $series['Course'] as $course ) {
	$seriesCourses .= $this->Html->tag('li', $this->Html->link($course['name'], array( 'controller' => 'course', 'action' => 'view', $course['id'] )));
}
echo $this->Html->tag('ol', $seriesCourses);


//debug( $series );