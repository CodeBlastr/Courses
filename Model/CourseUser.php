<?php
App::uses('CoursesAppModel', 'Courses.Model');
/**
 * CourseUser Model
 *
 * @property User $User
 * @property Course $Course
 */
class CourseUser extends CoursesAppModel {
	public $name = 'CourseUser';
/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'user_id';


/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'Users.User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Course' => array(
			'className' => 'Courses.Course',
			'foreignKey' => 'course_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
/**
 * after save callback
 */
	public function afterSave() {
		// we say in the model when people get subscribed
		if (in_array('Subscribers', CakePlugin::loaded())) {
			$subscriber['Subscriber']['model'] = 'Course';
			$subscriber['Subscriber']['foreign_key'] = $this->data['CourseUser']['course_id'];
			$subscriber['Subscriber']['user_id'] = $this->data['CourseUser']['user_id'];
			$this->Course->subscribe($subscriber);
		}
	}
	
/**
 * Returns a nice array of the participants in a Course
 * @param int $courseId
 * @return array
 */
	public function getCourseUsers ( $courseId ) {
		$courseUsers = $this->find('all', array(
			'conditions' => array('CourseUser.course_id' => $courseId),
			'contain' => array('User')
		));
		$courseUsers = Set::combine($courseUsers, '{n}.User.id', '{n}');
		
		return $courseUsers;
	}
	
}
