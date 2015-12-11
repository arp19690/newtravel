<?php
$user_fullname = $record['user_fullname'];
?>
<div class="main-cont">
    <div class="inner-page">
        <div class="inner-breadcrumbs">
            <div class="content-wrapper">
                <div class="page-title"><?php echo $user_fullname; ?></div>
                <div class="breadcrumbs">
                    <a href="<?php echo base_url(); ?>">Home</a> / <span><?php echo $user_fullname; ?></span>
                </div>
                <div class="clear"></div>
            </div>		
        </div>

        <div class="about-content">

            <div class="about-us-devider fly-in"></div>

            <div class="counters fly-in">
                <div class="content-wrapper">
                    <!-- // -->
                    <div class="counters-i">
                        <b class="numscroller" data-slno='1' data-min='0' data-max='4560' data-delay='3' data-increment="15">0</b>
                        <span>tours</span>
                    </div>
                    <!-- \\ -->
                    <!-- // -->
                    <div class="counters-i">
                        <b class="numscroller" data-slno='1' data-min='0' data-max='190' data-delay='3' data-increment="2">0</b>
                        <span>happy clients</span>
                    </div>
                    <!-- \\ -->
                    <!-- // -->
                    <div class="counters-i">
                        <b class="numscroller" data-slno='1' data-min='0' data-max='842' data-delay='2' data-increment="3">0</b>
                        <span>holes reviews</span>
                    </div>
                    <!-- \\ -->
                    <!-- // -->
                    <div class="counters-i">
                        <b class="numscroller" data-slno='1' data-min='0' data-max='98' data-delay='3' data-increment="2">0</b>
                        <span>company offices</span>
                    </div>
                    <!-- \\ -->
                    <!-- // -->
                    <div class="counters-i">
                        <b class="numscroller" data-slno='1' data-min='0' data-max='452' data-delay='3' data-increment="2">0</b>
                        <span>awwards win</span>
                    </div>
                    <!-- \\ -->
                </div>
                <div class="clear"></div>
            </div>
            
            
            <div class="about-us-devider fly-in"></div>
            
            
            
            <div class="content-wrapper">
                <header class="page-lbl fly-in">
                    <div class="offer-slider-lbl"><?php echo $user_fullname; ?></div>
                    <p><?php echo stripslashes($record['user_tagline']); ?></p>
                </header>			
                <div class="tree-colls fly-in">
                    <div class="tree-colls-i about-text">
                        <p><span class="paragraph">Q</span>erspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque lauda erspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et</p>
                    </div>
                    <div class="tree-colls-i about-text">
                        <p>doloremque laudantium, totam rem. Aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta. sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur.</p>
                    </div>
                    <div class="tree-colls-i about-text">
                        <div class="about-percent">
                            <label>tours - 87%</label>
                            <div data-percentage="87" class="about-percent-a"><span></span></div>
                        </div>
                        <div class="about-percent">
                            <label>work with clients - 47%</label>
                            <div data-percentage="47" class="about-percent-a"><span></span></div>
                        </div>
                        <div class="about-percent">
                            <label>hotels - 70%</label>
                            <div data-percentage="70" class="about-percent-a"><span></span></div>
                        </div>
                    </div>
                </div>
                <div class="clear"></div>
            </div>

            <div class="about-us-devider fly-in"></div>

            <div class="counters fly-in">
                <div class="content-wrapper">
                    <!-- // -->
                    <div class="counters-i">
                        <b class="numscroller" data-slno='1' data-min='0' data-max='4560' data-delay='3' data-increment="15">0</b>
                        <span>tours</span>
                    </div>
                    <!-- \\ -->
                    <!-- // -->
                    <div class="counters-i">
                        <b class="numscroller" data-slno='1' data-min='0' data-max='190' data-delay='3' data-increment="2">0</b>
                        <span>happy clients</span>
                    </div>
                    <!-- \\ -->
                    <!-- // -->
                    <div class="counters-i">
                        <b class="numscroller" data-slno='1' data-min='0' data-max='842' data-delay='2' data-increment="3">0</b>
                        <span>holes reviews</span>
                    </div>
                    <!-- \\ -->
                    <!-- // -->
                    <div class="counters-i">
                        <b class="numscroller" data-slno='1' data-min='0' data-max='98' data-delay='3' data-increment="2">0</b>
                        <span>company offices</span>
                    </div>
                    <!-- \\ -->
                    <!-- // -->
                    <div class="counters-i">
                        <b class="numscroller" data-slno='1' data-min='0' data-max='452' data-delay='3' data-increment="2">0</b>
                        <span>awwards win</span>
                    </div>
                    <!-- \\ -->
                </div>
                <div class="clear"></div>
            </div>

        </div>
    </div>
</div>
<script src="<?php echo JS_PATH; ?>/numscroller-1.0.js"></script>