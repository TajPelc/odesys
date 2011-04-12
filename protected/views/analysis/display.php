<script type="text/javascript">
Abacon.Data = <?php echo json_encode($eval); ?>;
</script>
<div id="accordion">
    <h3><a href="#">Abacon</a></h3>
    <div>
        <div id="abacon" class="content">
            <table class="criteria">
            <?php foreach($Project->findCriteriaByPriority() as $Criteria) { ?>
                <tr>
                    <td><?php echo CHtml::encode($Criteria->title); ?></td>
                </tr>
            <?php }?>
            </table>
            <table class="scale">
                <tr>
                    <td>0</td>
                    <td>10</td>
                    <td>20</td>
                    <td>30</td>
                    <td>40</td>
                    <td>50</td>
                    <td>60</td>
                    <td>70</td>
                    <td>80</td>
                    <td>90</td>
                    <td>100</td>
                </tr>
            </table>
        </div>
        <div id="abacon-sidebar" class="sidebar">
            <h4>Legend</h4>
            <form method="post" action="">
                <fieldset>
                    <select name="legend">
                        <?php foreach($Alternatives as $A) { ?>
                            <option value="<?php echo $A->alternative_id; ?>"><?php echo CHtml::encode($A->title); ?></option>
                        <?php }?>
                    </select>
                    <a class="selectBox selectBox-dropdown" style="display: inline-block; width: 232px; -moz-user-select: none;" title="" tabindex="0">
                        <span class="selectBox-label">Draw more alternatives</span>
                        <span class="selectBox-arrow"></span>
                    </a>
                </fieldset>
            </form>
            <ul>
                <?php foreach($bestAlternatives as $A) {?>
                    <li id="alternative_<?php echo $A->alternative_id; ?>"><span class="color" style="background-color: <?php echo $A->color; ?>">&nbsp;</span><?php echo CHtml::encode($A->title); ?><span class="remove">X</span></li>
                <?php }?>
            </ul>
        </div>
    </div>
    <h3><a href="#">Pie chart</a></h3>
    <div>
        <div class="content">
            <p>Here be another graph...</p>
        </div>
        <div class="sidebar">
            <p>and sidebar..</p>
        </div>
    </div>
    <h3><a href="#">Alternative analysis</a></h3>
    <div>
        <div class="content">
            <p>Here be another graph...</p>
        </div>
        <div class="sidebar">
            <p>and sidebar..</p>
        </div>
    </div>
    <h3><a href="#">Statistics</a></h3>
    <div>
        <div class="content">
            <p>Here be another graph...</p>
        </div>
        <div class="sidebar">
            <p>and sidebar..</p>
        </div>
    </div>
</div>

