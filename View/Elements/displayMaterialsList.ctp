<?php

echo '<ul class="courseMaterialsList">';
foreach ( $media as $medium ) {//debug($medium);
//	switch ($medium['type']) {
//		case ( 'images' ):
//			$link = $this->Html->image(
//					'/theme/Default/media/courses/' . $medium['type'] . '/' . $medium['filename'] . '.' . $medium['extension'], array('alt' => $medium['title'])
//			);
//			break;
//		case ( 'docs' ):
//			$link = $this->Html->image(
//					'/courses/img/1371768647_document.png', array('alt' => $medium['title'])
//			);
//			break;
//		case ( 'videos' ):
//			$link = $this->Html->image(
//					'/courses/img/1371768562_tv.png', array('alt' => $medium['title'])
//			);
//			break;
//		case ( 'audio' ):
//			$link = $this->Html->image(
//					'/courses/img/1371768587_lsongs.png', array('alt' => $medium['title'])
//			);
//			break;
//	}

	echo $this->Html->tag('li', $this->Html->link(
					$medium['title'], array('plugin' => 'media', 'controller' => 'media', 'action' => 'view', $medium['id']), array('escape' => false)
			), array()
	);
}
echo '</ul>';
