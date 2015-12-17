<?php
$redis_functions = new Redisfunctions();
?>

<div class="main-cont">
    <div class="body-wrapper">
        <div class="wrapper-padding">
            <div class="page-head">
                <div class="page-title"><span>Review</span></div>
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
                                    <h2><?php echo $page_title; ?></h2>

                                    <div class="comlete-alert">
                                        <div class="comlete-alert-a">
                                            <b>Thank You. Your Order is Confirmed.</b>
                                            <span>Quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur</span>
                                        </div>
                                    </div>

                                    <div class="complete-info">
                                        <h2>Your Personal Information</h2>
                                        <div class="complete-info-table">
                                            <div class="complete-info-i">
                                                <div class="complete-info-l">Number:</div>
                                                <div class="complete-info-r">521-645-6</div>
                                                <div class="clear"></div>
                                            </div>
                                            <div class="complete-info-i">
                                                <div class="complete-info-l">First Name:</div>
                                                <div class="complete-info-r">Roman</div>
                                                <div class="clear"></div>
                                            </div>
                                            <div class="complete-info-i">
                                                <div class="complete-info-l">Last Name:</div>
                                                <div class="complete-info-r">Polyarush</div>
                                                <div class="clear"></div>
                                            </div>
                                            <div class="complete-info-i">
                                                <div class="complete-info-l">E-Mail Adress:</div>
                                                <div class="complete-info-r">weblionmedia@gmail.com</div>
                                                <div class="clear"></div>
                                            </div>
                                            <div class="complete-info-i">
                                                <div class="complete-info-l">Country:</div>
                                                <div class="complete-info-r">Austria</div>
                                                <div class="clear"></div>
                                            </div>
                                            <div class="complete-info-i">
                                                <div class="complete-info-l">Phone Number:</div>
                                                <div class="complete-info-r">+8 256 254 25 625</div>
                                                <div class="clear"></div>
                                            </div>
                                        </div>

                                        <div class="complete-devider"></div>

                                        <div class="complete-txt">
                                            <h2>Payment Info</h2>
                                            <p>Voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui voluptatem sequi nesciunt. Que porro quisqua. Sed ut perspiciatis unde omnis ste natus error sit voluptatem.</p>
                                            <div class="complete-txt-link"><a href="#">Payment is made by Via Paypal.</a></div>
                                        </div>

                                        <div class="complete-devider"></div>

                                        <div class="complete-txt final">
                                            <h2>Booking Details</h2>
                                            <p>Qoluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui voluptatem sequi nesciunt. Que porro quisqua. Sed ut perspiciatis unde omnis ste natus error.</p>
                                            <div class="complete-txt-link"><a href="#">Your Hotel Info</a></div>
                                        </div>
                                    </div>
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