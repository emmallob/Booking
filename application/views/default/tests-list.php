<?php 
$page_title = "Tests List";

$loadedCSS = [
    "assets/css/quiz.css",
];

// initializing
$category_q_sets_count = 0;
$category_id = 0;

// include the headtags
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
                    <?php
                    // count the number of rows found
                    if(count($quizClass->category_listing()) > 0) {
                        
                        // using the while loop to get the list of all test categories
                        foreach($quizClass->category_listing() as $category) {
                        ?>
                            <div class="col-md-6 mb-2 col-xl-3">
                                <div class="block bg-gray-200 text-center">
                                    <div class="block-content block-content-full" align="center">
                                        <?php if(is_file($baseUrl.$category->image) && file_exists($baseUrl.$category->image)) { ?>
                                            <img width="100%" src="<?= $baseUrl.$category->image; ?>" alt="">
                                        <?php } else { ?>
                                            <img width="100%" src="<?= $baseUrl."assets/img/placeholder.jpg"; ?>" alt="">
                                        <?php } ?>
                                    </div>
                                    <div class="pt-3 pb-3 bg-white">
                                        <div class="font-size-sm text-muted"><?= $category->question_sets_count; ?>  Sets &bull; <?= $category->questions_count; ?> Questions &bull; <?= secondsToTime(($category->test_duration*60), true); ?></div>
                                    </div>
                                    <div class="block-content block-content-full">
                                        <div class="font-w600"><?= $category->description; ?></div>
                                    </div>
                                    <?php
                                    // confirm if the user has already paid for this test or not
                                    // if the user has already subscribed, then provide the link to the tests page
                                    // if not then allow the user to subscribe by making payment for the test
                                    if(in_array($category->category_id,  $studentSubscription)) { ?>
                                        <a title="Click to view the list of <?= $category->question_sets_count; ?> Question Sets under the <?= $category->description; ?>" data-toggle="tooltip" href="<?= $baseUrl.'tests-category/view/'.$category->category_id; ?>" class="btn btn-outline-primary btn-sm mb-3"><i class="fa fa-eye"></i> VIEW TEST</a>
                                    <?php } else { ?>
                                        <a href="javascript:void(0)" data-value="<?= $category->category_id; ?>" class="btn btn-sm btn-outline-success mb-3"><i class="fa fa-book"></i> SUBSCRIBE TO TEST</a>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } else { ?>
                        <div class="col-lg-12 alert alert-danger">Sorry! You have currently not Subscribed to any tests yet.</div>
                    <?php } ?>
                </div>

            </div>
        </div>
    </div>

</main>
<?php require "foottags.php"; ?>