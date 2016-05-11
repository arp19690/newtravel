<div class="checkout-coll">
    <div class="checkout-head">
        <div class="chk-left">
            <div class="chk-lbl"><p>Increase your reach</p></div>
            <div class="chk-lbl-a">Reach out to more audience. Choose a plan that suits you best.</div>
        </div>
        <div class="chk-right">

        </div>
        <div class="clear"></div>
    </div>
    <div class="chk-details">
        <div class="chk-detais-row">
            <?php
            $model = new Common_model();
            $featured_master_records = $model->fetchSelectedData('*', TABLE_FEATURED_MASTER, array('pfm_status' => '1'), 'pfm_amount');
            if (!empty($featured_master_records))
            {
                foreach ($featured_master_records as $key => $value)
                {
                    ?>
                    <div class="chk-line">
                        <span class="chk-l">
                            <a href="#" class="a-no-underline" style="color: #4a90a4;"><?php echo stripslashes($value['pfm_title']) ?>:</a>
                        </span>
                        <span class="chk-r"><a href="#" class="btn"><?php echo get_currency_symbol($value['pfm_currency']) . ' ' . $value['pfm_amount']; ?></a></span>
                        <div class="clear"></div>
                    </div>
                    <?php
                }
            }
            ?>					
        </div>
    </div>
    <div class="clear"></div>
</div>
<div class="clear"></div>