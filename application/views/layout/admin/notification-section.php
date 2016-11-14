<?php
if ($this->session->flashdata('success'))
{
    ?>
    <div class="alert alert-success alert-styled-left">
        <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
        <?php echo $this->session->flashdata('success'); ?>
    </div>
    <?php
}

if ($this->session->flashdata('warning'))
{
    ?>
    <div class="alert alert-warning alert-styled-left">
        <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
        <?php echo $this->session->flashdata('warning'); ?>
    </div>
    <?php
}

if ($this->session->flashdata('error'))
{
    ?>
    <div class="alert alert-danger alert-styled-left">
        <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
        <?php echo $this->session->flashdata('error'); ?>
    </div>
    <?php
}