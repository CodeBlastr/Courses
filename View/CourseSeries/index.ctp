<div class="series index">
	<h2><?php echo __($page_title);?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('description');?></th>
			<th><?php echo $this->Paginator->sort('location');?></th>
			<th><?php echo $this->Paginator->sort('language');?></th>
	</tr>
	<?php
	foreach ($series as $aSeries): ?>
	<tr>
		<td><?php echo h($aSeries['CourseSeries']['name']); ?>&nbsp;</td>
		<td><?php echo h($aSeries['CourseSeries']['description']); ?>&nbsp;</td>
		<td><?php echo h($aSeries['CourseSeries']['location']); ?>&nbsp;</td>
		<td><?php echo h($aSeries['CourseSeries']['language']); ?>&nbsp;</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} series out of {:count} total, starting on series {:start}, ending on {:end}')
	));
	?>	</p>

	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>


<?php
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Series',
		'items' => array(
			$this->Html->link('<i class="icon-th-list"></i>' .__('View All Series'), array('action' => 'index'), array('escape' => false)),
			$this->Html->link('<i class="icon-plus"></i>' .__('Create New Series'), array('action' => 'add'), array('escape' => false))
			),
		),
	array(
		'heading' => 'Courses',
		'items' => array(
			$this->Html->link('<i class="icon-th-list"></i>' .__('View All Courses'), array('controller' => 'courses', 'action' => 'index'), array('escape' => false)),
			$this->Html->link('<i class="icon-briefcase"></i>' . __('View Your Courses'), array('action' => 'dashboard'), array('escape' => false)),
			$this->Html->link('<i class="icon-plus"></i>' .__('Create New Course'), array('action' => 'add'), array('escape' => false))
			),
		),
	)));
