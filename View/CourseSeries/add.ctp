<div class="coursesseries form">
<?php echo $this->Form->create('CourseSeries');?>
	<fieldset>
		<legend><?php echo __('Create a  Series'); ?></legend>
	<?php
//		echo $this->Form->input('CourseSeries.parent_id', array('options' => $parentCourses, 'label' => 'Parent Course'));
		echo $this->Form->input('CourseSeries.name');
		echo $this->Form->input('CourseSeries.description', array('label' => 'Description'));
		echo $this->Form->input('CourseSeries.is_sequential', array('label' => 'Require members to go only through the defined sequence', 'value' => '1', 'checked' => true));
		echo $this->Form->input('CourseSeries.is_private', array('label' => 'Private (public won\'t be able to view the series)', 'value' => '1', 'checked' => false));
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
