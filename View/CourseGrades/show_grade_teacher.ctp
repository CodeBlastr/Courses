<?php
	$gradeDetail = $this->request->data['GradeDetail'];
	$grade = $this->request->data['CourseGrade'];
	$gradeAnswers = $this->request->data['GradeAnswers'];
	$student = $this->request->data['User'];
	//debug($gradeAnswers);break;
?>
<div id="showGrade" class="row-fluid">
<div class="span8 offset2">
	<h2 style="text-align: center">Grade for <?php echo $student['full_name']; ?></h2>
	
	<div class="row-fluid">
		<div class="span12">
			
			<h3 style="text-align: center"><?php echo $gradeDetail['name']; ?></h3>
			<p><?php echo $gradeDetail['description']; ?></p>
			<p>&nbsp;</p>
			<div class="well">
				<h1 style="text-align: center"><?php echo $grade['grade']; ?> / <?php echo $grade['total']; ?></h1>
			</div>
			<h4>Graded Answers</h4>
			<div class="row-fluid">
					<div class="span3">Question</div>
					<div class="span3">Their Answer</div>
					<div class="span3">Right Answer</div>
					<div class="span1"></div>
					<div class="span1">Change Grade</div>
					<div class="span1">Drop</div>
				</div>
			<?php foreach($gradeAnswers as $num => $ga): ?>
				<div class="row-fluid" style="border-top: #999 1px solid; padding: 10px 0;">
						<div class="span3 padtop">Question <?php echo $num; ?>: </div>
						<div class="span3 padtop"><?php echo $ga['answer']; ?></div>
						<div class="span3 padtop"><?php echo $ga['right_answer']; ?></div>
						
						<div class="span1">
							<?php if($ga['grade'] == $ga['total_worth']): ?>
								<div class="right"></div>
							<?php else: ?>
								<div class="wrong"></div>
							<?php endif; ?>
						</div>
						
						<div class="span1">
							<?php echo $this->Form->postLink('Change Grade', array('plugin' => 'courses', 'controller' => 'course_grades', 'action' => 'change_answer', $ga['id'] ), $options = array (), _('Are you sure you want to change this grade?')); ?>
						</div>
						
						<div class="span1">
							<?php
								//$dropped =  
								echo $this->Form->checkbox(null, array('class' => 'grade-drop', 'checked' => $ga['dropped'], 'data-grade-id' => $ga['id'])); ?> 
						</div>
					
				</div>
			<?php endforeach; ?>
			
		</div>
	</div>
	

</div>
</div>

<style type="text/css">
	#showGrade .wrong {
		background: url(/Courses/img/right_wrong_small.png) no-repeat -28px 0;
		background-size:cover;
		width: 25px;
		height: 25px;
	}
	#showGrade .right {
		background: url(/Courses/img/right_wrong_small.png) no-repeat 0 0;
		background-size:cover;
		width: 25px;
		height: 25px;
	}
	#showGrade .padtop {
		padding-top:14px;
	}
</style>

<script type="text/javascript">
	
	$('.grade-drop').click(function(e) {
		e.preventDefault();
		var id = $(this).data('grade-id');
		alert(id + ' Grade Dropped - Still need to add code for this!')
	});
	
</script>
