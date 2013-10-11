<div class="courses index">
<?php $courses = $this->request->data; ?>
	<h2><?php echo $page_title_for_layout;?></h2>
	<hr>
	<ul class="nav nav-pills">
		<?php
		$active = isset($this->request->query['category']) ? 'inactive' : 'active';
		echo __('<li class="%s">%s</li>', $active, $this->Html->link('All', array('action' => 'index')));
		foreach ($categories as $id => $category) {
			$active = $this->request->query['category'] == $id || $this->request->query['category'] == $category ? 'active' : 'inactive';
			echo __('<li class="%s">%s</li>', $active, $this->Html->link($category, array('action' => 'index', '?' => array('category' => urlencode($category)))));
		} ?>
	</ul>
	<hr>
	<?php foreach ($courses as $course): 
		$start = strtotime($course['Course']['start']);
		$end = strtotime($course['Course']['end']);
		$lengthOfCourse = round( abs( $end - $start ) / 60 / 60 / 24 / 7 );?>
		
		<?php if($course['Course']['type'] == 'series'): ?>
		<div class="row-fluid">
			<div class="span2">
				<img data-src="holder.js/100%x150" />
			</div>
			<div class="span8">
					<div class="span7">
						<div class="course-item">
						<h4><?php echo __($this->Html->link($course['Course']['name'], array('controller' => 'course_series', 'action' => 'view', $course['Course']['id']))); ?></h4>
						<h6><small><?php echo __($course['Course']['school']); ?></small></h6>
						<h6><small><?php echo	__('<b>%s</b><br />Starts : %s<br /> %s weeks long <br />', array($course['Category'][0]['name'], ZuhaInflector::datify($course['Course']['start']), $lengthOfCourse)); ?></small></h6>
						<div class="description">
							<div class="truncate"><?php echo __( $course['Course']['description'] ); ?></div>
						</div>
						</div>
					</div>
					<div class="span5">
						<h5>Available Courses:</h5>
						<div class="course-list-series" style="overflow-y:auto;">
						<?php foreach ($course['SubCourse'] as $subcourse): ?>
						 	<div class="media">
							  <a class="pull-left" href="#">
							    <img class="media-object" data-src="holder.js/50x50">
							  </a>
							  <div class="media-body">
							    <p class="media-heading"><b><?php echo __($subcourse['name'])?></b></p>
							  	<p><small><?php echo ZuhaInflector::datify($subcourse['start'], 100); ?></small></p>
							  </div>
							</div>
						<?php endforeach; ?>
						</div>
					</div>
				
			</div>
			<div class="span2">
				<div class="actions">
					<ul class="nav nav-tabs nav-stacked">
						<?php if(empty($course['CourseUser'])): ?>
						<li><?php echo $this->Html->link('Register', array('controller' => 'courses_series', 'action' => 'register', $course['Course']['id']), array('class' => 'btn btn-primary'))?></li>
						<?php else: ?>
						<li>You are already Registered <br /><?php echo $this->Html->link('View Series', array('controller' => 'courses_series', 'action' => 'view', $course['Course']['id']), array('class' => 'btn btn-mini btn-primary'))?></li>
						<?php endif; ?>
					</ul>
				</div>
			</div>
		</div>
		<?php elseif($course['Course']['type'] == 'course'): ?>
		<div class="row-fluid">
			<div class="span2">
				<img data-src="holder.js/100%x150" />
			</div>
			<div class="span8">
				<div class="course-item">
						<h4><?php echo __($this->Html->link($course['Course']['name'], array('controller' => 'course_series', 'action' => 'view', $course['Course']['id']))); ?></h4>
						<h6><small><?php echo	__('<b>%s</b><br />Starts : %s<br /> %s weeks long <br />', array($course['Category'][0]['name'], ZuhaInflector::datify($course['Course']['start']), $lengthOfCourse)); ?></small></h6>
						<h6><small><?php echo __($course['Course']['school']); ?></small></h6>
						<div class="description">
							<div class="truncate"><?php echo __( $course['Course']['description'] ); ?></div>
						</div>
				</div>
			</div>
			<div class="span2">
				<div class="actions">
					<ul class="nav nav-tabs nav-stacked">
						<?php if(empty($course['CourseUser'])): ?>
						<li><?php echo $this->Html->link('Register', array('controller' => 'courses', 'action' => 'register', $course['Course']['id']), array('class' => 'btn btn-primary'))?></li>
						<?php else: ?>
						<li><small>You are already Registered</small> <br /><?php echo $this->Html->link('View Course', array('controller' => 'courses', 'action' => 'view', $course['Course']['id']), array('class' => 'btn btn-mini'))?></li>
						<?php endif; ?>
					</ul>
				</div>
			</div>
		</div>
		
		<?php endif; ?>
	<hr />
	<?php endforeach; ?>
	
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} courses out of {:count} total')
	));
	?>	</p>

	<div class="paging">
		<?php
			echo $this->Paginator->prev(' << ' . __('previous'), array(), null, array('class' => 'prev disabled hidden'));
			echo $this->Paginator->numbers(array('separator' => ''));
			echo $this->Paginator->next(__('next') . ' << ', array(), null, array('class' => 'next disabled hidden'));
		?>
	</div>
</div>

<script type="text/javascript">
<!--
	$(function() {
		$('.course-list-series').each(function() {
			$(this).css('max-height', $(this).closest('.row-fluid').find('.course-list-series').height()+'px');
		});
	});
//-->
</script>

<style type="text/css">
	.course-item h4 {
		margin: 0;
	}		
</style>


<?php
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Courses',
		'items' => array(
			$this->Html->link('<i class="icon-briefcase"></i>' . __('View Your Courses'), array('action' => 'dashboard'), array('escape' => false)),
			$this->Html->link('<i class="icon-plus"></i>' .__('Create New Course'), array('action' => 'add'), array('escape' => false))
			),
		),
	)));
