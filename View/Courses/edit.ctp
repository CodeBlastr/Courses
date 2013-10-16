<div class="courses form">
<?php echo $this->Form->create('Course'); ?>
	<fieldset>
		<legend><?php echo __('Edit Course'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Html->tag('div',
			$this->Form->input('Course.parent_id', array('div' => array('class' => 'span4'), 'options' => $series, 'empty' => array(null => 'None'), 'label' => 'Part of a Series? <a href="#toggleSeriesAdd" class="toggleSeriesAdd">(create new series)</a>'))
			. $this->Form->input('Category', array('div' => array('class' => 'span4'), 'type' => 'select', 'label' => 'Subject', 'empty' => '-- Choose Subject --'))
			);
		echo $this->Form->input('Course.name', array('class' => 'required', 'placeholder' => 'Course Name', 'label' => false, 'class' => 'input-xxlarge'));
		
		echo $this->Form->label('Course.start', 'Start Date');
		echo $this->Form->dateTimePicker('Course.start', array('type' => 'datetime', 'class' => 'input-small required', 'label' => 'Start Date'));
		echo $this->Form->label('Course.end', 'End Date');
		echo $this->Form->dateTimePicker('Course.end', array('type' => 'datetime', 'class' => 'input-small required', 'label' => 'End Date'));
		echo $this->Html->tag('div',
			$this->Form->input('Course.school', array('type' => 'select', 'options' => $schools, 'div' => array('class' => 'span4'), 'class' => 'required span12', 'label' => 'School'))
			. $this->Form->input('Course.grade', array('options' => array('K','1','2','4','5','6','7','8','9','10','11','12'), 'empty' => 'Grade', 'label' => 'Grade', 'class' => 'input-small required', 'div' => array('class' => 'span5')))
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
		echo !empty($layouts) ? __('<h5>Choose a theme</h5> %s', $this->Form->input('Template.layout', array('legend' => false, 'type' => 'radio'))) : null;
	?>
	</fieldset>
	<fieldset>
	<legend>Choose Course Resources</legend>
	<?php echo $this->Element('Media.media_selector', array('media' => $this->request->data['Media'])); ?>
	
	</fieldset>
	
	<fieldset>
		<div class="gradingOptions">
			<?php echo $this->Element('Courses.courseGradingOptions', array('course_id' => $this->request->course['Course']['id'])); ?>
		</div>
	</fieldset>

<?php
echo $this->Form->submit(__('Save'), array('class' => 'btn-primary'));
echo $this->Form->end();
?>
</div>

<script type="text/javascript">
	applyCheckboxToggles();
</script>



<?php
//the context menu version doesn't work (not sure what to do with this delete link yet)
//echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Course.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Course.id')));
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => $this->request->data['Course']['name'],
		'items' => array(
			// this delete thing doesn't work because it shows twice on the page in the current admin theme
			$this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Course.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Course.id'))),
			$this->Html->link(__('Add Resources'), array('plugin' => 'media', 'controller' => 'media', 'action' => 'add_resource')),
			),
		),
	)));