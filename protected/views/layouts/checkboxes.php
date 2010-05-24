<?php $this->beginContent('application.views.layouts.main'); ?>
<div class="container">
    <div class="span-19">
        <div id="content">
            <?php echo $content; ?>
        </div><!-- content -->
    </div>
    <div class="span-5 last">
        <div id="sidebar">
            <form action="post" id="seriesPicker">
            <?php for($i=0; $i < count($this->menu); $i++) { ?>
                <input type="checkbox" name="series<?php echo $i; ?>" id="series<?php echo $i; ?>" <?php if($i < 2){ ?>checked="checked"<?php }?> value="<?php echo $this->menu[$i-1]['label']; ?>">
                <label for="series<?php echo $i; ?>"><?php echo $this->menu[$i]['label']; ?></label>
                <br />
            <?php }?>
            </form>
        </div><!-- sidebar -->
    </div>
</div>
<?php $this->endContent(); ?>