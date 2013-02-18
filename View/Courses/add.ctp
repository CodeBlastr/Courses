<div class="courses form">
<?php echo $this->Form->create('Course');?>
	<fieldset>
		<legend><?php echo __('Add Course'); ?></legend>
	<?php
		echo $this->Form->input('parent_id');
		echo $this->Form->input('lft');
		echo $this->Form->input('rght');
		echo $this->Form->input('name');
		echo $this->Form->input('description');
		echo $this->Form->input('location');
		echo $this->Form->input('school');
		echo $this->Form->input('grade');
		echo $this->Form->input('language');
		echo $this->Form->input('start');
		echo $this->Form->input('end');
		echo $this->Form->input('is_published');
		echo $this->Form->input('is_private');
		echo $this->Form->input('is_persistant');
		echo $this->Form->input('is_sequential');
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
