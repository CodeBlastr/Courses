<?php
	
	if (!isset($course) && isset($this->request->data['CourseGradeDetail'])) {
		$course = $this->request->data['CourseGradeDetail'];
	}
	
	
	if(isset($course['id'])) {
		echo $this->Form->input('CourseGradeDetail.id');
	}
	
	echo $this->Form->select('CourseGradeDetail.method', $methods, array('empty' => 'Choose a grading method...'));
	//echo $this->Form->input('CourseGradeDetail.name');
	
	
	//You must have a custom method action in Grade Model
	$methods = array(
		'weighted' => 'Weighted Grade',
		'total_points' => 'Total Points',
	);
	
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
	
	
