<div class="series index">
	<h2><?php echo __('Series');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('description');?></th>
			<th><?php echo $this->Paginator->sort('location');?></th>
			<th><?php echo $this->Paginator->sort('language');?></th>
			<th><?php echo $this->Paginator->sort('start');?></th>
			<th><?php echo $this->Paginator->sort('end');?></th>
			<th><?php echo $this->Paginator->sort('is_published');?></th>
			<th><?php echo $this->Paginator->sort('is_private');?></th>
			<th><?php echo $this->Paginator->sort('is_sequential');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	foreach ($series as $aSeries): ?>
	<tr>
		<td><?php echo h($aSeries['Series']['name']); ?>&nbsp;</td>
		<td><?php echo h($aSeries['Series']['description']); ?>&nbsp;</td>
		<td><?php echo h($aSeries['Series']['location']); ?>&nbsp;</td>
		<td><?php echo h($aSeries['Series']['language']); ?>&nbsp;</td>
		<td><?php echo h($aSeries['Series']['start']); ?>&nbsp;</td>
		<td><?php echo h($aSeries['Series']['end']); ?>&nbsp;</td>
		<td><?php echo h($aSeries['Series']['is_published']); ?>&nbsp;</td>
		<td><?php echo h($aSeries['Series']['is_private']); ?>&nbsp;</td>
		<td><?php echo h($aSeries['Series']['is_sequential']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $aSeries['Series']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $aSeries['Series']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $aSeries['Series']['id']), null, __('Are you sure you want to delete # %s?', $aSeries['Series']['id'])); ?>
		</td>
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
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Series'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List All Series'), array('controller' => 'series', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Course'), array('controller' => 'courses', 'action' => 'add')); ?> </li>
	</ul>
</div>
