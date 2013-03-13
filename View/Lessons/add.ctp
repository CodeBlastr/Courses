<ol>FLOW:
	<li><a href="/courses/courses/add">Create the course</a></li>
	<li>Add Classes &AMP; Resources</li>
	<li><a href="/courses/grades/setup">Setup Gradebook</a></li>
	<li><a href="/forms/forms/add">Add a Quiz</a></li>
	<li><a href="/invites/invites/invitation">Invite people</a></li>
</ol>

<div class="courses form">
<?php echo $this->Form->create('Lesson');?>
	<fieldset>
		<legend><?php echo __('Add Lesson'); ?></legend>
	<?php
		echo $this->Form->input('Lesson.parent_id', array('options' => $parentCourses));
		echo $this->Form->input('Lesson.name');
		echo $this->Form->input('Lesson.description', array('label' => 'Description'));
//		echo $this->Form->input('Lesson.location');
//		echo $this->Form->input('Lesson.school');
//		echo $this->Form->input('Lesson.grade', array('options' => array('K','1','2','4','5','6','7','8','9','10','11','12')));
//		echo $this->Form->input('Lesson.language', array('options' => array('English', 'Spanish')));
//		echo $this->Form->input('Lesson.start', array('type' => 'time'));
//		echo $this->Form->input('Lesson.end', array('type' => 'time'));
//		echo $this->Form->input('Lesson.is_published', array('label' => 'Active / Inactive'));
//		echo $this->Form->input('Lesson.is_persistant', array('label' => 'Allow access when Inactive'));
//		echo $this->Form->input('Lesson.is_private', array('label' => 'Public / Private'));
//		echo $this->Form->input('Lesson.is_sequential', array('label' => 'Require members to go only through the defined sequence'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>


<div id="media-add" class="media add">
    <h2>Submit Your Resources</h2>

    <?php
    echo $this->Form->create('Media', array('type' => 'file'));
    echo $this->Form->hidden('Media.user_id', array('value'=> $this->Session->read('Auth.User.id')));

//
//    $options = array('audio'=>'Audio','video'=>'Video');
//    $attributes = array('legend'=>'Type of Media');
//    echo $this->Form->radio('Media.type', $options, $attributes);


    echo $this->Form->input('Media.filename', array('type'=>'file', 'label' => 'Upload a file from your computer:')); // , 'accept' => 'audio/* video/*'

    echo $this->Form->input('Media.submittedurl', array('type'=>'text', 'label' => 'Alternatively enter the URL of a file that is already online:'));

    echo $this->Form->input('Media.title', array('type'=>'text', 'label' => 'Title:'));

    echo $this->Form->input('Media.description', array('type'=>'textarea', 'label' => 'Description:'));

    echo $this->Form->end('Submit');
    ?>
</div>



<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('List Courses'), array('action' => 'index'));?></li>
	</ul>
</div>
