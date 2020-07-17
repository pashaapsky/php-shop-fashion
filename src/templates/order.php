<section class="shop-page__order" hidden="">
    <div class="shop-page__wrapper">
      <h2 class="h h--1">Оформление заказа</h2>

      <form action="#" method="post" class="custom-form" id="js-order-form">
        <fieldset class="custom-form__group">
          <legend class="custom-form__title">Укажите свои личные данные</legend>

          <p class="custom-form__info">
            <span class="req">*</span> поля обязательные для заполнения
          </p>

          <div class="custom-form__column">
            <label class="custom-form__input-wrapper" for="surname">
              <input id="surname" class="custom-form__input" placeholder="Фамилия *" type="text" name="surname" required="">
            </label>

            <label class="custom-form__input-wrapper" for="name">
              <input id="name" class="custom-form__input" placeholder="Имя *" type="text" name="name" required="">
            </label>

            <label class="custom-form__input-wrapper" for="thirdName">
              <input id="thirdName" class="custom-form__input" placeholder="Отчество" type="text" name="thirdName">
            </label>

            <label class="custom-form__input-wrapper" for="phone">
              <input id="phone" class="custom-form__input" placeholder="Телефон *" type="tel" name="phone" required="">
            </label>

            <label class="custom-form__input-wrapper" for="email">
              <input id="email" class="custom-form__input" placeholder="Почта *" type="email" name="email" required="">
            </label>
          </div>
        </fieldset>

        <fieldset class="custom-form__group js-radio">
          <legend class="custom-form__title custom-form__title--radio">Способ доставки</legend>

          <input id="dev-no" class="custom-form__radio" type="radio" name="delivery" value="del-no" checked="">
          <label for="dev-no" class="custom-form__radio-label">Самовывоз</label>

          <input id="dev-yes" class="custom-form__radio" type="radio" name="delivery" value="del-yes">
          <label for="dev-yes" class="custom-form__radio-label">Курьерная доставка</label>
        </fieldset>

        <div class="shop-page__delivery shop-page__delivery--no">
          <table class="custom-table">
            <caption class="custom-table__title">Пункт самовывоза</caption>

            <tr>
              <td class="custom-table__head">Адрес:</td>
              <td>Москва г, Тверская ул,<br> 4 Метро «Охотный ряд»</td>
            </tr>
            <tr>
              <td class="custom-table__head">Время работы:</td>
              <td>пн-вс 09:00-22:00</td>
            </tr>
            <tr>
              <td class="custom-table__head">Оплата:</td>
              <td>Наличными или банковской картой</td>
            </tr>
            <tr>
              <td class="custom-table__head">Срок доставки: </td>
              <td class="date">13 декабря—15 декабря</td>
            </tr>
          </table>
        </div>

        <div class="shop-page__delivery shop-page__delivery--yes" hidden="">
          <fieldset class="custom-form__group">
            <legend class="custom-form__title">Адрес</legend>

            <p class="custom-form__info">
              <span class="req">*</span> поля обязательные для заполнения
            </p>

            <div class="custom-form__row">
              <label class="custom-form__input-wrapper" for="city">
                <input id="city" class="custom-form__input" placeholder="Город *" type="text" name="city">
              </label>

              <label class="custom-form__input-wrapper" for="street">
                <input id="street" class="custom-form__input" placeholder="Улица *" type="text" name="street">
              </label>

              <label class="custom-form__input-wrapper" for="home">
                <input id="home" class="custom-form__input custom-form__input--small" placeholder="Дом *" type="text" name="home">
              </label>

              <label class="custom-form__input-wrapper" for="aprt">
                <input id="aprt" class="custom-form__input custom-form__input--small" placeholder="Квартира *" type="text" name="aprt">
              </label>
            </div>
          </fieldset>
        </div>

        <fieldset class="custom-form__group shop-page__pay">
          <legend class="custom-form__title custom-form__title--radio">Способ оплаты</legend>

          <input id="cash" class="custom-form__radio" type="radio" name="pay" value="cash">
          <label for="cash" class="custom-form__radio-label">Наличные</label>

          <input id="card" class="custom-form__radio" type="radio" name="pay" value="card" checked="">
          <label for="card" class="custom-form__radio-label">Банковской картой</label>
        </fieldset>

        <fieldset class="custom-form__group shop-page__comment">
          <legend class="custom-form__title custom-form__title--comment">Комментарии к заказу</legend>

          <textarea class="custom-form__textarea" name="comment"></textarea>
        </fieldset>

        <button class="button" id="js-order-btn" type="submit">Отправить заказ</button>
      </form>
    </div> <!-- form /-->
  </section>  <!-- shop-order /-->