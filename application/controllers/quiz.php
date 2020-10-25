<?php 

class Quiz extends Booking {

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Score Grading
     * 
     * @param String $correct           This is the correct mark
     * @param String $instruction_id    The instruction id to get the score
     * 
     * @return Object
     */
    public function scoreGrading($correct, $instruction_id=null) {
		try {
			// preset the scaling method
			$presetInstructionSec1 = array(
				'QINS9283478179', // 2008 (section 1)
				'QINS1635984359', // 2007 (section 1)
				'QINS9781341435', // 2006 (section 1)
				'QINS3466589121', // 2005 (section 1)
				'QINS3859731269', // 2004 (section 1)
			);

			$presetInstructionSec2 = array(
				'QINS8176567948', // 2008 (section 2)
				'QINS7228691384', // 2007 (section 2)
				'QINS1332469815', // 2006 (section 2)
				'QINS3657871683', // 2005 (section 2)
				'QINS4921546273' // 2004 (section 2)
			);

			// if the instruction id parsed is in the array set 
			// above then it should be equal to that of 2009 section 1
			if(in_array($instruction_id, $presetInstructionSec1)) {
				$instruction_id = 'QINS2818335762';
			}

			// let it be equal to the section 2
			if(in_array($instruction_id, $presetInstructionSec2)) {
				$instruction_id = 'QINS2388219667';
			}

			// confirm that the instruction id has been set
			$test_category_id = !empty($instruction_id) ? "AND test_instruction_id='$instruction_id'" : null;

		    $q = $this->db->prepare("SELECT * FROM quiz_test_scores_scaling WHERE test_mark=? $test_category_id");
		    $q->execute([$correct]);
		    $r = $q->fetch(PDO::FETCH_OBJ);

		    return ($r->score_grade) ?? 0.00;

		} catch(PDOException $e) { return 0.00; }
	}

	/**
	 * Test Category Listing
	 * 
	 * @return Array
	 */
	public function category_listing() {

		try {
			
			$stmt = $this->db->prepare("
				SELECT *, 
					(
						SELECT count(*)
						FROM quiz_objective_tests ob
						WHERE tc.category_id = ob.test_category_id AND  
							ob.status = '1' AND ob.test_type='main-test'
							AND ob.current_state = 'published'
					) AS questions_count, (
						SELECT count(*) 
						FROM quiz_question_instructions qi 
						WHERE tc.category_id= qi.test_category_id
					) AS question_sets_count, (
						SELECT SUM(test_duration) AS test_duration
						FROM quiz_question_instructions qi
						WHERE tc.category_id= qi.test_category_id
					) AS test_duration 
				FROM quiz_test_categories tc
				WHERE tc.parent_category='0' AND tc.status='1'
			");
			// execute the statement that has been set
			$stmt->execute();

			return $stmt->fetchAll(PDO::FETCH_OBJ);

		} catch(PDOException $e) {}
	}

	/**
	 * confirm that there is a record with the user information
	 * 
	 * this is with respect to the question sets
	 * 
	 * @param String $user_guid
	 * @param String $category_id
	 * @param String $instruction_id
	 * 
	 * @return $this
	 */
	public function userQuestionSetConfirm($user_guid, $category_id, $instruction_id) {
		$this->confirmInDB = false;

		$stmt = $this->db->prepare("
			SELECT * FROM quiz_users_questions_sets WHERE 
			user_guid = ? AND category_id = ? AND instruction_id = ? AND status=?
			ORDER BY id DESC LIMIT 1
		");
		$stmt->execute([$user_guid, $category_id, $instruction_id, 1]);

		if($stmt->rowCount() == 1) {
			while($result = $stmt->fetch(PDO::FETCH_OBJ)) {
				$this->confirmInDB = true;
				$this->examsMode = $result->exams_mode;
				$this->timeUsed = $result->time_used;
				$this->timeLeftOut = $result->time_left;
				$this->returnCurState = $result->current_state;
				$this->returnQuestionSetId = $result->question_set_id;
			}
		}

		return $this;
	}


	/**
	 * Delete all sessions
	 * 
	 * Loop through all the session set and delete them from memory
	 */
	public function restartLesson() {
		// call the global $session variable
		global $session;

		// unset the saved time and allow the user to make a new selection
	    // that will be needed in the next phase of the learning / testing process
	    $sessions_array_set = array(
	    	"current_User_Mode", "testRightlyPrepared", "testQuestionsArray", "currentSystemTime",
	    	"finalQuestionReached", "testInstructionId", "studiesStartTime", "test_session",
	    	"questionSetId", "selectedAnswers", "thisNumber", "entryQuestionSetId",
	    	"resultRecordSetId", "testEndTime", "saveTimeLeftString", "previousQuestion",
	    	"currentUsedTime", "actualTestDuration", "testDuration", "lastQuestionId",
	    	"timeRemaining", "currentQuestionId", "presetAnswers", "testCurrentlyOngoing", 
	    	"getTestInstructions", "testQuestionSetId", "answersSubmitted", "currentTimeStamp", 
			"saveEndTime", "testStartTime", "fiveMinutesRemaining", "retakeTest", "testTimeOut", 
			"rightlySourcedDirection", "scrolledDown", "examsPaused"
	    );

	    // loop through the sessions array list and unset each of them
	    $session->remove($sessions_array_set);
	    
	}


}
?>