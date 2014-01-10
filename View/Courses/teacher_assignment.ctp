<div class="tasks form">
<?php echo $this->Form->create('Task', array('type' => 'file'));?>
	<fieldset>
 		<legend><?php echo __('Edit Assignment');?></legend>
	<?php
		//echo $this->Form->input('Category', array('div' => array('class' => 'span4'), 'type' => 'select', 'label' => 'Assignment Category', 'empty' => '-- Choose Category --'));
		echo $this->Form->input('Task.name');
		if(isset($this->request->data['Task']['id'])) {
			echo $this->Form->hidden('Task.id');
		}
		if(isset($this->request->data['CourseGradeDetail']['id'])) {
			echo $this->Form->hidden('CourseGradeDetail.id');
		}
		echo $this->Form->hidden('CourseGradeDetail.course_id', array('value' => $course_id));
	?>
	<div class="row-fluid">
	<div class="span6">
		<label>Start Date</label>
		<?php echo $this->Form->datetimepicker('Task.start_date'); ?>
	</div>
	<div class="span6">
		<label>Due Date</label>
		<?php echo $this->Form->datetimepicker('Task.due_date'); ?>
	</div>
	</div>
	
<?php
		//echo $this->Form->input('Task.parent_id', array('empty' => true, 'label' => 'Which task list should this be on?'));
		echo $this->Form->input('Task.foreign_key', array('options' => $parentCourses, 'value' => $course_id, 'empty' => '- Select Course -', 'label' => 'Course Assignment Belongs to', 'class' => 'required'));

		echo $this->Form->input('Task.settings', array('type' => 'select', 'label' => 'Assignment Type', 'required' => true, 'options' => $assignmentTypes, 'empty' => '-- Choose a Category --'));
		
		echo $this->Form->input('Task.description', array('type' => 'richtext'));

		echo $this->Form->input('Task.assignee_id', array('label' => 'Privacy', 'options' => array(0 => 'All Course Members', $this->Session->read('Auth.User.id') => 'Just Me')));

		echo $this->Form->hidden('Task.model', array('value' => 'Course'));
	?>
	</fieldset>
	
	<fieldset>
		<?php echo $this->form->input('Task.data.quizzes', array('label' => 'Quizzes shown for this assignment', 'selected' => $chosen, 'options' => $quizzes, 'type' => 'select', 'multiple' => 'checkbox')); ?>
	</fieldset>
		
		
	
<?php echo $this->Form->end('Submit');?>

</div>

<div class="clearfix"></div>

<?php 
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Create a Task',
		'items' => array(
			  $this->Html->link('<i class="icon-backward"></i>'.__('Back to Course Dashboard', true), array('plugin' => 'courses', 'controller' => 'courses', 'action' => 'dashboard'), array('escape' => false)),
			  ),
		),
	)));
