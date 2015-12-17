<!-- // authorize // -->
<div class="autorize-popup">
    <div class="autorize-tabs">
        <a href="#" class="autorize-tab-a current">Login</a>
        <a href="#" class="autorize-tab-b">Register</a>
        <a href="#" class="autorize-close"></a>
        <div class="clear"></div>
    </div>
    <section class="autorize-tab-content">
        <div class="autorize-padding">
            <form action="<?php echo base_url('login?next=' . current_url()); ?>" method="POST">
                <h6 class="autorize-lbl">Welcome! Login to Your Account</h6>
                <input type="email" name="user_email" required="required" placeholder="Email"/>
                <input type="password" name="user_password" required="required" placeholder="Password"/>
                <footer class="autorize-bottom">
                    <button class="authorize-btn">Login</button>
                    <a href="<?php echo base_url('forgot-password'); ?>" class="authorize-forget-pass">Forgot your password?</a>
                    <div class="clear"></div>
                </footer>
            </form>
        </div>
    </section>
    <section class="autorize-tab-content">
        <div class="autorize-padding">
            <h6 class="autorize-lbl">Register for Your Account</h6>
            <input type="email" name="user_email" required="required" placeholder="Email"/>
            <input type="password" name="user_password" required="required" placeholder="Password"/>
            <footer class="autorize-bottom">
                <button class="authorize-btn">Register</button>
                <div class="clear"></div>
            </footer>
        </div>
    </section>
</div>
<!-- \\ authorize \\-->