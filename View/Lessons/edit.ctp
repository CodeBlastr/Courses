<div class="lessons form">
<?php echo $this->Form->create('Lesson');?>
	<fieldset>
		<legend><?php echo __('Edit Lesson'); ?></legend>
	<?php
		echo $this->Form->input('Lesson.id');
		echo $this->Form->input('parent_id', array('options' => $parentCourses, 'empty' => array('false' => 'None'), 'label' => 'Make Part of a Course?'));
		echo $this->Form->input('Lesson.name', array('class' => 'required', 'placeholder' => 'Lesson Name', 'label' => false, 'class' => 'input-xxlarge'));
		echo $this->Form->input('Lesson.start', array('type' => 'datetime', 'class' => 'input-small required', 'label' => 'Start Date'));
		echo $this->Form->input('Lesson.end', array('type' => 'datetime', 'class' => 'input-small required', 'label' => 'End Date'));
//		echo $this->Html->tag('div',
//			$this->Form->input('Lesson.location', array('div' => array('class' => 'span3'), 'class' => 'required', 'placeholder' => 'Location', 'label' => false))
//			. $this->Form->input('Lesson.school', array('div' => array('class' => 'span4'), 'class' => 'required span12', 'placeholder' => 'School', 'label' => false))
//			. $this->Form->input('Lesson.grade', array('options' => array('K','1','2','4','5','6','7','8','9','10','11','12'), 'empty' => 'Grade', 'label' => false, 'class' => 'input-small required', 'div' => array('class' => 'span5')))
//		);
		echo $this->Form->input('Lesson.description', array('label' => 'Description', 'class' => 'input-xxlarge required', 'placeholder' => 'Description', 'label' => false));
		echo $this->Form->input('Lesson.is_published', array('label' => 'Active / Inactive'));
		echo $this->Form->input('Lesson.is_persistant', array('label' => 'Allow access when Inactive'));
		echo $this->Form->input('Lesson.is_private', array('label' => 'Public / Private'));
		echo $this->Form->input('Lesson.is_sequential', array('label' => 'Require members to go only through the defined sequence'));
		echo $this->Form->input('Lesson.language', array('options' => array('English' => 'English', 'Spanish' => 'Spanish')));
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
			$this->Form->postLink('<i class="icon-remove-sign"></i>'.__('Delete this Lesson'), array('action' => 'delete', $this->Form->value('Lesson.id')), array('escape' => false), __('Are you sure you want to delete this lesson?')),
		),
	)
)));
