<?php
/**
 * CourseUserFixture
 *
 */
class CourseGradeDetailFixture extends CakeTestFixture {

	
/**
 * Import
 *
 * @var array
 */
	public $import = array('config' => 'Courses.CourseGradeDetail');

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '1',
			'course_id' => '1',
			'model' => 'Course',
			'foreign_key' => '1',
			'name' => '',
			'description' => 'Testing Grading Details for Models',
			'total_worth' => 100,
			'right_answers' => null,
			'grading_method' => '',
			'notes' => '',
			'data' => array(
				'grading_options' => array(
					'letter_grade' => array(
						'A' => array(
							'from' => '90',
							'to' => '100'
						),
						'B' => array(
							'from' => '80',
							'to' => '89'
						),
						'C' => array(
							'from' => '70',
							'to' => '79'
						),
						'D' => array(
							'from' => '60',
							'to' => '69'
						),
						'F' => array(
							'from' => '0',
							'to' => '59'
						)
					),
					'pass_fail' => array(
						'pass' => array(
							'from' => '60',
							'to' => '100'
						),
						'fail' => array(
							'from' => '0',
							'to' => '59'
						)
					)
			),
			'assignmentcategory' => array(
				array(
					'type' => 'Tutorial',
					'weight' => .2,
					'droplowest' => true,
					'allowcurve' => true
				),
				array(
					'type' => 'Homework',
					'weight' => .5,
					'droplowest' => true,
					'allowcurve' => false
				)
			),
			'gradebooksettings' => array(
				'round_grades' => false,
				'decimal_places' => 0,
			),
			'curve_type' => 'square_root'
		),
			'alloted_time' => null,
			'creator_id' => 1,
			'created' => '2013-08-29 09:24:48',
		),
	);
	
	/**
	 * Added ability to serialize data
	 * @see CakeTestFixture::insert()
	 */
	public function insert($db) {
		foreach($this->records as $k => $v) {
			if(is_array($v['data'])) {
				$v['data'] = serialize($v['data']);
				$this->records[$k] = $v;
			}
		}
		
		parent::insert($db);
		
	}
}
