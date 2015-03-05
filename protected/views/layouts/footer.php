<div class="footer <? if (Yii::app()->request->url == '/contact') echo 'dark-footer'; ?>">
  <div class="row">
    <div class="col-sm-5 hidden-xs">
      <p class="pull-left condition">
        <i class="ico-pay ico-visa" data-toggle="tooltip" title="<?=Yii::t('app','Accept Visa card')?>"></i><i class="ico-pay ico-mc" data-toggle="tooltip" title="<?=Yii::t('app','Accept MasterCard Cards')?>"></i><i class="ico-pay ico-cash" data-toggle="tooltip" title="<?=Yii::t('app','Accept cash')?>"></i><span class="weinsoc hidden-sm"><em>&mdash;</em><?=Yii::t('app','PAYMENT METHODS')?></span>
      </p>
    </div>
    <div class="col-xs-12 visible-xs">
      <p class="text-center">
        <a class="btn-soc" target="_blank" href="https://www.facebook.com/cityquestru"><i class="ico-soc ico-fb"></i></a>
        <a class="btn-soc" target="_blank" href="http://vk.com/cityquestru"><i class="ico-soc ico-vk"></i></a>
      </p>
    </div>
    <div class="col-sm-2 col-xs-12">
      <p class="text-center">
        <span class="copy">&copy; 2014-2015 <strong>CITYQUEST</strong></span>
        <a href="/press_about_us" class="about_us"><?=Yii::t('app','PRESS ABOUT US')?></a>
      </p>
    </div>
    <div class="col-sm-5 col-xs-12 hidden-xs">
      <p class="pull-right right-soc">
        <span class="weinsoc hidden-sm"><?=Yii::t('app','we are in social networks')?><em>&mdash;</em></span>
        <a class="btn-soc" target="_blank" href="https://www.facebook.com/cityquestru"><i class="ico-soc ico-fb"></i></a>
        <a class="btn-soc" href="http://vk.com/cityquestru" target="_blank"><i class="ico-soc ico-vk"></i></a>
      </p>
    </div>
  </div>
</div>

<div aria-hidden="true" aria-labelledby="myModalMenuLabel" class="modal fade" id="myModalMenu" role="dialog" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header text-center">
        <button class="close" data-dismiss="modal" type="button"><span aria-hidden="true"> &times;</span><span class="sr-only">Close</span></button>
      </div>
      <div class="modal-body">
        <div class="row right-nav-btn">
          <div class="col-xs-6" id="for-select-city"></div>
          <div class="col-xs-6" id="for-login"></div>
        </div>
        <div class="row">
          <div class="col-xs-12" id="for-menu"></div>
        </div>
      </div>
    </div>
  </div>
</div>

<? if (Yii::app()->user->isGuest) { ?>
  <div aria-hidden="true" aria-labelledby="myModalLabelAuth" class="modal fade" id="myModalAuth" role="dialog" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button class="visible-xs close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
          <a class="h4 modal-title active" data-toggle="tab" href="#auth" id="auth-tab" role="tab"><?=Yii::t('app','Sign in')?></a>
          <a class="h4 modal-title" data-toggle="tab" href="#reg" role="tab"><?=Yii::t('app','Check In')?></a>
          <hr class="fadeOut">
        </div>
        <div class="modal-body">
          <div class="row social_auth">
            <div class="col-xs-6 text-right">
              <a class="vk" href="https://oauth.vk.com/authorize?client_id=4659293&scope=uid,first_name,last_name,sex,bdate,email&redirect_uri=http://<?=$_SERVER['SERVER_NAME']; ?>/user/login/vkauth&response_type=code"></a>
            </div>
            <div class="col-xs-6 text-left">
              <? if ($_SERVER['HTTP_HOST'] != 'cq.il' && $_SERVER['HTTP_HOST'] != 'cq.kzil') { ?>
                <script>
                  function statusChangeCallback(response) {
                    if (response.status === 'connected' && $.cookie("logout") != 1) goAuth();
                  }

                  function checkLoginState() {
                    FB.getLoginStatus(function(response) {
                      statusChangeCallback(response);
                    });
                  }

                  window.fbAsyncInit = function() {
                    FB.init({
                      appId      : '748253021885085',
                      cookie     : true,
                      xfbml      : true,
                      version    : 'v2.1'
                    });

                    FB.getLoginStatus(function(response) {
                      statusChangeCallback(response);
                    });

                  };

                  (function(d, s, id) {
                    var js, fjs = d.getElementsByTagName(s)[0];
                    if (d.getElementById(id)) return;
                    js = d.createElement(s); js.id = id;
                    js.src = "//connect.facebook.net/en_US/sdk.js";
                    fjs.parentNode.insertBefore(js, fjs);
                  }(document, 'script', 'facebook-jssdk'));

                  function goAuth() {
                    FB.api('/me', function(response) {
                      $.post(
                        "/user/login/fbauth",
                        response,
                        function(data){
                          try {
                            var data = JSON.parse(data);
                            if (data && data.auth && data.auth == 1){
                              location.reload();
                            }
                          } catch (e) {
                            console.log(e);
                          }
                      });
                    });
                  }

                  function loginFb(){
                    $.cookie('logout',0);
                    FB.login(function(response) {
                      checkLoginState();
                    }, {scope: 'email, public_profile'});
                  }
                </script>
              <? } ?>
              <div id="fb_logincustom_btn" onclick="loginFb();"></div>
            </div>
            <div class="col-xs-12">
              <div class="orTbl">
                <div class="orRow">
                  <div class="orCell orL"></div>
                  <div class="orCell orC">
                    <span><?=Yii::t('app','or'); ?></span>
                  </div>
                  <div class="orCell orR"></div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-content">
            <div class="tab-pane active" id="auth">
              <form role="form" id="auth-form" action="">
                <div class="form-group" id="form-group-username-auth">
                  <input class="form-control" placeholder="Email" id="auth-email" name="email" type="email">
                  <span class="error-msg">?</span>
                </div>
                <div class="form-group" style="display:none;" id="form-group-forgot-auth">
                  <input class="form-control" placeholder="Email" id="auth-forgot" type="forgot_email" name="email">
                  <p class="help-block"><small><?=Yii::t('app','To recover a password, enter Email'); ?></small></p>
                  <span class="error-msg">?</span>
                </div>
                <div class="form-group" id="form-group-pass-auth">
                  <input class="form-control" placeholder="<?=Yii::t('app','Password'); ?>" id="auth-pass" name="Profile[password]" type="password">
                  <span class="error-msg">?</span>
                </div>
                <div class="checkbox forgot"><label id="forgot"><?=Yii::t('app','Forgot your password?')?></label><label style="display:none;" id="auth_toogl"><?=Yii::t('app','Log In')?></label></div>
                <button class="btn btn-default btn-block btn-lg" type="submit"><?=Yii::t('app','LOGIN')?></button>
              </form>
            </div>
            <div class="tab-pane" id="reg">
              <form role="form" id="reg-form" action="">
                <div class="form-group" id="form-group-reg-email">
                  <input required class="form-control" placeholder="Email" id="reg-email" name="email" type="email">
                  <span class="error-msg">?</span>
                </div>
                <div class="form-group" id="form-group-reg-name">
                  <input required class="form-control" placeholder="<?=Yii::t('app','Name')?>" id="reg-name" name="username" type="text">
                  <span class="error-msg">?</span>
                </div>
                <div class="form-group" id="form-group-reg-phone">
                  <input required class="form-control" placeholder="+7(___)-___-__-__" id="reg-phone" name="Profile[phone]" type="text">
                  <span class="error-msg">?</span>
                </div>
                <div class="form-group" id="form-group-reg-pass">
                  <input required class="form-control" placeholder="<?=Yii::t('app','Password')?>" type="password" id="reg-pass" name="Profile[password]">
                  <span class="error-msg">?</span>
                </div>
                <div class="checkbox invisible" style="margin: 0;height: 20px;">
                  <label><input type="checkbox" id="reg-rules"><?=Yii::t('app','I accept')?> <a href="/rules"><?=Yii::t('app','Terms of Use'); ?></a></label>
                </div>
                <button class="btn btn-default btn-block btn-lg" type="submit"><?=Yii::t('app','Sign Up')?></button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<? } ?>

<div aria-hidden="true" aria-labelledby="myModalLabelBook" class="ModalBook modal fade" id="myModalBook" role="dialog" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <div class="row">
          <div class="col-sm-6 col-xs-12">
            <img alt="" class="featurette-image img-responsive" src="">
            <a class="descr" href="#lab">
              <h2></h2>
              <p>
                <span>
                  <i class="ico-ppl iconm-Man"></i>
                  <i class="ico-ppl iconm-Man"></i>
                  <i class="ico-ppl iconm-Man noactive"></i>
                  <i class="ico-ppl iconm-Man noactive"></i>2 - 4 <?=Yii::t('app','players')?>
                </span>
                <span class="addr-to"><i class="ico-loc"></i></span>
              </p>
            </a>
          </div>
          <div class="col-sm-6 col-xs-12 shad shadow">
            <button class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <div class="text-center">
              <h3><?=Yii::t('app','Confirmation'); ?></h3>
              <p class="book_time"></p>
              <div class="priceTbl">
                <div class="priceRow">
                  <span class="dashed">&nbsp;</span>
                  <span class="price">3000<em class="rur"><em><?=Yii::t('app','rub')?>.</em></em> <b class="team"><?=Yii::t('app','for the team')?></b></span>
                  <span class="dashed">&nbsp;</span>
                </div>
              </div>
              <p class="you_phone"><?=Yii::t('app','Your phone number')?>:<input type="text" id="book-phone" value=""> </p>
              <div class="btn btn-default"><?=Yii::t('app','Confirm the reservation')?></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<? if (!Yii::app()->user->isGuest) { ?>
  <div aria-hidden="true" aria-labelledby="myModalLabelAuth" class="modal fade" id="myModalEditProfile" role="dialog" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button class="visible-xs close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
          <h3 class="modal-title"><?=Yii::t('app','Profile'); ?></h3>
          <hr class="fadeOut">
        </div>
        <div class="modal-body">
          <form role="form" id="edit-form" class="tab-content">
            <h2 class="form-signin-heading"><?=Yii::t('app','Edit Profile'); ?></h2>
            <hr class="fadeOut">

            <div class="form-group">
              <label class="mail_label"><?=Yii::app()->getModule('user')->user()->email; ?></label>
            </div>

            <div class="tab-pane active" id="edit-my">
              <div class="form-group" id="form-group-username">
                <input required class="form-control" id="edit-name" name="name" placeholder="<?=Yii::t('app','Name')?>" type="text" value="<?=Yii::app()->getModule('user')->user()->username; ?>">
                <span class="error-msg">?</span>
              </div>
              <div class="form-group" id="form-group-phone">
                <input required class="form-control" id="edit-phone" name="phone" placeholder="+7(___)-___-__-__" type="text" value="<?=Yii::app()->getModule('user')->user()->phone; ?>">
                <span class="error-msg">?</span>
              </div>

              <div class="checkbox forgot" role="tablist">
                <a id="change-pass" href="#edit-pass" role="tab" data-toggle="tab"><?=Yii::t('app','Change your password'); ?></a>
              </div>
            </div>

            <div class="tab-pane" id="edit-pass">
              <div class="form-group" id="form-group-origin-pass">
                <input class="form-control" type="password" id="edit-pass" placeholder="<?=Yii::t('app','Old password'); ?>">
                <span class="error-msg">?</span>
              </div>

              <div class="form-group" id="form-group-new-pass" style="margin-top:20px;">
                <input class="form-control" type="password" placeholder="<?=Yii::t('app','New password'); ?>">
                <span class="error-msg">?</span>
              </div>

              <div class="form-group" id="form-group-new-confirm-pass">
                <input class="form-control" type="password" placeholder="<?=Yii::t('app','Repeat new password'); ?>">
                <span class="error-msg">?</span>
              </div>

              <div class="checkbox forgot" role="tablist">
                <a id="edit-name-phone" href="#edit-my" role="tab" data-toggle="tab"><?=Yii::t('app','Edit profile')?></a>
              </div>
            </div>

            <button class="btn btn-default btn-block btn-lg" id="editProfile" type="submit"><?=Yii::t('app','SAVE')?></button>
          </form>
        </div>
      </div>
    </div>
  </div>
<? } ?>

<? if ($_SERVER['HTTP_HOST'] != 'cq.il' && $_SERVER['HTTP_HOST'] != 'cq.kzil') { ?>
  <script type="text/javascript">
    (function (d, w, c) {
    (w[c] = w[c] || []).push(function() {
        try {
            w.yaCounter25221941 = new Ya.Metrika({id:25221941,
                    webvisor:true,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true});
        } catch(e) { }
    });
    
    var n = d.getElementsByTagName("script")[0],
        s = d.createElement("script"),
        f = function () { n.parentNode.insertBefore(s, n); };
    s.type = "text/javascript";
    s.async = true;
    s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";
    
    if (w.opera == "[object Opera]") {
        d.addEventListener("DOMContentLoaded", f, false);
    } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
  </script>
  <noscript><div><img alt="" src="//mc.yandex.ru/watch/25221941" style="position:absolute; left:-9999px;"></div></noscript>

  <script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-56033342-1', 'auto');
    ga('send', 'pageview');
  </script>

  <? if ($_SERVER['HTTP_HOST'] != 'cq.il' && $_SERVER['HTTP_HOST'] != 'cq.kzil') { ?>
    <script type="text/javascript">
      <!--//--><![CDATA[//><!--
      var advaction_params = advaction_params || {};
      advaction_params.asite = 'cityquest.ru';
      (function(){
        var aa = document.createElement("script");
        aa.type = "text/javascript";
        aa.async = true;
        aa.src = document.location.protocol+"//advaction.ru/js/advertiser.js";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(aa, s); 
      })();
      //-->!]>]
    </script>
  <? } ?>
<? } ?>

<script src="/js/jquery.min.js"></script>
<script src="/js/jq.elastic.js"></script>
<script src="/js/bootstrap.js"></script>
<script src="/js/jquery.mask.min.js"></script>
<script src="/js/main.js"></script>