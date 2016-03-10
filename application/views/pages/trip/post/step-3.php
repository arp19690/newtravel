<?php
$redis_functions = new Redisfunctions();
?>

<div class="main-cont">
    <div class="body-wrapper">
        <div class="wrapper-padding">
            <div class="page-head">
                <div class="page-title"><?php echo $page_title; ?> - <span>Budgets</span></div>
                <?php
                if (isset($breadcrumbs) && !empty($breadcrumbs))
                {
                    echo $breadcrumbs;
                }
                ?>
                <div class="clear"></div>
            </div>

            <div class="sp-page">
                <div class="sp-page-a">
                    <div class="sp-page-l">
                        <div class="sp-page-lb">
                            <div class="sp-page-p">
                                <div class="booking-left">
                                    <form method="POST" action="">
                                        <h2>Budget Information</h2>
                                        <?php
                                        if (count($post_records['post_costs']) > 0)
                                        {
                                            foreach ($post_records['post_costs'] as $key => $post_value)
                                            {
                                                ?>
                                                <div class="region-info">
                                                    <div class="booking-form">
                                                        <div class="bookin-three-coll">
                                                            <div class="booking-form-i">
                                                                <label>Title:</label>
                                                                <div class="input"><input type="text" name="cost_title[]" required="required" placeholder="Enter Title" value="<?php echo stripslashes($post_value->cost_title); ?>"/></div>
                                                            </div>
                                                            <div class="booking-form-i">
                                                                <label>Amount:</label>
                                                                <div class="input"><input type="number" name="cost_amount[]" required="required" placeholder="Enter Amount" step="any" value="<?php echo ($post_value->cost_amount); ?>"/></div>
                                                            </div>
                                                            <div class="booking-form-i">
                                                                <div class="form-calendar" style="float: none;">
                                                                    <label>Currency:</label>
                                                                    <div class="form-calendar-b">
                                                                        <select class="custom-select" required="required" name="cost_currency[]">
                                                                            <?php
                                                                            $currencies = (array) json_decode(CURRENCIES);
                                                                            foreach ($currencies as $key => $value)
                                                                            {
                                                                                $selected = '';
                                                                                if (strtolower($value) == strtolower($post_value->cost_currency))
                                                                                {
                                                                                    $selected = 'selected="selected"';
                                                                                }

                                                                                echo '<option value="' . $key . '" ' . $selected . '>' . strtoupper($key) . '</option>';
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="clear"></div>
                                                            </div>
                                                        </div>

                                                        <div class="clear"></div>	
                                                        <div class="booking-devider"></div>			
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                        }
                                        else
                                        {
                                            ?>
                                            <div class="region-info">
                                                <div class="booking-form">
                                                    <div class="bookin-three-coll">
                                                        <div class="booking-form-i">
                                                            <label>Title:</label>
                                                            <div class="input"><input type="text" name="cost_title[]" required="required" placeholder="Enter Title"/></div>
                                                        </div>
                                                        <div class="booking-form-i">
                                                            <label>Amount:</label>
                                                            <div class="input"><input type="number" name="cost_amount[]" required="required" placeholder="Enter Amount" step="any"/></div>
                                                        </div>
                                                        <div class="booking-form-i">
                                                            <div class="form-calendar" style="float: none;">
                                                                <label>Currency:</label>
                                                                <div class="form-calendar-b">
                                                                    <select class="custom-select" required="required" name="cost_currency[]">
                                                                        <?php
                                                                        $currencies = (array) json_decode(CURRENCIES);
                                                                        foreach ($currencies as $key => $value)
                                                                        {
                                                                            echo '<option value="' . $key . '">' . strtoupper($key) . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="clear"></div>
                                                        </div>
                                                    </div>

                                                    <div class="clear"></div>	
                                                    <div class="booking-devider"></div>			
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        ?>

                                        <span class="new-region-div-here"></span>	
                                        <a href="#" class="add-passanger add-region-click">Add to budgets</a>

                                        <div class="clear"></div>

                                        <div class="booking-complete">
                                            <button type="submit" class="booking-complete-btn">NEXT</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>

                <div class="sp-page-r">
                    <?php $this->load->view('pages/trip/post-right-sidebar'); ?>
                </div>
                <div class="clear"></div>
            </div>

        </div>	
    </div>  
</div>