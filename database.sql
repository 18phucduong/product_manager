
--
-- Database: `manager_product`
--

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `register_date` datetime DEFAULT NULL,
  PRIMARY KEY( `user_id` ),
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `price` int NOT NULL,
  `image` varchar(255) NOT NULL,
  `register` datetime DEFAULT NULL,
  `is_deleted` boolean DEFAULT false
  PRIMARY KEY( `id` ),
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `tag`
--

CREATE TABLE `tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `slug` varchar(50) NOT NULL,
  `is_deleted` boolean DEFAULT false ,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `product_tag`
--
CREATE TABLE `product_tag` (
  `product_id` int(20) NOT NULL,
  `tag_id` int(20) NOT NULL,
  FOREIGN KEY (`product_id`) REFERENCES `product`(`id`),
  FOREIGN KEY (`tag_id`) REFERENCES `tag`(`id`),
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
-- -----------------------------------------------