<?php
$start = strtotime($series['CourseSeries']['start']);
$end = strtotime($series['CourseSeries']['end']);
$lengthOfSeries = round( abs( $end - $start ) / 60 / 60 / 24 / 7 );
?>
<div class="courses view">
	<h2><?php echo $series['CourseSeries']['name'] ?></h2>
	<p><b><?php echo $series['CourseSeries']['school'] ?></b></p>
	<div class="row-fluid">
		<div class="span8">
			<p><?php echo $series['CourseSeries']['description'] ?></p>
			<table>
				<tr>
					<td><b>Starts: </b><?php echo $this->Time->niceShort($series['CourseSeries']['start']) ?> (<?php echo $lengthOfSeries ?> weeks long)</td>
					<td><b>Language: </b><?php echo $series['CourseSeries']['language'] ?></td>
				</tr>
				<tr>
					<td><b>Location: </b><?php echo $series['CourseSeries']['location'] ?></td>
					<td><b>Grade Level: </b><?php echo $series['CourseSeries']['grade'] ?></td>
				</tr>
			</table>
			<hr />

			<p>This series consists of the following courses:</p>
			<?php
			$seriesCourses = '';
			foreach ( $series['Course'] as $course ) {
				$seriesCourses .= $this->Html->tag('li', $this->Html->link($course['name'], array( 'controller' => 'courses', 'action' => 'view', $course['id'] )));
			}
			echo $this->Html->tag('ol', $seriesCourses);
			?>

			<p>
				<?php
				if (!$isOwner) {
					if (!$isEnrolled) {
						echo $this->Html->link('Register for this series', array('action' => 'register', $series['CourseSeries']['id']), array('class' => 'btn btn-primary'));
					} else {
						echo $this->Html->link('Drop ' . $series['CourseSeries']['name'], array('action' => 'unregister', $series['CourseSeries']['id']), array('class' => 'btn btn-danger'));
					}
				}
				?>
			</p>
		</div>
		<div class="span4">
			<h3>Instructed by:</h3>
			<?php
			echo $this->element('Users.snpsht', array('useGallery' => true, 'userId' => $series['Teacher']['id'], 'thumbSize' => 'medium', 'thumbLink' => 'default', 'showFirstName' => true, 'showLastName' => true));
			?>
		</div>
	</div>

<?php
/**
 * Menus !
 */
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Series',
		'items' => array(
			$this->Html->link(__('Edit this Series'), array('controller' => 'courseSeries', 'action' => 'edit', $series['CourseSeries']['id'])),
			$this->Html->link(__('Create New Series'), array('controller' => 'courseSeries', 'action' => 'add'))
			),
		),
	array(
		'heading' => 'Courses',
		'items' => array(
			$this->Html->link(__('View All Courses'), array('controller' => 'courses', 'action' => 'index')),
			$this->Html->link(__('View Your Courses'), array('controller' => 'cousres', 'action' => 'dashboard')),
			$this->Html->link(__('Create New Course'), array('controller' => 'courses', 'action' => 'add'))
			),
		),
	)));

$this->set('guest_menu', array('menus' => array(
	array(
		'heading' => 'Series',
		'items' => array(
			$this->Html->link(__('Edit this Series'), array('controller' => 'courseSeries', 'action' => 'edit', $series['CourseSeries']['id'])),
			$this->Html->link(__('Create New Series'), array('controller' => 'courseSeries', 'action' => 'add'))
			),
		),
	array(
		'heading' => 'Courses',
		'items' => array(
			$this->Html->link(__('View All Courses'), array('controller' => 'courses', 'action' => 'index')),
			$this->Html->link(__('View Your Courses'), array('controller' => 'courses', 'action' => 'dashboard')),
			$this->Html->link(__('Create New Course'), array('controller' => 'courses', 'action' => 'add'))
			),
		),
	)));

$this->set('owner_menu', array('menus' => array(
	array(
		'heading' => 'Series',
		'items' => array(
			$this->Html->link(__('Edit this Series'), array('controller' => 'courseSeries', 'action' => 'edit', $series['CourseSeries']['id'])),
			$this->Html->link(__('Create New Series'), array('controller' => 'courseSeries', 'action' => 'add'))
			),
		),
	array(
		'heading' => 'Courses',
		'items' => array(
			$this->Html->link(__('View All Courses'), array('controller' => 'couses', 'action' => 'index')),
			$this->Html->link(__('View Your Courses'), array('controller' => 'couses', 'action' => 'dashboard')),
			$this->Html->link(__('Create New Course'), array('controller' => 'couses', 'action' => 'add'))
			),
		),
	)));
