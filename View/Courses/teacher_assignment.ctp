<div class="tasks form">
<?php echo $this->Form->create('Task', array('type' => 'file'));?>
	<fieldset>
 		<legend><?php echo __('Moderating Assignment');?></legend>
	<?php
		echo $this->Form->input('Task.name');
		echo $this->Form->input('Task.start_date');
		echo $this->Form->input('Task.due_date');

		//echo $this->Form->input('Task.parent_id', array('empty' => true, 'label' => 'Which task list should this be on?'));

		echo $this->Form->input('Task.foreign_key', array('options' => $parentCourses, 'empty' => '- Select Course -', 'label' => 'Course', 'class' => 'required'));

		echo $this->Form->input('Task.description', array('type' => 'richtext'));

//		echo $this->Form->input('Task.order');
		echo $this->Form->input('Task.assignee_id', array('label' => 'Privacy', 'options' => array(0 => 'All Course Members', $this->userId => 'Just Me')));
//		echo $this->Form->input('GalleryImage.filename', array('type' => 'file', 'label' => 'Upload your best image for this item.', 'after' => ' <p> You can add additional images after you save.</p>'));
//	    echo $this->Form->input('GalleryImage.dir', array('type' => 'hidden'));
//	    echo $this->Form->input('GalleryImage.mimetype', array('type' => 'hidden'));
//	    echo $this->Form->input('GalleryImage.filesize', array('type' => 'hidden'));
		echo $this->Form->hidden('Task.model', array('value' => 'Course'));
	?>
	</fieldset>
<?php echo $this->Form->end('Submit');?>
</div>

<?php
if ( !empty($this->request->data['ChildTask']) ) {
	foreach ( $this->request->data['ChildTask'] as $childTask ) {
		//echo '<li>'. $this->Html->link($childTask['name'], array('action' => 'assignment', $task['id'])) . '</li>';
		$childTaskCells[] = array(
			$courseUsers[$childTask['assignee_id']]['User']['last_name'] . ', ' . $courseUsers[$childTask['assignee_id']]['User']['first_name'],
			$childTask['completed_date'],
		);
	}
	$this->assign('sidebar_afterMenu', '<h4>Completions</h4>'.$this->Html->tag('table', $this->Html->tableHeaders(array('Student', 'Date Completed')) . $this->Html->tableCells($childTaskCells)) );
}

//debug($task);

//echo $this->Html->tag('h1', $task['Task']['name']);
//echo $this->Html->tag('p', '<b>Due Date: </b>' . $this->Time->nice($task['Task']['due_date']));
//echo $this->Html->tag('div', $task['Task']['description']);

//echo $this->Html->link('Mark Complete', array($task['Task']['id'], 'completed'), array('class' => 'btn btn-primary'));