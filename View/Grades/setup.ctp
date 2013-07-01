<!--<ol>FLOW:
	<li><a href="/courses/courses/add">Create the course</a></li>
	<li><a href="/courses/lessons/add">Add Classes &AMP; Resources</a></li>
	<li>Setup Gradebook</li>
	<li><a href="/forms/forms/add/formanswer">Add a Quiz</a></li>
	<li><a href="/invites/invites/invitation">Invite people</a></li>
</ol>-->

<h2>Course Grading Options</h2>

<?php
echo $this->Form->create('Course');

if ( !empty($courses) ) {
	echo $this->Form->select('Course.id', $courses, array('empty' => '-- Select Course --'));
} else {
	echo $this->Form->hidden('Course.id');
}

echo $this->Form->input('Course.settings.is_percentage', array('type'=>'checkbox', 'label'=>'0 &mdash; 100 (Grade = Percentage)'));
echo $this->Form->input('Course.settings.letter_grades', array('type' => 'checkbox', 'data-target' => '#letterTable', 'class' => 'toggling'));
echo $this->Html->tag('table',
		$this->Html->tableCells(array(
			array('From', 'To', 'Grade'),
			array(
				$this->Form->input('Course.settings.letter_grades.0.low', array('placeholder' => '90', 'class' => 'input-mini', 'div' => false, 'label' => false)),
				$this->Form->input('Course.settings.letter_grades.0.high', array('placeholder' => '100', 'class' => 'input-mini', 'div' => false, 'label' => false)),
				$this->Form->input('Course.settings.letter_grades.0.letter', array('placeholder' => 'A', 'class' => 'input-mini', 'div' => false, 'label' => false))
			),
			array(
				$this->Form->input('Course.settings.letter_grades.1.low', array('placeholder' => '80', 'class' => 'input-mini', 'div' => false, 'label' => false)),
				$this->Form->input('Course.settings.letter_grades.1.high', array('placeholder' => '89', 'class' => 'input-mini', 'div' => false, 'label' => false)),
				$this->Form->input('Course.settings.letter_grades.1.letter', array('placeholder' => 'B', 'class' => 'input-mini', 'div' => false, 'label' => false))
			),
			array(
				$this->Form->input('Course.settings.letter_grades.2.low', array('placeholder' => '70', 'class' => 'input-mini', 'div' => false, 'label' => false)),
				$this->Form->input('Course.settings.letter_grades.2.high', array('placeholder' => '79', 'class' => 'input-mini', 'div' => false, 'label' => false)),
				$this->Form->input('Course.settings.letter_grades.2.letter', array('placeholder' => 'C', 'class' => 'input-mini', 'div' => false, 'label' => false))
			),
			array(
				$this->Form->input('Course.settings.letter_grades.3.low', array('placeholder' => '60', 'class' => 'input-mini', 'div' => false, 'label' => false)),
				$this->Form->input('Course.settings.letter_grades.3.high', array('placeholder' => '69', 'class' => 'input-mini', 'div' => false, 'label' => false)),
				$this->Form->input('Course.settings.letter_grades.3.letter', array('placeholder' => 'D', 'class' => 'input-mini', 'div' => false, 'label' => false))
			),
			array(
				$this->Form->input('Course.settings.letter_grades.4.low', array('placeholder' => '0', 'class' => 'input-mini', 'div' => false, 'label' => false)),
				$this->Form->input('Course.settings.letter_grades.4.high', array('placeholder' => '59', 'class' => 'input-mini', 'div' => false, 'label' => false)),
				$this->Form->input('Course.settings.letter_grades.4.letter', array('placeholder' => 'F', 'class' => 'input-mini', 'div' => false, 'label' => false))
			),

		)), array('id' => 'letterTable', 'style' => 'display:none')
);

echo $this->Form->input('Course.settings.pass_fail', array('type' => 'checkbox', 'label' => 'Pass/Fail', 'data-target' => '#passfailTable', 'class' => 'toggling'));
echo $this->Html->tag('table',
		$this->Html->tableCells(array(
			array('', 'From', 'To'),
			array(
				'Pass',
				$this->Form->input('Course.settings.pass_fail.passLow', array('placeholder' => '60', 'class' => 'input-mini', 'div' => false, 'label' => false)),
				$this->Form->input('Course.settings.pass_fail.passHigh', array('placeholder' => '100', 'class' => 'input-mini', 'div' => false, 'label' => false))
			),
			array(
				'Fail',
				$this->Form->input('Course.settings.pass_fail.failLow', array('placeholder' => '0', 'class' => 'input-mini', 'div' => false, 'label' => false)),
				$this->Form->input('Course.settings.pass_fail.failHigh', array('placeholder' => '59', 'class' => 'input-mini', 'div' => false, 'label' => false))
			)
		)), array('id' => 'passfailTable', 'style' => 'display:none')
);

echo $this->Form->input('Course.settings.is_weighted', array('type'=>'checkbox', 'label'=>'Weight assignment categories', 'data-target' => '#categoryTable', 'class' => 'toggling'));
echo $this->Form->input('Course.settings.category_settings', array('div' => array('id' => 'categoryTable', 'style' => 'display:none')));

echo $this->Form->input('Course.settings.curve_settings', array('type' => 'checkbox', 'label' => 'Grade on a Curve', 'data-target' => '#curveTable', 'class' => 'toggling'));
echo $this->Html->tag('table',
		$this->Html->tableCells(array(
			array('Type', ''),
			array(
				'Square Root',
				$this->Form->checkbox('Course.settings.curve_settings.sqrRoot', array('class' => 'input-mini', 'div' => false, 'label' => false)),
			),
			array(
				'Bell/Normal Distribution',
				$this->Form->checkbox('Course.settings.curve_settings.bellNormal', array('class' => 'input-mini', 'div' => false, 'label' => false)),
			),
			array(
				'Make Highest Grade 100',
				$this->Form->checkbox('Course.settings.curve_settings.highest100', array('class' => 'input-mini', 'div' => false, 'label' => false)),
			)
		)), array('id' => 'curveTable', 'style' => 'display:none')
);

echo $this->Form->submit('Save', array('class' => 'btn-primary'));
echo $this->Form->end();

?>
<script type="text/javascript">
	$(function() {
		$(".toggling").click(function(){
			var tableId = $(this).attr('data-target');
			$(tableId).toggle();
		});
	});
</script>