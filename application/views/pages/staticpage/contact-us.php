<style>
    .inner-breadcrumbs{margin: 0;}
</style>

<div class="main-cont">
    <div class="inner-page">
        <div class="inner-breadcrumbs">
            <div class="content-wrapper">
                <div class="page-title">Contact us</div>
                <?php
                if (isset($breadcrumbs) && !empty($breadcrumbs))
                {
                    echo $breadcrumbs;
                }
                ?>
                <div class="clear"></div>
            </div>		
        </div>

        <div class="contacts-page-holder">
            <div class="contacts-page">
                <header class="page-lbl">
                    <div class="offer-slider-lbl">GET IN TOUCH WITH US</div>
                    <p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit</p>
                </header> 	

                <div class="contacts-colls">
                    <div class="contacts-colls-l">
                        <?php echo get_google_ad(); ?>
                    </div>

                    <div class="contacts-colls-r">
                        <div class="contacts-colls-rb">
                            <div class="contact-colls-lbl">Contact Us</div>
                            <div class="booking-form">
                                <form id="contact_form" action="" method="post">
                                    <div class="booking-form-i">
                                        <label>Full Name:</label>
                                        <div class="input"><input type="text" name="full_name" required="required" /></div>
                                    </div>
                                    <div class="booking-form-i">
                                        <label>Email Address:</label>
                                        <div class="input"><input type="email" name="user_email" required="required" /></div>
                                    </div>
                                    <div class="booking-form-i textarea">
                                        <label>Message:</label>
                                        <div class="textarea-wrapper">
                                            <textarea name="message" required="required"></textarea>
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                    <button type="submit" name="btn_submit" class="btn btn-orange">Send message</button>
                                </form>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
                <div class="clear"></div>	
            </div>
        </div>
    </div>
</div>