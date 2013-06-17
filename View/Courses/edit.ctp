<div class="courses form">
<?php echo $this->Form->create('Course');?>
	<fieldset>
		<legend><?php echo __('Edit Course'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('parent_id');
		echo $this->Form->input('Course.name', array('class' => 'required', 'placeholder' => 'Course Name', 'label' => false, 'class' => 'input-xxlarge'));
		echo $this->Form->input('Course.start', array('type' => 'datetime', 'class' => 'input-small required', 'label' => 'Start Date'));
		echo $this->Form->input('Course.end', array('type' => 'datetime', 'class' => 'input-small required', 'label' => 'End Date'));
		echo $this->Html->tag('div',
			$this->Form->input('Course.location', array('div' => array('class' => 'span3'), 'class' => 'required', 'placeholder' => 'Location', 'label' => false))
			. $this->Form->input('Course.school', array('div' => array('class' => 'span4'), 'class' => 'required span12', 'placeholder' => 'School', 'label' => false))
			. $this->Form->input('Course.grade', array('options' => array('K','1','2','4','5','6','7','8','9','10','11','12'), 'empty' => 'Grade', 'label' => false, 'class' => 'input-small required', 'div' => array('class' => 'span5')))
		);
		echo $this->Form->input('Course.description', array('label' => 'Description', 'class' => 'input-xxlarge required', 'placeholder' => 'Description', 'label' => false));
		
		echo '<span>Course Availability</span>';
		echo $this->Form->input('Course.is_published', array('label' => false, 'class' => 'checkboxToggle', 'data-yes' => 'Active', 'data-no' => 'Inactive', 'data-width' => 105));
		
		echo '<span>Allow access after End Date?</span>';
		echo $this->Form->input('Course.is_persistant', array('label' => false, 'class' => 'checkboxToggle'));
		
		echo '<span>Course Visibility</span>';
		echo $this->Form->input('Course.is_private', array('label' => false, 'class' => 'checkboxToggle', 'data-yes' => 'Private', 'data-no' => 'Public', 'data-width' => 105));
		
		echo '<span>Require members to go only through the defined sequence?</span>';
		echo $this->Form->input('Course.is_sequential', array('label' => false, 'class' => 'checkboxToggle'));
		
		echo $this->Form->input('Course.language', array('options' => array('English', 'Spanish')));
	?>
	</fieldset>
<?php
echo $this->Form->submit(__('Save'), array('class' => 'btn-primary'));
echo $this->Form->end();
?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Course.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Course.id'))); ?></li>
		<li><?php echo $this->Html->link(__('Add Resources'), array('plugin' => 'media', 'controller' => 'media', 'action' => 'add_resource'));?></li>
	</ul>
</div>
<script>
	applyCheckboxToggles();
</script>