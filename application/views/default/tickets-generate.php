<?php 
$page_title = "Generate Tickets";

require "headtags.php";

$hallId = null;

$hallFound = true;

$listTickets = $accessObject->hasAccess("list", "tickets");
?>
<main>
    <div class="page-header pb-10 page-header-dark bg-gradient-primary-to-secondary">
        <div class="container-fluid">
            <div class="page-header-content">
                <h1 class="page-header-title">
                    <div class="page-header-icon"><i data-feather="book-open"></i></div>
                    <span><?= $page_title ?></span>
                </h1>
                <ol class="breadcrumb mt-4 mb-0">
                    <li class="breadcrumb-item"><a href="<?= $baseUrl ?>dashboard">Dashboard</a></li>
                    <?php if($listTickets) { ?>
                    <li class="breadcrumb-item"><a href="<?= $baseUrl ?>tickets">Tickets</a></li>
                    <?php } ?>
                    <li class="breadcrumb-item active"><?= $page_title ?></li>
                </ol>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-n10">
        <div class="card">
            <div class="card-header">
                <div class="row" style="width:100%">
                    <div class="col-lg-8 col-md-8"></div>
                    <?php if($listTickets) { ?>
                    <div class="col-lg-4 col-md-4 text-right pr-0 mr-0">
                        <a href="<?= $baseUrl ?>tickets" class="btn btn-sm btn-outline-primary"><i class="fa fa-list"></i>&nbsp;List Tickets</a>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <div class="card-body">
            <?php if(!$accessObject->hasAccess("generate", "tickets")) { ?>
                <?= pageNotFound($baseUrl) ?>
            <?php } else { ?>
                <form autocomplete="Off" action="<?= $baseUrl ?>api/tickets/generate" method="POST" class="appForm">
                    <div class="row">
                        <?= form_loader() ?>
                        <div class="col-lg-8 col-md-8">
                            <div class="row">
                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <label for="ticket_title">Ticket Title <span class="required">*</span></label>
                                        <input type="text" name="ticket_title" id="ticket_title" placeholder="Enter the title for this ticket (eg. Dinner on 25th September Tickets)" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="form-group">
                                        <label for="quantity">Quantity to Generate</label>
                                        <input placeholder="Default is 100" type="number" name="quantity" id="quantity" min="1" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="form-group">
                                        <label for="initials">Initials to Start With</label>
                                        <input type="text" style="text-transform:uppercase" maxlength="3" placeholder="Initials (eg DZ001)" name="initials" id="initials" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="form-group">
                                        <label for="length">Length of Characters <span class="required">*</span></label>
                                        <input type="number" min="6" value="6" max="32" placeholder="Length of each ticket serial" name="length" id="length" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="form-group">
                                        <label for="ticket_is_payable">Payable or Not Payable</label>
                                        <select name="ticket_is_payable" id="ticket_is_payable" class="form-control selectpicker">
                                            <option value="0">Not Payable (Free)</option>
                                            <option value="1">Paid Ticket</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 cards hidden col-md-6">
                                    <div class="form-group">
                                        <label for="length">Ticket Amount</label>
                                        <input type="number" min="6" max="10000" placeholder="Amount for Ticket" name="ticket_amount" id="ticket_amount" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12"><hr></div>
                                <div class="col-lg-12 text-right">
                                    <button type="submit" class="btn btn-outline-success btn-sm">Generate Tickets</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <div class="text-center">
                                <h4 class="text-center">Note</h4>
                            </div>
                            <div class="row sample-data text-center">
                                <em>Please remember to activate this ticket on the <a href="<?= $baseUrl ?>tickets">Tickets Page</a> after generating.</em>
                            </div>
                        </div>
                    </div>
                </form>
            <?php } ?>
            </div>
        </div>
    </div>

</main>
<?php require "foottags.php"; ?>