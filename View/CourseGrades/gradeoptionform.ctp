<?php
	echo $this->Form->create('Courses.CourseGradeDetail');
	echo $this->Form->input('CourseGradeDetail.id', array('type' => 'hidden'));
	echo $this->Form->input('CourseGradeDetail.course_id');
	echo $this->Form->input('CourseGradeDetail.model');
	echo $this->Form->input('CourseGradeDetail.foreign_key');
	echo $this->Form->input('CourseGradeDetail.name');
	echo $this->Form->input('CourseGradeDetail.description');
	echo $this->Form->input('CourseGradeDetail.total_points');
	echo $this->Form->input('CourseGradeDetail.right_answers');
	echo $this->Form->input('CourseGradeDetail.grading_method');
	echo $this->Form->input('CourseGradeDetail.notes');
	echo $this->Form->input('CourseGradeDetail.alloted_time');
	echo $this->Form->end('Submit');
