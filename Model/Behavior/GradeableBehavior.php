<?php

app::uses('CourseGrade', 'Courses.Model');
app::uses('CourseGradeDetail', 'Courses.Model');
app::uses('CourseGradeAnswer', 'Courses.Model');

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
		
	}
	
	public function beforeValidate(Model $Model) {
		
		return true;
	}

	
	/**
	 * Before Save
	 * 
	 * Grabs data from model. This allows any associated models to be save on save command etc saveAll()
	 * We wait till aftersave before actual grade gets saved. 
	 */
	
	public function beforeSave(Model $Model) {
		
		if(isset($Model->data[$Model->alias]) && isset($Model->data['CourseGradeDetail'])) {
			$this->data['CourseGradeDetail'] = $Model->data['CourseGradeDetail'];
			unset($Model->data['CourseGradeDetail']);
		}
		
		return true;
	
	}
	
	public function afterSave(Model $Model, $created) {
		
		$CourseGradeDetail = new CourseGradeDetail();
		
		//Removes the Grade Detail if Grading Options are Removed or not there
		if(empty($this->data['CourseGradeDetail']['grading_method'])) {
			
			//Deletes the Grade Detail
			if(isset($this->data['CourseGradeDetail']['id'])) {
				return $CourseGradeDetail->delete($this->data['CourseGradeDetail']['id']);
			}
			
			return true; //returns true if the grading method is not set
			
		}
		
		$this->data['CourseGradeDetail']['model'] = $Model->alias;
		$this->data['CourseGradeDetail']['foreign_key'] = $Model->data[$Model->alias]['id'];

		if (empty($this->data['CourseGradeDetail']['name'])) {
			$this->data['CourseGradeDetail']['name'] = $Model->data[$Model->alias][$Model->displayField];
		}
		
		$result = $CourseGradeDetail->save($this->data);
		
		return $result !== false ? true : false;
		
	}
	
	public function beforeFind(Model $Model, $query) {
		//This attaches the Grade Details Model to the $model so whens its created it saves the grade
		//Details
		$Model->bindModel(
	        array('hasMany' => array(
	                'CourseGradeDetail' => array(
						'className' => 'Courses.CourseGradeDetail',
						'foreignKey' => 'foreign_key',
						'conditions' => array('model' => $Model->alias),
	                	)
	             	)
	     		),false
			);
		$Model->contain('CourseGradeDetail');
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