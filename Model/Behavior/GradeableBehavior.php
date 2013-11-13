<?php

app::uses('CourseGrade', 'Courses.Model');
app::uses('CourseGradeDetail', 'Courses.Model');
app::uses('CourseGradeAnswer', 'Courses.Model');

class GradeableBehavior extends ModelBehavior {
		
	public $defaults = array(
		'answer_field_map' => array(),
		'save_self' => true
	);
	
	public $settings = array(
		'typeField' => 'type',
		
	);
	
	public function setup(Model $Model, $settings = array()) {
	    	
	    $this->settings[$Model->alias] = array_merge($this->defaults, $settings);
	    
	    //Bind the grade detail Model
	    $Model->bindModel(array(
	    	'hasOne' => array(
	    		'CourseGradeDetail' => array(
		    		'className' => 'Courses.CourseGradeDetail',
		    		'foreignKey' => 'foreign_key',
		    		'conditions' => array('CourseGradeDetail.model' => $Model->alias)
	    	))
	    ), false);
		
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
		
		//Check to see if grading detail exists
		if(!isset($Model->data['CourseGradeDetail']['id']) && isset($Model->data[$Model->alias]['id'])) {
			$this->gradedetail = $Model->CourseGradeDetail->find('first', array(
				'conditions' => array(
					'CourseGradeDetail.foreign_key' => $Model->data[$Model->alias]['id']),
					'CourseGradeDetail.model' => $Model->alias
			));
			if(!$this->gradedetail) {
				$this->gradedetail = $Model->CourseGradeDetail->create();
				$this->gradedetail['CourseGradeDetail'] = array(
					'type' => isset($Model->data[$Model->alias][$this->settings[$Model->alias]['typeField']]) ? $Model->data[$Model->alias][$this->settings[$Model->alias]['typeField']] : null,
					'model' => $Model->alias,
					'name' => isset($Model->data[$Model->alias][$Model->displayField]) ? $Model->data[$Model->alias][$Model->displayField] : '',
				);
			}
			if(isset($Model->data['CourseGradeDetail'])) {
				$this->gradedetail['CourseGradeDetail'] = array_merge($this->gradedetail['CourseGradeDetail'], $Model->data['CourseGradeDetail']);
				unset($Model->data['CourseGradeDetail']);
			}
		}
		
		return true;
	
	}
	
	public function afterSave(Model $Model, $created) {
		
		$this->gradedetail['CourseGradeDetail']['foreign_key'] = $Model->data[$Model->alias]['id'];

		if (empty($this->gradedetail['CourseGradeDetail']['name'])) {
			$this->data['CourseGradeDetail']['name'] = $Model->data[$Model->alias][$Model->displayField];
		}
		
		$result = $Model->CourseGradeDetail->save($this->gradedetail);
		
		return $result !== false ? true : false;
		
	}
	
	public function beforeFind(Model $Model, $query) {
		parent::beforeFind($Model, $query);
		$Model->contain[] = 'CourseGradeDetail';
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