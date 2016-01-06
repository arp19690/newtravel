<!-- main-cont -->
<div class="main-cont">
    <div class="body-wrapper">
        <div class="wrapper-padding">
            <div class="page-head">
                <div class="page-title">Tours - <span>Alternative</span></div>
                <?php
                if (isset($breadcrumbs) && !empty($breadcrumbs))
                {
                    echo $breadcrumbs;
                }
                ?>
                <div class="clear"></div>
            </div>
            <div class="two-colls">
                <div class="two-colls-left">
                    <!--Google Ad code goes here-->
                    <?php echo get_google_ad(); ?>
                    <div class="clear"></div>
                </div>

                <div class="two-colls-right">
                    <?php $this->load->view('pages/trip/listing/trip-list'); ?>
                    <br class="clear" />
                </div>
            </div>
            <div class="clear"></div>

        </div>	
    </div>  
</div>
<!-- /main-cont -->