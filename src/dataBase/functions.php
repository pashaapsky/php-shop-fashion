<?php

namespace dataBase;

function setConnectToDB() {
    require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

    $connect = mysqli_connect(HOST, USER, PASSWORD, DBNAME);

    if (!$connect) {
       echo "Ошибка: Невозможно установить соединение с MySQL." . PHP_EOL;
       echo "Код ошибки errno: " . mysqli_connect_errno() . PHP_EOL;
       echo "Текст ошибки error: " . mysqli_connect_error() . PHP_EOL;
       exit;
    } else {
        return $connect;
    }
}

function getCategoriesFromDB ($connect) {
    $categories = [];

    $result = mysqli_query($connect,
        "select * from category");

    while ($row = mysqli_fetch_assoc($result)) {
        array_push($categories, [
            'id' => $row['id'],
            'name' => $row['name'],
            'url' => $row['url'],
        ]);
    }

    mysqli_close($connect);

    return $categories;
}

function addFilterCondition($where, $add, $and = true)
{
    if ($where) {
        if ($and) $where .= " AND $add";
        else $where .= " OR $add";
    } else $where = $add;
    return $where;
}

function getProductsWithFilters ($connect, $params, $start, $countItemsOnPage) {
    if (!empty($params['url'])) {
        $url = parse_url($params['url'], PHP_URL_PATH);
    } else {
        $url = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
    }

    $products = [];
    $where = "";
    $orderBy = "";
    $pagination = " LIMIT $start, $countItemsOnPage";

    if (!empty($params)) {
        if (isset($params['sale'])) { $where = addFilterCondition($where, "p.sale = 1");}
        if (isset($params['new'])) { $where = addFilterCondition($where, "p.new = 1");}
        if (isset($params['minprice'])) { $where = addFilterCondition($where, "p.price >= " . $_GET['minprice']);}
        if (isset($params['maxprice'])) { $where = addFilterCondition($where, "p.price <= " . $_GET['maxprice']);}

        if (isset($params['how'])) {
            if ($params['how'] === 'name' || $_GET['how'] === 'aname') { $orderBy = "p.name ASC";}
            if ($params['how'] === 'price' || $_GET['how'] === 'aprice') { $orderBy = "p.price ASC";}
            if ($params['how'] === 'dname') { $orderBy = "p.name DESC";}
            if ($params['how'] === 'dprice') { $orderBy = "p.price DESC";}
        }

        if (!empty($where)) { $where = " WHERE $where ";}
        if (!empty($orderBy)) { $orderBy = " order by $orderBy ";}
    }

    if ($url === '/' || $url === '/index.php') {
        $defaultQuerry = "select * from products p";

        $result = mysqli_query($connect, "select COUNT(*) FROM products p" . $where . $orderBy);
        $productsWithFilters = mysqli_fetch_row($result);

        $result = mysqli_query($connect, $defaultQuerry . $where . $orderBy . $pagination);
    } else {
        $url = $connect->real_escape_string($url);

        $result = mysqli_query($connect,
            "select id from category where url = '$url'");

        $catId = mysqli_fetch_assoc($result);
        $catId = $connect->real_escape_string($catId['id']);

        $defaultQuerry = "select * from products p join categoty_product cp on p.id = cp.product_id and cp.category_id = '$catId'";

        $result = mysqli_query($connect, "select count(*) from products p join categoty_product cp on p.id = cp.product_id and cp.category_id = '$catId'" . $where . $orderBy);
        $productsWithFilters = mysqli_fetch_row($result);

        $result = mysqli_query($connect, $defaultQuerry . $where . $orderBy . $pagination);
    }

    while ($row = mysqli_fetch_assoc($result)) {
        array_push($products, [
            'id' => $row['id'],
            'name' => $row['name'],
            'price' => $row['price'],
            'count' => $row['count'],
            'description' => $row['description'],
            'photo' => $row['photo'],
            'sale' => $row['sale'],
            'new' => $row['new'],
            ]);
    }

    mysqli_close($connect);

    return ['products' => $products, 'productsWithFilters' =>  $productsWithFilters[0]];
}

function getProductSrcById($connect, $id) {
    $id=$connect->real_escape_string($id);
    $result = mysqli_query($connect, "select photo from products where id='$id'");

    $result = mysqli_fetch_assoc($result);

    mysqli_close($connect);
    return $result;
}

function getProductsInfo ($connect, $start, $countItemsOnPage) {
    $categoryProduct = [];
    $products = [];

    if($countItemsOnPage === 0 && $start === 0) {
        $pagination = "";
    } else {
        $pagination = " LIMIT $start, $countItemsOnPage";
    }

    $result = mysqli_query($connect,
        "select * from products" . $pagination);

    while ($row = mysqli_fetch_assoc($result)) {
        array_push($products, [
            'id' => $row['id'],
            'name' => $row['name'],
            'price' => $row['price'],
            'photo' => $row['photo'],
            'category' => [],
            'new' => $row['new'],
            'sale' => $row['sale'],
        ]);
    }

    $result = mysqli_query($connect,
        "select cp.category_id, cp.product_id, c.name from categoty_product cp join category c on cp.category_id = c.id order by cp.product_id" . $pagination);

    while ($row = mysqli_fetch_assoc($result)) {
        array_push($categoryProduct, [
            'cat_id' => $row['category_id'],
            'product_id' => $row['product_id'],
            'name' => $row['name'],
        ]);
    }

    mysqli_close($connect);

    foreach ($products as &$product) {
        foreach ($categoryProduct as $cp) {
            if ($product['id'] === $cp['product_id']) {
                array_push($product['category'], $cp['name']);
            }
        }
    }

    return $products;
}

function getCategoriesInfo($connect) {
    $categories = [];

    $result = mysqli_query($connect,
        "select * from category");

    while ($row = mysqli_fetch_assoc($result)) {
        array_push($categories, $row['name']);
    }

    mysqli_close($connect);

    return $categories;
}

function getNavMenu() {
        if (!empty($_COOKIE['grants'])) : ?>
            <?php if ($_COOKIE['grants'] === 'admin') : ?>
                <ul class="main-menu main-menu--header">
                    <li>
                        <a class="main-menu__item" href="/">Главная</a>
                    </li>

                    <li>
                        <a class="main-menu__item" href="/admin/products/">Товары</a>
                    </li>

                    <li>
                        <a class="main-menu__item active" href="/admin/orders/">Заказы</a>
                    </li>

                    <li>
                        <a class="main-menu__item" href="/?logout=yes">Выйти</a>
                    </li>
                </ul>
            <?php elseif ($_COOKIE['grants'] === 'operator') : ?>
                <ul class="main-menu main-menu--header">
                    <li>
                        <a class="main-menu__item" href="/">Главная</a>
                    </li>

                    <li>
                        <a class="main-menu__item active" href="/admin/orders/">Заказы</a>
                    </li>

                    <li>
                        <a class="main-menu__item" href="/?logout=yes">Выйти</a>
                    </li>
                </ul>
            <?php endif; ?>
        <?php else : ?>
            <ul class="main-menu main-menu--header">
                <li>
                    <a class="main-menu__item" href="/">Главная</a>
                </li>

                <li>
                    <a class="main-menu__item js-news" href="">Новинки</a>
                </li>

                <li>
                    <a class="main-menu__item active js-sale" href="">Sale</a>
                </li>

                <li>
                    <a class="main-menu__item" href="/delivery/">Доставка</a>
                </li>
            </ul>
        <?php endif;
}

function getFooterNavMenu() {
    if (!empty($_COOKIE['grants'])) : ?>
        <?php if ($_COOKIE['grants'] === 'admin') : ?>
            <ul class="main-menu main-menu--footer">
                <li>
                    <a class="main-menu__item" href="/">Главная</a>
                </li>

                <li>
                    <a class="main-menu__item" href="/admin/products/">Товары</a>
                </li>

                <li>
                    <a class="main-menu__item" href="/admin/orders/">Заказы</a>
                </li>

                <li>
                    <a class="main-menu__item" href="/?logout=yes">Выйти</a>
                </li>
            </ul>
        <?php elseif ($_COOKIE['grants'] === 'operator') : ?>
            <ul class="main-menu main-menu--footer">
                <li>
                    <a class="main-menu__item" href="/">Главная</a>
                </li>

                <li>
                    <a class="main-menu__item" href="/admin/orders/">Заказы</a>
                </li>

                <li>
                    <a class="main-menu__item" href="/?logout=yes">Выйти</a>
                </li>
            </ul>
        <?php endif; ?>
    <?php else : ?>
        <ul class="main-menu main-menu--footer">
            <li>
                <a class="main-menu__item" href="/">Главная</a>
            </li>

            <li>
                <a class="main-menu__item js-news" href="">Новинки</a>
            </li>

            <li>
                <a class="main-menu__item active js-sale">Sale</a>
            </li>

            <li>
                <a class="main-menu__item" href="/delivery/">Доставка</a>
            </li>
        </ul>
    <?php endif;
}

function getCategoryMenu($category) {
    $url = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

    if (($url === '/') || ($url === '/index.php')): ?>
        <li>
            <a class="filter__list-item active" href="/">Все</a>
        </li>
        <?php foreach ($category as $item) : ?>
            <li>
                <a class="filter__list-item" href="<?= $item['url']?>"><?= $item['name'] ?></a>
            </li>
        <?php endforeach; ?>
    <?php else: ?>
        <li>
            <a class="filter__list-item" href="/">Все</a>
        </li>
        <?php foreach ($category as $item) : ?>
            <?php if ($url === $item['url']) :?>
                <li>
                    <a class="filter__list-item active" href="<?= $item['url']?>"><?= $item['name'] ?></a>
                </li>
            <?php else: ?>
                <li>
                    <a class="filter__list-item" href="<?= $item['url']?>"><?= $item['name'] ?></a>
                </li>
            <?php endif;?>
        <?php endforeach; ?>
    <?php endif;
};

function getUsersFromDB($connect) {
    $defaultQuerry = "select * from users";

    $result = mysqli_query($connect, $defaultQuerry);

    $users = [];

    while ($row = mysqli_fetch_assoc($result)){
       array_push($users, $row);
    };

    mysqli_close($connect);

    return $users;
}

function checkUserInDB($users, $data) {
    if (!empty($data['email'])) {
        foreach ($users as $user) {
            if ($user['login'] === $data['email']) {
                return $user;
            }
        }
        return false;
    } else {
        return false;
    }
}

function createNewUser($connect, $data) {
    $login = $connect->real_escape_string($data['email']);
    $name = $connect->real_escape_string($data['name']);
    $surName = $connect->real_escape_string($data['surname']);
    $thirdName = $connect->real_escape_string($data['thirdName']);
    $phone = $connect->real_escape_string($data['phone']);

    $result = mysqli_query($connect,
        "insert into users (login, name, surname, thirdName, phone)
            values ('$login', '$name', '$surName', '$thirdName', '$phone')");

    if ($result) {
        $createdUserID = mysqli_insert_id($connect);

        $result = mysqli_query($connect,
            "insert into group_user (group_id, user_id)
            values (4, '$createdUserID')");

        mysqli_close($connect);

        return $createdUserID;
    } else {
        mysqli_close($connect);

        return false;
    }
}

function getUserGroup($connect, $user) {
    $userID = $connect->real_escape_string($user['id']);

    $result = mysqli_query($connect, "select * from group_user gu join `groups` g where gu.user_id = '$userID' and gu.group_id = g.id");

    $groups = [];

    while($row =mysqli_fetch_assoc($result)) {
        array_push($groups, $row);
    };

    mysqli_close($connect);

    return $groups;
}

function validationOrderFields($data) {
        if (empty($data['surname'])) {
            return 'Не заполнено поле : Фамилия.' . PHP_EOL;
        }

        if (empty($data['name'])) {
            return 'Не заполнено поле : Имя.' . PHP_EOL;
        }

        if (empty($data['phone'])) {
            return 'Не заполнено поле : Телефон.' . PHP_EOL;
        }

        if (empty($data['email'])) {
            return 'Не заполнено поле : Email.' . PHP_EOL;
        }

        if ($data['delivery'] === 'del-yes') {
            if (empty($data['city'])) {
                return 'Не заполнено поле : Город.' . PHP_EOL;
            }
            if (empty($data['street'])) {
                return 'Не заполнено поле : Улица.' . PHP_EOL;
            }
            if (empty($data['home'])) {
                return 'Не заполнено поле : Дом.' . PHP_EOL;
            }
            if (empty($data['aprt'])) {
                return 'Не заполнено поле : Квартира.' . PHP_EOL;
            }
        }

        return 'Success Validation Fields';
}

function getProductFromDB($connect, $data) {
    $src = $data['src'];
    $src = $connect->real_escape_string($src);

    $result = mysqli_query($connect, "select * from products p where p.photo = '$src'");
    $result = mysqli_fetch_assoc($result);

    mysqli_close($connect);

    return $result;
}

function validateNewProduct($data){
    if (!isset($data['product-name']) || empty($data['product-name'])) {
        echo 'Не заполнено поле : имя продукта';
        return false;
    };

    if (!isset($data['product-price']) || empty($data['product-price'])) {
        echo 'Не заполнено поле : цена продукта';
        return false;
    };

    if (empty($_FILES['product-photo']['name'])) {
        echo 'Не выбрано фото продукта';
        return false;
    };

    if (!isset($data['category']) || empty($data['category'])) {
        echo 'Не выбрана категория продукта';
        return false;
    };

    return true;
}

function createNewProduct($connect, $data, $photo) {
    $name = $connect->real_escape_string($data['product-name']);
    $price = $connect->real_escape_string($data['product-price']);
    $photo = $connect->real_escape_string($photo);
    isset($data['new']) && $data['new'] === 'on' ? $new = '1' : $new = '0';
    isset($data['sale']) && $data['sale'] === 'on' ? $sale = '1' : $sale = '0';
    $count = '1';

    $category = $data['category'];
    $photoArr = [];

    //проверка на уникальность названия загружаемого файла
    $result = mysqli_query($connect,
        "select photo from products");

    while ($row = mysqli_fetch_assoc($result)) {
        array_push($photoArr, $row['photo']);
    }

    if (in_array($photo, $photoArr)) {
        $type = mb_substr($photo, mb_strripos($photo, '.'));
        $photo = mb_substr($photo, 0, mb_strripos( $photo, '.')) . '_' . strval(rand(0, 10**6)) . $type;
    }

    $result = mysqli_query($connect,
    "insert into products (name, price, count, photo, sale, new)
            values ('$name', '$price', '$count', '$photo', '$sale' , '$new')");

    $productID = mysqli_insert_id($connect);

    foreach ($category as $cat) {
        $result = mysqli_query($connect,
            "select id from category where name = '$cat'");

        $catID = mysqli_fetch_assoc($result)['id'];

        $result = mysqli_query($connect,
            "insert into categoty_product (product_id, category_id)
            values ('$productID', '$catID')");
    }

    mysqli_close($connect);

    return $photo;
}

function createOrder($connect, $userId, $product, $data) {
        $productID = $connect->real_escape_string($product['id']);
        $city = $connect->real_escape_string($data['city']);
        $home = $connect->real_escape_string($data['home']);
        $street = $connect->real_escape_string($data['street']);
        $aprt = $connect->real_escape_string($data['aprt']);
        $price = $product['price'];
        $comment = $connect->real_escape_string($data['comment']);

        $payment = $data['pay'];
        if ($payment === 'card') {
            $payment = 'Банковской картой';
        } elseif ($payment === 'cash') {
            $payment = 'Наличными';
        }

        if ($data['delivery'] === 'del-no') {
            $price = $connect->real_escape_string($price);
            $result = mysqli_query($connect,
                "insert into orders (user_id, product_id, delivery, price, payment, comment)
                values ('$userId' , '$productID' , 'Самовывоз', '$price', '$payment', '$comment')");

            return $result;
        } elseif ($data['delivery'] === 'del-yes'){
            if ($price < 2000) {
                $price += 280;
            }
            $price = $connect->real_escape_string($price);

            $result = mysqli_query($connect,
                "insert into orders (user_id, product_id, delivery, city, street, home, aprt, price, payment, comment)
                values ('$userId' , '$productID' , 'Курьерская доставка', '$city', '$street', '$home', '$aprt', '$price', '$payment', '$comment')");

            return $result;
        } else {
            return false;
        }
}

function getUserFromOrder($order) {
    $connect = setConnectToDB();

    $orderID = $connect->real_escape_string($order['id']);

    $result = mysqli_query($connect, "select u.id, u.login, u.password, u.name, u.surname, u.phone, u.thirdName from users u join orders o where u.id = o.user_id and o.id = '$orderID'");
    return mysqli_fetch_assoc($result);
}

function getOrdersList($connect) {
    $result = mysqli_query($connect,
        "select * from orders order by status ASC, created_at DESC ");

    $orders = [];

    while ($row = mysqli_fetch_assoc($result)) {
        array_push($orders, $row);
    };

    mysqli_close($connect);

    return $orders;
}

function updateOrderStatus($connect, $orderID, $orderStatus) {
    $orderStatus === 'Не обработан' ? $orderStatus = 'Обработан' : $orderStatus = 'Не обработан';

    $orderStatus = $connect->real_escape_string($orderStatus);
    $orderID = $connect->real_escape_string($orderID);

    $result = mysqli_query($connect,
        "UPDATE orders o set o.status = '$orderStatus' where o.id = '$orderID'");

    mysqli_close($connect);
}

function checkLoadData($data) {
    if (empty($data['product-name'])) {
        echo 'Не заполнено поле : Название товара.' . PHP_EOL;
        return;
    }

    if (empty($data['product-price']) || !is_numeric($data['product-price'])) {
        echo 'Не заполнено поле : Цена товара, либо задано неверное значение.' . PHP_EOL;
        return;
    }

    if (empty($data['category'])) {
        echo 'Не выбрана категория товара.' . PHP_EOL;
        return;
    }

    return true;
}

function checkLoadFileType($itemTmpPath) {
    $correctFilesTypes = ['image/png', 'image/jpeg', 'image/jpg'];
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $fileType = finfo_file($finfo, $itemTmpPath);

    if (in_array($fileType, $correctFilesTypes)) {
        return true;
    }
    else return false;
}

function loadEditedProductFileToDB($targetPath) {
    $errorMessages = [
        UPLOAD_ERR_INI_SIZE => 'Размер файла превысил значение upload_max_filesize в конфигурации PHP.',
        UPLOAD_ERR_FORM_SIZE => 'Размер загружаемого файла превысил значение MAX_FILE_SIZE в HTML-форме.',
        UPLOAD_ERR_PARTIAL => 'Загружаемый файл был получен только частично.',
        UPLOAD_ERR_NO_FILE => 'Файл не был загружен.',
        UPLOAD_ERR_NO_TMP_DIR => 'Отсутствует временная папка.',
        UPLOAD_ERR_CANT_WRITE => 'Не удалось записать файл на диск.',
        UPLOAD_ERR_EXTENSION => 'PHP-расширение остановило загрузку файла.',
    ];
    $unknownMessage = 'При загрузке файла произошла неизвестная ошибка.';

    $error = $_FILES["product-photo"]['error'];

    if ($error == UPLOAD_ERR_OK) {
        $tmp_name = $_FILES["product-photo"]["tmp_name"];

        if (checkLoadFileType($tmp_name)){
            move_uploaded_file($tmp_name, $targetPath);
            return 'Файл успешно добавлен';
        } else {
            return 'Тип загружаемого файла не поддерживается.' . PHP_EOL;
        }
    } else {
        $outputMessage = isset($errorMessages[$error]) ? $errorMessages[$error] : $unknownMessage;
        return $outputMessage;
    }
}

function loadNewProductToDB()
{
    $loadFileStatus = false;
    $createProductStatus = false;

    $errorMessages = [
        UPLOAD_ERR_INI_SIZE => 'Размер файла превысил значение upload_max_filesize в конфигурации PHP.',
        UPLOAD_ERR_FORM_SIZE => 'Размер загружаемого файла превысил значение MAX_FILE_SIZE в HTML-форме.',
        UPLOAD_ERR_PARTIAL => 'Загружаемый файл был получен только частично.',
        UPLOAD_ERR_NO_FILE => 'Файл не был загружен.',
        UPLOAD_ERR_NO_TMP_DIR => 'Отсутствует временная папка.',
        UPLOAD_ERR_CANT_WRITE => 'Не удалось записать файл на диск.',
        UPLOAD_ERR_EXTENSION => 'PHP-расширение остановило загрузку файла.',
    ];
    $unknownMessage = 'При загрузке файла произошла неизвестная ошибка.';

    $error = $_FILES["product-photo"]['error'];

    if ($error == UPLOAD_ERR_OK) {
        $tmp_name = $_FILES["product-photo"]["tmp_name"];

        if (checkLoadFileType($tmp_name)) {
            $loadFileStatus = true;
        } else {
            echo 'Тип загружаемого файла не поддерживается.' . PHP_EOL;
        }
    } else {
        $outputMessage = isset($errorMessages[$error]) ? $errorMessages[$error] : $unknownMessage;
        echo $outputMessage;
    }

    if (checkLoadData($_POST)) {
        $name = basename($_FILES["product-photo"]["name"]);
        $name = \dataBase\createNewProduct(\dataBase\setConnectToDB(), $_POST, $name);

        $targetPath = $_SERVER['DOCUMENT_ROOT'] . '/src/img/products/' . $name;
        $createProductStatus = true;
    }

    if ($createProductStatus && $loadFileStatus) {
        move_uploaded_file($tmp_name, $targetPath);
        echo 'Продукт успешно добавлен';
    }
}