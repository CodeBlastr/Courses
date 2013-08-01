<h2><?php echo $lesson['CourseLesson']['name'] ?></h2>
<hr />
<p>
	<b>Starts: </b><?php echo $this->Time->niceShort($lesson['CourseLesson']['start']) ?> (<?php echo $lesson['CourseLesson']['lengthOfCourse'] ?> weeks long)
</p>
<p>
	<b>Location: </b><?php echo $lesson['CourseLesson']['location'] ?>
</p>
<p>
	<b>Language: </b><?php echo $lesson['CourseLesson']['language'] ?>
</p>