
--
-- Database: `manager_product`
--

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(255) DEFAULT NULL,
  `user_name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `register_date` datetime DEFAULT NULL,
  PRIMARY KEY( `id` )
);

--
-- Table structure for table `product`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `price` int NOT NULL,
  `image` varchar(255) NOT NULL,
  `register` datetime DEFAULT NULL,
  `is_deleted` boolean DEFAULT false,
  PRIMARY KEY( `id` )
) ;

--
-- Table structure for table `tag`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `slug` varchar(50) NOT NULL,
  `is_deleted` boolean DEFAULT false ,
  PRIMARY KEY (`id`)
);

--
-- Table structure for table `product_tag`
--
CREATE TABLE IF NOT EXISTS `product_tag` (
  `product_id` int(20) NOT NULL,
  `tag_id` int(20) NOT NULL,
  PRIMARY KEY( `product_id`, `tag_id`),
  FOREIGN KEY (`product_id`) REFERENCES `products`(`id`),
  FOREIGN KEY (`tag_id`) REFERENCES `tags`(`id`)
  );
-- ----------------------------------------------- 
