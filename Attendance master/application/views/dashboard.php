<?php
if (!$isAjax) {
    echo '<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="content">';
}
?>
<h1 class="page-header">Dashboard</h1>

<!--          <div class="row placeholders">
            <div class="col-xs-6 col-sm-3 placeholder">
              <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAMgAAADICAYAAACtWK6eAAADIklEQVR4nO3YsU0jQQBAURqgJRdEM06owT1AD1SAReCMyBEJyVxwWrNY5oMxPkD3VnoSMKwHofnjWV9cLu8HcNjFd/8B8JMJBIJAIAgEgkAgCASCQCAIBIJAIAgEgkAgCASCQCAIBIJAIAgEgkAgCASCQCAIBIJAIAgEgkAgCASCQCAIBIJAIAgEgkAgCASCQCAIBIJAIAgEgkAgCASCQCAIBIJAIAgEgkAgCASCQCAIBIJAIAgEgkAgCASCQCAIBIJAIAgEgkAgCASCQCAIBIJAIAgEgkAgCASCQCAIBIJAIAgEgkAgCASCQCAIBIJAIAgEgkAgCASCQCAIBIJAIAgEgkAgCASCQCAIBIJAIAgEgkAgCASCQCAIBIJAIAgEgkAgCASCQCAIBIJAIAjkSDcPT2N+Xd0+7sYWq82rsfl9NfYT5+QvgRzh+m77aoFOC3ex2ozL5f1Yb5/HzcPT7uv19nl3b439tDl5IZATXN0+jjHGuL7b7nbr67vtuFy+LOzFapNjv2HO/5lATjDf3aeFO+308+9rbH4Mml53vX1+czF/xZzf/X/7TQRygvnC3j8KzXf6Gpvfe+h3zzUnHyOQT5qeBaYFeOpind41xhi754Zzz8n7BPIJ8x1/+tmpx535UauOVl85J+8TyJGmhba/y791bFqsNjk23T/GePUu8i/m5H0COVLt8p/9yHX+0e2hGM4xJx8jkCNMu/D+NT/2zK/9+w+NHQpi/qxxjjn5OIFAEAgEgUAQCASBQBAIBIFAEAgEgUAQCASBQBAIBIFAEAgEgUAQCASBQBAIBIFAEAgEgUAQCASBQBAIBIFAEAgEgUAQCASBQBAIBIFAEAgEgUAQCASBQBAIBIFAEAgEgUAQCASBQBAIBIFAEAgEgUAQCASBQBAIBIFAEAgEgUAQCASBQBAIBIFAEAgEgUAQCASBQBAIBIFAEAgEgUAQCASBQBAIBIFAEAgEgUAQCASBQBAIBIFAEAgEgUAQCASBQBAIBIFAEAgEgUAQCASBQBAIBIFAEAgEgUAQCASBQBAIBIFAEAgEgUAQCASBQBAIhD8Gye8PBCUocAAAAABJRU5ErkJggg==" data-src="holder.js/200x200/auto/sky" class="img-responsive" alt="200x200">
              <h4>Label</h4>
              <span class="text-muted">Something else</span>
            </div>
            <div class="col-xs-6 col-sm-3 placeholder">
              <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAMgAAADICAYAAACtWK6eAAADLUlEQVR4nO3ZsVEqQQCAYSshMZEZDAwILMDMEizBwCYMLIECzCyCPizmXvDm8HTwR0SeOu8LvhlxOdZx9l/24OTy+WkAtjv57j8AfjKBQBAIBIFAEAgEgUAQCASBQBAIBIFAEAgEgUAQCASBQBAIBIFAEAgEgUAQCASBQBAIBIFAEAgEgUAQCASBQBAIBIFAEAgEgUAQCASBQBAIBIFAEAgEgUAQCASBQBAIBIFAEAgEgUAQCASBQBAIBIFAEAgEgUAQCASBQBAIBIFAEAgEgUAQCASBQBAIBIFAEAgEgUAQCASBQBAIBIFAEAgEgUAQCASBQBAIBIFAEAgEgUAQCASBQBAIBIFAEAgEgUAQCASBQBAIBIFAEAgEgUAQCASBQBAIBIFAEAgEgUAQCASBQBAIBIHs6ez2ZpjNFxsXj/ebseV69Wpsel2N/cQ5+Usgezh/uHu1QMeFu1yvhsvnp+H0+mo4u73Z/Hx6fbW5tsZ+2py8EMgBLh7vh9l8MZw/3G126/OHu+Hy+WVhL9erHPsNc/7PBHKA6e4+Ltxxp58+rrHpMWh83dPrq3cX81fM+d3/t99EIAeYLuy3R6HpTl9j02u3PfdYc/IxAvmk8V5gXICHLtbxXWM2X2zuG449J7sJ5BOmO/74u0OPO9OjVh2tvnJOdhPInsaF9naXf+/YtFyvcmy8fjZfvHoX+RdzsptA9lS7/Gc/cp1+dLsthmPMyccIZA/jLvzW9NhTX8xtG9sWxPRe4xhz8nECgSAQCAKBIBAIAoEgEAgCgSAQCAKBIBAIAoEgEAgCgSAQCAKBIBAIAoEgEAgCgSAQCAKBIBAIAoEgEAgCgSAQCAKBIBAIAoEgEAgCgSAQCAKBIBAIAoEgEAgCgSAQCAKBIBAIAoEgEAgCgSAQCAKBIBAIAoEgEAgCgSAQCAKBIBAIAoEgEAgCgSAQCAKBIBAIAoEgEAgCgSAQCAKBIBAIAoEgEAgCgSAQCAKBIBAIAoEgEAgCgSAQCAKBIBAIAoEgEAgCgSAQCAKBIBAIAoEgEAgCgSAQCAKBIBAIAoEgEAgCgSAQCAKBIBAIAoEgEAh/AHb+Hmvg5kffAAAAAElFTkSuQmCC" data-src="holder.js/200x200/auto/vine" class="img-responsive" alt="200x200">
              <h4>Label</h4>
              <span class="text-muted">Something else</span>
            </div>
            <div class="col-xs-6 col-sm-3 placeholder">
              <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAMgAAADICAYAAACtWK6eAAADIklEQVR4nO3YsU0jQQBAURqgJRdEM06owT1AD1SAReCMyBEJyVxwWrNY5oMxPkD3VnoSMKwHofnjWV9cLu8HcNjFd/8B8JMJBIJAIAgEgkAgCASCQCAIBIJAIAgEgkAgCASCQCAIBIJAIAgEgkAgCASCQCAIBIJAIAgEgkAgCASCQCAIBIJAIAgEgkAgCASCQCAIBIJAIAgEgkAgCASCQCAIBIJAIAgEgkAgCASCQCAIBIJAIAgEgkAgCASCQCAIBIJAIAgEgkAgCASCQCAIBIJAIAgEgkAgCASCQCAIBIJAIAgEgkAgCASCQCAIBIJAIAgEgkAgCASCQCAIBIJAIAgEgkAgCASCQCAIBIJAIAgEgkAgCASCQCAIBIJAIAgEgkAgCASCQCAIBIJAIAjkSDcPT2N+Xd0+7sYWq82rsfl9NfYT5+QvgRzh+m77aoFOC3ex2ozL5f1Yb5/HzcPT7uv19nl3b439tDl5IZATXN0+jjHGuL7b7nbr67vtuFy+LOzFapNjv2HO/5lATjDf3aeFO+308+9rbH4Mml53vX1+czF/xZzf/X/7TQRygvnC3j8KzXf6Gpvfe+h3zzUnHyOQT5qeBaYFeOpind41xhi754Zzz8n7BPIJ8x1/+tmpx535UauOVl85J+8TyJGmhba/y791bFqsNjk23T/GePUu8i/m5H0COVLt8p/9yHX+0e2hGM4xJx8jkCNMu/D+NT/2zK/9+w+NHQpi/qxxjjn5OIFAEAgEgUAQCASBQBAIBIFAEAgEgUAQCASBQBAIBIFAEAgEgUAQCASBQBAIBIFAEAgEgUAQCASBQBAIBIFAEAgEgUAQCASBQBAIBIFAEAgEgUAQCASBQBAIBIFAEAgEgUAQCASBQBAIBIFAEAgEgUAQCASBQBAIBIFAEAgEgUAQCASBQBAIBIFAEAgEgUAQCASBQBAIBIFAEAgEgUAQCASBQBAIBIFAEAgEgUAQCASBQBAIBIFAEAgEgUAQCASBQBAIBIFAEAgEgUAQCASBQBAIBIFAEAgEgUAQCASBQBAIBIFAEAgEgUAQCASBQBAIhD8Gye8PBCUocAAAAABJRU5ErkJggg==" data-src="holder.js/200x200/auto/sky" class="img-responsive" alt="200x200">
              <h4>Label</h4>
              <span class="text-muted">Something else</span>
            </div>
            <div class="col-xs-6 col-sm-3 placeholder">
              <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAMgAAADICAYAAACtWK6eAAADLUlEQVR4nO3ZsVEqQQCAYSshMZEZDAwILMDMEizBwCYMLIECzCyCPizmXvDm8HTwR0SeOu8LvhlxOdZx9l/24OTy+WkAtjv57j8AfjKBQBAIBIFAEAgEgUAQCASBQBAIBIFAEAgEgUAQCASBQBAIBIFAEAgEgUAQCASBQBAIBIFAEAgEgUAQCASBQBAIBIFAEAgEgUAQCASBQBAIBIFAEAgEgUAQCASBQBAIBIFAEAgEgUAQCASBQBAIBIFAEAgEgUAQCASBQBAIBIFAEAgEgUAQCASBQBAIBIFAEAgEgUAQCASBQBAIBIFAEAgEgUAQCASBQBAIBIFAEAgEgUAQCASBQBAIBIFAEAgEgUAQCASBQBAIBIFAEAgEgUAQCASBQBAIBIFAEAgEgUAQCASBQBAIBIHs6ez2ZpjNFxsXj/ebseV69Wpsel2N/cQ5+Usgezh/uHu1QMeFu1yvhsvnp+H0+mo4u73Z/Hx6fbW5tsZ+2py8EMgBLh7vh9l8MZw/3G126/OHu+Hy+WVhL9erHPsNc/7PBHKA6e4+Ltxxp58+rrHpMWh83dPrq3cX81fM+d3/t99EIAeYLuy3R6HpTl9j02u3PfdYc/IxAvmk8V5gXICHLtbxXWM2X2zuG449J7sJ5BOmO/74u0OPO9OjVh2tvnJOdhPInsaF9naXf+/YtFyvcmy8fjZfvHoX+RdzsptA9lS7/Gc/cp1+dLsthmPMyccIZA/jLvzW9NhTX8xtG9sWxPRe4xhz8nECgSAQCAKBIBAIAoEgEAgCgSAQCAKBIBAIAoEgEAgCgSAQCAKBIBAIAoEgEAgCgSAQCAKBIBAIAoEgEAgCgSAQCAKBIBAIAoEgEAgCgSAQCAKBIBAIAoEgEAgCgSAQCAKBIBAIAoEgEAgCgSAQCAKBIBAIAoEgEAgCgSAQCAKBIBAIAoEgEAgCgSAQCAKBIBAIAoEgEAgCgSAQCAKBIBAIAoEgEAgCgSAQCAKBIBAIAoEgEAgCgSAQCAKBIBAIAoEgEAgCgSAQCAKBIBAIAoEgEAgCgSAQCAKBIBAIAoEgEAgCgSAQCAKBIBAIAoEgEAh/AHb+Hmvg5kffAAAAAElFTkSuQmCC" data-src="holder.js/200x200/auto/vine" class="img-responsive" alt="200x200">
              <h4>Label</h4>
              <span class="text-muted">Something else</span>
            </div>
          </div>-->

<!--<h2 class="sub-header">Section title</h2>-->
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Header</th>
                <th>Header</th>
                <th>Header</th>
                <th>Header</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1,001</td>
                <td>Lorem</td>
                <td>ipsum</td>
                <td>dolor</td>
                <td>sit</td>
            </tr>
            <tr>
                <td>1,002</td>
                <td>amet</td>
                <td>consectetur</td>
                <td>adipiscing</td>
                <td>elit</td>
            </tr>
            <tr>
                <td>1,003</td>
                <td>Integer</td>
                <td>nec</td>
                <td>odio</td>
                <td>Praesent</td>
            </tr>
            <tr>
                <td>1,003</td>
                <td>libero</td>
                <td>Sed</td>
                <td>cursus</td>
                <td>ante</td>
            </tr>
            <tr>
                <td>1,004</td>
                <td>dapibus</td>
                <td>diam</td>
                <td>Sed</td>
                <td>nisi</td>
            </tr>
            <tr>
                <td>1,005</td>
                <td>Nulla</td>
                <td>quis</td>
                <td>sem</td>
                <td>at</td>
            </tr>
            <tr>
                <td>1,006</td>
                <td>nibh</td>
                <td>elementum</td>
                <td>imperdiet</td>
                <td>Duis</td>
            </tr>
            <tr>
                <td>1,007</td>
                <td>sagittis</td>
                <td>ipsum</td>
                <td>Praesent</td>
                <td>mauris</td>
            </tr>
            <tr>
                <td>1,008</td>
                <td>Fusce</td>
                <td>nec</td>
                <td>tellus</td>
                <td>sed</td>
            </tr>
            <tr>
                <td>1,009</td>
                <td>augue</td>
                <td>semper</td>
                <td>porta</td>
                <td>Mauris</td>
            </tr>
            <tr>
                <td>1,010</td>
                <td>massa</td>
                <td>Vestibulum</td>
                <td>lacinia</td>
                <td>arcu</td>
            </tr>
            <tr>
                <td>1,011</td>
                <td>eget</td>
                <td>nulla</td>
                <td>Class</td>
                <td>aptent</td>
            </tr>
            <tr>
                <td>1,012</td>
                <td>taciti</td>
                <td>sociosqu</td>
                <td>ad</td>
                <td>litora</td>
            </tr>
            <tr>
                <td>1,013</td>
                <td>torquent</td>
                <td>per</td>
                <td>conubia</td>
                <td>nostra</td>
            </tr>
            <tr>
                <td>1,014</td>
                <td>per</td>
                <td>inceptos</td>
                <td>himenaeos</td>
                <td>Curabitur</td>
            </tr>
            <tr>
                <td>1,015</td>
                <td>sodales</td>
                <td>ligula</td>
                <td>in</td>
                <td>libero</td>
            </tr>
        </tbody>
    </table>
</div>
<script type="text/javascript">
    $wl = jQuery.noConflict();
    $wl(document).ready(function(){
        $wl('#content').show();
        $wl('div #img-loader img').remove();
   });
</script>
<?php
if (!$isAjax) {
    ?>
    </div>
    </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?php echo base_url('assets/js/bootstrap.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/docs.js'); ?>"></script>


    </body>
    </html>
    <?php
}
?>