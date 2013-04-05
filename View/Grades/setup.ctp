<ol>FLOW:
	<li><a href="/courses/courses/add">Create the course</a></li>
	<li><a href="/courses/lessons/add">Add Classes &AMP; Resources</a></li>
	<li>Setup Gradebook</li>
	<li><a href="/forms/forms/add/formanswer">Add a Quiz</a></li>
	<li><a href="/invites/invites/invitation">Invite people</a></li>
</ol>

<b>setup grading config for a course here</b>

<?php
echo $this->Form->create('Course');
echo $this->Form->select('Course.id', $courses);
echo $this->Form->input('Course.settings.is_percentage', array('type'=>'checkbox', 'label'=>'0 - 100 (Grade = Percentage)'));
echo $this->Form->input('Course.settings.letter_grades');
echo $this->Form->input('Course.settings.pass_fail');
echo $this->Form->input('Course.settings.is_weighted', array('type'=>'checkbox', 'label'=>'Weight assignment categories'));
echo $this->Form->input('Course.settings.category_settings');
echo $this->Form->input('Course.settings.curve_settings');
echo $this->Form->submit('Save', array('class' => 'btn-primary'));
echo $this->Form->end();