<?php

app::uses('Courses.CourseGrade', 'Courses.Model');
app::uses('Courses.CourseGradeDetail', 'Courses.Model');
app::uses('Courses.CourseGradeAnswer', 'Courses.Model');

class GradeableBehavior extends ModelBehavior {
		
	/**
	 * Settings array
	 * 
	 * field_map array of (field_name) => grade_field_names
	 * This is for saving graded answers
	 * available fields from grade table
	 * 'model' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
	 * 'foreign_key' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
	 * 'answer' => array('type' => 'text', 'null' => false, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
	 * 'grade' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 3),
	 * 'right_answer' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
	 * 'notes' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
	 * 'time' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
	 * 'dropped' => array('type' => 'boolean', 'null' => false, 'default' => false),
	 * 'data' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
	 */
	public $defaults = array(
		'answer_field_map' => array(),
		'save_self' => true
	);
	
	public $settings = array();
	
	public function setup(Model $Model, $settings = array()) {
	    	
	    if (!isset($this->settings[$Model->alias])) {
	        
	    }
		
	    $this->settings[$Model->alias] = array_merge($this->defaults, $settings);
		
		//This attaches the Grade Details Model to the $model so whens its created it saves the grade
		//Details
		
		$Model->bindModel(
	        array('hasMany' => array(
	                'CourseGradeDetails' => array(
						'className' => 'Courses.CourseGradeDetail',
						'foreignKey' => 'foreign_key',
						'conditions' => array('CourseGradeDetail.model' => $Model->alias),
	                	)
	             	)
	     		)
			);
	}
	
	/**
	 * Before Save
	 * 
	 * Grabs data from model. This allows any associated models to be save on save command etc saveAll()
	 * We wait till aftersave before actual grade gets saved. if save_self == true then it will also save
	 * the $Model with its default save method
	 */
	
	public function beforeSave(Model $Model) {
		parent::beforeSave($options);
		if(isset($Model->data[$Model->alias]) && isset($Model->data['CourseGradeDetail'])) {
			$this->detailId = $Model->data['CourseGradeDetail']['foreign_key'];
			$this->detailModel = isset($Model->data['CourseGradeDetail']['model']) ? $Model->data['CourseGradeDetail']['model'] : $Model->alias;
			unset($Model->data['CourseGradeDetail']);
			$this->data[$Model->alias] = is_array($Model->data[$Model->alias]) ? $Model->data[$Model->alias] : array($Model->data[$Model->alias]);
			if(!$this->settings[$Model->alias]['save_self']) {
				unset($Model->data[$Model->alias]);
			}
		}
		
		return true;
	
	}
	
	public function afterSave(Model $Model, $created) {
		
		//If Model isn't saved or is not new, create the grades
		if(isset($this->data) && !empty($this->data)) {
		
			//Get the grading details
			$GradeDetail = new CourseGradeDetail;
			
			$gradedetails = $GradeDetail->find('first', array(
				'foreign_key' => $this->detailId,
				'model' => $this->detailModel,
			));
			
			if(empty($gradedetails)) {
				
				
			}else {
				$CourseGrade = new CourseGrade;
				$data['CouseGrade'] = $CourseGrade->createGradeFromDetails($gradedetails);
				
				$answers = $this->_createGradeAnswers($gradedetails);
				if(!empty($answers)) {
					$data['CourseGradeAnswer'] = $answers;
				}
			}
			
		}
		
		return true;
		
	}
	
	private function _createGradeAnswers($gradedetails) {
		//If array_field_map is empty we aren't saveing anything to the answers table	
		if(empty($this->settings[$Model->alias]['answer_field_map']) || !isset($this->settings[$Model->alias]['answer_field_map']['answer'])) {
			return false;
		}else {
			$fields = $this->settings[$Model->alias]['answer_field_map'];
		}
		
		$rightAnswers = unserialize($gradedetails['CourseGradeDetail']['right_answers']);
		
		$data = array();
		foreach($this->data[$Model->alias] as $k => $gradeanswer) {
				$data[$k]['course_grade_detail_id'] = $gradedetails['CourseGradeDetail']['id'];
				$data[$k]['model'] = isset($fields['model']) ? $fields['model'] : $gradedetails['CourseGradeDetail']['model'];
				$data[$k]['foreign_key'] = isset($fields['foreign_key']) ? $fields['foreign_key'] : $gradedetails['CourseGradeDetail']['foreign_key'];
				$data[$k]['answer'] = $gradeanswer[$Model->alias][$fields['foreign_key']['answer']];
		}
		
		return $data;

	}

	
}