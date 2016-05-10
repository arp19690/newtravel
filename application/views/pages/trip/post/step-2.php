<?php
$redis_functions = new Redisfunctions();
?>

<div class="main-cont">
    <div class="body-wrapper">
        <div class="wrapper-padding">
            <div class="page-head">
                <div class="page-title"><?php echo $page_title; ?> - <span>Itinerary</span></div>
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
                                        <h2>Itinerary Information</h2>

                                        <!--If related data exists-->
                                        <?php
                                        if (count($post_records['post_regions']) > 0)
                                        {
                                            foreach ($post_records['post_regions'] as $key => $post_value)
                                            {
                                                $exploded_from_date = explode('-', $post_value->pr_from_date);
                                                $exploded_to_date = explode('-', $post_value->pr_to_date);
                                                ?>
                                                <div class="region-info">
                                                    <div class="booking-form">
                                                        <div class="booking-form-i">
                                                            <label>Origin:</label>
                                                            <div class="input"><input type="text" name="post_source[]" required="required" placeholder="Enter your Origin" class="gMapLocation-cities" value="<?php echo stripslashes($post_value->pr_source_location); ?>"/></div>
                                                        </div>
                                                        <div class="booking-form-i">
                                                            <label>Destination:</label>
                                                            <div class="input"><input type="text" name="post_destination[]" required="required" placeholder="Enter your Destination" class="gMapLocation-cities" value="<?php echo stripslashes($post_value->pr_destination_location); ?>"/></div>
                                                        </div>
                                                        <div class="clear"></div>
                                                        <div class="bookin-three-coll">
                                                            <div class="booking-form-i">
                                                                <div class="form-calendar" style="float: none;">
                                                                    <label>From:</label>
                                                                    <div class="form-calendar-a">
                                                                        <select class="custom-select" required="required" name="date_from_dd[]">
                                                                            <option value="">dd</option>
                                                                            <?php
                                                                            for ($dd_i = 1; $dd_i <= 31; $dd_i++)
                                                                            {
                                                                                $selected = '';
                                                                                if ($dd_i == $exploded_from_date[2])
                                                                                {
                                                                                    $selected = 'selected="selected"';
                                                                                }

                                                                                echo '<option value="' . $dd_i . '" ' . $selected . '>' . $dd_i . '</option>';
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-calendar-a">
                                                                        <select class="custom-select" required="required" name="date_from_mm[]">
                                                                            <option value="">mm</option>
                                                                            <?php
                                                                            for ($mm_i = 1; $mm_i <= 12; $mm_i++)
                                                                            {
                                                                                $selected = '';
                                                                                if ($mm_i == $exploded_from_date[1])
                                                                                {
                                                                                    $selected = 'selected="selected"';
                                                                                }

                                                                                echo '<option value="' . $mm_i . '" ' . $selected . '>' . $mm_i . '</option>';
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-calendar-a">
                                                                        <select class="custom-select" required="required" name="date_from_yy[]">
                                                                            <option value="">year</option>
                                                                            <?php
                                                                            for ($yy_i = date('Y'); $yy_i <= (date('Y') + 10); $yy_i++)
                                                                            {
                                                                                $selected = '';
                                                                                if ($yy_i == $exploded_from_date[0])
                                                                                {
                                                                                    $selected = 'selected="selected"';
                                                                                }

                                                                                echo '<option value="' . $yy_i . '" ' . $selected . '>' . $yy_i . '</option>';
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="clear"></div>
                                                            </div>
                                                            <div class="booking-form-i">
                                                                <div class="form-calendar" style="float: none;">
                                                                    <label>To:</label>
                                                                    <div class="form-calendar-a">
                                                                        <select class="custom-select" required="required" name="date_to_dd[]">
                                                                            <option value="">dd</option>
                                                                            <?php
                                                                            for ($dd_i = 1; $dd_i <= 31; $dd_i++)
                                                                            {
                                                                                $selected = '';
                                                                                if ($dd_i == $exploded_to_date[2])
                                                                                {
                                                                                    $selected = 'selected="selected"';
                                                                                }

                                                                                echo '<option value="' . $dd_i . '" ' . $selected . '>' . $dd_i . '</option>';
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-calendar-a">
                                                                        <select class="custom-select" required="required" name="date_to_mm[]">
                                                                            <option value="">mm</option>
                                                                            <?php
                                                                            for ($mm_i = 1; $mm_i <= 12; $mm_i++)
                                                                            {
                                                                                $selected = '';
                                                                                if ($mm_i == $exploded_to_date[1])
                                                                                {
                                                                                    $selected = 'selected="selected"';
                                                                                }

                                                                                echo '<option value="' . $mm_i . '" ' . $selected . '>' . $mm_i . '</option>';
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-calendar-a">
                                                                        <select class="custom-select" required="required" name="date_to_yy[]">
                                                                            <option value="">year</option>
                                                                            <?php
                                                                            for ($yy_i = date('Y'); $yy_i <= (date('Y') + 10); $yy_i++)
                                                                            {
                                                                                $selected = '';
                                                                                if ($yy_i == $exploded_to_date[0])
                                                                                {
                                                                                    $selected = 'selected="selected"';
                                                                                }

                                                                                echo '<option value="' . $yy_i . '" ' . $selected . '>' . $yy_i . '</option>';
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="clear"></div>
                                                            </div>
                                                            <div class="booking-form-i">
                                                                <div class="form-calendar" style="float: none;">
                                                                    <label>Travel via:</label>
                                                                    <div class="form-calendar-b">
                                                                        <select class="custom-select" required="required" name="travel_medium[]">
                                                                            <option value="">--</option>
                                                                            <?php
                                                                            $travel_mediums = $redis_functions->get_travel_mediums();
                                                                            foreach ($travel_mediums as $key => $value)
                                                                            {
                                                                                $selected = '';
                                                                                if ($value->tm_id == $post_value->pr_travel_medium)
                                                                                {
                                                                                    $selected = 'selected="selected"';
                                                                                }

                                                                                echo '<option value="' . $value->tm_id . '" ' . $selected . '>' . $value->tm_title . '</option>';
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

                                            <!--If no related data exists-->
                                            <div class="region-info">
                                                <div class="booking-form">
                                                    <div class="booking-form-i">
                                                        <label>Origin:</label>
                                                        <div class="input"><input type="text" name="post_source[]" required="required" placeholder="Enter your Origin" class="gMapLocation-cities"/></div>
                                                    </div>
                                                    <div class="booking-form-i">
                                                        <label>Destination:</label>
                                                        <div class="input"><input type="text" name="post_destination[]" required="required" placeholder="Enter your Destination" class="gMapLocation-cities"/></div>
                                                    </div>
                                                    <div class="clear"></div>
                                                    <div class="bookin-three-coll">
                                                        <div class="booking-form-i">
                                                            <div class="form-calendar" style="float: none;">
                                                                <label>From:</label>
                                                                <div class="form-calendar-a">
                                                                    <select class="custom-select" required="required" name="date_from_dd[]">
                                                                        <option value="">dd</option>
                                                                        <?php
                                                                        for ($dd_i = 1; $dd_i <= 31; $dd_i++)
                                                                        {
                                                                            echo '<option value="' . $dd_i . '">' . $dd_i . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                                <div class="form-calendar-a">
                                                                    <select class="custom-select" required="required" name="date_from_mm[]">
                                                                        <option value="">mm</option>
                                                                        <?php
                                                                        for ($mm_i = 1; $mm_i <= 12; $mm_i++)
                                                                        {
                                                                            echo '<option value="' . $mm_i . '">' . $mm_i . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                                <div class="form-calendar-a">
                                                                    <select class="custom-select" required="required" name="date_from_yy[]">
                                                                        <option value="">year</option>
                                                                        <?php
                                                                        for ($yy_i = date('Y'); $yy_i <= (date('Y') + 10); $yy_i++)
                                                                        {
                                                                            echo '<option value="' . $yy_i . '">' . $yy_i . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="clear"></div>
                                                        </div>
                                                        <div class="booking-form-i">
                                                            <div class="form-calendar" style="float: none;">
                                                                <label>To:</label>
                                                                <div class="form-calendar-a">
                                                                    <select class="custom-select" required="required" name="date_to_dd[]">
                                                                        <option value="">dd</option>
                                                                        <?php
                                                                        for ($dd_i = 1; $dd_i <= 31; $dd_i++)
                                                                        {
                                                                            echo '<option value="' . $dd_i . '">' . $dd_i . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                                <div class="form-calendar-a">
                                                                    <select class="custom-select" required="required" name="date_to_mm[]">
                                                                        <option value="">mm</option>
                                                                        <?php
                                                                        for ($mm_i = 1; $mm_i <= 12; $mm_i++)
                                                                        {
                                                                            echo '<option value="' . $mm_i . '">' . $mm_i . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                                <div class="form-calendar-a">
                                                                    <select class="custom-select" required="required" name="date_to_yy[]">
                                                                        <option value="">year</option>
                                                                        <?php
                                                                        for ($yy_i = date('Y'); $yy_i <= (date('Y') + 10); $yy_i++)
                                                                        {
                                                                            echo '<option value="' . $yy_i . '">' . $yy_i . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="clear"></div>
                                                        </div>
                                                        <div class="booking-form-i">
                                                            <div class="form-calendar" style="float: none;">
                                                                <label>Travel via:</label>
                                                                <div class="form-calendar-b">
                                                                    <select class="custom-select" required="required" name="travel_medium[]">
                                                                        <option value="">--</option>
                                                                        <?php
                                                                        $travel_mediums = $redis_functions->get_travel_mediums();
                                                                        foreach ($travel_mediums as $key => $value)
                                                                        {
                                                                            echo '<option value="' . $value->tm_title . '">' . $value->tm_title . '</option>';
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
                                        <a href="#" class="add-passanger add-region-click">Add to itinerary</a>

                                        <div class="clear"></div>

                                        <div class="booking-complete">
                                            <button type="submit" class="booking-complete-btn">NEXT&nbsp;<span class="fa fa-arrow-right"></span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>

                <div class="sp-page-r">
                    <?php $this->load->view('pages/trip/post-right-sidebar', array('post_records' => $post_records)); ?>
                </div>
                <div class="clear"></div>
            </div>

        </div>	
    </div>  
</div>