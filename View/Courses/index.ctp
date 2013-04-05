<div class="courses index">
	<h2><?php echo __('Courses');?></h2>
	
	
	<?php
	foreach ($courses as $course) {
		
		$start = strtotime($course['Course']['start']);
		$end = strtotime($course['Course']['end']);
		$lengthOfCourse = round( abs( $end - $start ) / 60 / 60 / 24 / 7 );
		
		echo $this->Html->tag('div',
				$this->Html->tag('div',
						$course['Course']['school'] . '<br />'
						. '<b>'.$this->Html->link($course['Course']['name'], array('action' => 'view', $course['Course']['id'])).'</b>',
						array('class' => 'span9')
				)
				. $this->Html->tag('div',
						$this->Time->niceShort($course['Course']['start']). '<br />'
						. $lengthOfCourse . ' weeks long',
						array('class' => 'span3')
				),
				array( 'class' => 'row-fluid' )
		);
	}
	?>
	
	
<!--	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('parent_id');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('description');?></th>
			<th><?php echo $this->Paginator->sort('location');?></th>
			<th><?php echo $this->Paginator->sort('school');?></th>
			<th><?php echo $this->Paginator->sort('grade');?></th>
			<th><?php echo $this->Paginator->sort('language');?></th>
			<th><?php echo $this->Paginator->sort('start');?></th>
			<th><?php echo $this->Paginator->sort('end');?></th>
			<th><?php echo $this->Paginator->sort('is_published');?></th>
			<th><?php echo $this->Paginator->sort('is_private');?></th>
			<th><?php echo $this->Paginator->sort('is_persistant');?></th>
			<th><?php echo $this->Paginator->sort('is_sequential');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	foreach ($courses as $course): ?>
	<tr>
		<td><?php echo h($course['Course']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($course['ParentCourse']['name'], array('controller' => 'courses', 'action' => 'view', $course['ParentCourse']['id'])); ?>
		</td>
		<td><?php echo h($course['Course']['name']); ?>&nbsp;</td>
		<td><?php echo h($course['Course']['description']); ?>&nbsp;</td>
		<td><?php echo h($course['Course']['location']); ?>&nbsp;</td>
		<td><?php echo h($course['Course']['school']); ?>&nbsp;</td>
		<td><?php echo h($course['Course']['grade']); ?>&nbsp;</td>
		<td><?php echo h($course['Course']['language']); ?>&nbsp;</td>
		<td><?php echo h($course['Course']['start']); ?>&nbsp;</td>
		<td><?php echo h($course['Course']['end']); ?>&nbsp;</td>
		<td><?php echo h($course['Course']['is_published']); ?>&nbsp;</td>
		<td><?php echo h($course['Course']['is_private']); ?>&nbsp;</td>
		<td><?php echo h($course['Course']['is_persistant']); ?>&nbsp;</td>
		<td><?php echo h($course['Course']['is_sequential']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $course['Course']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $course['Course']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $course['Course']['id']), null, __('Are you sure you want to delete # %s?', $course['Course']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>-->
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} courses out of {:count} total')
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
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Course'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Courses'), array('controller' => 'courses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Parent Course'), array('controller' => 'courses', 'action' => 'add')); ?> </li>
	</ul>
</div>
