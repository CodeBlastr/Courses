<?php
	//debug($this->request->data);
	//Set up some variables
	$task = $this->request->data['Task'];
	$gradeDetails = $this->request->data['CourseGradeDetail'];
	$completedTask = $this->request->data['ChildTask'];
	//Array for table body
	$courseUsers = array();
	foreach($this->request->data['CourseUser'] as $k => $student) {
		$courseUsers[$student['User']['id']]['student_name'] = $student['User']['full_name'];
		$courseUsers[$student['User']['id']]['grade'] = !empty($student['User']['Grade']) ? $student['User']['Grade']['grade'] : '';
		$courseUsers[$student['User']['id']]['completed'] = !empty($student['User']['Grade']) ? true : false;
	}
	$completedCheck = Set::extract('/assignee_id', $completedTask);
	$taskattachment = $this->request->data['TaskAttachment'];
	$quizzes = array();
	foreach($taskattachment as $q) {
		if($q['model'] == 'Answer') { $quizzes[] = $q; }
	}

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
	
<?php if(!empty($quizzes)): ?>
	<?php foreach ($quizzes as $quiz): ?>
		<hr />
		<div class="quiz">
			<p>Create and answer key for <?php echo $task['name']; ?> : <?php echo $this->Html->link('Create', array('plugin' => 'courses', 'controller' => 'course_grades', 'action' => 'answerkey', $quiz['foreign_key']), array('class' => 'btn')); ?></p>
		</div>
		<hr />
	<?php endforeach; ?>
<?php endif; ?>
	
</div>

<div id="studentDetails" class="row-fluid">
	<div class="span12">
	   <div class="container" style="padding:30px;">
	   		<table>
				<thead>
					<?php echo $this->Html->tableHeaders(
					    array('Student Name','Grade','Completed', 'Change Status')
					); ?>
				</thead>
				<tbody>
					<?php foreach($courseUsers as $id => $courseUser): ?>
						<tr>
							<td class="padtop"><?php echo $courseUser['student_name']; ?></td>
							<td class="padtop"><?php echo $courseUser['grade']; ?></td>
							<?php if($courseUser['completed']): ?>
								<td><div class="right"></div></td>
								<td class="padtop"><a href="#markIncomplete" data-assignee_id="<?php echo $id; ?>"" style="margin-left: 5px;">Mark Incomplete</a></td>
							<?php else: ?>
								<td><div class="wrong"></div></td>
								<td class="padtop"><a class="complete" href="#markcomplete" data-assignee_id="<?php echo $id; ?>"" style="margin-left: 5px;">Mark Complete</a></td>
							<?php endif; ?>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
	   </div>
		
	</div>


<script type="text/javascript">
	
	(function($) {
		
		bindhandlers();
		
		function bindhandlers() {
			
			$('#studentDetails').off('click');
			
			$('#studentDetails').on('click', 'a[href=#markcomplete]', (function(e) {
				var tar = $(e.currentTarget);
				var data = {Task: { assignee_id: tar.data('assignee_id'), parent_id: '<?php echo $task['id']; ?>', model: '<?php echo $task['model']; ?>', foreign_key: '<?php echo $task['foreign_key']; ?>'} };
				$.post('<?php echo $this->Html->url(array('plugin' => 'courses', 'controller' => 'courses', 'action' => 'completeAssignment')); ?>', data)
					.success(function() {
						var comp = tar.closest('tr');
						comp.find('.complete').attr("href", "#markIncomplete").html('Mark Incomplete');
						comp.find('.wrong').removeClass('wrong').addClass('right');
						bindhandlers();
					});	
			}));
	
			$('#studentDetails').on('click', 'a[href=#markIncomplete]', (function(e) {
				var tar = $(e.currentTarget);
				var data = { Task: { id: '<?php echo $task['id']; ?>', assignee_id: tar.data('assignee_id') } };
				$.post('<?php echo $this->Html->url(array('plugin' => 'courses', 'controller' => 'courses', 'action' => 'incompleteAssignment')); ?>', data)
					.success(function() {
						var comp = tar.closest('tr');
						comp.find('a').attr("href", "#markcomplete").html('Mark Complete');
						comp.find('.right').removeClass('right').addClass('wrong');
						bindhandlers();
					});	
			}));
		}
		
		
	})(jQuery);
	
	
</script>

<style type="text/css">
	#studentDetails .wrong {
		background: url(/Courses/img/right_wrong_small.png) no-repeat -28px 0;
		background-size:cover;
		width: 25px;
		height: 25px;
	}
	#studentDetails .right {
		background: url(/Courses/img/right_wrong_small.png) no-repeat 0 0;
		background-size:cover;
		width: 25px;
		height: 25px;
	}
	#studentDetails .padtop {
		padding-top:14px;
	}
</style>

