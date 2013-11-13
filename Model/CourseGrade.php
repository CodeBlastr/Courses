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
		'MainCourse' => array(
				'className' => 'Courses.Course',
				'foreignKey' => 'foreign_key',
				'conditions' => array('CourseGrade.model' => 'Course'),
				'fields' => '',
				'order' => ''
		),
		'User' => array(
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
		),
		'SubGrades' => array(
			'className' => 'Courses.CourseGrade',
			'foreignKey' => false,
			'conditions' => array(
				'SubGrades.model NOT' => 'Course',
				'SubGrades.course_id' => 'CourseGrade.foreign_key',
				'SubGrades.student_id' => 'CourseGrade.student_id',
				),
			'fields' => '',
			'order' => ''
		),
		'SubDetails' => array(
				'className' => 'Courses.CourseGradeDetail',
				'foreignKey' => 'course_id',
				'conditions' => array(
					'SubDetails.model NOT' => 'Course',
					'SubDetails.course_id' => 'Course.id',
				),
			)
	);
	
	public $studentId = ''; //User Id of grades being saved
	
	public $gradeDetails = ''; //Holder for grading information
	
	/**
	 * Curve types 
	 * [Method Name] => [Label]
	 * @var unknown
	 */
	public $curveTypes = array(
		'square_root' => 'Square Root',
		'highest' => 'Highest Grade to 100',
		'flat_scale' => 'Flat Scale'
	);


	/**
	 * Main Grading Function
	 * @param $gradeDetailId - Grade detail
	 * @param $answers - array of answers
	 * @param $studentId - Id of Student
	 * 
	 * @return bool
	 * 
	 */

	public function grade($gradeDetailId = false, $answers = array(), $studentId = null, $score = null, $total = null) {
		if($gradeDetailId) {
			$this->gradeDetails = $this->GradeDetail->findById($gradeDetailId);
			if($this->gradeDetails) {
				$this->studentId = !empty($student_id) ? $student_id : CakeSession::read('Auth.User.id');
				if(!empty($answers)) {
					$scores = $this->gradeAnswers($answers);
				}else {
					if(!empty($score) && !empty($total)) {
						$scores = compact('score', 'total');
					}else {
						throw new Exception("No answers to grade, and no score or total provided", 1);
					}
				}
				
				$grades = $this->_prepareGrade($scores, $method);
				//Reattach the Answers for saving if available
				if(isset($scores['answers'])) {
					$grades['GradeAnswers'] = $scores['answers'];
				}
				
				$grades['CourseGrade']['type'] = $this->gradeDetails['GradeDetail']['type'];
				
				$gradeid = '';
				if($this->saveAll($grades)) {
					$gradeid = $this->id;
					if(!$this->updateCourseGrade($this->gradeDetails['GradeDetail']['course_id'])) {
						throw new Exception('Course grade was not updated, you will need to update manually');
					}
				}
				return $gradeid;
				
			}
			
		}else{
			throw new Exception('No Grading Details Defined');
		}
	}
	
	/**
	 * Build Grade array for saving 
	 * @param $answers -  the graded save ready answers array
	 * @param $method - String 
	 * @return - array ready for saving
	 */
	 
	 protected function _prepareGrade($answers = null, $details = null) {
	 	$details = empty($details) ? $this->gradeDetails : $details;
	 	$grade = array();
		$grade['CourseGrade'] = array(
			'course_grade_detail_id' => $details['GradeDetail']['id'],
			'model' => $details['GradeDetail']['model'],
			'foreign_key' => $details['GradeDetail']['foreign_key'],
			'course_id' => $details['GradeDetail']['course_id'],
			'student_id' => $this->studentId,
		);
		
		if(!empty($answers)) {
			$grade['CourseGrade']['points_earned'] = $answers['score'];
			$grade['CourseGrade']['total'] = $answers['total'];
		}
		
		return $grade;
	 }
	 
	 public function updateCourseGrade($courseid) {
	 	$course_grade = $this->find('first', array(
	 		'conditions' => array(
				'CourseGrade.model' => 'Course',
				'CourseGrade.foreign_key' => $courseid,
				'CourseGrade.student_id' => $this->studentId,
				),
			'contain' => array('GradeDetail')
		));
	 	//debug(unserialize($course_grade['GradeDetail']['data']));exit;
		//If grade doesn't exist yet, lets make one
		if(!$course_grade) {
			throw new Exception('No Course Grading Settings Defined');
		}
		
		$this->gradeSettings = unserialize($course_grade['GradeDetail']['data']);
		
		$subgrades = $this->find('all', array(
			'conditions' => array(
				'CourseGrade.model NOT' => 'Course',
				'CourseGrade.course_id' => $courseid,
				'CourseGrade.student_id' => $this->studentId,
				)
		));
		
		if(!$subgrades) {
			throw new Exception('Nothing to Grade', 0);
		}
		debug($subgrades);
		if(empty($this->gradeSettings)) {
			throw new Exception('Grading Details are not defined', 0);
		}
		debug($this->gradeSettings);
		$subgrades = $this->formatSubGrades($subgrades);
		try {
			$grade = $this->gradeSubGrades($subgrades);
		}catch (Exception $e) {
			debug($e->getMessage());
		}
		exit;
		$score = $this->$method($course_grade, $subgrades, $details);
		$course_grade['CourseGrade']['grade'] = $score['score'];
		$course_grade['CourseGrade']['total'] =  $score['total'];
		
		if($this->save($CourseGrade)) {
			return true;
		}else {
			return false;
		}
	 }
	 
	 protected function gradeSubGrades($subgrades) {
	 	$keys = Hash::extract($this->gradeSettings, 'assignmentcategory.{n}.type');
	 	$total = 0;
	 	foreach($subgrades as $type => $sub) {
	 		$key = array_search($type, $keys);
	 		$droplowest = $this->gradeSettings['assignmentcategory'][$key]['droplowest'];
	 		//$allowcurve = $this->gradeSettings['assignmentcategory'][$key]['allowcurve'];
	 		//$curvetype = $allowcurve ? $this->gradeSettings['curve_type'].'_grading' : false;
	 		if($droplowest) {
	 			$sub['grades'] = $this->_dropLowest($sub['grades']);
	 		}
	 		$sub['total_points'] = $this->_getTotal($sub['grades']);
	 		$sub['points'] = $this->_getPoints($sub['grades']);
	 		$sub['weight'] = $this->gradeSettings['assignmentcategory'][$key]['weight'];
	 		$total += $sub['points']/$sub['total_points'] * $sub['weight'];
	 		$subgrades[$type] = $sub;
	 	}
	 	debug($subgrades);
	 	debug($total);exit;
	 }
	 
	 private function _dropLowest($grades) {
	 	$lowest = $grades[0]['grade'];
	 	$recindex = 0;
	 	foreach($grades as $key => $value) {
	 		if($value['grade'] < $lowest) {
	 			$recindex = $key;
	 			$lowest = $value['grade'];
	 		}
	 	}
	 	unset($grades[$recindex]);
	 	return $grades;
	 }
	 
	 private function _getPoints($grades) {
	 	$points = 0;
	 	foreach ($grades as $grade) {
	 		if(isset($grade['CourseGrade'])) {
	 			$grade = $grade['CourseGrade'];
	 		}
	 		
	 		$points += $grade['points_earned'];
	 	}
	 	return $points;
	 }
	 
	 private function _getTotal($grades) {
	 	$total = 0;
	 	foreach ($grades as $grade) {
	 		if(isset($grade['CourseGrade'])) {
	 			$grade = $grade['CourseGrade'];
	 		}
	 
	 		$total += $grade['total'];
	 	}
	 	return $total;
	 }
	
	/**
	 * Grading methods
	 * @param $answers - The graded answers array
	 * @return int - grade
	 */
	 
	 
	 /**
	  * Square Root Grading
	  * Final Grade = (SQRT (Raw Score/100)) x 100
	  * @param formated $subgrade
	  */
	 
	 protected function square_root_grading($total, $points) {	
	 	 $raw_grade = $points/$total;
	 	 return sqrt($raw_grade)*100;
	 }
	 
	 /**
	  * Grade Answers
	  * @param $answers - The graded answers array
	  */
	  
	  protected function gradeAnswers($answers) {
	  	
		 $answers = $this->createAnswersFromDetails($answers);
		 $total = 0;
		 $score = 0;
	  	 if(!empty($this->gradeDetails['GradeDetail']['right_answers'])) {
	  	 	//Grade and Save the Answers
	  	 	$rightAnswers = json_decode($this->gradeDetails['GradeDetail']['right_answers']);
			foreach($answers as $index => $answer) {
				$answer['right_answer'] = $rightAnswers->$answer['input_id']->answer;
				$answer['total_worth'] = $rightAnswers->$answer['input_id']->points;
				$answer['grade'] = $this->_gradeAnswer($answer['answer'], $rightAnswers->$answer['input_id']->answer, $rightAnswers->$answer['input_id']->points);
				$score += $answer['grade'];
				$total += $rightAnswers->$answer['input_id']->points;
				$answers[$index] = $answer;
			}
	  	 }
		 
		 return compact('total', 'score', 'answers');
	  }
	  
  /**
   * Grading for Individual Answers
   * 
   * @return points
   * 
   */
	  
	  protected function _gradeAnswer($ans, $rightans, $total = null) {
	  		if($ans == $rightans) {
	  			return $total;
	  		}else {
	  			return 0;
	  		}

	  }
	  
	/**
	 * create a grade function, this creates a grade from the grade details
	 * @param $details can be $id or CourseGradeDetail array
	 */

		protected function createAnswersFromDetails($answers) {
			$arr = array();
			foreach($answers as $input_id => $answer) {
				$arr[] = array(
					'course_grade_detail_id' => $this->gradeDetails['GradeDetail']['id'],
					'input_id' => $input_id,
					'course_id' => $this->gradeDetails['GradeDetail']['course_id'],
					'student_id' => $this->studentId,
					'answer' => $answer,
				);
			}
			
			return $arr;
			 
		}
		
		public function updateGradeFromAnswers($course_grade_id, $studentid, $courseid = false) {
			$gradedAnswers = $this->GradeAnswers->find('all', array('conditions' => array('course_grade_id' => $course_grade_id)));
			$total = 0;
			$grade = 0;
			foreach($gradedAnswers as $answer) {
				if(!$answer['GradeAnswers']['dropped']) {
					$total += $answer['GradeAnswers']['total_worth'];
					$grade += $answer['GradeAnswers']['grade'];
				}
			}
			$coursegrade = $this->save(array(
				'id' => $course_grade_id,
				'points_earned' => $grade,
				'total' => $total,
			));
			
			if($courseid) {
				$this->studentId = $studentid;
				debug($this->updateCourseGrade($courseid));exit;
			}
			return $coursegrade;
		}
		
	 
	 	protected function formatSubGrades($subs) {
	 		$result = array();
	 		$total_points = 0;
	 		$points = 0;
	 		foreach ($subs as $sub) {
	 			$type = $sub[$this->alias]['type'];
	 			if(key_exists($type, $result)) {
	 				$result[$type]['grades'][] = $sub[$this->alias];
	 			}
	 			else {
	 				$result[$type]['grades'] = array($sub[$this->alias]);
	 			}
	 		}
	 		return $result;
	 	}
	
}
