<?php
$current_base_url = explode('?', current_url())[0];
?>
<div class="catalog-head fly-in">
    <label>Sort results by:</label>
    <div class="search-select">
        <select name="sort" class="sort-filter-select">
            <option value="<?php echo modify_url($current_base_url, array('sort' => 'title')); ?>">Title</option>
            <option value="<?php echo modify_url($current_base_url, array('sort' => 'price_low')); ?>">Price: Low to High</option>
            <option value="<?php echo modify_url($current_base_url, array('sort' => 'price_high')); ?>">Price High to Low</option>
            <option value="<?php echo modify_url($current_base_url, array('sort' => 'duration_low')); ?>">Duration: Low to High</option>
            <option value="<?php echo modify_url($current_base_url, array('sort' => 'duration_high')); ?>">Duration: High to Low</option>
        </select>
    </div>
    <a href="#" class="show-list"></a>              
    <a class="show-thumbs chosen" href="#"></a> 
    <div class="clear"></div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('.sort-filter-select').change(function () {
            var sort_url = $(this).val();
            window.location.href = sort_url;
        });
    });
</script>