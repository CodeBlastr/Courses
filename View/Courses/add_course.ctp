<ol>FLOW:
	<li>Create the course</li>
	<li><a href="/invites/invites/invitation">Invite people</a></li>
	<li><a href="/courses/classes/add">Add Classes &AMP; Resources</a></li>
	<li><a href="/courses/course_grades/setup">Setup Gradebook</a></li>
</ol>
<div class="courses form">
<?php echo $this->Form->create('Course');?>
	<fieldset>
		<legend><?php echo __('Add Course'); ?></legend>
	<?php
		echo $this->Form->input('Course.parent_id');
		echo $this->Form->input('Course.name');
		echo $this->Form->input('Course.description', array('label' => 'Description'));
		echo $this->Form->input('Course.location');
		echo $this->Form->input('Course.school');
		echo $this->Form->input('Course.grade', array('options' => array('K','1','2','4','5','6','7','8','9','10','11','12')));
		echo $this->Form->input('Course.language', array('options' => array('English', 'Spanish')));
		echo $this->Form->input('Course.start', array('type' => 'time'));
		echo $this->Form->input('Course.end', array('type' => 'time'));
		echo $this->Form->input('Course.is_published', array('label' => 'Active / Inactive'));
		echo $this->Form->input('Course.is_persistant', array('label' => 'Allow access when Inactive'));
		echo $this->Form->input('Course.is_private', array('label' => 'Public / Private'));
		echo $this->Form->input('Course.is_sequential', array('label' => 'Require members to go only through the defined sequence'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('List Courses'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('Add Series'), array('action' => 'add', 'series'));?></li>
		<li><?php echo $this->Html->link(__('Add Course'), array('action' => 'add', 'course'));?></li>
		<li><?php echo $this->Html->link(__('Add Lesson'), array('action' => 'add', 'lesson'));?></li>
	</ul>
</div>
