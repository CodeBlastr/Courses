
<?php

echo $this->Html->tag('h1', $this->request->data['Task']['name']);
echo $this->Html->tag('p', '<b>Due Date: </b>' . $this->Time->nice($this->request->data['Task']['due_date']));
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
	
	if(!empty($quizzes)) {
		echo $this->Html->link('Take Quizz', array('plugin' => 'courses', 'controller' => 'courses', 'action' => 'takeQuiz', $this->request->data['Task']['id']), array('class' => 'btn btn-success'));
	}
}
