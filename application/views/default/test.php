<!DOCTYPE html>
<html>
    <head>
        <title>Booking Div</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="original/theme/sb-admin-pro/css/styles.css" rel="stylesheet" />
        <style>
            .seat-item {
                /* overflow: hidden; */
                /* position: relative; */
                display: -webkit-box;
                display: flex;
                -webkit-box-orient: vertical;
                -webkit-box-direction: normal;
                flex-direction: column;
                min-width: 45px!important;
                word-wrap: break-word;
                background-color: #fff;
                background-clip: border-box;
                border: 1px solid rgba(31, 45, 65, 0.125);
                border-radius: 0.35rem;
                cursor: pointer;
                /* width: 50px; */
                text-align: center;
            }
            .seat-item:hover {
                /* font-weight: bolder; */
                background-color: #ddd;
                color: #fff;
            }
            .selected {
                color: #fff;
                background-color: #569013;
            }
            .seats-table input {
                width: 45px;
                height: 30px
            }
            td.width {
                min-width: 45px;
            }
            .hidden {
                display: none;
            }
        </style>
    </head>
    <body>

        <div class="container">
            <div class="row">
                <div style="min-height: 300px" class="col-lg-12 pl-3 p-2 mt-5 bg-white border">
                    <div class="row seats-table table-responsive">
                        <table class="p-0 m-0">
                        <?php
                        // init
                        $rows = 5;
                        $columns = 10;
                        $removed = [];
                        $counter = 1;
                        
                        // draw the items
                        for($i = 1; $i < $rows + 1; $i++) {
                            
                            print "<tr>\n";
                            for($ii = 1; $ii < $columns + 1; $ii++) {
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
                </div>
            </div>
            <div class="row mt-3 p-0">
                <div class="col-lg-9 col-sm-9 col-md-9">
                    <button type="reset" class="btn btn-outline-danger">Remove</button>
                    <button type="submit" class="btn btn-outline-success">Save</button>
                </div>
                <div class="col-lg-3 col-sm-3 col-md-3 text-right">
                    <button type="restore" class="btn hidden btn-outline-primary">Restore</button>
                </div>
            </div>
        </div>
        <script src="original/code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
        <script>
            var hiddenItems = [];
            $(`div[class~="seats-table"] table tr td div`).on("click", function() {
                $(this).toggleClass("selected");
                $(`input[data-label="${$(this).data("label")}"]`).focus();
            });

            function remove(array) {
                var what, a = arguments, L = a.length, ax;
                while (L > 1 && array.length) {
                    what = a[--L];
                    while ((ax= array.indexOf(what)) !== -1) {
                        array.splice(ax, 1);
                    }
                }
                return array;
            }
            
            $(`button[type="submit"]`).on('click', function(i, e) {
                let selectibles = {};
                $.each($(`div[class~="seats-table"] table tr td div`), function(i, e) {
                    if(!$(this).hasClass("hidden")) {
                        let label = $(this).data("label");
                        let value = $(`input[data-label="${$(this).data("label")}"]`).val();
                        selectibles[label] = value;
                    }
                });
                $(`button[type="restore"]`).addClass("hidden");
                hiddenItems = [];
            });

            $(`button[type="restore"]`).on('click', function(i, e) {
                $.each($(`div[class~="seats-table"] table tr td div`), function(i, e) {
                    if($.inArray($(this).data("label"), hiddenItems) !== -1) {
                        $(`div[class~="seats-table"] table tr td[data-label="${$(this).data("label")}"] div`).removeClass('selected hidden');
                        remove(hiddenItems, $(this).data("label"));
                    }
                });
                $(`button[type="restore"]`).addClass("hidden");
            });

            function restoreButton() {
                if(hiddenItems.length) {
                    $(`button[type="restore"]`).removeClass("hidden");
                } else {
                    $(`button[type="restore"]`).addClass("hidden");
                }
            }

            $(`button[type="reset"]`).on('click', function(i, e) {
                $.each($(`div[class~="seats-table"] table tr td div`), function(i, e) {
                    if($(this).hasClass("selected")) {
                        $(`div[class~="seats-table"] table tr td[data-label="${$(this).data("label")}"] div`).removeClass('selected').addClass(`hidden`);
                        hiddenItems.push($(this).data("label"));
                    }
                });
                restoreButton();
            });
        </script>
    </body>
</html>