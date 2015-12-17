<?php
$redis_functions = new Redisfunctions();
?>

<div class="main-cont">
    <div class="body-wrapper">
        <div class="wrapper-padding">
            <div class="page-head">
                <div class="page-title"><?php echo $page_title; ?> - <span>Photos / Videos</span></div>
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
                                    <form method="POST" action="" enctype="multipart/form-data">
                                        <h2>Budget Information</h2>
                                        <div class="region-info">
                                            <div class="booking-form">
                                                <div class="bookin-three-coll">
                                                    <div class="booking-form-i">
                                                        <label>Title:</label>
                                                        <div class="input"><input type="text" name="media_title[]" placeholder="Enter Title"/></div>
                                                    </div>
                                                    <div class="booking-form-i">
                                                        <span class="post-image">
                                                            <label>Select Image:</label>
                                                            <div class="input"><input type="file" name="media_image[]"/></div>
                                                        </span>
                                                        <span class="post-video hidden">
                                                            <label>Enter Youtube / Vimeo URL:</label>
                                                            <div class="input"><input type="text" name="media_video[]" placeholder="Enter Youtube / Vimeo URL"/></div>
                                                        </span>
                                                    </div>
                                                    <div class="booking-form-i">
                                                        <div class="form-calendar" style="float: none;">
                                                            <label>Type:</label>
                                                            <div class="form-calendar-b">
                                                                <select class="custom-select post-media-type" required="required" name="media_type[]">
                                                                    <option value="image">Image</option>
                                                                    <option value="video">Video</option>
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

                                        <span class="new-region-div-here"></span>	
                                        <a href="#" class="add-passanger add-region-click">Add photos / videos</a>

                                        <div class="clear"></div>

                                        <div class="booking-complete">
                                            <button type="submit" class="booking-complete-btn">REVIEW</button>
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