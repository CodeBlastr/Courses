
<div class="courses form">
<?php echo $this->Form->create('CourseLesson');?>
	<fieldset>
		<legend><?php echo __('Add Lesson'); ?></legend>
	<?php
		echo $this->Form->input('CourseLesson.parent_id', array('options' => $parentCourses, 'label' => 'Parent Course'));
		echo $this->Form->input('CourseLesson.name');
		echo $this->Form->input('CourseLesson.description', array('label' => 'Description'));
//		echo $this->Form->input('Lesson.location');
//		echo $this->Form->input('Lesson.school');
//		echo $this->Form->input('Lesson.grade', array('options' => array('K','1','2','4','5','6','7','8','9','10','11','12')));
//		echo $this->Form->input('Lesson.language', array('options' => array('English', 'Spanish')));
//		echo $this->Form->input('Lesson.start', array('type' => 'time'));
//		echo $this->Form->input('Lesson.end', array('type' => 'time'));
//		echo $this->Form->input('Lesson.is_published', array('label' => 'Active / Inactive'));
//		echo $this->Form->input('Lesson.is_persistant', array('label' => 'Allow access when Inactive'));
//		echo $this->Form->input('Lesson.is_private', array('label' => 'Public / Private'));
//		echo $this->Form->input('Lesson.is_sequential', array('label' => 'Require members to go only through the defined sequence'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Save'));?>
</div>

<?php
$this->set('context_menu', array('menus' => array(

	array(
		'heading' => 'Courses',
		'items' => array(
			$this->Html->link('<i class="icon-th-list"></i>' . __('View All Courses'), array('controller' => 'courses', 'action' => 'index'), array('escape' => false)),
			$this->Html->link('<i class="icon-briefcase"></i>' . __('View Your Courses'), array('controller' => 'courses', 'action' => 'dashboard'), array('escape' => false)),
		),
	),
	)));
