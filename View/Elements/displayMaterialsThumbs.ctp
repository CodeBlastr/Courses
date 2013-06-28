<?php

echo '<ul class="courseMaterialsThumbs thumbnails">';
foreach ( $media as $medium ) {//debug($medium);
	switch ($medium['type']) {
		case ( 'images' ):
			$imageToLink = $this->Html->image(
					'/theme/Default/media/courses/' . $medium['type'] . '/' . $medium['filename'] . '.' . $medium['extension'], array('alt' => $medium['title'])
			);
			break;
		case ( 'docs' ):
			$imageToLink = $this->Html->image(
					'/courses/img/1371768647_document.png', array('alt' => $medium['title'])
			);
			break;
		case ( 'videos' ):
			$imageToLink = $this->Html->image(
					'/courses/img/1371768562_tv.png', array('alt' => $medium['title'])
			);
			break;
		case ( 'audio' ):
			$imageToLink = $this->Html->image(
					'/courses/img/1371768587_lsongs.png', array('alt' => $medium['title'])
			);
			break;
	}

	echo $this->Html->tag('li', $this->Html->link(
					$imageToLink, array('plugin' => 'media', 'controller' => 'media', 'action' => 'view', $medium['id']), array('escape' => false, 'class' => 'thumbnail')
			), array('class' => 'span3')
	);
}
echo '</ul>';
