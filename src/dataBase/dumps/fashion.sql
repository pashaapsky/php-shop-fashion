-- MySQL dump 10.13  Distrib 8.0.20, for Win64 (x86_64)
--
-- Host: fashion    Database: fashion
-- ------------------------------------------------------
-- Server version	8.0.15

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8 */;
CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `category_id_uindex` (`id`),
  UNIQUE KEY `category_name_uindex` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (1,'Женщины','/category/women/'),(2,'Мужчины','/category/men/'),(3,'Дети','/category/children/'),(4,'Аксессуары','/category/accessories/');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categoty_product`
--

DROP TABLE IF EXISTS `categoty_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8 */;
CREATE TABLE `categoty_product` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`,`category_id`),
  KEY `categoty_product_category_id_fk` (`category_id`),
  CONSTRAINT `categoty_product_category_id_fk` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  CONSTRAINT `categoty_product_products_id_fk` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categoty_product`
--

LOCK TABLES `categoty_product` WRITE;
/*!40000 ALTER TABLE `categoty_product` DISABLE KEYS */;
INSERT INTO `categoty_product` VALUES (8,1),(9,1),(10,1),(11,1),(12,1),(13,1),(14,1),(15,1),(5,2),(6,2),(7,2),(84,2),(85,2),(86,2),(87,2),(88,2),(2,3),(3,3),(4,3),(79,3),(80,3),(81,3),(82,3),(83,3),(1,4),(71,4),(72,4),(73,4),(74,4),(75,4),(76,4),(77,4),(78,4);
/*!40000 ALTER TABLE `categoty_product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `group_user`
--

DROP TABLE IF EXISTS `group_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8 */;
CREATE TABLE `group_user` (
  `group_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`group_id`,`user_id`),
  KEY `group_user_users_id_fk` (`user_id`),
  CONSTRAINT `group_user_groups_id_fk` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`),
  CONSTRAINT `group_user_users_id_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `group_user`
--

LOCK TABLES `group_user` WRITE;
/*!40000 ALTER TABLE `group_user` DISABLE KEYS */;
INSERT INTO `group_user` VALUES (1,1),(3,1),(2,2),(3,2),(2,3),(4,4),(4,5),(4,6);
/*!40000 ALTER TABLE `group_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8 */;
CREATE TABLE `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `groups_id_uindex` (`id`),
  UNIQUE KEY `groups_name_uindex` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groups`
--

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
INSERT INTO `groups` VALUES (1,'Администратор'),(3,'Зарегистрированный пользователь'),(4,'Незарегистрированный пользователь'),(2,'Оператор');
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `delivery` varchar(255) NOT NULL,
  `city` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `home` varchar(255) DEFAULT NULL,
  `aprt` varchar(255) DEFAULT NULL,
  `price` float NOT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `payment` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(255) NOT NULL DEFAULT 'Не обработан',
  PRIMARY KEY (`id`),
  UNIQUE KEY `orders_id_uindex` (`id`),
  KEY `orders_users_id_fk` (`user_id`),
  KEY `orders_products_id_fk` (`product_id`),
  CONSTRAINT `orders_products_id_fk` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  CONSTRAINT `orders_users_id_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,1,1,'Самовывоз','Москва','Московская','90','25',1000,'До 18.00','Банковской картой','2020-06-26 06:20:36','Не обработан'),(2,1,1,'Самовывоз',NULL,NULL,NULL,NULL,1000,'','','2020-06-26 06:20:38','Не обработан'),(4,1,4,'Курьерская доставка','Москва','Московская','22','2123',4000,'qweqewq','Банковской картой','2020-06-26 06:20:38','Не обработан'),(23,1,1,'Самовывоз',NULL,NULL,NULL,NULL,1000,'','Банковской картой','2020-06-26 06:24:55','Не обработан'),(24,3,2,'Самовывоз',NULL,NULL,NULL,NULL,2000,'Комментарий','Банковской картой','2020-06-26 10:15:18','Не обработан'),(25,1,5,'Самовывоз',NULL,NULL,NULL,NULL,5000,'Заказ','Банковской картой','2020-06-28 10:45:46','Не обработан'),(26,1,1,'Самовывоз',NULL,NULL,NULL,NULL,1000,'','Банковской картой','2020-06-28 11:18:00','Не обработан'),(27,1,4,'Самовывоз',NULL,NULL,NULL,NULL,4000,'','Банковской картой','2020-06-29 11:08:29','Не обработан'),(28,1,5,'Самовывоз',NULL,NULL,NULL,NULL,5000,'','Наличными','2020-06-29 11:09:21','Обработан'),(29,1,1,'Самовывоз',NULL,NULL,NULL,NULL,1000,'','Банковской картой','2020-06-30 08:25:00','Не обработан'),(30,1,4,'Самовывоз',NULL,NULL,NULL,NULL,4000,'','Банковской картой','2020-07-03 11:53:14','Не обработан'),(31,1,9,'Самовывоз',NULL,NULL,NULL,NULL,9000,'','Банковской картой','2020-07-03 12:18:07','Обработан'),(32,1,2,'Самовывоз',NULL,NULL,NULL,NULL,2000,'qwe','Наличными','2020-07-09 09:24:04','Не обработан'),(33,5,67,'Самовывоз',NULL,NULL,NULL,NULL,2555,'unregister','Банковской картой','2020-07-12 09:45:59','Не обработан'),(34,1,2,'Курьерская доставка','Москва','Московское шоссе','22','22',2000,'Заказ','Банковской картой','2020-07-12 09:49:51','Не обработан'),(35,6,6,'Самовывоз',NULL,NULL,NULL,NULL,6000,'newsa','Наличными','2020-07-14 07:40:56','Не обработан');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `count` int(11) NOT NULL DEFAULT '1',
  `description` text,
  `photo` varchar(255) NOT NULL,
  `sale` tinyint(1) NOT NULL DEFAULT '0',
  `new` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_photo_uindex` (`photo`)
) ENGINE=InnoDB AUTO_INCREMENT=89 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'Часы',24000.00,1,'Часы','accessories_1.jpg',0,1),(2,'Детская футболка Likee',2000.00,1,'Футболка','children_1.jpg',0,1),(3,'Детская футболка Likee',1500.00,1,'Футболка','children_2.jpg',0,1),(4,'Детская футболка',4000.00,1,'Футболка','children_3.jpg',0,0),(5,'Мужская футболка',5000.00,1,'Футболка','men_1.jpg',1,0),(6,'Мужская футболка',6000.00,1,'Футболка','men_2.jpg',1,1),(7,'Мужская футболка',7000.00,1,'Футболка','men_3.jpg',1,0),(8,'Платье со складками',8000.00,1,'Платье','women_1.jpg',1,0),(9,'Женская блузка',9000.00,1,'Блузка','women_2.jpg',1,1),(10,'Платье со складками',8000.00,1,'Платье','women_3.jpg',0,0),(11,'Женские брюки',9000.00,1,'Брюки','women_4.jpg',0,0),(12,'Женские ботинки',8000.00,1,'Ботинки','women_5.jpg',0,0),(13,'Платье со складками',9000.00,1,'Платье','women_6.jpg',0,0),(14,'Платье со складками',8000.00,1,'Платье','women_7.jpg',0,0),(15,'Платье со складками',9000.00,1,'Платье','women_8.jpg',0,1),(71,'Часы Guess',12000.00,1,'Часы','accessories_2.jpg',0,1),(72,'Часы Element',14000.00,1,'Часы','accessories_3.jpg',0,1),(73,'Часы Only The Brave',26000.00,1,'Часы','accessories_4.jpg',0,1),(74,'Часы АЧС-1',25000.00,1,'Часы','accessories_5.jpg',0,1),(75,'Часы Guess',21000.00,1,'Часы','accessories_6.jpg',0,1),(76,'Часы Sony',26000.00,1,'Часы','accessories_7.jpg',0,1),(77,'Часы Quartz',15000.00,1,'Часы','accessories_8.jpg',0,1),(78,'Часы',27000.00,1,'Часы','accessories_9.jpg',0,1),(79,'Детская футболка Likee',1000.00,1,'Футболка','children_4.jpg',0,1),(80,'Детская футболка Likee',2500.00,1,'Футболка','children_5.jpg',0,1),(81,'Детская футболка BrawlStars',4000.00,1,'Футболка','children_6.jpg',0,1),(82,'Детская футболка BrawlStars',3000.00,1,'Футболка','children_7.jpg',0,1),(83,'Детская футболка Mikki',2800.00,1,'Футболка','children_8.jpg',0,1),(84,'Мужская футболка',3000.00,1,'Футболка','men_4.jpg',0,1),(85,'Мужская футболка',4000.00,1,'Футболка','men_5.jpg',0,1),(86,'Мужская футболка',3500.00,1,'Футболка','men_6.jpg',0,1),(87,'Мужская футболка',2500.00,1,'Футболка','men_7.jpg',0,1),(88,'Мужская футболка',3000.00,1,'Футболка','men_8.jpg',0,1);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `thirdName` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_id_uindex` (`id`),
  UNIQUE KEY `users_login_uindex` (`login`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin@mail.ru','$2y$10$Pk25cB6OldTXi9WDES2NAe72Yz2b/7rcznFFdQ7gMRcl/finto/D6','Павел','Грошков','1111111111',NULL),(2,'user@mail.ru','$2y$10$7vgtnO/.HNUf.AuAJEqKiu..LRg5o3zn/kXboYdH2js3xw0ex5YUW','Виктор','Викторов','2222222222',NULL),(3,'operator@mail.ru','$2y$10$bskDRbRLznjyS6E7A834XeYBlcTtdZwXxcTmfbEiyLSNMEslJEm46','Игорь','Петров','3333333333',NULL),(4,'noname@mail.ru','$2y$10$/PSSBc7/9jfvVGVUlr9rHO3nezz9i2mpICviN9mqHKeDgU9P/nLx2','Василий','Куприянов','4444444444',NULL),(5,'newmail@mail',NULL,'Unname','Un','11111111',''),(6,'newuser@mail.ru',NULL,'131313','йцуйу','1232131313','');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-07-17 12:57:52
