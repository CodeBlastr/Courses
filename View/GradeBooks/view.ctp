<?php

// show a dropdown to flip between this user's courses
echo $this->Form->select('Course.id', $courseSelectOptions, array('empty' => '- Choose a course -'));

// if we have course data, show the gradebook
if ( !empty($course) ) {

	// display some stuff above the table
	echo $this->Html->tag('h1', $course['Course']['name']);
	echo $this->Html->tag('p', '<b>Session: </b>'. $this->Time->niceShort($course['Course']['start']) . ' to ' . $this->Time->niceShort($course['Course']['end']));

	// initiate the table headings array
	$tableHeaders = array('Student', 'Average');

	// add the rest of our table headers, and get some grade data while we are there
	$i = 1;
	foreach ( $course['Task'] as $assignment ) {
		$tableHeaders[] = $this->Html->tag('abbr', $i, array('title' => $assignment['name'])); // column title foreach assignment
		$gradeables[] = $assignment['id']; // an array of id's so we can easily display their grades later
		++$i;
	}

	$i = 1;
	foreach ( $course['Form'] as $form ) {
		$tableHeaders[] = $this->Html->tag('abbr', $i, array('title' => $form['name'])); // column title foreach quiz/test
		$gradeables[] = $form['id']; // an array of id's so we can easily display their grades later
		++$i;
	}

	// time to build the data rows !
	$tableCells = '';
	foreach ( $courseUsers as $student ) {
		// create data for Student's Name and Average cells
		$studentAverage = 0;
		foreach ( $grades[ $student['User']['id'] ] as $grade ) {
			$studentAverage += $grade;
		}
		$studentAverage = $studentAverage / ( count($course['Task']) + count($course['Form']) );
		$studentRow = array(
			$this->Html->link($student['User']['full_name'], array('plugin' => 'users', 'controller' => 'users', 'action' => 'view', $student['User']['id'])),
			$this->Number->toPercentage($studentAverage)
		);
		$courseAverage[] = $studentAverage;
		// create data for Student's Grades cells
		foreach ( $gradeables as $gradeForeignKey ) {
			$studentRow[] = $grades[ $student['User']['id'] ][ $gradeForeignKey ] ? $grades[ $student['User']['id'] ][ $gradeForeignKey ] : '-';
		}
		// add the student's cells to the table output
		$tableCells .= $this->Html->tableCells(array($studentRow));
	}

	// add a row of overall course averages
	$tableCells .= $this->Html->tableCells(array(
		array(
			'Overall',
			$this->Number->toPercentage(array_sum($courseAverage) / count($courseAverage))
		)
	));

	// some final formatting..
	$tableTitles = array('', '', array('Assignments', array('colspan' => count($course['Task']))), array('Quizzes / Tests', array('colspan' => count($course['Form']))));
	$tableTitles = $this->Html->tableCells($tableTitles);
	$tableHeaders = $this->Html->tableHeaders($tableHeaders);

	// and we're done.
	echo $this->Html->tag('table', $tableTitles . $tableHeaders . $tableCells, array('class' => 'table-bordered'));

}
