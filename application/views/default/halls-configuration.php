<?php 
$page_title = "Configure Hall Seats";

require "headtags.php";

$hallId = null;

$hallFound = true;

// if the hall was found
if($hallFound) {
    // assign variables
    $hall_rows = 8;
    $hall_columns = 13;

    // counter for numbering
    $counter = 1;

    // removed seats
    $removed = ["2_1", "3_3", "5_4", "2_7", "5_8"];

    // blocked seats

}
?>
<main>
    <div class="page-header pb-10 page-header-dark bg-gradient-primary-to-secondary">
        <div class="container-fluid">
            <div class="page-header-content">
                <h1 class="page-header-title">
                    <div class="page-header-icon"><i data-feather="sunset"></i></div>
                    <span><?= $page_title ?></span>
                </h1>
                <ol class="breadcrumb mt-4 mb-0">
                    <li class="breadcrumb-item"><a href="<?= $baseUrl ?>dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= $baseUrl ?>halls">Halls</a></li>
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
                    <div class="col-lg-4 col-md-4 text-right pr-0 mr-0">
                        <a href="<?= $baseUrl ?>halls-edit/<?= $hallId ?>" class="btn btn-sm btn-outline-success"><i class="fa fa-edit"></i>&nbsp;Update Hall</a>
                        <a href="<?= $baseUrl ?>halls" class="btn btn-sm btn-outline-primary"><i class="fa fa-list"></i>&nbsp;List Halls</a>
                    </div>
                </div>
            </div>
            <div class="card-body">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="justify-content-around">
                            <div class="col-lg-8 p-0 m-0 col-md-8">
                                <div class="form-group">
                                    <label for="hall_name">Hall Name <span class="required">*</span></label>
                                    <input type="text" name="hall_name" disabled id="hall_name" class="form-control">
                                </div>
                            </div>
                            <div>
                                <div class="seats-table slim-scroll">
                                    <table class="p-0 m-0">
                                    <?php
                                    // draw the items
                                    for($i = 1; $i < $hall_rows + 1; $i++) {
                                        print "<tr>\n";
                                        for($ii = 1; $ii < $hall_columns + 1; $ii++) {
                                            // label
                                            $label = "{$i}_{$ii}";
                                            // print header
                                            print "<td data-label=\"{$label}\" class=\"width\">";
                                            // confirm that it has not been removed
                                            if(!in_array($label, $removed)) {
                                                print "<div data-label=\"{$label}\" id=\"seat-item_{$label}\" class=\"p-2 mt-1 seat-item border\">
                                                    {$counter}
                                                    <input class=\"form-control p-0\" data-label=\"{$label}\">
                                                </div>";
                                            }
                                            print "</td>\n";
                                            // increment the counter
                                            $counter++;
                                        }
                                        print "</tr>";
                                    }
                                    ?>
                                    </table>
                                </div>
                                <div class="text-center">
                                    <input type="hidden" name="hall_id" valu="<?= $hallId ?>">
                                    <div class="row mt-3 p-0 text-center justify-content-around">
                                        <div class="mt-2">
                                            <button type="remove" class="btn btn-sm btn-outline-warning">Remove</button>
                                            <button type="submit" class="btn btn-sm btn-outline-success">Save</button>
                                            <button type="block" class="btn btn-sm btn-outline-danger">Block</button>
                                        </div>
                                        <div style="width:300px;" class="mt-2">
                                            <button type="unblock" class="btn hidden btn-sm btn-outline-secondary">Unblock</button>
                                            <button type="restore" class="btn hidden btn-sm btn-outline-primary">Restore</button>
                                        </div>
                                    </div>
                                </div>  
                            </div>
                            
                        </div>
                        
                    </div>
                </div>

            </div>
        </div>
    </div>

</main>
<?php require "foottags.php"; ?>