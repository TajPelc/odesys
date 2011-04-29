<?php $this->pageTitle='Buying a car'; ?>
<div id="heading">
    <h2><?php echo CHtml::encode($this->Decision->title); ?></h2>
</div>
<?php if($this->DecisionModel instanceof DecisionModel) { ?>
<script type="text/javascript">
var Graph = {};
Graph.Data = <?php echo json_encode($eval); ?>;
</script>
<div id="content">
    <h2>About the decision</h2>
    <div id="about">
        <ul class="comments small">
            <li>
                <?php echo CHtml::image('https://graph.facebook.com/' . $this->Decision->User->facebook_id . '/picture?type=large');?>
                <div>
                    <span class="author">Frenk Ten Sedmak Nahtigal says:</span>
                    <span class="timestamp">April 5th, 18:13</span>
                    <p><?php echo nl2br(CHtml::encode($this->Decision->description)); ?></p>
                    <span class="last">&nbsp;</span>
                </div>
            </li>
        </ul>
    </div>

    <h2>Score for alternatives</h2>
    <div id="score">
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

    <div id="abacon">
    </div>

    <h2>Opinions and comments</h2>
    <div id="opinions">
        <ul class="comments">
            <li class="new">
                <img src="https://graph.facebook.com/1362051067/picture" title="" alt="" />
                <div>
                    <form method="post" action="">
                        <fieldset>
                            <label class="author" for="comment_new">Share your opinion:</label>
                            <textarea name="comment_new" id="comment_new" rows="5" cols="63"></textarea>
                            <input type="submit" name="comment_save" value="Share" />
                        </fieldset>
                    </form>
                    <span class="last">&nbsp;</span>
                </div>
            </li>
            <li>
                <img src="https://graph.facebook.com/1362051067/picture" title="" alt="" />
                <div>
                    <span class="author">Frenk Ten Sedmak Nahtigal says:</span>
                    <span class="timestamp">April 5th, 18:13</span>
                    <p>U resnic u pičko zafukana odločitev. Pizda kurac drek, kako se zdej odločit? Hondica je res kr prikladna, ampak je cena pa stroški vzdrževanja mal previsoka.
                    <br /><br />A se mi splača stegnt za petardo, al bo ena Mazdica u resnic več kot dovolj dobra?</p>
                    <span class="last">&nbsp;</span>
                </div>
            </li>
        </ul>
        <a href="#" id="comments_more">Show more opinions</a>
    </div>
</div>
<div id="sidebar">
    <div class="help">
        <h4>Share on:</h4>
        <ul id="sns">
            <li><a id="share_facebook" href="#">Facebook</a></li>
            <li><a id="share_twitter" href="#">Twitter</a></li>
            <li><a id="share_digg" href="#">Digg</a></li>
            <li><a id="share_reddit" href="#">Reddit</a></li>
            <li><a id="share_stumbleupon" href="#">StumbleUpon</a></li>
        </ul>
        <div class="last"></div>
    </div>
    <div class="help">
        <h4>Decision overview:</h4>
        <ul class="do">
            <li><span>No. alternatives</span><em><?php echo $this->DecisionModel->no_alternatives; ?></em></li>
            <li><span>No. criteria</span><em><?php echo $this->DecisionModel->no_criteria; ?></em></li>
            <li><span>No. opinions</span><em><?php // echo $this->DecisionModel->no_opinions; ?>Meny</em></li>
        </ul>
        <div class="last"></div>
    </div>
    <div class="help">
        <h4>Best scored alternative:</h4>
        <p class="l"><b><?php echo CHtml::encode($first->title);?> by <?php echo $difference; ?>%</b></p>
        <div class="last"></div>
    </div>
    <div class="help">
        <h4>Frenk Ten prefers</h4>
        <p><b>Mazda MX-5 2.0 Revolution</b></p>
        <h4>out of</h4>
        <p>Honda S2000, Mazda MX-5, Fiat Barchetta, Golf MK II Cabrio, MG Roadster</p>
        <h4>when considering</h4>
        <p>Price, Acceleration, Looks, Top Speed, Fun factor, Running costs</p>
        <div class="last"></div>
    </div>
</div>
<?php } else { ?>
<div id="content">
    <h2>This decision is not yet published.</h2>
    <p>Please wait until the owner finishes building the decision model.</p>
</div>
<?php }?>