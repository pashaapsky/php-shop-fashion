$(document).ready(function(){
    //filters main
    const shopForm = $('#shop-form');
    const addFiltersBtn = $('#add-filters-btn');
    const shopWrapper = $('.js-shop-sorting');
    const newsLinkElem = $('.js-news');
    const salesLinkElem = $('.js-sale');
    let minPriceElem = $('.js-min-price');
    let maxPriceElem = $('.js-max-price');

    //order
    const orderForm = $('#js-order-form');
    const orderFormBtn = $('#js-order-btn');
    const orderSuccessBtn = $('#js-order-success-btn');
    const productsItems = $('.product');

    const shopOrder = document.querySelector('.shop-page__order');
    const popupEnd = document.querySelector('.shop-page__popup-end');

    //order-status
    const changeOrderStatusBtn = $('.js-order-item-btn');

    //admin page-products
    const pageProductsElem = $('.page-products');

    //add-product
    const pageAddElem = $('.page-add');
    const addProductForm = document.querySelector('#js-add-product-form');

    //edit-product
    const editProductForm = document.querySelector('#js-edit-product-form');
    const editProductBtn = $('#js-edit-product-btn');
    const productPhotoItem = $('.add-list__item--active');

    //auth
    const authForm = $('#js-auth-form');
    const authFormBtn = $('#js-auth-form-btn');

    //main page shop
    newsLinkElem.on('click', function (event) {
        event.preventDefault();
        let href = location.href;

        if (href.includes('delivery')) {
            href = href.substr(0, href.indexOf('delivery'));
        }

        if (href.includes('?')) {
            href = href.substr(0, href.indexOf('?')) + '?new=on';
        } else {
            href = href + '?new=on';
        }
        location.href = href;
    });

    salesLinkElem.on('click', function (event) {
        event.preventDefault();
        let href = location.href;

        if (href.includes('delivery')) {
            href = href.substr(0, href.indexOf('delivery'));
        }

        if (href.includes('?')) {
            href = href.substr(0, href.indexOf('?')) + '?sale=on';
        } else {
            href = href + '?sale=on';
        }
        location.href = href;
    });

    shopWrapper.on('change', '.js-orderByCat', function (event) {
        event.preventDefault();

        let url = '';
        let href = location.href;

        const val = $(this).val();

        function getResponse(url, href) {
            if (!href.includes('how=')) {
                if (href.includes('?')) {
                    href += '&' + url;
                } else {
                    href += '?' + url;
                }

                history.pushState(null, null, href);
                const data = href.substr(href.indexOf('?') + 1) + `&url=${href}`;

                $.get('/src/templates/shop-wrapper.php', data, function (response) {
                    $('.js-shop-sorting').html(response);
                });
            } else {
                if (href.indexOf('?') === href.indexOf('how=') - 1) {   //  fashion/?how= ?
                    href = href.substr(0, href.indexOf('how') - 1) + '?' + url;
                } else {
                    href = href.substr(0, href.indexOf('how') - 1) + '&' + url;
                }

                history.pushState(null, null, href);
                const data = href.substr(href.indexOf('?') + 1) + `&url=${href}`;

                $.get('/src/templates/shop-wrapper.php', data, function (response) {
                    $('.js-shop-sorting').html(response);
                })
            }
        }

        if (val === 'price'){
            url = 'how=price';

            getResponse(url, href);
        } else if (val === 'name') {
            url = 'how=name';

            getResponse(url, href);
        }
    });


    shopWrapper.on('change', '.js-sortedBy', function (event) {
        event.preventDefault();

        const selectOrderByElem = $('.js-orderByCat');

        let href = location.href;

        const val = $(this).val();

        if (href.includes('how=')) {
            if (val === 'ASC') {
                href = href.substr(0, href.indexOf('how=')) + 'how=a' + selectOrderByElem.val();
            } else if (val === 'DESC') {
                href = href.substr(0, href.indexOf('how=')) + 'how=d' + selectOrderByElem.val();
            }

            history.pushState(null, null, href);
            const data = href.substr(href.indexOf('?') + 1) + `&url=${href}`;

            $.get('/src/templates/shop-wrapper.php', data, function (response) {
                $('.js-shop-sorting').html(response);
            });
        }
    });

    shopWrapper.on('click', '.product', function (event) {
        const products = Array.from(productsItems);

        products.forEach(item => {
            if (item.classList.contains('selected')) {
                item.classList.remove('selected')
            }
        });

        const target = event.target;
        target.classList.add('selected');

        const shopOrder = document.querySelector('.shop-page__order');

        toggleHidden(document.querySelector('.intro'), document.querySelector('.shop'), shopOrder);

        window.scroll(0, 0);

        shopOrder.classList.add('fade');
        setTimeout(() => shopOrder.classList.remove('fade'), 1000);

        const form = shopOrder.querySelector('.custom-form');
        labelHidden(form);
        toggleDelivery(shopOrder);
    });

    shopWrapper.on('click', '.paginator__item--shop', function (event) {
        event.preventDefault();

        let href = location.href;

        let pageVal = $(this).text();

        if (!href.includes('page=')) {
            if (href.includes('?')) {
                href += '&page=' + pageVal;
            } else {
                href += '?page=' + pageVal;
            }

            location.href = href;
        } else {
            if (href.indexOf('?') === href.indexOf('page=') - 1) {
                if (href.indexOf('&', href.indexOf('page')) === -1) {
                    href = href.substr(0, href.indexOf('page') - 1) + '?page=' + pageVal;
                } else {
                    href = href.substr(0, href.indexOf('page') - 1) + '?page=' + pageVal + href.substr(href.indexOf('&', href.indexOf('page')))
                }
            } else {
                if (href.indexOf('&', href.indexOf('page')) === -1) {
                    href = href.substr(0, href.indexOf('page') - 1) + '&page=' + pageVal;
                } else {
                    href = href.substr(0, href.indexOf('page') - 1) + '&page=' + pageVal + href.substr(href.indexOf('&', href.indexOf('page')));
                }
            }
            location.href = href;
        }
    });

    addFiltersBtn.on('click', function (event) {
        event.preventDefault();

        const minPrice = Number(minPriceElem.text().slice(0,-5));  // 325 руб. = 325
        const maxPrice = Number(maxPriceElem.text().slice(0,-5));

        let data = shopForm.serialize();

        if (data) {
            data += `&maxprice=${maxPrice}&minprice=${minPrice}`;
        } else {
            data = `maxprice=${maxPrice}&minprice=${minPrice}`
        }

        const url = $(location).attr('href').split('?')[0];
        history.pushState(null, null, url + '?' + data);

        data += `&url=${url}`;

        $.get('/src/templates/shop-wrapper.php', data, function (response) {
            $('.js-shop-sorting').html(response);
        });
    });

    //make order
    orderFormBtn.on('click', function (event) {
        event.preventDefault();

        let itemSrc = $('.selected').children('.product__image').children().attr("src");
        itemSrc = itemSrc.substr(itemSrc.lastIndexOf('/') + 1);

        let data = orderForm.serialize();

        if (!itemSrc.empty) {
            data += '&src=' + itemSrc;
        }

        $.post('/src/templates/createOrder.php', data, function (response) {
            if (response === 'Заказ создан') {
                toggleHidden(shopOrder, popupEnd);
                popupEnd.classList.add('fade');
                setTimeout(() => popupEnd.classList.remove('fade'), 1000);
            } else if (response === 'Не удалось создать заказ') {
                alert('Не удалось создать заказ, попробуйте еще раз')
            } else {
                alert(response);
            }
        })
    });

    orderSuccessBtn.on('click', function (event) {
        popupEnd.classList.add('fade-reverse');
        setTimeout(() => {
            popupEnd.classList.remove('fade-reverse');

            toggleHidden(popupEnd, document.querySelector('.intro'), document.querySelector('.shop'));
        }, 1000);

        orderForm[0].reset();
    });

    //admin edit products
    pageProductsElem.on('click', '.js-edit-product-btn', function (event) {
        event.preventDefault();

        const productID = event.target.closest('.product-item').querySelectorAll('.product-item__field')[0].innerHTML;

        let href = '/admin/products/edit/' + '?edit_product_id=' + productID;

        location.href = href;
    });

    pageProductsElem.on('click', '.js-product-delete-btn', function (event) {
        event.preventDefault();

        const productID = event.target.closest('.product-item').querySelectorAll('.product-item__field')[0].innerHTML;
        let data = 'del_product_id=' + productID;

        $.post('/admin/products/del_product.php', data, function (response) {
            if (response === 'Продукт успешно удален') {
                location.reload();
                alert(response);
            } else {
                alert(response);
            }
        });
    });

    pageProductsElem.on('click', '.paginator__item--page-products', function (event) {
        event.preventDefault();

        let href = location.href;
        let pageVal = $(this).text();

        if (!href.includes('page=')) {
            if (href.includes('?')) {
                href += '&page=' + pageVal;
            } else {
                href += '?page=' + pageVal;
            }

            history.pushState(null, null, href);
            const data = href.substr(href.indexOf('?') + 1) + `&url=${href}`;

            $.get('/admin/products/products_list.php', data, function (response) {
                $('#js-products-list').html(response);
            });
        } else {
            href = href.substr(0, href.indexOf('page') - 1) + '?page=' + pageVal;

            history.pushState(null, null, href);
            const data = href.substr(href.indexOf('?') + 1) + `&url=${href}`;

            $.get('/admin/products/products_list.php', data, function (response) {
                $('#js-products-list').html(response);
            });
        }
    });

    pageAddElem.on('click', '#js-add-product-btn', function (event) {
        event.preventDefault();

        const form_data = new FormData(addProductForm);

        $.ajax({
            url: '/admin/products/add/add_product.php',
            data: form_data,
            processData: false,
            contentType: false,
            type: "POST",
            success: function(response) {
                if (response === 'Продукт успешно добавлен') {
                    addProductForm.hidden = true;
                    popupEnd.hidden = false;
                } else {
                    alert(response);
                }
            },
            error: function(response) {
                alert('данные не отправлены');
            }
        });
    });

    editProductBtn.on('click', (event) => {
        event.preventDefault();
        const form_data = new FormData(editProductForm);
        const href = location.href;
        const selectedProductID = href.substr(href.lastIndexOf('id')+3);

        let productSrc = $('.add-list__item--active >img').attr('src');
        if (productSrc) {
            productSrc = productSrc.substr(productSrc.lastIndexOf('/') + 1);
            form_data.append('productSrc', productSrc);
        }

        form_data.append('productID', selectedProductID);

        $.ajax({
            url: '/admin/products/edit/edit_product.php',
            data: form_data,
            processData: false,
            contentType: false,
            type: "POST",
            success: function(response) {
                if (response === 'Файл успешно изменен') {
                    editProductForm.hidden = true;
                    popupEnd.hidden = false;
                } else {
                    alert(response);
                }
            },
            error: function(response) {
                alert('данные не отправлены');
            }
        });
    });

    productPhotoItem.on('click', (event) => {
        event.target.remove();
        document.querySelector('.add-list__item--add').hidden = false;
    });

    changeOrderStatusBtn.on('click', function (event) {
        event.preventDefault();

        const status = event.target.previousElementSibling;
        const selectedOrderID = '&orderID=' + this.closest('.order-item').querySelector('.order-item__info--id').textContent;
        const data = 'orderStatus=' + status.textContent + selectedOrderID;

        $.post('/admin/orders/changeOrder.php', data, function (response) {
            if (response === 'Успех') {
                if (status.classList && status.classList.contains('order-item__info--no')) {
                    status.textContent = 'Обработан';
                } else {
                    status.textContent = 'Не обработан';
                }

                status.classList.toggle('order-item__info--no');
                status.classList.toggle('order-item__info--yes');

                location.reload();
            } else if (response === 'error') {
                alert('Ошибка изменения данных в базе данных. Данные не были изменены')
            } else {
                alert('Ошибка передачи данных');
            }
        });
    });

    //admin auth
    authFormBtn.on('click', function (event) {
        event.preventDefault();

        let data = authForm.serialize();

        $.post('/admin/login.php', data, function (response) {
            if (response === 'Успех') {
                location.href = '/admin/orders/';
            } else if (response === 'Пользователь не имеет достаточно прав') {
                 alert(response);
            } else {
                alert(response);
            }
        })
    });
});

