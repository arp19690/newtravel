<div class="main-cont">  	
    <div class="inner-page">
        <div class="inner-breadcrumbs">
            <div class="content-wrapper">
                <div class="page-title"><?php echo $page_title; ?></div>
                <?php
                if (isset($breadcrumbs) && !empty($breadcrumbs))
                {
                    echo $breadcrumbs;
                }
                ?>
                <div class="clear"></div>
            </div>		
        </div>

        <div class="about-content">
            <div class="content-wrapper" style="margin-bottom: 80px;">
                    <h2><?php echo $page_title; ?></h2>
                    <div><?php echo stripslashes($content); ?></div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('body').removeClass('');
        $('body').addClass('inner-body');
    });
</script>