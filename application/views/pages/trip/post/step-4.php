<?php
$redis_functions = new Redisfunctions();
?>

<style>
    .media-thumb-wrapper{display: inline-block;}
    .media-thumb-wrapper > img{display: inline-block;width: 80%;margin: auto;}
</style>

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
                                        <h2>Add photos or video links</h2>
                                        <div class="region-info <?php echo isset($post_records['post_media']) == TRUE ? (!empty($post_records['post_media']) == TRUE ? 'hidden' : '') : ''; ?>">
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

                                        <?php
//                                        if any media exists then display it below
                                        if (isset($post_records['post_media']) == TRUE)
                                        {
                                            if (!empty($post_records['post_media']) == TRUE)
                                            {
                                                foreach ($post_records['post_media'] as $media_type => $value)
                                                {
                                                    if (!empty($value))
                                                    {
                                                        foreach ($value as $tmp_key => $tmp_value)
                                                        {
                                                            $pm_id_enc = getEncryptedString($tmp_value->pm_id);
                                                            ?>
                                                            <div class="region-info" id="media-div-<?php echo $pm_id_enc; ?>">
                                                                <div class="booking-form">
                                                                    <div class="bookin-three-coll">
                                                                        <div class="booking-form-i">
                                                                            <label>Title:</label>
                                                                            <div class="input">
                                                                                <input type="hidden" name="existing_media_id[]" value="<?php echo $pm_id_enc; ?>"/>
                                                                                <input type="text" name="media_title[]" placeholder="Enter Title" value="<?php echo stripslashes($tmp_value->pm_media_title); ?>"/>
                                                                            </div>
                                                                        </div>
                                                                        <div class="booking-form-i">
                                                                            <span class="post-image">
                                                                                <div class="media-thumb-wrapper">
                                                                                    <?php
                                                                                    if ($media_type == 'images')
                                                                                    {
                                                                                        echo '<img src="' . base_url($tmp_value->pm_media_url) . '" alt="' . stripslashes($tmp_value->pm_media_title) . '"/>';
                                                                                    }
                                                                                    else if ($media_type == 'videos')
                                                                                    {
                                                                                        
                                                                                    }
                                                                                    ?>
                                                                                </div>
                                                                            </span>
                                                                        </div>
                                                                        <div class="booking-form-i">
                                                                            <div class="form-calendar" style="float: none;">
                                                                                <label>Type:</label>
                                                                                <div class="form-calendar-b">
                                                                                    <a href="#" class="remove-media-btn" data-href="<?php echo base_url('trip/removeMediaAjax/' . $post_records['post_url_key'] . '?id=' . $pm_id_enc); ?>"  data-id="<?php echo $pm_id_enc; ?>"><span class="fa fa-trash"></span>&nbsp;&nbsp;Remove</a>
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
                                                }
                                            }
                                        }
                                        ?>

                                        <span class="new-region-div-here"></span>	
                                        <a href="#" class="add-passanger add-region-click">Add photos / videos</a>

                                        <div class="clear"></div>

                                        <div class="booking-complete">
                                            <button type="submit" class="booking-complete-btn">COMPLETE</button>
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

<script type="text/javascript">
    $ = jQuery;
    $(document).ready(function () {
        $('.remove-media-btn').click(function (e) {
            e.preventDefault();
            var cnfm = confirm('Sure you want to remove this media?');
            if (cnfm == true)
            {
                var data_href = $(this).attr('data-href');
                var pm_id_enc = $(this).attr('data-id');
                $.ajax({
                    dataType: 'json',
                    url: data_href,
                    success: function (response) {
                        if (response['status'] == 'success')
                        {
                            $('#media-div-' + pm_id_enc).slideUp('slow');
                        }
                        else if (response['status'] == 'error')
                        {
                            alert(response['message']);
                        }
                    }
                });
            }
        });
    });
</script>