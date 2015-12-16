<link rel="stylesheet" href="<?php echo CSS_PATH; ?>/jquery.formstyler.css">  
<div class="main-cont">
    <div class="body-wrapper">
        <div class="wrapper-padding">
            <div class="page-head">
                <div class="page-title">Trips - <span>Post new</span></div>
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
                                    <h2>Tour Passenger Information</h2>
                                    <div class="booking-form">
                                        <div class="booking-form-i">
                                            <label>First Name:</label>
                                            <div class="input"><input type="text" value="" /></div>
                                        </div>
                                        <div class="booking-form-i">
                                            <label>Last Name:</label>
                                            <div class="input"><input type="text" value="" /></div>
                                        </div>
                                        <div class="booking-form-i">
                                            <div class="form-sex">
                                                <label>Male/Female</label>
                                                <div class="sex-type chosen">M</div>
                                                <div class="sex-type">F</div>
                                                <div class="clear"></div>
                                            </div>
                                            <div class="form-calendar">
                                                <label>Date of birth:</label>
                                                <div class="form-calendar-a">
                                                    <select class="custom-select">
                                                        <option>dd</option>
                                                        <option>01</option>
                                                        <option>02</option>
                                                        <option>03</option>
                                                        <option>04</option>
                                                    </select>
                                                </div>
                                                <div class="form-calendar-a">
                                                    <select class="custom-select">
                                                        <option>mm</option>
                                                        <option>01</option>
                                                        <option>02</option>
                                                        <option>03</option>
                                                        <option>04</option>
                                                    </select>
                                                </div>
                                                <div class="form-calendar-b">
                                                    <select class="custom-select">
                                                        <option>year</option>
                                                        <option>01</option>
                                                        <option>02</option>
                                                        <option>03</option>
                                                        <option>04</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="clear"></div>
                                        </div>
                                        <div class="booking-form-i">
                                            <label>Country:</label>
                                            <div class="input"><input type="text" value="" /></div>
                                        </div>

                                        <div class="clear"></div>

                                        <div class="bookin-three-coll">
                                            <div class="booking-form-i">
                                                <label>Citizenship:</label>
                                                <div class="input"><input type="text" value="" /></div>
                                            </div>
                                            <div class="booking-form-i">
                                                <label>Document Series:</label>
                                                <div class="input"><input type="text" value="" /></div>
                                            </div>
                                            <div class="booking-form-i">
                                                <label>Expiry date:</label>
                                                <div class="form-calendar-a">
                                                    <select class="custom-select">
                                                        <option>dd</option>
                                                        <option>01</option>
                                                        <option>02</option>
                                                        <option>03</option>
                                                        <option>04</option>
                                                    </select>
                                                </div>
                                                <div class="form-calendar-a">
                                                    <select class="custom-select">
                                                        <option>mm</option>
                                                        <option>01</option>
                                                        <option>02</option>
                                                        <option>03</option>
                                                        <option>04</option>
                                                    </select>
                                                </div>
                                                <div class="form-calendar-b">
                                                    <select class="custom-select">
                                                        <option>year</option>
                                                        <option>01</option>
                                                        <option>02</option>
                                                        <option>03</option>
                                                        <option>04</option>
                                                    </select>
                                                </div>
                                                <div class="clear"></div>
                                            </div>
                                            <div class="clear"></div>
                                        </div>

                                        <a href="#" class="add-passanger">Add Passenger</a>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="" />
                                                Save Personal Info
                                            </label>
                                        </div> 		
                                        <div class="booking-devider"></div>						
                                    </div>

                                    <h2>Your Personal Information</h2>

                                    <div class="booking-form">
                                        <div class="booking-form-i">
                                            <label>First Name:</label>
                                            <div class="input"><input type="text" value=""></div>
                                        </div>
                                        <div class="booking-form-i">
                                            <label>Last Name:</label>
                                            <div class="input"><input type="text" value=""></div>
                                        </div>
                                        <div class="booking-form-i">
                                            <label>Email Adress:</label>
                                            <div class="input"><input type="text" value=""></div>
                                        </div>
                                        <div class="booking-form-i">
                                            <label>Confirm Email Adress:</label>
                                            <div class="input"><input type="text" value=""></div>
                                        </div>
                                        <div class="booking-form-i">
                                            <label>Country:</label>
                                            <div class="input"><input type="text" value=""></div>
                                        </div>
                                        <div class="booking-form-i">
                                            <label>Preferred Phone Number:</label>
                                            <div class="input"><input type="text" value=""></div>
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                    <div class="booking-devider no-margin"></div>	
                                    <h2>How would you like to pay?</h2>

                                    <div class="payment-wrapper">
                                        <div class="payment-tabs">
                                            <a href="#" class="active">Credit Card <span></span></a>
                                            <a href="#">Paypal <span></span></a>
                                        </div>
                                        <div class="clear"></div>
                                        <div class="payment-tabs-content">
                                            <!-- // -->
                                            <div class="payment-tab">
                                                <div class="payment-type">
                                                    <label>Card Type:</label>
                                                    <div class="card-type"><img alt="" src="img/paymentt-01.png"></div>
                                                    <div class="card-type"><img alt="" src="img/paymentt-02.png"></div>
                                                    <div class="card-type"><img alt="" src="img/paymentt-03.png"></div>
                                                    <div class="clear"></div>
                                                </div>
                                                <div class="booking-form">
                                                    <div class="booking-form-i">
                                                        <label>Card Number:</label>
                                                        <div class="input"><input type="text" value=""></div>
                                                    </div>
                                                    <div class="booking-form-i">
                                                        <label>Card Holder Name:</label>
                                                        <div class="input"><input type="text" value=""></div>
                                                    </div>
                                                    <div class="booking-form-i">
                                                        <label>Expiration Date:</label>
                                                        <div class="card-expiration">
                                                            <select class="custom-select">
                                                                <option>Month</option>
                                                                <option>01</option>
                                                                <option>02</option>
                                                                <option>03</option>
                                                                <option>04</option>
                                                                <option>05</option>
                                                                <option>06</option>
                                                                <option>07</option>
                                                                <option>08</option>
                                                                <option>09</option>
                                                                <option>10</option>
                                                                <option>11</option>
                                                                <option>12</option>
                                                            </select>
                                                        </div>
                                                        <div class="card-expiration">
                                                            <select class="custom-select card-year">
                                                                <option>Year</option>
                                                                <option>2015</option>
                                                                <option>2016</option>
                                                                <option>2017</option>
                                                                <option>2018</option>
                                                                <option>2019</option>
                                                                <option>2020</option>
                                                            </select>
                                                        </div>
                                                        <div class="clear"></div>
                                                    </div>
                                                    <div class="booking-form-i">
                                                        <label>Card Indefication Number:</label>
                                                        <div class="inpt-comment">
                                                            <div class="inpt-comment-l">
                                                                <div class="inpt-comment-lb">
                                                                    <div class="input"><input type="text" value=""></div>
                                                                </div>
                                                                <div class="clear"></div>
                                                            </div>
                                                        </div>
                                                        <div class="inpt-comment-r">
                                                            <div class="padding">
                                                                <a href="#">What’s This?</a>
                                                            </div>
                                                            <div class="clear"></div>
                                                        </div>
                                                        <div class="clear"></div>
                                                    </div>
                                                </div>
                                                <div class="clear"></div>
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" value="" />
                                                        Im accept the rules <a href="#">Terms & Conditions</a>
                                                    </label>
                                                </div> 
                                            </div>
                                            <!-- \\ -->
                                            <!-- // -->
                                            <div class="payment-tab">
                                                <div class="payment-alert">
                                                    <span>You will be redirected to PayPal's website to securely complete your payment.</span>
                                                    <div class="payment-alert-close"><a href="#"><img alt="" src="img/alert-close.png"></a></div>
                                                </div>
                                                <a href="#" class="paypal-btn">proceed to paypall</a>
                                            </div>
                                            <!-- \\ -->
                                        </div>
                                    </div>
                                    <div class="booking-complete">
                                        <h2>Review and book your trip</h2>
                                        <p>Voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui voluptatem sequi nesciunt. </p>	
                                        <button class="booking-complete-btn">COMPLETE BOOKING</button>
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