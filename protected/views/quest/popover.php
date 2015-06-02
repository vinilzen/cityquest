<script id="BookInfWrap" type="text/template">
  <div class="checkBooking" id="BookInf">
    <form class="form-horizontal pop-row" id="editBookingRow" role="form">
      <% if (action == 'add') { %>
        <div class="form-group form-group-select-user">
          <div class="col-xs-12">
            <div class="dropdown" id="dropdown_users">
              <button type="button" id="dLabel_users" class="btn btn-sm btn-block btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                Выбрать из зарегестрированных <span class="caret"></span>
              </button>
              <input type="hidden" id="selectUser_id" value="0" />
              
              <ul class="dropdown-menu" id="addUser" role="menu" aria-labelledby="dLabel_users">
                <li class="search_line" role="presentation">
                  <div class="input-group">
                    <input type="text" class="input-block-level input-sm form-control" placeholder="Имя или Email" autocomplete="off"
                      data-toggle="popover" data-placement="top" data-container="body" data-content="Введите как минимум три символа для начала поиска" >
                    <i class="gi gi-search form-control-feedback" aria-hidden="true"></i>
                  </div>
                </li>
                <li class="last hide" role="presentation">
                  <a href="#" class="btn"><strong>Показать всех</strong></a>
                </li>
              </ul>
            </div>
          </div>
          <div class="col-xs-9" id="selectUser"></div>
        </div>
      <% } %>
      <div class="form-group">
        <label for="inputName" class="col-xs-4 text-left control-label">
          <?=Yii::t('app','Name')?>
          <% if (action == 'edit') { %>
            <% if ( name != 'CQ' && user_url != '#') { %>
              <a href="<%= user_url %>" target="_blank" title="Посмотреть пользователя '<%= name %>' " data-toggle="tooltip">
                <i class="hi hi-link"></i>
              </a>
            <% } %>
            <% if (fb_id > 0) { %>
              <a href="https://www.facebook.com/app_scoped_user_id/<%= fb_id %>/" target="_blank">
                <svg style="width:14px; height:14px;top: 2px;position: relative;" height="12px" id="Layer_1" version="1.1" viewBox="0 0 512 512" width="12px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g id="social_x5F_3"><g><ellipse cx="255.672" cy="255.758" rx="256" ry="255.828" style="fill:#6D85B4;"></ellipse><path d="M255.672,511.586c141.386,0,256-114.537,256-255.828c0-68.754-27.191-131.121-71.346-177.09    L76.119,438.054C122.328,483.511,185.71,511.586,255.672,511.586z" style="fill:#5B6F98;"></path><path d="M290.145,83.166c-84.496,18.465-83.43,82.326-83.43,82.326v35.205v47.589h-50.322v78.681h50.322    l-0.351,181.258c15.854,3.068,32.209,3.705,48.958,3.705c18.486,0,36.501-0.981,53.878-4.703l0.351-180.26h76.482l7.447-78.681    H309.55v-47.589c0-63.119,85.994-32.084,85.994-32.084l11.551-79.703C407.096,88.91,349.416,70.259,290.145,83.166z" style="fill:#FFFFFF;"></path><g><path d="M206.715,326.967l-0.352,179.834c15.959,3.115,32.435,4.785,49.309,4.785     c18.363,0,36.261-1.973,53.528-5.644l0.351-178.977h76.482l7.447-78.681H309.55v-40.573L188.695,326.966L206.715,326.967     L206.715,326.967z" style="fill:#F1F2F2;"></path><path d="M356.825,161.064c19.98,0.792,38.72,7.549,38.72,7.549l7.737-53.395L356.825,161.064z" style="fill:#F1F2F2;"></path></g></g></g><g id="Layer_1_1_"></g></svg></a>
            <% } %>
            <% if (vk_id > 0) { %>
              <a href="https://vk.com/id<%= vk_id %>" target="_blank">
                <svg style="width:14px; height:14px;top: 2px;position: relative;" enable-background="new 0 0 512 512" id="Layer_1" version="1.1" viewBox="0 0 512 512" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path d="M256,512C114.6,512,0,397.4,0,256C0,114.6,114.6,0,256,0c141.4,0,256,114.6,256,256  C512,397.4,397.4,512,256,512z" fill="#4C75A3"></path><g id="Layer_1_1_"></g><path d="M256,512c141.4,0,256-114.6,256-256c0-68.2-26.7-130-70.1-175.9L77.7,439.7C123.8,484.4,186.7,512,256,512z" fill="#466C96"></path><path d="M282.6,212.5c0,8,0,16,0,24.1c0,1.3,0,2.6,0.2,3.9c0.7,5.2,1.2,11.1,6.9,13.1c5.2,1.8,8.6-2.9,11.6-6.3  c14.5-16.4,24.7-35.4,33.4-55.3c1.8-4.1,3.4-8.2,5.2-12.4c1.9-4.4,5-6.6,10-6.5c17.4,0.1,34.7,0,52.1,0.1c1.8,0,3.7,0.3,5.5,0.8  c7,1.7,8.8,4.8,6.8,11.8c-2.6,9.5-7.9,17.6-13.3,25.7c-9.2,13.8-19.8,26.6-29.6,40c-11.7,16-11.4,20,3,33.5  c12,11.2,24,22.4,33.7,35.8c2.4,3.3,4.6,6.8,6.1,10.6c2.2,5.9,0.5,10.3-5.1,12.9c-3.2,1.5-6.6,2.3-10.3,2.3  c-14.6-0.1-29.1,0.1-43.7,0c-9.8,0-17.6-4.7-24.2-11.3c-6.1-6-11.6-12.6-17.4-18.9c-3.2-3.4-6.3-6.9-10.3-9.4  c-6.3-4-11.8-2.7-15.4,3.9c-3.7,6.7-4.5,14.2-4.8,21.6c-0.5,10.8-3.9,13.6-14.9,14.2c-23.8,1.2-46.4-2.7-67.2-14.8  c-17.8-10.4-31.5-24.9-43.6-41.2c-23.9-32.4-42.2-68-58.7-104.7c-3.7-8.2-0.9-12.6,8.2-12.8c14.9-0.3,29.9-0.2,44.8,0  c6.1,0.1,10.4,3.1,12.8,9c8.1,19.7,17.8,38.6,30,56.1c3.6,5.2,7.3,10.5,12.6,14.1c5.4,3.7,9.4,2.4,12-3.6c1.8-4.4,2.4-9,2.8-13.6  c1.1-13.2,1-26.5-0.7-39.6c-1.2-8.9-6-14.8-15-16.5c-4.6-0.9-3.6-2.6-1.5-5c3.7-4.3,8.8-6.4,14.2-7c17.4-2.2,34.9-2.9,52.3,0.5  c8.3,1.6,10.7,4.8,12,13.2C284.6,191.3,282.2,201.9,282.6,212.5z" fill="#FCFDFD"></path><path d="M334.7,192c-8.7,19.9-19,38.9-33.4,55.3c-3,3.4-6.3,8.1-11.6,6.3c-5.7-2-6.2-7.8-6.9-13.1  c-0.1-1-0.2-2.1-0.2-3.1l-90.2,89.1c2.7,1.9,5.5,3.7,8.4,5.5c20.8,12.2,43.4,16,67.2,14.8c11-0.5,14.4-3.4,14.9-14.2  c0.3-7.5,1.2-14.9,4.8-21.6c3.6-6.6,9.1-7.9,15.4-3.9c4,2.5,7.1,6,10.3,9.4c5.8,6.3,11.3,12.9,17.4,18.9  c6.6,6.6,14.4,11.3,24.2,11.3c14.6,0,29.1-0.1,43.7,0c3.6,0,7-0.8,10.3-2.3c5.6-2.6,7.3-7.1,5.1-12.9c-1.4-3.9-3.7-7.3-6.1-10.6  c-9.6-13.4-21.7-24.6-33.7-35.8c-14.4-13.5-14.8-17.5-3-33.5c9.8-13.4,20.5-26.2,29.6-40c5.4-8.1,10.7-16.2,13.3-25.7  c2-7,0.1-10.2-6.8-11.8c-1.8-0.4-3.7-0.8-5.5-0.8c-17.4-0.1-34.7,0.1-52.1-0.1c-0.8,0-1.6,0.1-2.3,0.2l-8.5,8.4  C337.6,185.1,336.2,188.6,334.7,192z" fill="#F1F2F2"></path></svg></a>
            <% } %>
          <% } %>
        </label>
        <div class="col-xs-8">
          <input type="text" class="form-control input-sm inputName" placeholder="Ivan">
        </div>
      </div>
      <div class="form-group">
        <label for="inputPhone" class="col-xs-4 text-left control-label"><?=Yii::t('app','Phone')?></label>
        <div class="col-xs-8">
          <input type="text" class="form-control input-sm inputPhone" placeholder="+7(123)-456-78-90">
        </div>
      </div>
      <% if (action == 'edit') { %>
      <div class="form-group">
        <div class="row">
          <div class="col-xs-6">
            <label for="inputPrice" class="col-xs-6 text-left control-label"><?=Yii::t('app','Price')?></label>
            <div class="col-xs-6">
              <input type="text" class="form-control input-sm inputPrice" placeholder="3000">
            </div>
          </div>
          <div class="col-xs-6">
            <label for="inputResult" class="col-xs-6 text-left control-label"><?=Yii::t('app','Result')?></label>
            <div class="col-xs-6">
              <input type="text" class="form-control input-sm inputResult" placeholder="00:00">
            </div>
          </div>
        </div>
      </div>
      <% } else { %>
      <div class="form-group">
        <label for="inputPrice" class="col-xs-4 text-left control-label"><?=Yii::t('app','Price')?></label>
        <div class="col-xs-8">
          <input type="text" class="form-control input-sm inputPrice" placeholder="3000">
        </div>
      </div>
      <% } %>

      <div class="form-group" id="priceRow">
        <label class="col-xs-4 text-left control-label"><?=Yii::t('app','Reason discounts')?></label>
        <div class="col-xs-8">
          <select name="discount" id="discount" class="form-control">
            <option value="0">(Пусто)</option>
            <? if (isset($discounts)) foreach ($discounts AS $discount) { ?>
              <option value="<?=$discount->id?>" <% if (discount == '<?=$discount->id?>') { %> selected="selected" <% } %> >
                <?=$discount->key?>
              </option>
            <? } ?>
          </select>
        </div>
      </div>

      <div class="form-group" id="paymentsMethodRow">
        <label class="col-xs-4 text-left control-label"><?=Yii::t('app','Payment method')?></label>
        <div class="col-xs-8">
          <select name="payment" id="payment" class="form-control">
            <option value="0">(Пусто)</option>
            <? if (isset($payments)) foreach ($payments AS $payment) { ?>
              <option value="<?=$payment->id?>" <% if (payment == '<?=$payment->id?>') { %> selected="selected" <% } %>>
                <?=$payment->name?>
              </option>
            <? } ?>
          </select>
        </div>
      </div>

      <div class="form-group" id="sourceMethodRow">
        <label class="col-xs-4 text-left control-label">Откуда узнали</label>
        <div class="col-xs-8">
          <select name="source" id="source" class="form-control">
            <option value="0">(Пусто)</option>
            <? if (isset($sources)) foreach ($sources AS $source) { ?>
              <option value="<?=$source->id?>" <% if (source == '<?=$source->id?>') { %> selected="selected" <% } %>>
                <?=$source->name?>
              </option>
            <? } ?>
          </select>
        </div>
      </div>

      <div class="form-group">
        <div class="col-xs-12">
          <textarea type="text" class="form-control input-sm inputComment" placeholder="<?=Yii::t('app','Additional comment')?>"></textarea>
        </div>
      </div>
      <% if (action == 'edit') { %>
      <div class="form-group" id="uploadWinnerPhoto">
        <div class="col-xs-6">
          <input type="button" id="upload-btn" class="btn btn-default btn-block btn-large clearfix" value="Загрузить фото">
          <span id="sizeBox"></span>
          <div id="errormsg" class="clearfix hide"></div>
          <div class="progress progress-striped active hide">
            <div class="progress-bar progress-bar-success" id="progress" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">0%</div>
          </div>
        </div>
        <div class="col-xs-6">
          <div id="picbox" class="clear text-center">
            <a href="/images/winner_photo/<%= id %>.jpg" target="_blank">
              <img class="img-responsive" style="max-height: 100px; height: 200px;" src="/images/winner_photo/<%= id %>.jpg" alt="Нет фото"></a>
          </div>
        </div>
        <div class="col-xs-12">
          <div id="affilate_container"></div>
        </div>
      </div>
      <% } %>
      <div class="form-group" style="margin-bottom:0;">
        <div class="col-xs-12">
          <% if (action == 'edit') { %>
            <% if (status == 0) { %>
              <button class="btn btn-primary btn-block btn-sm" id="confirmBooking" data-toggle="tooltip" title="<?=Yii::t('app','Confirm reservation')?>">
                <i class="hi hi-ok-circle"></i> <?=Yii::t('app','Confirm reservation')?>
              </button>
            <% } else { %>
              <button class="btn btn-default btn-block btn-sm" id="undoBooking" data-toggle="tooltip" title="<?=Yii::t('app','Unconfirmed reservation')?>">
                <i class="hi hi-remove-circle"></i> <?=Yii::t('app','Unconfirmed reservation')?>
              </button>
            <% } %>
          <% } else { %>
            <button class="btn btn-warning btn-block btn-sm" id="reservation" data-toggle="tooltip" title="<?=Yii::t('app','Reservation')?>">
              <i class="hi hi-ban-circle"></i> <?=Yii::t('app','Reservation')?>
            </button>
          <% } %>
        </div>
        <div class="col-xs-6">
          <button id="saveBooking" class="btn btn-success btn-block btn-sm" data-toggle="tooltip" title="<?=Yii::t('app','Save')?>">
            <i class="hi hi-ok"></i> <?=Yii::t('app','Save')?>
          </button>
        </div>
        <div class="col-xs-6">
          <button class="btn btn-danger btn-block btn-sm" id="showRemoveBooking" data-toggle="tooltip" title="<?=Yii::t('app','Remove reservation')?>">
            <i class="hi hi-trash"></i> <?=Yii::t('app','Remove reservation')?>
          </button>
          <button id="cancelEditBooking" class="btn hide btn-warning btn-block btn-sm" data-toggle="tooltip" title="<?=Yii::t('app','Cancel')?>">
            <i class="hi hi-remove"></i> <?=Yii::t('app','Cancel')?>
          </button>
        </div>
      </div>
    </form>
    <div class="pop-row" id="confirmRow">
    <p class="text-center">
      <strong>Вы уверены?</strong>
      <button class="btn btn-default btn-sm" data-toggle="tooltip" title="Да, Удалить!" id="confirmedDelete">
        <i class="hi hi-ok"></i>
      </button>
      <button class="btn btn-default btn-sm" data-toggle="tooltip" title="Отменить удаление" id="cancelDelete">
        <i class="hi hi-remove"></i>
      </button>
    </p>
    </div>
    <div class="pop-row" id="btnRow">
      <p class="text-center">
        <% if (status == 0) { %>
          <button class="btn btn-default btn-sm" id="confirmBooking" data-toggle="tooltip" title="Подтвердить бронирование">
            <i class="hi hi-ok-circle"></i>
          </button>
        <% } else { %>
          <button class="btn btn-default btn-sm" id="undoBooking" data-toggle="tooltip" title="Удалить подтверждение">
            <i class="hi hi-remove-circle"></i>
          </button>
        <% } %>
        <button class="btn btn-default btn-sm" id="showRemoveBooking" data-toggle="tooltip" title="Удалить бронирование">
          <i class="hi hi-remove"></i>
        </button>
        <button class="btn btn-default btn-sm" id="editBooking" data-toggle="tooltip" title="Редактировать бронирование">
          <i class="hi hi-pencil"></i>
        </button>
      </p>
    </div>
    <div class="pop-row" id="addRow">
      <p class="text-center">
        <strong>Записать вручную</strong>
        <button class="btn btn-default btn-sm" id="addBooking" data-toggle="tooltip" title="Добавить бронирование">
          <i class="hi hi-plus"></i>
        </button>
      </p>
    </div>
  </div>
</script>