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
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'SubGrades' => array(
			'className' => 'Courses.CourseGrade',
			'conditions' => array(
				'SubGrades.model NOT' => 'Course',
				'course_id' => 'CourseGrade.foreign_key',
				'student_id' => 'CourseGrade.student_id',
				),
			'fields' => '',
			'order' => ''
		),
	);
	
	public $studentId = ''; //User Id of grades being saved
	
	public $gradeDetails = ''; //Holder for grading information


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
				if($this->saveAll($grades)) {
					if(!$this->_updateCourseGrade($this->gradeDetails['GradeDetail']['course_id'])) {
						throw new Exception('Course grade was not updated, you will need to update manually');
					}
				}
				
				return $this->id;
				
			}
			
		}else{
			throw new Exception('No Grading Details Defines');
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
			$grade['CourseGrade']['grade'] = $answers['score'];
			$grade['CourseGrade']['total'] = $answers['total'];
		}
		
		return $grade;
	 }
	 
	 protected function _updateCourseGrade($courseid) {
	 	$CourseGrade = $this->find('all', array(
	 		'conditions' => array(
				'CourseGrade.model' => 'Course',
				'CourseGrade.foreign_key' => $courseid,
				'CourseGrade.student_id' => $this->studentId,
				),
			'contain' => array()
		));
		
		//If grade doesn't exist yet, lets make one
		if(empty($CourseGrade)) {
			$CourseGrade = $this->create();
		}
		
		$subgrades = $this->find('all', array(
			'joins' => array(
				array('table' => 'categorized',
			        'alias' => 'Categorized',
			        'type' => 'LEFT',
			        'conditions' => array(
			            'Categorized.model = CourseGrade.model',
			            'Categorized.foreign_key = CourseGrade.foreign_key' 
			        )
			    ),
			),
			'conditions' => array(
				'CourseGrade.model NOT' => 'Course',
				'CourseGrade.course_id' => $courseid,
				'CourseGrade.student_id' => $this->studentId,
				),
			'fields' => array('CourseGrade.*','Categorized.id')
			));
		
		if(!$subgrades) {
			throw new Exception('Nothing to Grade', 1);
		}
			
		$details = $this->GradeDetail->find('first', array(
			'conditions' => array(
				'GradeDetail.model' => 'Course',
				'GradeDetail.foreign_key' => $courseid
			)
			));
		
		if(!isset($details['GradeDetail']['grading_method'])) {
			throw new Exception('Grading Details are not defined', 1);
		}
		
		$method = $details['GradeDetail']['grading_method'].'_grading';
		if(!method_exists($this, $method)) {
			throw new Exception('Grading Method not available', 1);
		}
		
		$CourseGrade = array_merge_recursive($this->_prepareGrade(null, $details), $CourseGrade);
		$score = $this->$method($CourseGrade, $subgrades, $details);
		$CourseGrade['CourseGrade']['grade'] = $score['score'];
		$CourseGrade['CourseGrade']['total'] =  $score['total'];
		
		if($this->save($CourseGrade)) {
			return true;
		}else {
			return false;
		}
	 }
	
	/**
	 * Grading methods
	 * @param $answers - The graded answers array
	 * @return int - grade
	 */
	 
	 /**
	  * @todo - setting will be available when editing the course and will need to add categories to the tasks
	  * 		And will have a percentage value for grading assigned to them
	  */
	 
	 protected function weighted_grading($CourseGrade, $subgrades, $details) {	
	 	  $settings = !empty($details['GradeDetail']['data']) ? json_decode($details['GradeDetail']['data']) : array();
		  $totalpoints = 0;
		  $score = 0;
		  
		  foreach($subgrades as $grade) {
		  	$score += $grade['CourseGrade']['grade'];
			$total += $grade['CourseGrade']['total'];
		  }

		  return array('score' => $score/$total * 100, 'total' => $total);
		  
	 }
	 
	 /**
	  * Grade Answers
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
   * @TODO this could be expanded on to allow weighted grading etc.
   * 
   * @return percentage of points
   * 
   */
	  
	  protected function _gradeAnswer($ans, $rightans, $total = null) {
	  		if($ans == $rightans) {
	  			return !empty($total) ? $total : 100;
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
	 
	 
	
}
