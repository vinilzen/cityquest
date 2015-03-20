<?
 $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Login");
?>
<div class="container">
    <div class="row">
      <div class="col-xs-12 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
          <div id="myModalAuth" class="login-page">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
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
                  <div class="tab-content" style="padding:0;">
                    <div class="tab-pane active" id="auth">
                      <form role="form" id="auth-form" action="">
                        <div class="form-group" id="form-group-username-auth">
                          <input class="form-control" placeholder="Email" id="auth-email" name="email" type="email">
                          <span class="error-msg">?</span>
                        </div>
                        <div class="form-group" style="display:none;" id="form-group-forgot-auth">
                          <input class="form-control" placeholder="Email" id="auth-forgot" type="forgot_email" name="email">
                          <div class="clearfix"></div>
                          <p class="help-block" style="margin-top: 45px;"><small style="font-size:12px;"><?=Yii::t('app','To recover a password, enter Email'); ?></small></p>
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
      </div>
    </div>
</div>