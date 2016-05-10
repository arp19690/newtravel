<?php
$redis_functions = new Redisfunctions();
$trip_faqs = $redis_functions->get_trip_faqs();
?>
<!-- // content-tabs-i // -->
<div class="content-tabs-i">
    <h2>FAQ</h2>
    <p class="small">Most frequently asked questions by backpackers about trips posted on our platform.</p>
    <div class="todo-devider"></div>
    <div class="faq-row">
        <?php
        foreach ($trip_faqs as $value)
        {
            ?>
            <!-- // -->
            <div class="faq-item">
                <div class="faq-item-a">
                    <span class="faq-item-left"><?php echo stripslashes($value->faq_question); ?></span>
                    <span class="faq-item-i"></span>
                    <div class="clear"></div>
                </div>
                <div class="faq-item-b">
                    <div class="faq-item-p"><?php echo stripslashes($value->faq_answer); ?></div>
                </div>
            </div>
            <!-- \\ -->
            <?php
        }
        ?>
    </div>
</div>
<!-- \\ content-tabs-i \\ -->