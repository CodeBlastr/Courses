<div class="messages index">
	<div class="messages form"> <?php echo $this->Form->create('Message', array('url' => '/messages/messages/send')); ?>
		<fieldset> 
			<?php
			echo __('<legend class="toggleClick">Messages <span class="btn">Create a Message</span></legend>');
			echo $this->Form->input('Message.title', array('label' => __('Subject', true)));
			echo $this->Form->input('Message.body', array('label' => '', 'type' => 'richtext', 'ckeSettings' => array('buttons' => array('Bold', 'Italic', 'Underline', 'FontSize', 'TextColor', 'BGColor', '-', 'NumberedList', 'BulletedList', 'Blockquote', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', '-', 'Link', 'Unlink', '-', 'Image'))));
			echo $this->Form->input('User', array(
				'multiple' => 'checkbox',
				'label' => 'Select people to send this message to.  They will also be notified of all comments.'
			));
			echo $this->Form->input('Message.sender_id', array('type' => 'hidden', 'value' => $this->Session->read('Auth.User.id')));
			echo $this->Form->input('Success.redirect', array('type' => 'hidden', 'value' => '/courses/courses/message/' . $this->request->data['Message']['foreign_key']));
			echo $this->Form->hidden('Message.foreign_key');
			echo $this->Form->hidden('Message.model', array('value' => 'Course'));
			echo $this->Form->hidden('Message.viewPath', array('value' => '/courses/courses/message/{messageId}'));
			echo $this->Form->end(__('Send', true));
			?>
		</fieldset>
	</div>
