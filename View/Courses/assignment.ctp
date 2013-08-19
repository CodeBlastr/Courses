<?php

debug($task);

echo $this->Html->tag('h1', $task['Task']['name']);
echo $this->Html->tag('p', '<b>Due Date: </b>' . $this->Time->nice($task['Task']['due_date']));
echo $this->Html->tag('div', $task['Task']['description']);

echo $this->Html->link('Mark Complete', array($task['Task']['id'], 'completed'), array('class' => 'btn btn-primary'));