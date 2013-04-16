<ol>FLOW:
	<li><a href="/courses/courses/add">Create the course</a></li>
	<li>Add Classes &AMP; Resources</li>
	<li><a href="/courses/grades/setup">Setup Gradebook</a></li>
	<li><a href="/forms/form_inputs/create">Add a Quiz</a></li>
	<li><a href="/invites/invites/invitation">Invite people</a></li>
</ol>

<div class="courses form">
<?php echo $this->Form->create('Series');?>
	<fieldset>
		<legend><?php echo __('Create a  Series'); ?></legend>
	<?php
//		echo $this->Form->input('Series.parent_id', array('options' => $parentCourses, 'label' => 'Parent Course'));
		echo $this->Form->input('Series.name');
		echo $this->Form->input('Series.description', array('label' => 'Description'));
//		echo $this->Form->input('Lesson.location');
//		echo $this->Form->input('Lesson.school');
//		echo $this->Form->input('Lesson.grade', array('options' => array('K','1','2','4','5','6','7','8','9','10','11','12')));
//		echo $this->Form->input('Lesson.language', array('options' => array('English', 'Spanish')));
//		echo $this->Form->input('Lesson.start', array('type' => 'time'));
//		echo $this->Form->input('Lesson.end', array('type' => 'time'));
//		echo $this->Form->input('Lesson.is_published', array('label' => 'Active / Inactive'));
//		echo $this->Form->input('Lesson.is_persistant', array('label' => 'Allow access when Inactive'));
//		echo $this->Form->input('Lesson.is_private', array('label' => 'Public / Private'));
		echo $this->Form->input('Series.is_sequential', array('label' => 'Require members to go only through the defined sequence', 'value' => '1', 'checked' => true));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Save'));?>
</div>




<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('List All Series'), array('action' => 'index'));?></li>
	</ul>
</div>
