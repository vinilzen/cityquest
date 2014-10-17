<script id="BookInfWrap" type="text/template">
  <div class="checkBooking" id="BookInf">
    <h3 style="margin-top: 0;" class="pop-row"><a href="<%= user_url %>"><%= name %></a></h3>
    <p class="phoneRow pop-row" id="phoneRow">
      <strong>Phone</strong>: <span><%= phone %></span><br>
      <strong>Comment</strong>: <span><%= comment %></span>
    </p>
    <form class="form-horizontal pop-row" id="editBookingRow" role="form">
      <div class="form-group">
        <label for="inputName" class="col-sm-2 control-label">Name</label>
        <div class="col-sm-7">
          <input type="text" class="form-control input-sm inputName" placeholder="Ivan">
        </div>
        <div class="col-sm-2">
          <button id="saveBooking" class="btn btn-default btn-sm" data-toggle="tooltip" title="Сохранить">
            <span class="glyphicon glyphicon-ok"></span>
          </button>
        </div>
      </div>
      <div class="form-group">
        <label for="inputPhone" class="col-sm-2 control-label">Phone</label>
        <div class="col-sm-7">
          <input type="text" class="form-control input-sm inputPhone" placeholder="123-456-789">
        </div>
        <div class="col-sm-2">
          <button id="cancelEditBooking" class="btn btn-default btn-sm" data-toggle="tooltip" title="Отменить">
            <span class="glyphicon glyphicon-remove"></span>
          </button>
        </div>
      </div>
      <div class="form-group">
        <label for="inputPrice" class="col-sm-2 control-label">Price</label>
        <div class="col-sm-7">
          <input type="text" class="form-control input-sm inputPrice" placeholder="3000">
        </div>
      </div>
      <div class="form-group">
        <label for="inputResult" class="col-sm-2 control-label">Result</label>
        <div class="col-sm-7">
          <input type="text" class="form-control input-sm inputResult" placeholder="00:00">
        </div>
      </div>
      <div class="form-group">
        <div class="col-sm-12">
          <textarea type="text" class="form-control input-sm inputComment" placeholder="Дополнительный комментарий"></textarea>
        </div>
      </div>
    </form>
    <form class="form-horizontal pop-row" id="addBookingRow" role="form">
      <div class="form-group">
        <label for="inputName" class="col-sm-2 control-label">Name</label>
        <div class="col-sm-7">
          <input type="text" class="form-control input-sm inputName" placeholder="Ivan">
        </div>
        <div class="col-sm-2">
          <button id="saveBooking" class="btn btn-default btn-sm" data-toggle="tooltip" title="Сохранить">
            <span class="glyphicon glyphicon-ok"></span>
          </button>
        </div>
      </div>
      <div class="form-group">
        <label for="inputPhone" class="col-sm-2 control-label">Phone</label>
        <div class="col-sm-7">
          <input type="text" class="form-control input-sm inputPhone" placeholder="123-456-789">
        </div>
        <div class="col-sm-2">
          <button id="cancelAddBooking" class="btn btn-default btn-sm" data-toggle="tooltip" title="Отменить">
            <span class="glyphicon glyphicon-remove"></span>
          </button>
        </div>
      </div>
      <div class="form-group">
        <label for="inputPrice" class="col-sm-2 control-label">Price</label>
        <div class="col-sm-7">
          <input type="text" class="form-control input-sm inputPrice" value="<%= price %>" placeholder="3000">
        </div>
      </div>
      <div class="form-group">
        <label for="inputResult" class="col-sm-2 control-label">Result</label>
        <div class="col-sm-7">
          <input type="text" class="form-control input-sm inputResult" value="<%= result %>" placeholder="00:00">
        </div>
      </div>
      <div class="form-group">
        <div class="col-sm-9" id="selectUser">
          <select name="user">
            <option value="0">Пользователь</option>
            <?php if (isset($users)) foreach ($users as $user) {
                echo '<option value="'.$user->id.'" title="'.$user->email.'" data-name="'.$user->username.'" data-phone="'.$user->phone.'">'.$user->username.' ('. $user->email .')</option>';
            } ?>
          </select>
        </div>
      </div>
      <div class="form-group">
        <div class="col-sm-12">
          <textarea type="text" class="form-control input-sm inputComment" placeholder="Дополнительный комментарий"></textarea>
        </div>
      </div>
    </form>
    <div class="pop-row" id="confirmRow">
    <p class="text-center">
      <strong>Вы уверены?</strong>
      <button class="btn btn-default btn-sm" data-toggle="tooltip" title="Да, Удалить!" id="confirmedDelete">
        <span class="glyphicon glyphicon-ok"></span>
      </button>
      <button class="btn btn-default btn-sm" data-toggle="tooltip" title="Отменить удаление" id="cancelDelete">
        <span class="glyphicon glyphicon-remove"></span>
      </button>
    </p>
    </div>
    <div class="pop-row" id="btnRow">
    <p class="text-center">
      <button class="btn btn-default btn-sm" id="confirmBooking" data-toggle="tooltip" title="Подтвердить бронирование">
        <span class="glyphicon glyphicon-ok-circle"></span>
      </button>
      <button class="btn btn-default btn-sm" id="undoBooking" data-toggle="tooltip" title="Удалить подтверждение">
        <span class="glyphicon glyphicon-remove-circle"></span>
      </button>
      <button class="btn btn-default btn-sm" id="showRemoveBooking" data-toggle="tooltip" title="Удалить бронирование">
        <span class="glyphicon glyphicon-remove"></span>
      </button>
      <button class="btn btn-default btn-sm" id="editBooking" data-toggle="tooltip" title="Редактировать бронирование">
        <span class="glyphicon glyphicon-pencil"></span>
      </button>
    </p>
    </div>
    <div class="pop-row" id="addRow">
      <p class="text-center">
        <strong>Записать вручную</strong>
        <button class="btn btn-default btn-sm" id="addBooking" data-toggle="tooltip" title="Добавить бронирование">
          <span class="glyphicon glyphicon-plus"></span>
        </button>
      </p>
    </div>
  </div>
</script>