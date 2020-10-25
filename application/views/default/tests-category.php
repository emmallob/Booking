<?php 
$page_title = "Tests List";

$loadedCSS = [
    "assets/css/quiz.css",
];

$loadedJS = [
    "assets/js/quiz.js",
];

// confirm that the category has been called
if(confirm_url_id(2)) {
    // if the user first item is view
    if(confirm_url_id(1, 'view')) {
        // assign variables
        $category_id = xss_clean($SITEURL[2]);

        // The test must be active
        $test_status = 1;

        // the test should be a main test and not a diagnostic test
        $test_type = 'main-test';

        // The test should also be published and not a draft question
        $current_state = 'published';

        // run the sql query for the information about this category
        $category_q_sets = $booking->prepare("
            SELECT
                count(*) AS questions_count
            FROM quiz_objective_tests ob
            WHERE ob.test_category_id=?  AND ob.status = '$test_status' AND 
                ob.test_type='$test_type' AND ob.current_state = '$current_state'
        ");

        // execute the statement that has been set
        $category_q_sets->execute([$category_id]);

        // count the number
        $result = $category_q_sets->fetch(PDO::FETCH_OBJ);
    }
} else {
    header("location: ".$config->base_url('tests-list'));
    exit(-1);
}

// confirm that the user has not already visited the results page
if($session->answersSubmitted or $session->presetAnswers) {
  // call the unset sessions method which will destroy
  // all the sessions that was used during the testing and 
  // learning phase of the software
  $eddylearnClass->restartLesson();
}

// headtags inclusion
require "headtags.php";
?>
<main>
    <div class="page-header pb-10 page-header-dark bg-gradient-primary-to-secondary">
        <div class="container-fluid">
            <div class="page-header-content">
                <h1 class="page-header-title">
                    <div class="d-none d-md-block page-header-icon"><i data-feather="home"></i></div>
                    <span><?= $page_title ?></span>
                </h1>
                <ol class="breadcrumb mt-4 mb-0">
                    <li class="breadcrumb-item"><a href="<?= $baseUrl ?>dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= $baseUrl ?>tests-list">Category</a></li>
                    <li class="breadcrumb-item active"><?= $page_title ?></li>
                </ol>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-n10">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    
                    <div class="col-lg-12">


                        <ul class="nav nav-tabs nav-tabs-block" data-toggle="tabs" role="tablist">
                            <ul class="nav nav-tabs" id="badgeSizingTabs" role="tablist">
                            <?php
                            // Fetch the test categories that the user has subscribed to
                            // list them where the status is 1 and order by the name of the test
                            $parent_query = $booking->prepare("SELECT * FROM quiz_test_categories WHERE parent_category='{$category_id}' AND (parent_category IN ('".implode("', '", $studentSubscription)."')) AND status='1' ORDER BY name DESC");
                            $parent_query->execute();
                            $i = 0;
                            
                            /** Assign to a variable */
                            $parentList = $parent_query->fetchAll(PDO::FETCH_OBJ);

                            // using the while loop go through the list of items that has been fetched
                            foreach($parentList as $i => $parent_category) {
                                $i++;
                                // print the results by setting the first item as true where it is the first one
                                ?>
                                <li class="nav-item">
                                    <a class="nav-link <?= ($i == 1) ? "active": null; ?>" id="cat_tabs-<?= $parent_category->category_id ?>Tab" data-toggle="tab" href="#cat_tabs-<?= $parent_category->category_id ?>" role="tab" aria-controls="cat_tabs-<?= $parent_category->category_id ?>" aria-selected="true"><?= $parent_category->name ?></a>
                                </li>
                            <?php } ?>
                            </ul>
                            <?php
                            // run another query through the list of the categories that the has subscribed to
                            if(count($parentList)) { ?>  

                            <div class="block-content tab-content overflow-hidden" style="min-height: 500px;">

                                <?php
                                foreach($parentList as $ii => $parent_category) {
                                    $ii++;
                                    ?>
                                    <div class="tab-pane fade fade-left <?= ($ii==1) ? "show active" : null; ?>" id="cat_tabs-<?= $parent_category->category_id ?>" role="tabpanel" aria-labelledby="cat_tabs-<?= $parent_category->category_id ?>Tab">
                                    <?php
                                    // prepare to get the numbe of question sets under each parent category for listing
                                    $category_q_sets = $booking->prepare("
                                        SELECT *, qq.test_duration as ins_test_duration,
                                            (
                                                SELECT count(*) FROM quiz_objective_tests ob
                                                WHERE ob.question_instruction_id = qq.instruction_id
                                            ) AS questions_count
                                        FROM quiz_question_instructions qq
                                        WHERE qq.test_category_id=? AND qq.test_sub_category_id=?
                                    ");
                                    $category_q_sets->execute([$category_id, $parent_category->category_id]);

                                    // count the number
                                    $category_q_sets_count = $category_q_sets->rowCount();

                                    // run the script
                                    if($category_q_sets_count > 0) { ?>
                                        <div class="row">
                                        <?php
                                        // using the while loop to get the list of all test categories
                                        // count($eddylearnClass->stringToArray($category->questions_sets));
                                        while($category = $category_q_sets->fetch(PDO::FETCH_OBJ)) {
                                        ?>
                                        <div class="col-md-4 col-lg-3 mt-3 pt-2" style="border: 1px dashed rgba(0, 0, 0, 0.1);">
                                            <div class="block bg-white-light block-link-shadow block-rounded ribbon ribbon-bookmark ribbon-left ribbon-success text-center" style="padding:5px">
                                                <div style="min-height: 85px" class="block-content block-content-full" align="center">
                                                    <?php if(is_file($baseUrl.$category->instruction_image) && file_exists($baseUrl.$category->instruction_image)) { ?>
                                                        <img src="<?= $baseUrl.$category->instruction_image; ?>" alt="" height="135px">
                                                    <?php } else { ?>
                                                        <img width="100%" src="<?= $baseUrl."assets/img/placeholder.jpg"; ?>" alt="">
                                                    <?php } ?>
                                                </div>
                                                <div class="block-content block-content-full block-content-sm bg-body-light">
                                                    <div class="font-size-sm text-muted">
                                                    &bull; <?= $category->questions_count; ?> Questions
                                                    <?php
                                                    // quiz test query
                                                    $testQuery = $quizClass->userQuestionSetConfirm($userId, $category->test_category_id, $category->instruction_id);

                                                    // check if the user has already not started taking this particular test
                                                    if(!$testQuery->confirmInDB) {
                                                        // if so get the test duration assinged to this test
                                                        print " &bull; ". secondsToTime(($category->ins_test_duration*60), true);
                                                    } else {
                                                        // this portion runs if the user has already started the test
                                                        // if the user has started then print the duration of time that is left for the user to use
                                                        $timer_to_display = secondsToTime($testQuery->timeLeftOut, true);
                                                        print " &bull; ". $timer_to_display;
                                                    }
                                                    ?> &bull;
                                                    </div>
                                                </div>
                                                <div class="block-content block-content-full">
                                                    <div class="font-w600"><?= $category->test_type; ?></div><hr>
                                                    <div class="font-w600"><?= $category->test_title; ?></div>
                                                </div>

                                            <?php
                                            // check if the test has already been taken and then continue from there
                                            // The first part of the if statement runs when the user has not started the test
                                            if(!$testQuery->confirmInDB) { ?>

                                                <?php if($category->questions_count > 0) { ?>

                                                    <a data-function="undefined-mode" title="Click to try this test <?= $category->test_title; ?>" data-toggle="tooltip" class="mb-3 btn-sm btn btn-outline-primary btn-block text-center prepare-test" href="javascript:void(0)" value="<?= $category->test_category_id.":".$category->instruction_id; ?>" data-instruction="<?= $category->instruction_id; ?>"> START</a>

                                                <?php } else { ?>

                                                    <span class="mb-3 btn btn-outline-danger btn-block">NO QUESTIONS TO WORK ON</span>

                                                <?php } ?>

                                            <?php } else {

                                                // get the stored question set id
                                                // fetch the exams mode of that particular test
                                                $returnQuestionSetId = $testQuery->returnQuestionSetId;
                                                $examsMode = $testQuery->examsMode;

                                                // this portion of the if statement that was started above runs if there is a record
                                                // in the user tests history table that indicates that the user has began the test.
                                                // now check if the user has not completed the test yet
                                                if($testQuery->returnCurState != "complete") {

                                                // print the button to continue the test.
                                                ?>
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                    <a data-function="<?= $examsMode; ?>" title="Click to continue from where you left off." data-toggle="tooltip" class="btn btn-block btn-outline-primary text-center prepare-test" href="javascript:void(0)" value="<?= $category->test_category_id.":".$category->instruction_id.":".$returnQuestionSetId; ?>" data-instruction="<?= $category->instruction_id; ?>">
                                                        CONTINUE <?= ($examsMode == "test-mode") ? "EXAM" : "LEARNING"; ?>
                                                    </a>
                                                    </div>
                                                    <div class="col-lg-6">
                                                    <a data-value="<?= $returnQuestionSetId; ?>" class="btn-block btn  btn-outline-danger stop-exams" href="javascript:void(0)">
                                                        <i class="fa fa-stop"></i> <strong>STOP</strong>
                                                    </a>
                                                    </div>
                                                </div>
                                                <?php } else { ?>

                                                <?php if($examsMode == "test-mode") { ?>
                                                    <span class="mb-3" <?= ($examsMode == "test-mode") ? "style='color:#ffca28;font-weight:bolder;font-size:16px;padding:5px;margin:5px;'" : "style='color:#ffca28;font-weight:bolder;font-size:16px;padding:5px;margin:5px;'"; ?>><?= ($examsMode == "test-mode") ? "EXAM" : "LEARNING"; ?> COMPLETED</span>
                                                    <a data-function="undefined-mode" title="Click to continue from where you left off." data-toggle="tooltip" class="mb-3 btn-block btn-sm btn btn-outline-primary text-center prepare-test" href="javascript:void(0)" value="<?= $category->test_category_id.":".$category->instruction_id.":".$returnQuestionSetId.":retake-test"; ?>" data-instruction="<?= $category->instruction_id; ?>">
                                                    RETAKE <?= ($examsMode == "test-mode") ? "EXAM" : "LEARNING"; ?></a>
                                                <?php } else { ?>
                                                    <a data-function="undefined-mode" title="Click to try this test <?= $category->test_title; ?>" data-toggle="tooltip" class="mb-3 btn-sm btn btn-outline-primary btn-block text-center prepare-test" href="javascript:void(0)" value="<?= $category->test_category_id.":".$category->instruction_id; ?>" data-instruction="<?= $category->instruction_id; ?>">START</a>
                                                <?php } ?>

                                                <?php } ?>

                                            <?php } ?>                      
                                            </div>
                                        </div>
                                        <?php } ?>

                                        </div>

                                    <?php } ?>

                                    </div>

                                <?php } ?>

                                <!-- Pop In Modal -->
                                <div class="modal fade" id="modal-popin" tabindex="-1" role="dialog" aria-labelledby="modal-popin" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-popin" role="document">
                                    <div class="modal-content" style="background: #fff; text-align: center;">

                                        <div class="block block-themed block-transparent mb-0">
                                        <div class="block-header bg-primary-dark">
                                            <h2 class="block-title"><strong>OPTION SELECTION</strong></h2>
                                            <div class="block-options">
                                            <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                                <i class="si si-close"></i>
                                            </button>
                                            </div>
                                        </div>

                                        </div>
                                        <div class="block-content test-content" style="font-size:25px; font-weight: bolder;">
                                        <h1>Feeling Ready for some Challenge?</h1>
                                        <p>Go to</p>
                                        <button type="button" class="option-selecter font30 test-button mb-30" data-dismiss="modal">
                                            <span onclick='selected_mode("test-mode");'><i class='fa fa-pencil'></i> EXAM MODE</span>
                                        </button>
                                        </div>

                                        <div class="mt-10 mb-10 learning-content" style="padding: 5px;" align="center">
                                        <h1>Not Confident Enough?</h1>
                                        <p style="font-size:25px; font-weight: bolder;">Go to</p>
                                        <button type="button" class="option-selecter font30 study-button mb-30" data-dismiss="modal">
                                            <span onclick='selected_mode("study-mode");'><i class='fa fa-book'></i> LEARNING MODE</span>
                                        </button>
                                        </div>

                                        <input type="hidden" readonly="" class="form-control" name="test_set_full_id" id="test_set_full_id">
                                        <input type="hidden" readonly="" name="test_defined_mode" id="test_defined_mode">

                                    </div>
                                    </div>
                                </div>
                                <!-- END Pop In Modal -->

                            <?php } else { ?>
                                <div class="text-center" style="padding: 1rem;">
                                    <div class="alert alert-primary">
                                    Sorry! You have currently not Subscribed to this test. Please click on the button below to continue.
                                    </div>
                                    <a class="btn btn-outline-success" href="<?= $config->base_url('subscribe/add/'.$category_id); ?>">
                                    <i class="fa fa-book mr-5"></i> SUBSCRIBE TO THIS TEST
                                    </a>
                                </div>
                            <?php } ?>

                            </div>
                            
                    </div>


                </div>

            </div>
        </div>
    </div>

</main>
<?php require "foottags.php"; ?>