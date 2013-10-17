<?php
	
	if (isset($this->request->data['CourseGradeDetail'][0])) {
		$this->request->data['CourseGradeDetail'] = $this->request->data['CourseGradeDetail'][0];
	}
	
	
	if(isset($this->request->data['CourseGradeDetail']['id'])) {
		echo $this->Form->hidden('CourseGradeDetail.id');
	}
	
?>

<div id="gradingMethods">
		
	<?php echo $this->Form->input('CourseGradeDetail.description', array('type' => 'textarea', 'label' => '(Optional) Grade Description, can be seen by public')); ?>
	<?php echo $this->Form->input('CourseGradeDetail.notes', array('type' => 'textarea', 'label' => '(Optional) Notes for grading, can only be seen by teacher of the course')); ?>
	
</div>
	
	
