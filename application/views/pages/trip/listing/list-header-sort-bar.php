<?php
$current_base_url = explode('?', current_url())[0];
?>
<div class="catalog-head fly-in">
    <label>Sort results by:</label>
    <div class="search-select">
        <select name="sort" class="sort-filter-select">
            <?php
            $sort_array = array(
                'title' => 'Title',
                'price_low' => 'Price: Low to High',
                'price_high' => 'Price High to Low',
                'duration_low' => 'Duration: Low to High',
                'duration_high' => 'Duration: High to Low',
            );

            foreach ($sort_array as $key => $value)
            {
                $selected = '';
                if (isset($_GET['sort']))
                {
                    if ($_GET['sort'] == $key)
                    {
                        $selected = 'selected="selected"';
                    }
                }
                echo '<option value="' . modify_url($current_base_url, array('sort' => $key)) . '" ' . $selected . '>' . $value . '</option>';
            }
            ?>
        </select>
    </div>
    <a href="<?php echo str_replace('/grid', '/list', current_url()); ?>" class="show-list"></a>              
    <a href="<?php echo str_replace('/list', '/grid', current_url()); ?>" class="show-thumbs chosen"></a> 
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