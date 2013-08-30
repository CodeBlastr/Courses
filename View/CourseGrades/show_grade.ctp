<?php
	$gradeDetail = $this->request->data['GradeDetail'];
	$grade = $this->request->data['CourseGrade'];
	$gradeAnswers = $this->request->data['GradeAnswers'];
	$student = $this->request->data['User'];
?>
<div id="showGrade" class="row-fluid">
<div class="span8 offset2">
	<h2 style="text-align: center">Your Grade</h2>
	
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
					<div class="span4">Your Answer</div>
					<div class="span4">Right Answer</div>
					<div class="span1"></div>
				</div>
			<?php foreach($gradeAnswers as $num => $ga): ?>
				<div class="row-fluid" style="border-top: #999 1px solid; padding: 10px 0;">
						<div class="span3 padtop">Question <?php echo $num; ?>: </div>
						<div class="span4 padtop"><?php echo $ga['answer']; ?></div>
						<div class="span4 padtop"><?php echo $ga['right_answer']; ?></div>
						
						<div class="span1">
							<?php if($ga['grade'] == $ga['total_worth']): ?>
								<div class="right"></div>
							<?php else: ?>
								<div class="wrong"></div>
							<?php endif; ?>
						</div>
					
				</div>
			<?php endforeach; ?>
			
		</div>
	</div>
	

</div>
</div>

<style type="text/css">
	#showGrade .wrong {
		background: url(/Courses/img/right_wrong_small.png) no-repeat -50px 0;
		width: 50px;
		height: 50px;
	}
	#showGrade .right {
		background: url(/Courses/img/right_wrong_small.png) no-repeat 0 0;
		width: 50px;
		height: 50px;
	}
	#showGrade .padtop {
		padding-top:14px;
	}
</style>
