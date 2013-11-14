<?php $courses = $this->request->data; ?>

<?php foreach ($courses as $course) : ?>
	<item>
		<title><?php echo $course['Course']['name'] ?></title>
		<link><?php echo $this->Html->url(array('controller' => 'course_series', 'action' => 'view', $course['Course']['id']), true); ?></link>
		<description><?php echo $course['Course']['description'] ?></description>
		<pubDate><?php echo date('r', strtotime($course['Course']['created'])); ?></pubDate>
	</item>
<?php endforeach; ?>
