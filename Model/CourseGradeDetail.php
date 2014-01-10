<?php
App::uses('CoursesAppModel', 'Courses.Model');
/**
 * Course Grade Detail Model - Used to store grading details for each grade given.
 *
 * @property Course $ParentCourse
 */
class CourseGradeDetail extends CoursesAppModel {
	
	public $name = 'CourseGradeDetail';
	
	public $useTable = 'course_grade_details';

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
		'Teacher' => array(
			'className' => 'Users.User',
			'foreignKey' => 'creator_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);
	
	public $hasMany = array(
		'GradeAnswers' => array(
			'className' => 'Courses.CourseGrade',
			'foreignKey' => 'course_grade_detail_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);
	
	public function beforeSave($options=array()) {
		if(isset($this->data['CourseGradeDetail']['data']) && !empty($this->data['CourseGradeDetail']['data'])) {
			$this->data['CourseGradeDetail']['data'] = serialize($this->data['CourseGradeDetail']['data']);
			for($i = 0 ; $i < count($result['CourseGradeDetail']['data']['assignmentcategory']) ; $i++) {
				$result['CourseGradeDetail']['data']['assignmentcategory'][$i]['weight'] = $result['CourseGradeDetail']['data']['assignmentcategory'][$i]['weight']/100;
			}
		}
		parent::beforeSave($options);
		return true;
	}
	
	public function afterFind($results, $primary) {
		foreach ($results as $index => $result) {
			if(isset($result['CourseGradeDetail']['data']) && !empty($result['CourseGradeDetail']['data'])) {
				$result['CourseGradeDetail']['data'] = unserialize(($result['CourseGradeDetail']['data']));
				for($i = 0 ; $i < count($result['CourseGradeDetail']['data']['assignmentcategory']) ; $i++) {
					$result['CourseGradeDetail']['data']['assignmentcategory'][$i]['droplowest'] = (int) $result['CourseGradeDetail']['data']['assignmentcategory'][$i]['droplowest'];
					$result['CourseGradeDetail']['data']['assignmentcategory'][$i]['allowcurve'] = (int) $result['CourseGradeDetail']['data']['assignmentcategory'][$i]['allowcurve'];
					$result['CourseGradeDetail']['data']['assignmentcategory'][$i]['weight'] = (float) $result['CourseGradeDetail']['data']['assignmentcategory'][$i]['weight'];
				}
				$results[$index] = $result;
			}
		}
		
		return $results;
	}
	
	public function gettypes($model, $id) {
		$types = $this->find('first', array(
			'conditions' => array(
				'model' => $model,
				'foreign_key' => $id
		)));
		
		if(!$types) {
			return array();
		}
		
		$types = Hash::extract($types, 'CourseGradeDetail.data.assignmentcategory.{n}.type');
		$types = array_combine($types, $types);
		return $types;
	}
}
