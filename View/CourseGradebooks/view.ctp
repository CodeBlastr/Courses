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
if ( !empty($course)) {

	// display some stuff above the table
	echo $this->Html->link('<h1>'.$course['Course']['name'].'</h1>', array('controller' => 'courses', 'action' => 'view', $course['Course']['id']), array('escape' => false));
	echo $this->Html->tag('p', '<b>Session: </b>'. $this->Time->niceShort($course['Course']['start']) . ' to ' . $this->Time->niceShort($course['Course']['end']));

	// initiate the table headings array
	$tableHeaders = array('Student');
	
	if(!empty($assingments)) {
		//merge assingments
		foreach($assingments as $a) {
			$tableHeaders[] = $a['name'];
		}
		
		$tableHeaders[] = 'Overall';
		$tableHeaders[] = 'Pass/Fail';
	
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
			$row[] = $this->Form->checkbox('CourseUser.is_complete', array('checked' => $student['is_complete'], 'data-userid' => $student['User']['id'], 'class' => 'passFailCheckbox'));
			$tablerows[] = $row;
		}
	
		$tableHeaders = $this->Html->tableHeaders($tableHeaders);
		$tableCells = $this->Html->tableCells($tablerows);
		
		// and we're done.
		echo $this->Html->tag('table', $tableHeaders . $tableCells, array('class' => 'table-bordered'));
		
		
	}else {
		echo $this->Html->tag('div', 'No Grades available', array('class' => 'well'));
	}
	

	

}else {
	echo $this->Html->tag('div', 'Choose a Course to view a gradebook', array('class' => 'well'));
}

?>
<script type="text/javascript">
	$(document).ready(function() {
		$(".passFailCheckbox").change(function(){
			var that = this;
			$.ajax({
				url: '<?php echo Router::url(array('controller' => 'courses', 'action' => 'passFail', $course['Course']['id'])) ?>' + '/' + $(this).attr('data-userid'),
				data: {data:{isComplete:$(this).is(":checked")}},
				cache: false,
				type: 'POST',
				error: function(){
					alert('failed to update grade');
					$(that).attr('checked', false);
				}
			});
		});
	});
</script>
