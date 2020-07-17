'use strict';

const toggleHidden = (...fields) => {

  fields.forEach((field) => {

    if (field.hidden === true) {

      field.hidden = false;

    } else {

      field.hidden = true;

    }
  });
};

const labelHidden = (form) => {

  form.addEventListener('focusout', (evt) => {

    const field = evt.target;
    const label = field.nextElementSibling;

    if (field.tagName === 'INPUT' && field.value && label) {

      label.hidden = true;

    } else if (label) {

      label.hidden = false;

    }
  });
};

const toggleDelivery = (elem) => {

  const delivery = elem.querySelector('.js-radio');
  const deliveryYes = elem.querySelector('.shop-page__delivery--yes');
  const deliveryNo = elem.querySelector('.shop-page__delivery--no');
  const fields = deliveryYes.querySelectorAll('.custom-form__input');

  delivery.addEventListener('change', (evt) => {

    if (evt.target.id === 'dev-no') {

      fields.forEach(inp => {
        if (inp.required === true) {
          inp.required = false;
        }
      });


      toggleHidden(deliveryYes, deliveryNo);

      deliveryNo.classList.add('fade');
      setTimeout(() => {
        deliveryNo.classList.remove('fade');
      }, 1000);

    } else {

      fields.forEach(inp => {
        if (inp.required === false) {
          inp.required = true;
        }
      });

      toggleHidden(deliveryYes, deliveryNo);

      deliveryYes.classList.add('fade');
      setTimeout(() => {
        deliveryYes.classList.remove('fade');
      }, 1000);
    }
  });
};

const filterWrapper = document.querySelector('.filter__list');
if (filterWrapper) {

  filterWrapper.addEventListener('click', evt => {

    const filterList = filterWrapper.querySelectorAll('.filter__list-item');

    filterList.forEach(filter => {

      if (filter.classList.contains('active')) {

        filter.classList.remove('active');

      }

    });

    const filter = evt.target;

    filter.classList.add('active');

  });

}

const pageOrderList = document.querySelector('.page-order__list');
if (pageOrderList) {

  pageOrderList.addEventListener('click', evt => {

    if (evt.target.classList && evt.target.classList.contains('order-item__toggle')) {
      var path = evt.path || (evt.composedPath && evt.composedPath());
      Array.from(path).forEach(element => {

        if (element.classList && element.classList.contains('page-order__item')) {

          element.classList.toggle('order-item--active');

        }

      });

      evt.target.classList.toggle('order-item__toggle--active');
    }
  });

}

const checkList = (list, btn) => {

  if (list.children.length === 1) {

    btn.hidden = false;

  } else {
    btn.hidden = true;
  }

};
const addList = document.querySelector('.add-list');
if (addList) {

  const form = document.querySelector('.custom-form');
  labelHidden(form);

  const addButton = addList.querySelector('.add-list__item--add');
  const addInput = addList.querySelector('#product-photo');

  checkList(addList, addButton);

  addInput.addEventListener('change', evt => {

    const template = document.createElement('LI');
    const img = document.createElement('IMG');

    template.className = 'add-list__item add-list__item--active';
    template.addEventListener('click', evt => {
      addList.removeChild(evt.target);
      addInput.value = '';
      checkList(addList, addButton);
    });

    const file = evt.target.files[0];
    const reader = new FileReader();

    reader.onload = (evt) => {
      img.src = evt.target.result;
      template.appendChild(img);
      addList.appendChild(template);
      checkList(addList, addButton);
    };

    reader.readAsDataURL(file);
  });
}

// jquery range maxmin
if (document.querySelector('.shop-page')) {

  $('.range__line').slider({
    min: 350,
    max: 32000,
    values: [350, 32000],
    range: true,
    stop: function(event, ui) {

      $('.min-price').text($('.range__line').slider('values', 0) + ' руб.');
      $('.max-price').text($('.range__line').slider('values', 1) + ' руб.');

    },
    slide: function(event, ui) {

      $('.min-price').text($('.range__line').slider('values', 0) + ' руб.');
      $('.max-price').text($('.range__line').slider('values', 1) + ' руб.');

    }
  });

}
