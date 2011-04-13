<script type="text/javascript">
var Graph = {};
Graph.Data = <?php echo json_encode($eval); ?>;
</script>
<div id="accordion">
    <h3 id=""><a href="#">Score graph</a></h3>
    <div>
        <div id="score" class="content">
            <table class="alternatives">
            <?php foreach($bestAlternatives as $A) { ?>
                <tr>
                    <td><?php echo CHtml::encode($A->title); ?></td>
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
        <div id="score-sidebar" class="sidebar">
            <h4>Need some help?</h4>
            <ul>
                <li>
                    <dl>
                        <dt>About the score graph</dt>
                        <dd>Score graph shows you nominal score values for all your alternatives. Your best scored alternative is at the top, scoring 100 points. All other alternative's scores are relative to the winning alternative.</dd>
                    </dl>
                </li>
                <li>
                    <dl>
                        <dt>Top scored alternative</dt>
                        <dd>Is not necessarily the best alternative for you. If you would like to compare two or more alternatives, please use Abacon graph below.</dd>
                    </dl>
                </li>
            </ul>
        </div>
    </div>
    <h3 id="abacon-tab"><a href="#">Abacon</a></h3>
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
            <h3>Legend</h3>
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
            <ul class="legend">
                <?php $i = 0; ?>
                <?php foreach($bestAlternatives as $A) {?>
                    <li id="alternative_<?php echo $A->alternative_id; ?>"><span class="color" style="background-color: <?php echo $A->color; ?>">&nbsp;</span><?php echo CHtml::encode($A->title); ?><span class="remove">X</span></li>
                    <?php if($i == 1) break; ?>
                    <?php $i++;?>
                <?php }?>
            </ul>
            <h4>Need some help?</h4>
            <ul class="help">
                <li>
                    <dl>
                        <dt>About the abacon graph</dt>
                        <dd>Compare two or more alternatives by criteria. Alternative that scored most points and is the winning one is not necessarily the best choice for you. You should yet again think about your decision problem, compare your alternatives by criteria and then make your final decision.</dd>
                    </dl>
                </li>
            </ul>
        </div>
    </div>
    <h3><a href="#">Statistics</a></h3>
    <div>
        <div class="content">
        </div>
        <div class="sidebar">
        </div>
    </div>
</div>

