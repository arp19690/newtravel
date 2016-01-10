<!-- main-cont -->
<div class="main-cont">
    <div class="body-wrapper">
        <div class="wrapper-padding">
            <div class="page-head">
                <div class="page-title"><?php echo $page_title; ?></div>
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
                    <?php $this->load->view('pages/trip/listing/search-sidebar'); ?>
                    <div class="clear"></div>
                </div>

                <div class="two-colls-right">
                    <?php
                    if ($view_type == 'list')
                    {
                        $this->load->view('pages/trip/listing/trip-list');
                    }
                    elseif ($view_type == 'grid')
                    {
                        $this->load->view('pages/trip/listing/trip-grid');
                    }
                    ?>
                    <br class="clear" />
                </div>
            </div>
            <div class="clear"></div>

        </div>	
    </div>  
</div>
<!-- /main-cont -->