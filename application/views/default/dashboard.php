<?php 
$page_title = "Dashboard";

require "headtags.php";
?>
<main>
    <div class="container-fluid mt-5">
        <div class="d-flex justify-content-between align-items-sm-center flex-column flex-sm-row mb-4">
            <div class="mr-4 mb-3 mb-sm-0">
                <h1 class="mb-0">Dashboard</h1>
                <div class="small"><span class="font-weight-500 text-primary"><?= date("l"); ?></span> &#xB7; <?= date("F d, Y") ?> &#xB7; <?= date("h:i A") ?></div>
            </div>
        </div>
        <div class="alert alert-primary border-0 mb-4 mt-5 px-md-5" data-notice="dashboard">
            <div class="position-relative">
                <div class="row align-items-center justify-content-between">
                    <div class="col position-relative">
                        <h2 class="text-primary">Welcome back, your dashboard is ready!</h2>
                        <p class="text-gray-700">Great job, your dashboard is ready to go! You can view events, make bookings, prepare tickets, and download reports using this dashboard.</p>
                        <a class="btn btn-teal" href="<?= $baseUrl ?>events">Get started<i class="ml-1" data-feather="arrow-right"></i></a>
                    </div>
                    <div class="col d-none d-md-block text-right pt-3"><img class="img-fluid mt-n5" src="<?= $baseUrl ?>assets/img/drawkit/color/drawkit-content-man-alt.svg" style="max-width: 25rem;" /></div>
                </div>
            </div>
            <span class="close-notice" data-notice="dashboard"><span title="Close Notification" data-toggle="tooltip" class="fa fa-times"></span></span>
        </div>
        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-top-0 border-bottom-0 border-right-0 border-left-lg border-blue h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <div class="small font-weight-bold text-blue mb-1">Events (monthly)</div>
                                <div class="h5">N/A</div>
                                <div class="text-xs font-weight-bold text-success d-inline-flex align-items-center"><i class="mr-1" data-feather="trending-up"></i>N/A</div>
                            </div>
                            <div class="ml-2"><i class="fas fa-list fa-2x text-gray-200"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-top-0 border-bottom-0 border-right-0 border-left-lg border-purple h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <div class="small font-weight-bold text-purple mb-1">Bookings</div>
                                <div class="h5">N/A</div>
                                <div class="text-xs font-weight-bold text-danger d-inline-flex align-items-center"><i class="mr-1" data-feather="trending-down"></i>N/A</div>
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
                                <div class="small font-weight-bold text-green mb-1">Clicks</div>
                                <div class="h5">N/A</div>
                                <div class="text-xs font-weight-bold text-success d-inline-flex align-items-center"><i class="mr-1" data-feather="trending-up"></i>N/A</div>
                            </div>
                            <div class="ml-2"><i class="fas fa-mouse-pointer fa-2x text-gray-200"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-top-0 border-bottom-0 border-right-0 border-left-lg border-yellow h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <div class="small font-weight-bold text-yellow mb-1">Conversion rate</div>
                                <div class="h5">N/A</div>
                                <div class="text-xs font-weight-bold text-danger d-inline-flex align-items-center"><i class="mr-1" data-feather="trending-down"></i>N/A</div>
                            </div>
                            <div class="ml-2"><i class="fas fa-percentage fa-2x text-gray-200"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
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
            <div class="col-lg-9">
                <div class="card mb-4">
                    <div class="card-header">Events vs Bookings <i title="Event as against the number of Bookings" data-toggle="tooltip" class="fa ml-3 fa-info"></i></div>
                    <div class="card-body">
                        <div class="chart-area"><canvas id="myAreaChart" width="100%" height="30"></canvas></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 mb-4">
                
                <div class="card">
                    <div class="card-header">Recent Events</div>
                    <div class="card-body">
                        <div class="datatable table-responsive">
                            <table class="table table-hover" data-toggle="datatable">
                                <thead>
                                    <th width="6%">&#8470;</th>
                                    <th>Event Title</th>
                                    <th>Event Date</th>
                                    <th>Event Details</th>
                                    <th>&#8470; Booked</th>
                                    <th>Status</th>
                                    <th></th>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</main>
<?php require "foottags.php"; ?>