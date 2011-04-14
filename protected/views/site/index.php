<div id="content">
    <?php $this->pageTitle=Yii::app()->name . 'ODESYS: Online Decision Support System'; ?>
    <ol>
        <li class="current"><p>Start by signing in with Facebook and creating a new project</p></li>
        <li><p>Define alternatives among which you are choosing</p></li>
        <li><p>Define criteria and order them from most to least important</p></li>
        <li><p>Evalute each alternative by the defined criteria</p></li>
        <li><p>Analyse the results using our graphical method</p></li>
        <li><p>Make a better decision</p></li>
    </ol>
    <dl>
        <dt><em>What is it?</em></dt>
        <dd>ODESYS is a simple online decision support system (<a href="http://en.wikipedia.org/wiki/Decision_support_system" title="Decision Support System">DSS</a>) with a friendly graphical user interface.</dd>
        <dt>How does it work?</dt>
        <dd>It seamlessly guides you through the process of creating a decision model, the evaluation of alternatives and results analysis. Armed with new knowledge the hard part is still up to you. Making a choice.</dd>
        <dt>What may I use it for?</dt>
        <dd>A wide variety of decision problems. A basic understanding of <a href="http://en.wikipedia.org/wiki/Decision_theory" title="Decision making">decision theory</a> is wanted, but not required. Try it out!</dd>
    </dl>
</div>
<div id="sidebar">
    <ul>
        <li class="show">
            <img src="/images/pictures/introduction_1.png" title=""  alt="pic1" />
        </li>
        <li>
            <img src="/images/pictures/introduction_3.png" title=""  alt="pic3" />
        </li>
        <li>
            <img src="/images/pictures/introduction_2.png" title=""  alt="pic2" />
        </li>
        <li>
            <img src="/images/pictures/introduction_4.png" title=""  alt="pic1" />
        </li>
            <li>
            <img src="/images/pictures/introduction_5.png" title=""  alt="pic2" />
        </li>
        <li>
            <img src="/images/pictures/introduction_6.png" title=""  alt="pic3" />
        </li>
    </ul>
    <script src="http://widgets.twimg.com/j/2/widget.js"></script>
    <script>
    new TWTR.Widget({
      version: 2,
      type: 'profile',
      rpp: 3,
      interval: 6000,
      width: 444,
      height: 182,
      theme: {
        shell: {
          background: '#dedfe3',
          color: '#444a56'
        },
        tweets: {
          background: '#ffffff',
          color: '#444a56',
          links: '#000000'
        }
      },
      features: {
        scrollbar: false,
        loop: false,
        live: true,
        hashtags: true,
        timestamp: true,
        avatars: false,
        behavior: 'all'
      }
    }).render().setUser('ODESYSinfo').start();
    </script>
</div>