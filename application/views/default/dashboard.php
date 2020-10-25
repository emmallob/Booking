<?php 
$page_title = "Dashboard";

require "headtags.php";

$ticketsManage = $accessObject->hasAccess("generate", "tickets");
?>
<main>
    <div class="container-fluid mt-5">
        <div class="d-flex justify-content-between align-items-sm-center flex-column flex-sm-row mb-4">
            <div class="mr-4 mb-3 mb-sm-0">
                <h1 class="mb-0">Dashboard</h1>
                <div class="small"><span class="font-weight-500 text-primary"><?= date("l"); ?></span> &#xB7; <?= date("F d, Y") ?> &#xB7; <?= date("h:i A") ?></div>
            </div>
        </div>

        <?php if($accessObject->hasAccess("quiz", "dashboard")) { ?>
            <div class="row">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-top-0 border-bottom-0 border-right-0 border-left-lg border-blue h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <div class="small font-weight-bold text-blue mb-1">Tests Taken</div>
                                    <div class="h5" data-count="events_count">N/A</div>
                                </div>
                                <div class="ml-2"><i class="fas fa-home fa-2x text-gray-200"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-top-0 border-bottom-0 border-right-0 border-left-lg border-purple h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <div class="small font-weight-bold text-purple mb-1">Exams Prepping</div>
                                    <div class="h5" data-count="halls_count">N/A</div>
                                </div>
                                <div class="ml-2"><i class="fas fa-tag fa-2x text-gray-200"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-top-0 border-bottom-0 border-right-0 border-left-lg border-green h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <div class="small font-weight-bold text-green mb-1">Average Score</div>
                                    <div class="h5" data-count="audience_count">N/A</div>
                                </div>
                                <div class="ml-2"><i class="fas fa-users fa-2x text-gray-200"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-top-0 border-bottom-0 border-right-0 border-left-lg border-yellow h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <div class="small font-weight-bold text-yellow mb-1">Hours Testing</div>
                                    <div class="h5" data-count="overall_funds_realised">N/A</div>
                                </div>
                                <div class="ml-2"><i class="fa fa-list fa-2x text-gray-200"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 p-0 mb-4">
                <div class="card">
                    <div class="card-header">Most Recents Tests Undertaken</div>
                    <div class="card-body">
                        <div class="datatable table-responsive">
                            <table class="table table-hover" data-toggle="datatable">
                                <thead>
                                    <tr>
                                        <th class="text-center">ID</th>
                                        <?php if($quizModerator) { ?>
                                        <th>Student Name</th>
                                        <?php  } ?>
                                        <th width="22%">Test Type</th>
                                        <th>Score</th>
                                        <th>Duration</th>
                                        <th width="20%">Date of Test</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    <?php
                                    // initialize the query string
                                    $i = 0;
                                    // set the query
                                    if($quizModerator) {

                                        $stmt = $booking->prepare("
                                            SELECT *, 
                                                users.name, tc.category_id,
                                                tc.name as category_name, tc.description, q.date_log AS test_date
                                            FROM quiz_users_test_history q
                                                LEFT JOIN users ON users.user_guid=q.user_guid
                                                LEFT JOIN quiz_test_categories tc ON q.category_id=tc.category_id
                                            ORDER BY q.id DESC
                                        ");
                                        $stmt->execute();

                                    } else {
                                        
                                        $stmt = $booking->prepare("
                                            SELECT *, 
                                                users.name, tc.category_id,
                                                tc.name as category_name, tc.description, q.date_log AS test_date
                                            FROM quiz_users_test_history q
                                                LEFT JOIN users ON users.user_guid=q.user_guid
                                                LEFT JOIN quiz_test_categories tc ON q.category_id=tc.category_id
                                            WHERE q.user_guid=? ORDER BY q.id DESC
                                        ");
                                        $stmt->execute([$userId]);
                                    }

                                    while($result = $stmt->fetch(PDO::FETCH_OBJ)) {
                                        $i++;
                                    ?>
                                    <tr>
                                        <td class="text-center"><?= $i; ?></td>
                                        <?php if($quizModerator) { ?>
                                        <th><a data-toggle="tooltip" href="<?= $config->base_url("tests-performance/{$result->user_guid}/{$result->record_id}") ?>" title="View detailed records of this test undertaken by <?= $result->name; ?>"><?= $result->name; ?></a></th>
                                        <?php  } ?>
                                        <td><?= $result->category_name ?></td>
                                        <td>
                                            <?= $quizClass->scoreGrading($result->correct, $result->instruction_id); ?>
                                        </td>
                                        <td class="d-none d-sm-table-cell"><?= (secondsToTime($result->duration)); ?></td>
                                        <td><?= date("l, jS F, Y", strtotime($result->test_date)); ?></td>
                                        <!-- <td class="d-none d-sm-table-cell">
                                            <?= $result->assesment; ?>
                                        </td> -->
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        <?php } ?>
        <?php if($accessObject->hasAccess("app", "dashboard")) { ?>
            <div class="alert alert-primary border-0 mb-4 mt-5 px-md-5" data-notice="dashboard">
                <div class="position-relative">
                    <div class="row align-items-center justify-content-between">
                        <div class="col position-relative">
                            <h2 class="text-primary">Welcome back <em><?= $userData->name ?></em>,</h2>
                            <p class="text-gray-700">Great job, your dashboard is ready to go! You can view events, make bookings, prepare tickets, and download reports using this dashboard.</p>
                            <a class="btn btn-teal" href="<?= $baseUrl ?>events">Get started<i class="ml-1" data-feather="arrow-right"></i></a>
                        </div>
                        <div class="col d-none d-md-block text-right pt-3"><img class="img-fluid mt-n5" src="<?= $baseUrl ?>assets/img/drawkit/color/drawkit-content-man-alt.svg" style="max-width: 25rem;" /></div>
                    </div>
                </div>
            </div>        
            <div class="row">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-top-0 border-bottom-0 border-right-0 border-left-lg border-blue h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <div class="small font-weight-bold text-blue mb-1">Events Held</div>
                                    <div class="h5" data-count="events_count">N/A</div>
                                </div>
                                <div class="ml-2"><i class="fas fa-home fa-2x text-gray-200"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-top-0 border-bottom-0 border-right-0 border-left-lg border-purple h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <div class="small font-weight-bold text-purple mb-1">Halls</div>
                                    <div class="h5" data-count="halls_count">N/A</div>
                                    <!-- <div class="text-xs font-weight-bold text-danger d-inline-flex align-items-center"><i class="mr-1" data-feather="trending-down"></i>N/A</div> -->
                                </div>
                                <div class="ml-2"><i class="fas fa-tag fa-2x text-gray-200"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-top-0 border-bottom-0 border-right-0 border-left-lg border-green h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <div class="small font-weight-bold text-green mb-1">Unique Audience</div>
                                    <div class="h5" data-count="audience_count">N/A</div>
                                    <!-- <div class="text-xs font-weight-bold text-success d-inline-flex align-items-center"><i class="mr-1" data-feather="trending-up"></i>N/A</div> -->
                                </div>
                                <div class="ml-2"><i class="fas fa-users fa-2x text-gray-200"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-top-0 border-bottom-0 border-right-0 border-left-lg border-yellow h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <div class="small font-weight-bold text-yellow mb-1">Funds Raised</div>
                                    <div class="h5" data-count="overall_funds_realised">N/A</div>
                                    <!-- <div class="text-xs font-weight-bold text-danger d-inline-flex align-items-center"><i class="mr-1" data-feather="trending-down"></i>N/A</div> -->
                                </div>
                                <div class="ml-2"><i class="fa fa-list fa-2x text-gray-200"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
        <div class="row">
            <?php if($ticketsManage) { ?>
            <div class="col-lg-4 col-xl-3 mb-4">
                <div class="card bg-secondary o-visible mb-4">
                    <div class="card-body">
                        <h4 class="text-white">Tickets Management</h4>
                        <p class="text-white-50">Ready to get started? Let us know now! It&apos;s time to start taking charge of your Events by generating Tickets and making them available on sale!</p>
                        <img class="float-left" src="assets/img/drawkit/color/drawkit-developer-woman-flush.svg" style="width: 8rem; margin-left: -2.5rem; margin-bottom: -5.5rem;" />
                    </div>
                    <div class="card-footer bg-transparent pt-0 border-0 text-right"><a class="btn btn-primary" href="<?= $baseUrl ?>tickets">Continue</a></div>
                </div>
            </div>
            <?php } ?>
            <div class="col-lg-<?= ($ticketsManage) ? 9 : 12; ?>">
                <div class="card mb-4">
                    <div class="card-header">Events & Bookings <i title="Event as against the number of Bookings" data-toggle="tooltip" class="fa ml-3 fa-info"></i></div>
                    <div class="card-body">
                        <div class="chart-area"><canvas id="myAreaChart" width="100%" height="300px"></canvas></div>
                    </div>
                </div>
            </div>
            <?php if($accessObject->hasAccess("list", "events")) { ?>
                <div class="col-lg-12 mb-4">
                    <div class="card">
                        <div class="card-header">Upcoming Events</div>
                        <div class="card-body">
                            <div class="datatable table-responsive">
                                <table class="table table-hover eventsList" data-toggle="datatable">
                                    <thead>
                                        <th width="6%">&#8470;</th>
                                        <th>Event Title</th>
                                        <th width="10%">Event Date</th>
                                        <th>Summary Details</th>
                                        <th width="10%">&#8470; Booked</th>
                                        <th width="12%">&#8470; of Seats</th>
                                        <th width="10%">Status</th>
                                        <th width="15%"></th>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <?php } ?>
    </div>
</main>
<?php require "foottags.php"; ?>