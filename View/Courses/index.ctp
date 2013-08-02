<div class="courses index">
	<h2><?php echo $page_title_for_layout;?></h2>
	<ul class="nav nav-pills">
		<?php 
		$active = empty($this->params->pass[0]) ? 'active' : 'inactive';
		echo __('<li class="%s">%s</li>', $active, $this->Html->link('All', array('action' => 'index')));
		foreach ($categories as $id => $category) {
			$active = $this->params->pass[0] == $id ? 'active' : 'inactive';
			echo __('<li class="%s">%s</li>', $active, $this->Html->link($category, array('action' => 'index', $id)));
		} ?>
	</ul>
	<?php
	foreach ($courses as $course) {
		$start = strtotime($course['Course']['start']);
		$end = strtotime($course['Course']['end']);
		$lengthOfCourse = round( abs( $end - $start ) / 60 / 60 / 24 / 7 );
		
		echo $this->Html->tag('div',
			$this->Html->tag('div',
				__('<b>%s</b> from %s<br /><p class="truncate">%s</p>', $this->Html->link($course['Course']['name'], array('action' => 'view', $course['Course']['id'])), $course['Course']['school'], $course['Course']['description']),
				array('class' => 'span9')
				) .
			$this->Html->tag('div', __('<b>%s</b><br />Starts : %s<br /> %s weeks long <br />%s', $course['Category'][0]['name'], ZuhaInflector::datify($course['Course']['start']), $lengthOfCourse, $this->Rating->bar(number_format($course['Course']['_rating'], 2, '.', ','), 5, array('outerClass' => 'progress', 'innerClass' => 'bar bar-success'))), array('class' => 'span3')),
			array( 'class' => 'row-fluid' )
		);
	} ?>
	
	
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
