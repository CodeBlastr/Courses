<?php
	
	if (isset($this->request->data['CourseGradeDetail'][0])) {
		$this->request->data['CourseGradeDetail'] = $this->request->data['CourseGradeDetail'][0];
	}
	
	
	if(isset($this->request->data['CourseGradeDetail']['id'])) {
		echo $this->Form->hidden('CourseGradeDetail.id');
	}
	
	//You must have a custom method action in Grade Model
	$methods = array(
		'weighted' => 'Weighted Grade',
		'total_points' => 'Total Points',
	);
	
	echo $this->Form->select('CourseGradeDetail.grading_method', $methods, array('empty' => 'No Grade Given'));
	
	if(isset($course_id)) {
		echo $this->Form->hidden('CourseGradeDetail.course_id', array('value' => $course_id));
	}
	
?>

<div id="gradingMethods">
	
	<div id="weightedGrade">
		
		<label for="PostPublished">
			Total Worth: <br />
			<?php echo $this->Form->input('CourseGradeDetail.total_worth', array('label' => false, 'div' => false)); ?>
			%
		</label>
		
		<?php echo $this->Form->input('CourseGradeDetail.description', array('type' => 'textarea', 'label' => '(Optional) Grade Description, can be seen by public')); ?>
		
		<?php echo $this->Form->input('CourseGradeDetail.notes', array('type' => 'textarea', 'label' => '(Optional) Notes for grading, can only be seen by teacher of the course')); ?>
		
		
		
	</div>
	
	<div id="totalPoingsGrade">
		
	</div>
	
</div>
	
	
