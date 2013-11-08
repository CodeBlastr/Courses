
<?php

echo $this->Html->tag('h1', $this->request->data['Task']['name']);
echo $this->Html->tag('p', '<b>Due Date: </b>' . $this->Time->format('F', $this->request->data['Task']['due_date']));
echo $this->Html->tag('div', $this->request->data['Task']['description']);

if(isset($this->request->data['TaskAttachment'])) {
	$quizzes = array();
	$attachments = array();
	foreach($this->request->data['TaskAttachment'] as $attachment) {
		if($attachment['model'] == 'Answer') {
			$quizzes[] = $attachment;
		}else {
			$attachments[] = $attachment;
		}
	}
	
	if(!empty($quizzes) && empty($this->request->data['CourseGrade'])) {
		echo $this->Html->link('Take Quizz', array('plugin' => 'courses', 'controller' => 'courses', 'action' => 'takeQuiz', $this->request->data['Task']['id']), array('class' => 'btn btn-success'));
	}elseif (!empty($this->request->data['CourseGrade'])) {
		echo $this->Html->tag('h3', 'Your Score: '.$this->request->data['CourseGrade']['grade']);
	}
}
