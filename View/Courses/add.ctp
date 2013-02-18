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
		echo $this->Form->input('Course.grade');
		echo $this->Form->input('Course.language');
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
		<li><?php echo $this->Html->link(__('List Courses'), array('controller' => 'courses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Parent Course'), array('controller' => 'courses', 'action' => 'add')); ?> </li>
	</ul>
</div>
