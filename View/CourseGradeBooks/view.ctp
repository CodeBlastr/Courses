<?php

// show a dropdown to flip between this user's courses
echo $this->Form->create();
echo $this->Form->select('Course.id', $courseSelectOptions, array('empty' => '- Choose a course -'));
echo $this->Form->submit('View Gradebook');
echo $this->Form->end();

// if we have course data, show the gradebook
if ( !empty($course) ) {

	// display some stuff above the table
	echo $this->Html->link('<h1>'.$course['Course']['name'].'</h1>', array('controller' => 'courses', 'action' => 'view', $course['Course']['id']), array('escape' => false));
	echo $this->Html->tag('p', '<b>Session: </b>'. $this->Time->niceShort($course['Course']['start']) . ' to ' . $this->Time->niceShort($course['Course']['end']));

	// initiate the table headings array
	$tableHeaders = array('Pass / Fail', 'Student', 'Average');

	// add the rest of our table headers, and get some grade data while we are there
	if ( $course['Task'] ) {
		$i = 1;
		foreach ( $course['Task'] as $assignment ) {
			$tableHeaders[] = $this->Html->tag('abbr', $i, array('title' => $assignment['name'])); // column title foreach assignment
			$gradeables[] = $taskIds[] = $assignment['id']; // an array of id's so we can easily display their grades later
			++$i;
		}
	}

	if ( $course['Answer'] ) {
		$i = 1;
		foreach ( $course['Answer'] as $form ) {
			$tableHeaders[] = $this->Html->tag('abbr', $i, array('title' => $form['title'])); // column title foreach quiz/test
			$gradeables[] = $form['id']; // an array of id's so we can easily display their grades later
			++$i;
		}
	}

	// time to build the data rows !
	$tableCells = '';
	foreach ( $courseUsers as $student ) {

		// create data for Student's Name and Average cells
		$studentAverage = 0;
		foreach ( $grades[ $student['User']['id'] ] as $gradeableItem ) {
			$studentAverage += $gradeableItem['grade'];
		}
		$studentAverage = $studentAverage / ( count($course['Task']) + count($course['Answer']) );
		$studentRow = array(
			$this->Form->checkbox('CourseUser.is_complete', array('checked' => $student['CourseUser']['is_complete'], 'data-userid' => $student['User']['id'], 'class' => 'passFailCheckbox')),
			$this->Html->link($student['User']['full_name'], array('plugin' => 'users', 'controller' => 'users', 'action' => 'view', $student['User']['id'])),
			$this->Number->toPercentage($studentAverage)
		);
		$courseAverage[] = $studentAverage;

		// create data for Student's Grades cells
		foreach ( $gradeables as $gradeForeignKey ) {
			if ( in_array($gradeForeignKey, $taskIds) ) {
				$model = 'Task';
			} else {
				$model = 'Answer';
			}

			$studentRow[] = $this->Form->input('gradeInput', array(
				'value' => $grades[$student['User']['id']][$courseGradeDetails[$gradeForeignKey]]['grade'],
				'placeholder' => 0,
				'class' => 'gradeInput input-mini',
				'label' => false, 'div' => false,
				'data-coursegrade-id' => $grades[$student['User']['id']][$courseGradeDetails[$gradeForeignKey]]['id'],
				'data-coursegradedetail-id' => $courseGradeDetails[$gradeForeignKey],
				'data-coursegrade-model' => $model,
				'data-coursegrade-foreignkey' => $gradeForeignKey,
				'data-coursegrade-studentid' => $student['User']['id']
				));
		}
		// add the student's cells to the table output
		$tableCells .= $this->Html->tableCells(array($studentRow));
	}

	// add a row of overall course averages
	$tableCells .= $this->Html->tableCells(array(
		array(
			'',
			'Overall',
			$this->Number->toPercentage(array_sum($courseAverage) / count($courseAverage))
		)
	));

	// some final formatting..
	#$tableTitles = array('', '', '', array('Assignments', array('colspan' => count($course['Task']))), array('Quizzes / Tests', array('colspan' => count($course['Form']))));
	$tableTitles = array( '', '', '', array( 'Assignments', array( 'colspan' => count($course['Task']) ) ) );
	$tableTitles = $this->Html->tableCells($tableTitles);
	$tableHeaders = $this->Html->tableHeaders($tableHeaders);

	// and we're done.
	echo $this->Html->tag('table', $tableTitles . $tableHeaders . $tableCells, array('class' => 'table-bordered'));

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
