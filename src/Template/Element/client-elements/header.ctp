<div class="row">
    <?php
    if(isset($_SERVER['MAINTENANCE']) && $_SERVER['MAINTENANCE'] == 1){
        ?>
        <div style="width:100%;background: #C2C2C2;line-height: 25px;text-align: center;margin-bottom: 25px"><i class="fa fa-wrench"></i>  We are under maintenance. Thank you for your patience.</div>
    <?php
    }
    ?>
    <div class="col-12 profile-wrap">
            <?= $this->element('client-elements/my-profile');?>
    </div>
</div>




