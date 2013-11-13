<?php
	//debug($this->request->data);
	$gradeDetail = $this->request->data['GradeDetail'];
	$grade = $this->request->data['CourseGrade'];
	$gradeAnswers = $this->request->data['GradeAnswers'];
	$student = $this->request->data['User'];
?>
<div id="showGrade" class="row-fluid">
<div class="span12">
	<h2 style="text-align: center">Grade for <?php echo $student['full_name']; ?></h2>
	<?php echo $this->Html->link('Go Back to assignment', array('controller' => 'courses', 'action' => 'assignment', $grade['foreign_key'] )); ?>
	<div class="row-fluid">
		<div class="span12">
			
			<h3 style="text-align: center"><?php echo $gradeDetail['name']; ?></h3>
			<p><?php echo $gradeDetail['description']; ?></p>
			<p>&nbsp;</p>
			<div class="well">
				<h1 style="text-align: center"><?php echo $grade['grade']; ?> / <?php echo $grade['total']; ?></h1>
			</div>
			<h4>Graded Answers</h4>
			<hr>
			<div class="row-fluid">
					<div class="span2">Question</div>
					<div class="span3">Their Answer</div>
					<div class="span3">Right Answer</div>
					<div class="span1"></div>
					<div class="span2">Points</div>
					<div class="span1">Drop</div>
				</div>
			<?php echo $this->Form->create(null, array('url' => array('action' => 'edit_answers'))); ?>
			<?php echo $this->Form->hidden('GradeDetail.creator_id'); ?>
			<?php echo $this->Form->hidden('GradeDetail.course_id'); ?>
			<?php echo $this->Form->hidden('CourseGrade.id'); ?>
			<?php echo $this->Form->hidden('CourseGrade.student_id'); ?>
			<?php foreach($gradeAnswers as $num => $ga): ?>
				<div class="row-fluid" style="border-top: #999 1px solid; padding: 10px 0;">
						<div class="span2 padtop">Question <?php echo $num; ?>: </div>
						<div class="span3 padtop"><?php echo $ga['answer']; ?></div>
						<div class="span3 padtop"><?php echo $ga['right_answer']; ?></div>
						
						<div class="span1">
							<?php if($ga['grade'] == $ga['total_worth']): ?>
								<div class="right"></div>
							<?php else: ?>
								<div class="wrong"></div>
							<?php endif; ?>
						</div>
						
						<div class="span2">
							<?php echo $this->Form->input('GradeAnswers.'.$num.'.id'); ?>
							<?php echo $this->Form->input('GradeAnswers.'.$num.'.grade', array('label' => false, 'div' => false, 'class' => 'pull-left input-mini', 'style' => 'margin-right: 5px;')); ?>/ <?php echo $ga['total_worth']; ?>
						</div>
						
						<div class="span1">
							<?php
								echo $this->Form->checkbox('GradeAnswers.'.$num.'.dropped', array('class' => 'grade-drop', 'checked' => $ga['dropped'], 'data-grade-id' => $ga['id'])); ?> 
						</div>
					
				</div>
			<?php endforeach; ?>
			<hr>
			<?php echo $this->Form->end('Save Grades'); ?>
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
