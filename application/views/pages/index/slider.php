<div class="mp-slider">
    <!-- // slider // -->
    <div class="mp-slider-row">
        <div class="swiper-container">
            <div class="swiper-preloader-bg"></div>
            <div id="preloader">
                <div id="spinner"></div>
            </div>

            <a href="#" class="arrow-left"></a>
            <a href="#" class="arrow-right"></a>
            <div class="swiper-pagination"></div>
            <div class="swiper-wrapper">  				
                <div class="swiper-slide">
                    <div class="slide-section" style="background:url(<?php echo IMAGES_PATH; ?>/sider-01.jpg) center top no-repeat;">
                        <div class="mp-slider-lbl">Great journey begins with a small step</div>
                        <div class="mp-slider-lbl-a">“We travel, some of us forever, to seek other places, other lives, other souls.” – Anais Nin</div>
                    </div>
                </div>
                <div class="swiper-slide"> 
                    <div class="slide-section slide-b" style="background:url(<?php echo IMAGES_PATH; ?>/sider-02.jpg) center top no-repeat;">
                        <div class="mp-slider-lbl">Once a year, go someplace you’ve never been before</div>
                        <div class="mp-slider-lbl-a">“The gladdest moment in human life, me thinks, is a departure into unknown lands.” – Sir Richard Burton</div>
                    </div>
                </div>
                <div class="swiper-slide"> 
                    <div class="slide-section slide-b" style="background:url(<?php echo IMAGES_PATH; ?>/sider-03.jpg) center top no-repeat;">
                        <div class="mp-slider-lbl">You don’t have to be rich to travel well</div>
                        <div class="mp-slider-lbl-a">“Travel makes one modest. You see what a tiny place you occupy in the world.” – Gustave Flaubert</div>
                    </div>
                </div>            
            </div>
        </div>
    </div>
    <!-- \\ slider \\ -->
</div>	

<div class="wrapper-a-holder">
    <div class="wrapper-a">

        <!-- // search // -->
        <div class="page-search search-type-a">		
            <div class="page-search-content">
                <form action="<?php echo base_url('trip/search/list'); ?>" method="GET">
                    <!-- // tab content // -->
                    <div class="search-tab-content hotels-tab">
                        <div class="page-search-p">
                            <!-- // -->
                            <div class="srch-tab-line">
                                <label>Place / Destination name</label>
                                <div class="input-a"><input type="text" name="search_location" placeholder="Example: France" class="gMapLocation-cities"></div>
                            </div>
                            <!-- // -->
                            <!-- // -->
                            <div class="srch-tab-line" style="margin-bottom:0;">
                                <div class="srch-tab-left">
                                    <label>Departure</label>
                                    <div class="input-a"><input type="text" name="search_date_start" class="date-inpt" id="dt1" placeholder="mm/dd/yy"> <span class="date-icon"></span></div>	
                                </div>
                                <div class="srch-tab-right">
                                    <label>Return</label>
                                    <div class="input-a"><input type="text" name="search_date_end" class="date-inpt" id="dt2" placeholder="mm/dd/yy"> <span class="date-icon"></span></div>	
                                </div>
                                <div class="clear"></div>
                            </div>
                            <!-- \\ -->
                        </div>
                        <footer class="search-footer">
                            <button type="submit" class="btn btn-orange">Search</button>
                            <div class="clear"></div>
                        </footer>
                    </div>
                    <!-- // tab content hotels // -->	
                </form>
            </div>
        </div>
        <!-- \\ search \\ -->
        <div class="clear"></div>	
    </div>
</div>