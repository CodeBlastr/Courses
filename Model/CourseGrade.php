<?php
App::uses('CoursesAppModel', 'Courses.Model');
/**
 * Grade Model Stores over all Grades given Details provided by Course Grade Detail
 *
 * @property Course $ParentCourse
 */
class CourseGrade extends CoursesAppModel {
	
	public $name = 'Grade';
	
	public $useTable = 'course_grades';
	
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Course' => array(
			'className' => 'Courses.Course',
			'foreignKey' => 'course_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Student' => array(
			'className' => 'Users.User',
			'foreignKey' => 'student_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'GradeDetail' => array(
			'className' => 'Courses.CourseGradeDetail',
			'foreignKey' => 'course_grade_detail_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Creator' => array(
			'className' => 'Users.User',
			'foreignKey' => 'creator_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);
	
	public $hasMany = array(
		'GradeAnswers' => array(
			'className' => 'Courses.CourseGradeAnswer',
			'foreignKey' => 'course_grade_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);

/**
 * 
 * @param type $results
 * @param boolean $primary
 * @return type
 */
	public function afterFind($results, $primary = false) {
		parent::afterFind($results, $primary);
		foreach ( $results as &$result ) {
			// parse out the settings of an actual (parent) course
			if ( empty($result['Course']['parent_id']) ) {
				$result['Course']['settings'] = json_decode($result['Course']['settings']);
			}
		}
		
		return $results;
	}
	
/**
 * 
 * @param array $options
 * @return boolean
 */
	public function beforeSave($options = array()) {
		parent::beforeSave($options);
		// save Course.settings as json if necessarry
		if ( !empty($this->data['Course']['settings']) ) {
			if ( is_array($this->data['Course']['settings']) ) {
				$this->data['Course']['settings'] = json_encode($this->data['Course']['settings']);
			}
		}
		
		return true;
	}
	

/**
 * Callback from Answer->process()
 *
 * saves an empty grade for the teacher to grade later
 */
	public function afterAnswerProcess ( $form ) {
			$grade['Grade'] = array(
				'form_id' => $form['Answer']['id'],
				'student_id' => CakeSession::read('Auth.User.id'),
				'course_id' => $form['Answer']['foreign_key']
			);

			if ( $this->save($grade) ) {
				return true;
			} else {
				throw new Exception('Grade did not initialize.');
			}
	}

	/**
	 * create a grade function, this creates a grade from the grade details
	 * @param $details can be $id or CourseGradeDetail array
	 */

	public function createGradeFromDetails($details, $student_id = null) {
		
		if(!isset($details['CourseGradeDetail']) && !is_array($details)) {
			$details = $this->findById($details);
		}
		
		$grade = array();
		
		$grade['course_grade_detail_id'] = $details['CourseGradeDetail']['id'];
		$grade['model'] = $details['CourseGradeDetail']['model'];
		$grade['foreign_key'] = $details['CourseGradeDetail']['foreign_key'];
		$grade['course_id'] = $details['CourseGradeDetail']['course_id'];
		$grade['student_id'] = !empty($student_id) ? $student_id : CakeSession::read('Auth.User.id');
		$grade['total'] = $details['CourseGradeDetail']['total'];
		
	}
	
}
