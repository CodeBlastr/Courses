<div class="lessons form">
<?php echo $this->Form->create('CourseLesson');?>
	<fieldset>
		<legend><?php echo __('Edit Lesson'); ?></legend>
	<?php
		echo $this->Form->input('CourseLesson.id');
		echo $this->Form->input('parent_id', array('options' => $parentCourses, 'empty' => array('false' => 'None'), 'label' => 'Make Part of a Course?'));
		echo $this->Form->input('CourseLesson.name', array('class' => 'required', 'placeholder' => 'Lesson Name', 'label' => false, 'class' => 'input-xxlarge'));
		echo $this->Form->input('CourseLesson.start', array('type' => 'datetime', 'class' => 'input-small required', 'label' => 'Start Date'));
		echo $this->Form->input('CourseLesson.end', array('type' => 'datetime', 'class' => 'input-small required', 'label' => 'End Date'));
//		echo $this->Html->tag('div',
//			$this->Form->input('Lesson.location', array('div' => array('class' => 'span3'), 'class' => 'required', 'placeholder' => 'Location', 'label' => false))
//			. $this->Form->input('Lesson.school', array('div' => array('class' => 'span4'), 'class' => 'required span12', 'placeholder' => 'School', 'label' => false))
//			. $this->Form->input('Lesson.grade', array('options' => array('K','1','2','4','5','6','7','8','9','10','11','12'), 'empty' => 'Grade', 'label' => false, 'class' => 'input-small required', 'div' => array('class' => 'span5')))
//		);
		echo $this->Form->input('CourseLesson.description', array('class' => 'input-xxlarge required', 'placeholder' => 'Description', 'label' => false));
		echo $this->Form->input('CourseLesson.is_published', array('label' => 'Active / Inactive'));
		echo $this->Form->input('CourseLesson.is_persistant', array('label' => 'Allow access when Inactive'));
		echo $this->Form->input('CourseLesson.is_private', array('label' => 'Public / Private'));
		echo $this->Form->input('CourseLesson.is_sequential', array('label' => 'Require members to go only through the defined sequence'));
		echo $this->Form->input('CourseLesson.language', array('options' => array('English' => 'English', 'Spanish' => 'Spanish')));
		echo $this->Element('Media.media_selector', array('media' => $this->request->data['Media']));
		echo !empty($layouts) ? __('<h5>Choose a theme</h5> %s', $this->Form->input('Template.layout', array('type' => 'radio'))) : null;

	?>
	</fieldset>
<?php
echo $this->Form->submit(__('Save'), array('class' => 'btn-primary'));
echo $this->Form->end();
?>
</div>

<?php
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => $this->Form->value('Lesson.name'),
		'items' => array(
			$this->Html->link('<i class="icon-folder-open"></i>'.__('Add Lesson Materials'), array('plugin' => 'media', 'controller' => 'media', 'action' => 'add_resource'), array('escape' => false)),
			$this->Form->postLink('<i class="icon-remove-sign"></i>'.__('Delete this Lesson'), array('action' => 'delete', $this->Form->value('CourseLesson.id')), array('escape' => false), __('Are you sure you want to delete this lesson?')),
		),
	)
)));
