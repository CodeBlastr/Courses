<?php

$course = $this->request->data['Course'];
$assingments = $this->request->data['Task'];
$courseUsers = $this->request->data['CourseUser'];

// show a dropdown to flip between this user's courses
echo $this->Form->create();
echo $this->Form->select('Course.id', $courseSelectOptions, array('empty' => '- Choose a course -', 'class' =>  'pull-left'));
echo $this->Form->submit('View Gradebook');
echo $this->Form->end();

// if we have course data, show the gradebook
if ( !empty($course) ) {

	// display some stuff above the table
	echo $this->Html->link('<h1>'.$course['Course']['name'].'</h1>', array('controller' => 'courses', 'action' => 'view', $course['Course']['id']), array('escape' => false));
	echo $this->Html->tag('p', '<b>Session: </b>'. $this->Time->niceShort($course['Course']['start']) . ' to ' . $this->Time->niceShort($course['Course']['end']));

	// initiate the table headings array
	$tableHeaders = array('Student');
	
	//merge assingments
	foreach($assingments as $a) {
		$tableHeaders[] = $a['name'];
	}
	
	$tableHeaders[] = 'Overall';

	// time to build the data rows !
	$tablerows = '';
	foreach ( $courseUsers as $student ) {
		
		$row = array();
		$row[] = $student['User']['full_name'];
		foreach($assingments as $a) {
			$ex = false;
			foreach($student['Grades'] as $grade) {
				if($a['id'] == $grade['foreign_key']) {
					$row[] = $this->Html->link($grade['grade'], array('plugin' => 'courses', 'controller' => 'course_grades', 'action' => 'show_grade', $grade['id']));
					$ex = true;
					break;
				}
			}
			if(!$ex) {
				$row[]= '';
			}
		}
		
		$row[] = empty($student['CourseGrade']) ? '' : $this->Number->toPercentage($student['CourseGrade']['grade'] * 100, 2);
		
		$tablerows[] = $row;
	}
	
	$tableHeaders = $this->Html->tableHeaders($tableHeaders);
	$tableCells = $this->Html->tableCells($tablerows);
	

	// and we're done.
	echo $this->Html->tag('table', $tableHeaders . $tableCells, array('class' => 'table-bordered'));

}else {
	echo $this->Html->tag('div', 'Choose a Course to view a gradebook', array('class' => 'well'));
}

?>
<script type="text/javascript">
	$(document).ready(function() {
		$(".passFailCheckbox").change(function(){
			$.ajax({
				url: '<?php echo Router::url(array('controller' => 'courses', 'action' => 'passFail', $course['Course']['id'])) ?>' + '/' + $(this).attr('data-userid'),
				data: {data:{isComplete:$(this).is(":checked")}},
				cache: false,
				type: 'POST',
				error: function(){
					
				}
			});
		});
		$(".gradeInput").change(function(){
			var input = $(this);
			setTimeout(
					$.ajax({
						url: '<?php echo Router::url(array('controller' => 'courseGradebooks', 'action' => 'modifyGrade')) ?>',
						data: {
							data: {
								CourseGrade:{
									id: $(this).attr('data-coursegrade-id'),
									course_grade_detail_id: $(this).attr('data-coursegradedetail-id'),
									model: $(this).attr('data-coursegrade-model'),
									foreign_key: $(this).attr('data-coursegrade-foreignkey'),
									course_id: '<?php echo $course['Course']['id'] ?>',
									student_id: $(this).attr('data-coursegrade-studentid'),
									grade: $(this).val()
								}
							}
						},
						cache: false,
						type: 'POST',
						beforeSend: function(jqXHR, settings) {
							input.css('background-color', '#f0ad4e');
						},
						error: function(jqXHR, textStatus, errorThrown){
							input.css('background-color', '#d9534f');
						},
						success: function(data, textStatus, jqXHR){
							input.css('background-color', '#5cb85c');
							input.attr('data-coursegrade-id', data);
						},
						complete: function(jqXHR, textStatus) {
							input.css('background-color', '#ffffff');
						}
					})
				,1500);
		});
	});
</script>
