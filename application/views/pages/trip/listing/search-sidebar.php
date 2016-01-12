<?php
$redis_functions = new Redisfunctions();
$travel_mediums = $redis_functions->get_travel_mediums();
$count_search_results = 0;
?>

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
                        <div class="input-a"><input type="text" name="search_location" value="" placeholder="example: France" class="gMapLocation-cities"></div>	
                    </div>
                    <div class="clear transformed margin-top-20">
                        <label>Number of Travelers</label>
                        <div class="select-wrapper">
                            <select class="custom-select">
                                <?php
                                for ($i = 1; $i <= 5; $i++)
                                {
                                    $num_of_travelers = $i == 5 ? ($i . '+') : ($i);
                                    echo '<option value="' . $num_of_travelers . '">' . $num_of_travelers . '</option>';
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
                        <div class="input-a"><input type="text" name="search_date_start" value="" class="date-inpt" placeholder="mm/dd/yy"> <span class="date-icon"></span></div>	
                    </div>
                    <div class="srch-tab-right">
                        <label>Return</label>
                        <div class="input-a"><input type="text" name="search_date_end" value="" class="date-inpt" placeholder="mm/dd/yy"> <span class="date-icon"></span></div>	
                    </div>
                    <div class="clear"></div>
                </div>
                <!-- \\ -->
                <button class="srch-btn">Search</button> 
            </div>  
        </div>          
    </div>

    <!-- // side // -->
    <div class="side-block fly-in">
        <div class="side-price">
            <div class="side-padding">
                <div class="side-lbl">Budget</div>
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
                $trip_duration_arr = array(
                    '4' => '2 - 4',
                    '6' => '4 - 6',
                    '10' => '6 - 10',
                    '10+' => '10+'
                );

                foreach ($trip_duration_arr as $key => $value)
                {
                    ?>
                    <div class="checkbox"><label><input type="checkbox" name="search_trip_days[]" value="<?php echo $key; ?>" /><?php echo $value; ?> Days</label></div>
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
                        ?>
                        <div class="checkbox"><label><input type="checkbox" name="search_travel_medium[]" value="<?php echo $value->tm_id; ?>"/><?php echo stripslashes($value->tm_title); ?></label></div>
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
</div>
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
                min: 0,
                max: 15000,
                values: [250, 3500],
                slide: function (event, ui) {
                    $("#ammount-from").val(ui.values[0] + '$');
                    $("#ammount-to").val(ui.values[1] + '$');
                }
            });
            $("#ammount-from").val($("#slider-range").slider("values", 0) + '$');
            $("#ammount-to").val($("#slider-range").slider("values", 1) + '$');
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