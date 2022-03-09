
--
-- Database: `manager_product`
--

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

<<<<<<< HEAD
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(255) DEFAULT NULL,
  `user_name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `register_date` datetime DEFAULT NULL,
  PRIMARY KEY( `id` )
);
=======
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `register_date` datetime DEFAULT NULL,
  PRIMARY KEY( `user_id` ),
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
>>>>>>> anh xem giup em voi

--
-- Table structure for table `product`
--

<<<<<<< HEAD
CREATE TABLE IF NOT EXISTS `products` (
=======
CREATE TABLE `product` (
>>>>>>> anh xem giup em voi
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `price` int NOT NULL,
  `image` varchar(255) NOT NULL,
  `register` datetime DEFAULT NULL,
<<<<<<< HEAD
  `is_deleted` boolean DEFAULT false,
  PRIMARY KEY( `id` )
) ;
=======
  `is_deleted` boolean DEFAULT false
  PRIMARY KEY( `id` ),
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
>>>>>>> anh xem giup em voi

--
-- Table structure for table `tag`
--

<<<<<<< HEAD
CREATE TABLE IF NOT EXISTS `tags` (
=======
CREATE TABLE `tag` (
>>>>>>> anh xem giup em voi
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `slug` varchar(50) NOT NULL,
  `is_deleted` boolean DEFAULT false ,
  PRIMARY KEY (`id`)
<<<<<<< HEAD
);
=======
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
>>>>>>> anh xem giup em voi

--
-- Table structure for table `product_tag`
--
<<<<<<< HEAD
CREATE TABLE IF NOT EXISTS `product_tag` (
  `product_id` int(20) NOT NULL,
  `tag_id` int(20) NOT NULL,
  PRIMARY KEY( `product_id`, `tag_id`),
  FOREIGN KEY (`product_id`) REFERENCES `products`(`id`),
  FOREIGN KEY (`tag_id`) REFERENCES `tags`(`id`)
  );
-- ----------------------------------------------- 
=======
CREATE TABLE `product_tag` (
  `product_id` int(20) NOT NULL,
  `tag_id` int(20) NOT NULL,
  FOREIGN KEY (`product_id`) REFERENCES `product`(`id`),
  FOREIGN KEY (`tag_id`) REFERENCES `tag`(`id`),
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
-- --------------------------------------------------------
>>>>>>> anh xem giup em voi
