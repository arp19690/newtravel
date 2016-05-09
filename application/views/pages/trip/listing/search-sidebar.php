<?php
$redis_functions = new Redisfunctions();
$custom_model = new Custom_model();
$min_and_max_costs = $custom_model->get_min_and_max_cost_amounts();
$travel_mediums = $redis_functions->get_travel_mediums();
if (!isset($count_search_results))
{
    $count_search_results = 0;
}
?>

<form action="<?php echo base_url('trip/search/list'); ?>" method="GET">
    <div class="clear">
        <div class="srch-results-lbl fly-in">
            <span><?php echo number_format($count_search_results); ?> results found.</span>
        </div> 

        <div class="side-block fly-in">
            <div class="side-block-search">
                <div class="page-search-p">
                    <!-- // -->
                    <div class="srch-tab-line">
                        <div class="clear">
                            <label>Location</label>
                            <div class="input-a"><input type="text" name="search_location" value="<?php echo isset($_GET['search_location']) == TRUE ? $_GET['search_location'] : ''; ?>" placeholder="example: France" class="gMapLocation-cities"></div>	
                        </div>
                        <div class="clear transformed margin-top-20">
                            <label>Number of Travelers</label>
                            <div class="select-wrapper">
                                <select class="custom-select" name="search_travelers">
                                    <?php
                                    for ($i = 1; $i <= 5; $i++)
                                    {
                                        $num_of_travelers = $i;
                                        $selected = '';
                                        if (isset($_GET['search_travelers']))
                                        {
                                            if ($_GET['search_travelers'] == $num_of_travelers)
                                            {
                                                $selected = 'selected="selected"';
                                            }
                                        }
                                        echo '<option value="' . $num_of_travelers . '" ' . $selected . '>' . $num_of_travelers . '+</option>';
                                    }
                                    ?>
                                </select>
                            </div>	
                        </div>
                        <div class="clear"></div>
                    </div>
                    <!-- \\ -->
                    <!-- // -->
                    <div class="srch-tab-line">
                        <div class="srch-tab-left">
                            <label>Departure</label>
                            <div class="input-a"><input type="text" name="search_date_start" value="<?php echo isset($_GET['search_date_start']) == TRUE ? $_GET['search_date_start'] : ''; ?>" class="date-inpt" placeholder="mm/dd/yy"> <span class="date-icon"></span></div>	
                        </div>
                        <div class="srch-tab-right">
                            <label>Return</label>
                            <div class="input-a"><input type="text" name="search_date_end" value="<?php echo isset($_GET['search_date_end']) == TRUE ? $_GET['search_date_end'] : ''; ?>" class="date-inpt" placeholder="mm/dd/yy"> <span class="date-icon"></span></div>	
                        </div>
                        <div class="clear"></div>
                    </div>
                    <!-- \\ -->
                </div>  
            </div>          
        </div>

        <!-- // side // -->
        <div class="side-block fly-in">
            <div class="side-price">
                <div class="side-padding">
                    <div class="side-lbl">Budget <small>(USD)</small></div>
                    <div class="price-ranger">
                        <div id="slider-range"></div>              
                    </div>
                    <div class="price-ammounts">
                        <input type="text" name="search_budget_min" id="ammount-from" readonly>
                        <input type="text" name="search_budget_max" id="ammount-to" readonly>
                        <div class="clear"></div>
                    </div>              
                </div>
            </div>  
        </div>
        <!-- \\ side \\ -->

        <!-- // side // -->
        <div class="side-block fly-in">
            <div class="side-stars">
                <div class="side-padding">
                    <div class="side-lbl">Trip duration</div>  
                    <?php
                    $trip_duration_arr = array('2-4', '4-6', '6-10', '10+');

                    foreach ($trip_duration_arr as $value)
                    {
                        $checked = '';
                        if (isset($_GET['search_duration']))
                        {
                            if (in_array($value, $_GET['search_duration']))
                            {
                                $checked = 'checked="checked"';
                            }
                        }
                        ?>
                        <div class="checkbox"><label><input type="checkbox" name="search_duration[]" value="<?php echo $value; ?>" <?php echo $checked; ?>/><?php echo $value; ?> Days</label></div>
                        <?php
                    }
                    ?>     
                </div>
            </div>  
        </div>
        <!-- \\ side \\ -->

        <?php
        if (!empty($travel_mediums))
        {
            ?>
            <!-- // side // -->
            <div class="side-block fly-in">
                <div class="side-stars">
                    <div class="side-padding">
                        <div class="side-lbl">Travel medium</div>  
                        <?php
                        foreach ($travel_mediums as $key => $value)
                        {
                            $checked = '';
                            if (isset($_GET['search_travel_medium']))
                            {
                                if (in_array($value->tm_id, $_GET['search_travel_medium']))
                                {
                                    $checked = 'checked="checked"';
                                }
                            }
                            ?>
                            <div class="checkbox"><label><input type="checkbox" name="search_travel_medium[]" value="<?php echo $value->tm_id; ?>" <?php echo $checked; ?>/><?php echo stripslashes($value->tm_title); ?></label></div>
                            <?php
                        }
                        ?>
                    </div>
                </div>  
            </div>
            <!-- \\ side \\ -->
            <?php
        }
        ?>

        <button type="submit" class="btn btn-orange"><span class="fa fa-arrow-up"></span>&nbsp;Submit</button>
    </div>
</form>
<script src="<?php echo JS_PATH; ?>/jquery.formstyler.js"></script>
<script>
    $(document).ready(function () {
        $('.date-inpt').datepicker();
        (function ($) {
            $(function () {
                $('input:checkbox,input:radio,.search-engine-range-selection-container input:radio').styler();
            })
        })(jQuery);
        $(function () {
            $("#slider-range").slider({
                range: true,
                min: <?php echo round($min_and_max_costs['min_cost']); ?>,
                max: <?php echo round($min_and_max_costs['max_cost']); ?>,
                values: [<?php echo isset($_GET['search_budget_min']) == TRUE ? $_GET['search_budget_min'] : round($min_and_max_costs['min_cost']); ?>, <?php echo isset($_GET['search_budget_max']) == TRUE ? $_GET['search_budget_max'] : round($min_and_max_costs['max_cost']); ?>],
                slide: function (event, ui) {
                    $("#ammount-from").val(ui.values[0]);
                    $("#ammount-to").val(ui.values[1]);
                }
            });
            $("#ammount-from").val($("#slider-range").slider("values", 0));
            $("#ammount-to").val($("#slider-range").slider("values", 1));
        });

        $(".side-time").each(function () {
            var $this = $(this);
            $this.find('.time-range').slider({
                range: true,
                min: 0,
                max: 24,
                values: [3, 20],
                slide: function (event, ui) {
                    $this.find(".time-from").text(ui.values[0]);
                    $this.find(".time-to").text(ui.values[1]);
                }
            });

            $(this).find(".time-from").text($this.find(".time-range").slider("values", 0));
            $(this).find(".time-to").text($this.find(".time-range").slider("values", 1));

        });

        $(function () {
            $(document.body).on('appear', '.fly-in', function (e, $affected) {
                $(this).addClass("appeared");
            });
            $('.fly-in').appear({force_process: true});
        });
    });
</script>