<?php
$controller = $this->router->fetch_class();
$action = $this->router->fetch_method();
$path = $controller . "/" . $action;
?>
<!-- // mobile menu // -->
<div class="mobile-menu">
    <nav>
        <ul>
            <li><a class="has-child" href="<?php echo base_url(); ?>">HOME</a>
                <ul>
                    <li><a href="index.html">Home style one</a></li>
                    <li><a href="index_02.html">Home style two</a></li>
                    <li><a href="index_03.html">Home style three</a></li>
                    <li><a href="index_04.html">Home style four</a></li>	
                </ul>						
            </li>
            <li><a class="has-child" href="#">Hotels</a>
                <ul>
                    <li><a href="hotel_list.html">Hotels standard list</a></li>
                    <li><a href="hotel_simple_style.html">Hotels simple style</a></li>
                    <li><a href="hotel_detail_style.html">Hotels detail style</a></li>
                    <li><a href="hotel_detail.html">Hotel item page</a></li>
                    <li><a href="hotel_booking.html">Hotel booking page</a></li>
                    <li><a href="#">booking complete page</a></li>
                </ul>
            </li>						
            <li><a class="has-child" href="#">Flights</a>
                <ul>
                    <li><a href="flight_round_trip.html">Flights round trip</a></li>
                    <li><a href="flight_one_way.html">flights one way trip</a></li>
                    <li><a href="flight_alternative.html">flights alternative style</a></li>
                    <li><a href="flight_detail.html">Flights detail page</a></li>
                    <li><a href="flight_booking.html">Flights booking page</a></li>
                    <li><a href="booking_complete.html">booking complete</a></li>
                </ul>
            </li>
            <li><a class="has-child" href="#">Tours</a>
                <ul>
                    <li><a href="tour_alternative.html">Tours list style</a></li>
                    <li><a href="tour_grid.html">tours grid style</a></li>
                    <li><a href="tour_simple.html">Tours simple style</a></li>
                    <li><a href="tour_detail.html">Tour detail page</a></li>
                    <li><a href="tour_booking.html">tour booking page</a></li>
                    <li><a href="booking_complete.html">booking complete</a></li>
                </ul>
            </li>						
            <li><a class="has-child" href="#">Pages</a>
                <ul>
                    <li><a href="about_us.html">about us style one</a></li>

                    <li><a href="services.html">services</a></li>
                    <li><a href="<?php echo base_url('contact-us'); ?>">contact us</a></li>
                </ul>
            </li>
            <li><a class="has-child" href="#">Portfolio</a>
                <ul>
                    <li><a href="portfolio_three_collumns.html">Portfolio three columns</a></li>
                    <li><a href="portfolio_four_collumns.html">portfolio four columns</a></li>
                    <li><a href="item_page.html">item page</a></li>
                    <li><a href="item_page_full_width.html">Item page full width style</a></li>
                </ul>
            </li>
            <li><a class="has-child" href="#">Blog</a>
                <ul>
                    <li><a href="blog_with_sidebar.html">Blog with sidebar</a></li>
                    <li><a href="blog_masonry.html">blog masonry style</a></li>
                    <li><a href="standart_blog_post.html">Blog post example</a></li>
                </ul>
            </li>
            <li><a class="has-child" href="#">Features</a>
                <ul>
                    <li><a href="typography.html">typography</a></li>
                    <li><a href="shortcodes.html">shortcodes</a></li>
                    <li><a href="interactive_elements.html">interactive elements</a></li>
                    <li><a href="cover_galleries.html">cover galleries</a></li>
                    <li><a href="columns.html">columns</a></li>
                </ul>
            </li>						
            <li><a href="<?php echo base_url('contact-us'); ?>">CONTACS</a></li>
        </ul>
    </nav>	
</div>
<!-- \\ mobile menu \\ -->

<div class="wrapper-padding">
    <div class="header-logo"><a href="index.html"><img alt="" src="<?php echo IMAGES_PATH; ?>/logo.png" /></a></div>
    <div class="header-right">
        <div class="hdr-srch">
            <a href="#" class="hdr-srch-btn"></a>
        </div>
        <div class="hdr-srch-overlay">
            <div class="hdr-srch-overlay-a">
                <input type="text" value="" placeholder="Start typing...">
                <a href="#" class="srch-close"></a>
                <div class="clear"></div>
            </div>
        </div>	
        <div class="hdr-srch-devider"></div>
        <a href="#" class="menu-btn"></a>
        <nav class="header-nav">
            <ul>
                <li><a href="#">Home</a>
                    <ul>
                        <li><a href="index.html">Home style one</a></li>
                        <li><a href="index_02.html">Home style two</a></li>
                        <li><a href="index_03.html">Home style three</a></li>
                        <li><a href="index_04.html">Home style four</a></li>	
                    </ul>
                </li>
                <li><a href="#">Hotels</a>
                    <ul>
                        <li><a href="hotel_list.html">Hotels standard list</a></li>
                        <li><a href="hotel_simple_style.html">Hotels simple style</a></li>
                        <li><a href="hotel_detail_style.html">Hotels detail style</a></li>
                        <li><a href="hotel_detail.html">Hotel item page</a></li>
                        <li><a href="hotel_booking.html">Hotel booking page</a></li>
                        <li><a href="booking_complete.html">booking complete page</a></li>
                    </ul>
                </li>
                <li><a href="#">Flights</a>
                    <ul>
                        <li><a href="flight_round_trip.html">Flights round trip</a></li>
                        <li><a href="flight_one_way.html">flights one way trip</a></li>
                        <li><a href="flight_alternative.html">flights alternative style</a></li>
                        <li><a href="flight_detail.html">Flights detail page</a></li>
                        <li><a href="flight_booking.html">Flights booking page</a></li>
                        <li><a href="booking_complete.html">booking complete</a></li>
                    </ul>
                </li>
                <li><a href="#">Tours</a>
                    <ul>
                        <li><a href="tour_alternative.html">Tours list style</a></li>
                        <li><a href="tour_grid.html">tours grid style</a></li>
                        <li><a href="tour_simple.html">Tours simple style</a></li>
                        <li><a href="tour_detail.html">Tour detail page</a></li>
                        <li><a href="tour_booking.html">tour booking page</a></li>
                        <li><a href="booking_complete.html">booking complete</a></li>
                    </ul>
                </li>
                <li><a href="#">Pages</a>
                    <ul>
                        <li><a href="about_us.html">about us style one</a></li>

                        <li><a href="services.html">services</a></li>
                        <li><a href="<?php echo base_url('contact-us'); ?>">contact us</a></li>
                    </ul>
                </li>
                <li><a href="#">Portfolio</a>
                    <ul>
                        <li><a href="portfolio_three_collumns.html">Portfolio three columns</a></li>
                        <li><a href="portfolio_four_collumns.html">portfolio four columns</a></li>
                        <li><a href="item_page.html">item page</a></li>
                        <li><a href="item_page_full_width.html">Item page full width style</a></li>
                    </ul>
                </li>
                <li><a href="#">Blog</a>
                    <ul>
                        <li><a href="blog_with_sidebar.html">Blog with sidebar</a></li>
                        <li><a href="blog_masonry.html">blog masonry style</a></li>
                        <li><a href="standart_blog_post.html">Blog post example</a></li>
                    </ul>
                </li>
                <li><a href="#">Features</a>
                    <ul>
                        <li><a href="typography.html">typography</a></li>
                        <li><a href="shortcodes.html">shortcodes</a></li>
                        <li><a href="interactive_elements.html">interactive elements</a></li>
                        <li><a href="cover_galleries.html">cover galleries</a></li>
                        <li><a href="columns.html">columns</a></li>
                    </ul>
                </li>
                <li><a href="<?php echo base_url('contact-us'); ?>">Contacts</a></li>
            </ul>
        </nav>
    </div>
    <div class="clear"></div>
</div>