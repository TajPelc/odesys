<script type="text/javascript">
var data = <?php echo json_encode($eval); ?>;
</script>
<div id="accordion">
    <h3><a href="#">Abacon</a></h3>
    <div>
        <div id="abacon" class="content">
            <table class="criteria">
            <?php foreach($Project->criteria as $Criteria) { ?>
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
        <div class="sidebar">
            <h4>Legend</h4>
            <form method="post" action="">
                <fieldset>
                    <select name="legend">
                        <option value="option_1">option_1</option>
                        <option value="option_2">option_2</option>
                        <option value="option_3">option_3</option>
                    </select>
                    <input type="submit" name="add" value="add option" />
                </fieldset>
            </form>
            <ul>
                <li><span class="color" style="background-color: #f00">&nbsp;</span>Fiat kurac<span class="remove">X</span></li>
                <li><span class="color" style="background-color: #ef034f">&nbsp;</span>Fiat pizda<span class="remove">X</span></li>
                <li><span class="color" style="background-color: #040">&nbsp;</span>Fiat drek<span class="remove">X</span></li>
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

