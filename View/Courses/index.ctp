<div class="courses index">
<?php $courses = $this->request->data; ?>
	<h2><?php echo $page_title_for_layout;?></h2>
	<ul class="nav nav-pills">
		<?php
		$active = isset($this->request->query['category']) ? 'inactive' : 'active';
		echo __('<li class="%s">%s</li>', $active, $this->Html->link('All', array('action' => 'index')));
		foreach ($categories as $id => $category) {
			$active = $this->request->query['category'] == $id || $this->request->query['category'] == $category ? 'active' : 'inactive';
			echo __('<li class="%s">%s</li>', $active, $this->Html->link($category, array('action' => 'index', '?' => array('category' => urlencode($category)))));
		} ?>
	</ul>
	<?php foreach ($courses as $course): 
		$start = strtotime($course['Course']['start']);
		$end = strtotime($course['Course']['end']);
		$lengthOfCourse = round( abs( $end - $start ) / 60 / 60 / 24 / 7 ); ?>
		
	<div class="row-fluid">
		<div class="span9">
			<?php echo __('<b>%s</b> from %s<br /><p class="truncate">%s</p>', $this->Html->link($course['Course']['name'], array('action' => 'view', $course['Course']['id'])), $course['Course']['school'], $course['Course']['description']); ?>
		</div>
		<div class="span3">
			<?php echo	__('<b>%s</b><br />Starts : %s<br /> %s weeks long <br />', $course['Category'][0]['name'], ZuhaInflector::datify($course['Course']['start']), $lengthOfCourse); ?>
		</div>
	</div>	
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
