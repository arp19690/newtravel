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
                                <form id="contact_form" action="php/contact_form.php">
                                    <div class="booking-form-i">
                                        <label>First Name:</label>
                                        <div class="input"><input type="text" name="FirstName" value="" /></div>
                                    </div>
                                    <div class="booking-form-i">
                                        <label>Last Name:</label>
                                        <div class="input"><input type="text" name="lastName" value="" /></div>
                                    </div>
                                    <div class="booking-form-i">
                                        <label>Email Adress:</label>
                                        <div class="input"><input type="text" name="Email" value="" /></div>
                                    </div>
                                    <div class="booking-form-i">
                                        <label>Website:</label>
                                        <div class="input"><input type="text" name="Website" value="" /></div>
                                    </div>
                                    <div class="booking-form-i textarea">
                                        <label>Message:</label>
                                        <div class="textarea-wrapper">
                                            <textarea name="Message"></textarea>
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                    <button class="contacts-send">Send message</button>
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