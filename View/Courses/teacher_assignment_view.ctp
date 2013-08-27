<?php
	//debug($this->request->data);
	//Set up some variables
	$task = $this->request->data['Task'];
	$gradeDetails = $this->request->data['CourseGradeDetail'][0];
	$completedTask = $this->request->data['ChildTask'];
	$courseUsers = $this->request->data['CourseUser'];
	$completedCheck = Set::extract('/assignee_id', $completedTask);
?>

<div id="Task-<?php echo $task['id']; ?> class="row-fluid">
	<h1> <?php echo $task['name']; ?></h1>
	<p>Due Date: <?php echo $this->Time->nice($task['due_date']); ?></p>
	<div class="description">
		<?php echo $task['description']; ?>
	</div>
</div>

<div id="gradeDetails" class="row-fluid">
	<h5>Grading Details</h5>
	<div class="total span6">
		Total: <?php echo $gradeDetails['total_worth']; ?>% <br />
		Grading Method: <?php echo $gradeDetails['grading_method']; ?>
		<div class="description">
			<?php echo $gradeDetails['description']; ?>
		</div>
	</div>
	
	</div>
</div>

<div id="studentDetails" class="row-fluid">
	<div class="span4 offset1">
		<h6>Completed</h6>
		<ul id="StudentsCompleted">
			<?php foreach($completedTask as $comp): ?>
				<li>
					<a href="<?php echo $this->Html->url(array('plugin' => 'users', 'controller' => 'users', 'action' => 'view', $comp['Assignee']['id'])); ?>"><?php echo $comp['Assignee']['full_name']; ?></a>
					<a href="#markIncomplete" data-assignee_id="<?php echo $comp['Assignee']['id']; ?>"" style="margin-left: 5px;"><i class="icon-remove-sign"></i></a>
				</li>
					
			<?php endforeach; ?>
		</ul>
	</div>
	<div class="span4 offset1">
		<h6>Not Completed</h6>
		<ul id='StudentsUncompleted'>
			<?php foreach($courseUsers as $CourseUser): ?>
				<?php if(!in_array($CourseUser['user_id'], $completedCheck)): ?>
				<li>
					<a href="<?php echo $this->Html->url(array('plugin' => 'users', 'controller' => 'users', 'action' => 'view', $CourseUser['user_id'])); ?>"><?php echo $CourseUser['User']['full_name']; ?></a>
					<a class="complete" href="#markcomplete" data-assignee_id="<?php echo $CourseUser['user_id']; ?>"" style="margin-left: 5px;"><i class="icon-thumbs-up"></i></a>
				</li>
				<?php endif; ?>
			<?php endforeach; ?>
		</ul>
	</div>
</div>

<script type="text/javascript">
	
	(function($) {
		
		bindhandlers();
		
		function bindhandlers() {
			
			$('#StudentsUncompleted').off('click');
			$('#StudentsCompleted').off('click');
			
			$('#StudentsUncompleted').on('click', 'a[href=#markcomplete]', (function(e) {
				var tar = $(e.currentTarget);
				var data = {Task: { assignee_id: tar.data('assignee_id'), parent_id: '<?php echo $task['id']; ?>', model: '<?php echo $task['model']; ?>', foreign_key: '<?php echo $task['foreign_key']; ?>'} };
				$.post('<?php echo $this->Html->url(array('plugin' => 'courses', 'controller' => 'courses', 'action' => 'completeAssignment')); ?>', data)
					.success(function() {
						var comp = tar.closest('li');
						comp.find('.complete').attr("href", "#markIncomplete").find('i').removeClass( "icon-thumbs-up" ).addClass( "icon-remove-sign" );
						comp.appendTo('#StudentsCompleted');
						bindhandlers();
					});	
			}));
	
			$('#StudentsCompleted').on('click', 'a[href=#markIncomplete]', (function(e) {
				var tar = $(e.currentTarget);
				var data = { Task: { id: '<?php echo $task['id']; ?>', assignee_id: tar.data('assignee_id') } };
				$.post('<?php echo $this->Html->url(array('plugin' => 'courses', 'controller' => 'courses', 'action' => 'incompleteAssignment')); ?>', data)
					.success(function() {
						var comp = tar.closest('li');
						comp.find('a').attr("href", "#markcomplete").find('i').removeClass( "icon-remove-sign" ).addClass( "icon-thumbs-up" );
						comp.appendTo('#StudentsUncompleted');
						bindhandlers();
					});	
			}));
		}
		
		
	})(jQuery);
	
	
</script>

