<div class="footer <? if (Yii::app()->request->url == '/contact') echo 'dark-footer'; ?>">
  <div class="row">
    <div class="col-sm-5 hidden-xs">
      <p class="pull-left condition">
        <i class="ico-pay ico-visa" data-toggle="tooltip" title="Принимаем к оплате карты Visa"></i><i class="ico-pay ico-mc" data-toggle="tooltip" title="Принимаем к оплате карты MasterCard"></i><i class="ico-pay ico-cash" data-toggle="tooltip" title="Принимаем к оплате наличные"></i><span class="weinsoc hidden-sm"><em>&mdash;</em>Принимаем к оплате</span>
      </p>
    </div>
    <div class="col-xs-12 visible-xs">
      <p class="text-center">
        <a class="btn-soc" href="#"><i class="ico-soc ico-fb"></i></a><a class="btn-soc" href="#"><i class="ico-soc ico-tw"></i></a><a class="btn-soc" href="#"><i class="ico-soc ico-vk"></i></a>
      </p>
    </div>
    <div class="col-sm-2 col-xs-12">
      <p class="text-center">
        <span class="brand"><strong>CITY</strong>QUEST 2014</span>
      </p>
    </div>
    <div class="col-sm-5 col-xs-12 hidden-xs">
      <p class="pull-right right-soc">
        <span class="weinsoc hidden-sm">мы в социальных сетях<em>&mdash;</em></span><a class="btn-soc" href="#"><i class="ico-soc ico-fb"></i></a><a class="btn-soc" href="#"><i class="ico-soc ico-tw"></i></a><a class="btn-soc" href="#"><i class="ico-soc ico-vk"></i></a>
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

<div aria-hidden="true" aria-labelledby="myModalLabelAuth" class="modal fade" id="myModalAuth" role="dialog" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button class="visible-xs close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <a class="h4 modal-title active" data-toggle="tab" href="#auth" id="auth-tab" role="tab">Вход на сайт</a>
        <a class="h4 modal-title" data-toggle="tab" href="#reg" role="tab">Регистрация</a>
        <hr class="fadeOut">
      </div>
      <div class="modal-body">
        <div class="row social_auth hidden">
          <div class="col-xs-6 text-right">
            <a class="vk" href="#vk"></a>
          </div>
          <div class="col-xs-6 text-left">
            <a class="fb" href="#fb"></a>
          </div>
          <div class="col-xs-12">
            <div class="orTbl">
              <div class="orRow">
                <div class="orCell orL"></div>
                <div class="orCell orC">
                  <span>или</span>
                </div>
                <div class="orCell orR"></div>
              </div>
            </div>
          </div>
        </div>
        <div class="tab-content">
          <div class="tab-pane active" id="auth">
            <form role="form" id="auth-form">
              <div class="form-group">
                <input class="form-control" placeholder="Email" id="auth-email" type="email">
              </div>
              <div class="form-group">
                <input class="form-control" placeholder="Пароль" id="auth-pass" type="password">
              </div>
              <div class="checkbox invisible"><label></label></div>
              <button class="btn btn-default btn-block btn-lg" type="submit">Авторизоваться</button>
            </form>
          </div>
          <div class="tab-pane" id="reg">
            <form role="form" id="reg-form">
              <div class="form-group">
                <input required class="form-control" placeholder="Имя" id="reg-name" name="Profile[name]" type="text">
              </div>
              <div class="form-group">
                <input required class="form-control" placeholder="Email" id="reg-email" name="Profile[email]" type="email">
              </div>
              <div class="form-group">
                <input required class="form-control" placeholder="Номер телефона" id="reg-phone" name="Profile[phone]" type="text">
              </div>
              <div class="form-group">
                <input required class="form-control" placeholder="Пароль" type="password" id="reg-pass" name="Profile[password]">
              </div>
              <div class="checkbox">
                <label><input type="checkbox" required id="reg-rules">Я принимаю <a href="/rules">Условия использования</a></label>
              </div>
              <button class="btn btn-default btn-block btn-lg" type="submit">Зарегистрироваться</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div aria-hidden="true" aria-labelledby="myModalLabelBook" class="ModalBook modal fade" id="myModalBook" role="dialog" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <div class="row">
          <div class="col-sm-6 col-xs-12">
            <img alt="" class="featurette-image img-responsive" src="">
            <a class="descr" href="#lab">
              <h2>Лаборатория</h2>
              <p>
                <span>
                  <i class="ico-ppl"></i>
                  <i class="ico-ppl"></i>
                  <i class="ico-ppl noactive"></i>
                  <i class="ico-ppl noactive"></i>2 - 4 игрока
                </span>
                <span class="addr-to"><i class="ico-loc"></i>ул. Стасовой, д. 10, корп. 3</span>
              </p>
            </a>
          </div>
          <div class="col-sm-6 col-xs-12 shad shadow">
            <button class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <div class="text-center">
              <h3>Подтверждение</h3>
              <p class="book_time"></p>
              <!-- <small>Понедельник</small><span>30.07</span><em>в</em><span>10:45</span> -->
              <div class="priceTbl">
                <div class="priceRow">
                  <span class="dashed"></span><span class="price">3000<em>руб.</em></span><span class="dashed"></span>
                </div>
              </div>
              <p class="you_phone">Ваш номер телефона:<a>+7 952 377-97-97</a></p>
              <div class="btn btn-default">Подтвердить бронь</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="/js/jquery.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script src="/js/main.js"></script>