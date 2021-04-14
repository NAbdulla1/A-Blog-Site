-- MySQL dump 10.16  Distrib 10.1.32-MariaDB, for Win32 (AMD64)
--
-- Host: 127.0.0.1    Database: id16518670_new_blog_db
-- ------------------------------------------------------
-- Server version	10.1.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `blogs`
--

DROP TABLE IF EXISTS `blogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blogs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title_text` varchar(100) NOT NULL,
  `title_img_path` varchar(200) NOT NULL,
  `blog_text` varchar(5000) NOT NULL,
  `author_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_to_categories` (`category_id`),
  KEY `fk_to_blog_images` (`title_img_path`),
  KEY `fk_blog_user` (`author_id`),
  CONSTRAINT `fk_blog_user` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_to_catgry_id` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blogs`
--

LOCK TABLES `blogs` WRITE;
/*!40000 ALTER TABLE `blogs` DISABLE KEYS */;
INSERT INTO `blogs` VALUES (1,'5 WAYS MILLLENNIALS CAN START BUILDING THEIR FUTURE TODAY','../images/16178492816506.jpg','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin feugiat feugiat dignissim. Nullam cursus accumsan nulla. Aenean posuere a nisi in ultricies. Donec nec sapien a nibh hendrerit elementum sagittis id lectus. Proin semper dolor eget interdum imperdiet. Aenean ornare ultricies nisl non pretium. Sed quis erat tempor, imperdiet nibh quis, interdum turpis. Aenean aliquet, massa et convallis mattis, lorem tortor ullamcorper ligula, in pretium leo lacus egestas lectus.\r\n\r\nPhasellus posuere nibh at tincidunt suscipit. Phasellus dui metus, varius ac facilisis venenatis, varius at urna. Duis tincidunt pharetra quam, eu sagittis ligula rutrum vel. Suspendisse ac massa eget metus fermentum efficitur et sit amet erat. Fusce ut dictum lacus. Ut sed pellentesque ligula, id cursus elit. Praesent volutpat quam id felis rhoncus, ut consequat velit convallis. Vestibulum pretium sed lacus ac cursus. Curabitur viverra, nibh ac ornare elementum, magna lectus interdum est, eget feugiat arcu felis ut felis.\r\n\r\nNunc viverra nec lacus aliquet pretium. Maecenas vitae ultricies tellus, quis condimentum libero. Fusce a ipsum a nibh commodo convallis sit amet vel nulla. Proin et ligula lacinia, congue nisl ut, lobortis sem. Phasellus tempus consequat augue placerat molestie. Nullam lectus risus, scelerisque eu magna vel, sagittis sollicitudin quam. Vestibulum ac tempor tellus. Sed eget lorem pulvinar, tincidunt ex et, venenatis libero. Proin eu nunc pulvinar, consectetur urna sed, rutrum lectus. Donec scelerisque leo a eros rutrum sodales.',1,11,'2021-04-08 02:34:41'),(2,'10 Things To Do To Change Your Life Forever','../images/16178494342116.jpg','Phasellus posuere nibh at tincidunt suscipit. Phasellus dui metus, varius ac facilisis venenatis, varius at urna. Duis tincidunt pharetra quam, eu sagittis ligula rutrum vel. Suspendisse ac massa eget metus fermentum efficitur et sit amet erat. Fusce ut dictum lacus. Ut sed pellentesque ligula, id cursus elit. Praesent volutpat quam id felis rhoncus, ut consequat velit convallis. Vestibulum pretium sed lacus ac cursus. Curabitur viverra, nibh ac ornare elementum, magna lectus interdum est, eget feugiat arcu felis ut felis.\r\n\r\nNunc viverra nec lacus aliquet pretium. Maecenas vitae ultricies tellus, quis condimentum libero. Fusce a ipsum a nibh commodo convallis sit amet vel nulla. Proin et ligula lacinia, congue nisl ut, lobortis sem. Phasellus tempus consequat augue placerat molestie. Nullam lectus risus, scelerisque eu magna vel, sagittis sollicitudin quam. Vestibulum ac tempor tellus. Sed eget lorem pulvinar, tincidunt ex et, venenatis libero. Proin eu nunc pulvinar, consectetur urna sed, rutrum lectus. Donec scelerisque leo a eros rutrum sodales.\r\n\r\nPraesent consequat leo et velit iaculis varius. Sed egestas urna vitae nibh interdum mattis. Phasellus scelerisque est ac dui dictum, a egestas nisi dictum. In eu leo quis quam tincidunt placerat tristique a quam. Maecenas ultrices, nunc nec lobortis vulputate, nisi erat elementum dolor, sit amet iaculis justo sem posuere ante. Nunc malesuada, erat nec vulputate posuere, arcu neque dignissim libero, vitae blandit nunc magna a nibh. Nullam sagittis pharetra nunc, lobortis eleifend neque pulvinar nec. Donec sit amet placerat felis. Mauris id condimentum augue. Cras ac sem rutrum, elementum quam vitae, cursus tellus. In lacinia consectetur ultricies. Praesent ac volutpat erat. Aliquam tempor est non diam consectetur, quis finibus libero semper.',1,6,'2021-04-08 02:37:14'),(3,'4 Natural Ways To Have Young Skin','../images/16178495254550.jpg','Phasellus posuere nibh at tincidunt suscipit. Phasellus dui metus, varius ac facilisis venenatis, varius at urna. Duis tincidunt pharetra quam, eu sagittis ligula rutrum vel. Suspendisse ac massa eget metus fermentum efficitur et sit amet erat. Fusce ut dictum lacus. Ut sed pellentesque ligula, id cursus elit. Praesent volutpat quam id felis rhoncus, ut consequat velit convallis. Vestibulum pretium sed lacus ac cursus. Curabitur viverra, nibh ac ornare elementum, magna lectus interdum est, eget feugiat arcu felis ut felis.\r\n\r\nNunc viverra nec lacus aliquet pretium. Maecenas vitae ultricies tellus, quis condimentum libero. Fusce a ipsum a nibh commodo convallis sit amet vel nulla. Proin et ligula lacinia, congue nisl ut, lobortis sem. Phasellus tempus consequat augue placerat molestie. Nullam lectus risus, scelerisque eu magna vel, sagittis sollicitudin quam. Vestibulum ac tempor tellus. Sed eget lorem pulvinar, tincidunt ex et, venenatis libero. Proin eu nunc pulvinar, consectetur urna sed, rutrum lectus. Donec scelerisque leo a eros rutrum sodales.\r\n\r\nPraesent consequat leo et velit iaculis varius. Sed egestas urna vitae nibh interdum mattis. Phasellus scelerisque est ac dui dictum, a egestas nisi dictum. In eu leo quis quam tincidunt placerat tristique a quam. Maecenas ultrices, nunc nec lobortis vulputate, nisi erat elementum dolor, sit amet iaculis justo sem posuere ante. Nunc malesuada, erat nec vulputate posuere, arcu neque dignissim libero, vitae blandit nunc magna a nibh. Nullam sagittis pharetra nunc, lobortis eleifend neque pulvinar nec. Donec sit amet placerat felis. Mauris id condimentum augue. Cras ac sem rutrum, elementum quam vitae, cursus tellus. In lacinia consectetur ultricies. Praesent ac volutpat erat. Aliquam tempor est non diam consectetur, quis finibus libero semper.',5,11,'2021-04-08 02:38:45'),(4,'10 Singals From Your Body Telling You Should Sleep More','../images/16178497408141.jpg','Phasellus posuere nibh at tincidunt suscipit. Phasellus dui metus, varius ac facilisis venenatis, varius at urna. Duis tincidunt pharetra quam, eu sagittis ligula rutrum vel. Suspendisse ac massa eget metus fermentum efficitur et sit amet erat. Fusce ut dictum lacus. Ut sed pellentesque ligula, id cursus elit. Praesent volutpat quam id felis rhoncus, ut consequat velit convallis. Vestibulum pretium sed lacus ac cursus. Curabitur viverra, nibh ac ornare elementum, magna lectus interdum est, eget feugiat arcu felis ut felis.\r\n\r\nNunc viverra nec lacus aliquet pretium. Maecenas vitae ultricies tellus, quis condimentum libero. Fusce a ipsum a nibh commodo convallis sit amet vel nulla. Proin et ligula lacinia, congue nisl ut, lobortis sem. Phasellus tempus consequat augue placerat molestie. Nullam lectus risus, scelerisque eu magna vel, sagittis sollicitudin quam. Vestibulum ac tempor tellus. Sed eget lorem pulvinar, tincidunt ex et, venenatis libero. Proin eu nunc pulvinar, consectetur urna sed, rutrum lectus. Donec scelerisque leo a eros rutrum sodales.\r\n\r\nPraesent consequat leo et velit iaculis varius. Sed egestas urna vitae nibh interdum mattis. Phasellus scelerisque est ac dui dictum, a egestas nisi dictum. In eu leo quis quam tincidunt placerat tristique a quam. Maecenas ultrices, nunc nec lobortis vulputate, nisi erat elementum dolor, sit amet iaculis justo sem posuere ante. Nunc malesuada, erat nec vulputate posuere, arcu neque dignissim libero, vitae blandit nunc magna a nibh. Nullam sagittis pharetra nunc, lobortis eleifend neque pulvinar nec. Donec sit amet placerat felis. Mauris id condimentum augue. Cras ac sem rutrum, elementum quam vitae, cursus tellus. In lacinia consectetur ultricies. Praesent ac volutpat erat. Aliquam tempor est non diam consectetur, quis finibus libero semper.',5,6,'2021-04-08 02:42:20'),(5,'The perfect weekend getaway','../images/16178497793998.png','Phasellus posuere nibh at tincidunt suscipit. Phasellus dui metus, varius ac facilisis venenatis, varius at urna. Duis tincidunt pharetra quam, eu sagittis ligula rutrum vel. Suspendisse ac massa eget metus fermentum efficitur et sit amet erat. Fusce ut dictum lacus. Ut sed pellentesque ligula, id cursus elit. Praesent volutpat quam id felis rhoncus, ut consequat velit convallis. Vestibulum pretium sed lacus ac cursus. Curabitur viverra, nibh ac ornare elementum, magna lectus interdum est, eget feugiat arcu felis ut felis.\r\n\r\nNunc viverra nec lacus aliquet pretium. Maecenas vitae ultricies tellus, quis condimentum libero. Fusce a ipsum a nibh commodo convallis sit amet vel nulla. Proin et ligula lacinia, congue nisl ut, lobortis sem. Phasellus tempus consequat augue placerat molestie. Nullam lectus risus, scelerisque eu magna vel, sagittis sollicitudin quam. Vestibulum ac tempor tellus. Sed eget lorem pulvinar, tincidunt ex et, venenatis libero. Proin eu nunc pulvinar, consectetur urna sed, rutrum lectus. Donec scelerisque leo a eros rutrum sodales.\r\n\r\nPraesent consequat leo et velit iaculis varius. Sed egestas urna vitae nibh interdum mattis. Phasellus scelerisque est ac dui dictum, a egestas nisi dictum. In eu leo quis quam tincidunt placerat tristique a quam. Maecenas ultrices, nunc nec lobortis vulputate, nisi erat elementum dolor, sit amet iaculis justo sem posuere ante. Nunc malesuada, erat nec vulputate posuere, arcu neque dignissim libero, vitae blandit nunc magna a nibh. Nullam sagittis pharetra nunc, lobortis eleifend neque pulvinar nec. Donec sit amet placerat felis. Mauris id condimentum augue. Cras ac sem rutrum, elementum quam vitae, cursus tellus. In lacinia consectetur ultricies. Praesent ac volutpat erat. Aliquam tempor est non diam consectetur, quis finibus libero semper.',5,7,'2021-04-08 02:42:59'),(6,'Top 10 songs for running','../images/16178499236803.jpg','Phasellus posuere nibh at tincidunt suscipit. Phasellus dui metus, varius ac facilisis venenatis, varius at urna. Duis tincidunt pharetra quam, eu sagittis ligula rutrum vel. Suspendisse ac massa eget metus fermentum efficitur et sit amet erat. Fusce ut dictum lacus. Ut sed pellentesque ligula, id cursus elit. Praesent volutpat quam id felis rhoncus, ut consequat velit convallis. Vestibulum pretium sed lacus ac cursus. Curabitur viverra, nibh ac ornare elementum, magna lectus interdum est, eget feugiat arcu felis ut felis.\r\n\r\nNunc viverra nec lacus aliquet pretium. Maecenas vitae ultricies tellus, quis condimentum libero. Fusce a ipsum a nibh commodo convallis sit amet vel nulla. Proin et ligula lacinia, congue nisl ut, lobortis sem. Phasellus tempus consequat augue placerat molestie. Nullam lectus risus, scelerisque eu magna vel, sagittis sollicitudin quam. Vestibulum ac tempor tellus. Sed eget lorem pulvinar, tincidunt ex et, venenatis libero. Proin eu nunc pulvinar, consectetur urna sed, rutrum lectus. Donec scelerisque leo a eros rutrum sodales.\r\n\r\nPraesent consequat leo et velit iaculis varius. Sed egestas urna vitae nibh interdum mattis. Phasellus scelerisque est ac dui dictum, a egestas nisi dictum. In eu leo quis quam tincidunt placerat tristique a quam. Maecenas ultrices, nunc nec lobortis vulputate, nisi erat elementum dolor, sit amet iaculis justo sem posuere ante. Nunc malesuada, erat nec vulputate posuere, arcu neque dignissim libero, vitae blandit nunc magna a nibh. Nullam sagittis pharetra nunc, lobortis eleifend neque pulvinar nec. Donec sit amet placerat felis. Mauris id condimentum augue. Cras ac sem rutrum, elementum quam vitae, cursus tellus. In lacinia consectetur ultricies. Praesent ac volutpat erat. Aliquam tempor est non diam consectetur, quis finibus libero semper.',5,NULL,'2021-04-08 02:45:23'),(7,'test','../images/dummy_pic2.jpg','text text text',NULL,NULL,'2021-04-11 09:06:05'),(8,'test1','../images/16181578542518.jpg','test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1 test1',1,11,'2021-04-11 16:17:34'),(9,'test2','../images/16181578969500.jpg','<ol><li>test2 test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;<i>test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;</i><font color=\"#330000\"><i>test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2</i>&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;</font><font color=\"#660099\">test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2</font>&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2&nbsp;test2</li></ol>',1,11,'2021-04-11 16:18:16'),(10,'test3','../images/16181579609788.jpg','Praesent non placerat nulla. Donec tempus elit ac interdum molestie. Ut sed pellentesque risus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Integer at metus enim. Nulla ultrices nibh vel nisl bibendum vestibulum. Sed eget dignissim justo. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Etiam quis euismod purus, non consequat eros. Cras sollicitudin pretium ante vel facilisis. Aenean bibendum massa velit, eget mollis ante convallis at. Vestibulum fringilla quis erat sed commodo. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nullam at lorem ultricies, lobortis mauris non, viverra orci.\r\n\r\nInteger quis pharetra nisi, sit amet accumsan leo. Etiam blandit dui finibus tincidunt blandit. Duis lorem velit, tempor eu ultrices et, ultricies ac tellus. Proin vitae tempor nunc, non placerat orci. Ut lobortis pellentesque nisl, vel auctor elit euismod et. In ac purus dignissim tortor faucibus semper non sit amet velit. Mauris mattis tincidunt enim, a dapibus nisi finibus eu. Donec id vestibulum purus. Nulla efficitur interdum mauris, quis mollis dui congue nec.\r\n\r\nNam vitae est mi. Duis gravida diam arcu, in rhoncus urna viverra at. Fusce varius mauris in condimentum ornare. Nunc vehicula ultrices convallis. Nulla auctor non massa quis viverra. Morbi dictum dui a orci vestibulum sagittis eu a justo. Nunc ullamcorper nulla nec risus vulputate, eu placerat justo eleifend. Sed facilisis efficitur metus eu vulputate. Nunc sit amet rutrum risus.',1,11,'2021-04-11 16:19:20'),(11,'test4','../images/16181579876729.jpg','Praesent non placerat nulla. Donec tempus elit ac interdum molestie. Ut sed pellentesque risus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Integer at metus enim. Nulla ultrices nibh vel nisl bibendum vestibulum. Sed eget dignissim justo. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Etiam quis euismod purus, non consequat eros. Cras sollicitudin pretium ante vel facilisis. Aenean bibendum massa velit, eget mollis ante convallis at. Vestibulum fringilla quis erat sed commodo. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nullam at lorem ultricies, lobortis mauris non, viverra orci.\r\n\r\nInteger quis pharetra nisi, sit amet accumsan leo. Etiam blandit dui finibus tincidunt blandit. Duis lorem velit, tempor eu ultrices et, ultricies ac tellus. Proin vitae tempor nunc, non placerat orci. Ut lobortis pellentesque nisl, vel auctor elit euismod et. In ac purus dignissim tortor faucibus semper non sit amet velit. Mauris mattis tincidunt enim, a dapibus nisi finibus eu. Donec id vestibulum purus. Nulla efficitur interdum mauris, quis mollis dui congue nec.\r\n\r\nNam vitae est mi. Duis gravida diam arcu, in rhoncus urna viverra at. Fusce varius mauris in condimentum ornare. Nunc vehicula ultrices convallis. Nulla auctor non massa quis viverra. Morbi dictum dui a orci vestibulum sagittis eu a justo. Nunc ullamcorper nulla nec risus vulputate, eu placerat justo eleifend. Sed facilisis efficitur metus eu vulputate. Nunc sit amet rutrum risus.',1,11,'2021-04-11 16:19:47'),(12,'test5','../images/16181580055817.jpg','Praesent non placerat nulla. Donec tempus elit ac interdum molestie. Ut sed pellentesque risus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Integer at metus enim. Nulla ultrices nibh vel nisl bibendum vestibulum. Sed eget dignissim justo. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Etiam quis euismod purus, non consequat eros. Cras sollicitudin pretium ante vel facilisis. Aenean bibendum massa velit, eget mollis ante convallis at. Vestibulum fringilla quis erat sed commodo. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nullam at lorem ultricies, lobortis mauris non, viverra orci.\r\n\r\nInteger quis pharetra nisi, sit amet accumsan leo. Etiam blandit dui finibus tincidunt blandit. Duis lorem velit, tempor eu ultrices et, ultricies ac tellus. Proin vitae tempor nunc, non placerat orci. Ut lobortis pellentesque nisl, vel auctor elit euismod et. In ac purus dignissim tortor faucibus semper non sit amet velit. Mauris mattis tincidunt enim, a dapibus nisi finibus eu. Donec id vestibulum purus. Nulla efficitur interdum mauris, quis mollis dui congue nec.\r\n\r\nNam vitae est mi. Duis gravida diam arcu, in rhoncus urna viverra at. Fusce varius mauris in condimentum ornare. Nunc vehicula ultrices convallis. Nulla auctor non massa quis viverra. Morbi dictum dui a orci vestibulum sagittis eu a justo. Nunc ullamcorper nulla nec risus vulputate, eu placerat justo eleifend. Sed facilisis efficitur metus eu vulputate. Nunc sit amet rutrum risus.',1,11,'2021-04-11 16:20:05'),(13,'test6','../images/16181580268767.jpg','Praesent non placerat nulla. Donec tempus elit ac interdum molestie. Ut sed pellentesque risus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Integer at metus enim. Nulla ultrices nibh vel nisl bibendum vestibulum. Sed eget dignissim justo. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Etiam quis euismod purus, non consequat eros. Cras sollicitudin pretium ante vel facilisis. Aenean bibendum massa velit, eget mollis ante convallis at. Vestibulum fringilla quis erat sed commodo. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nullam at lorem ultricies, lobortis mauris non, viverra orci.\r\n\r\nInteger quis pharetra nisi, sit amet accumsan leo. Etiam blandit dui finibus tincidunt blandit. Duis lorem velit, tempor eu ultrices et, ultricies ac tellus. Proin vitae tempor nunc, non placerat orci. Ut lobortis pellentesque nisl, vel auctor elit euismod et. In ac purus dignissim tortor faucibus semper non sit amet velit. Mauris mattis tincidunt enim, a dapibus nisi finibus eu. Donec id vestibulum purus. Nulla efficitur interdum mauris, quis mollis dui congue nec.\r\n\r\nNam vitae est mi. Duis gravida diam arcu, in rhoncus urna viverra at. Fusce varius mauris in condimentum ornare. Nunc vehicula ultrices convallis. Nulla auctor non massa quis viverra. Morbi dictum dui a orci vestibulum sagittis eu a justo. Nunc ullamcorper nulla nec risus vulputate, eu placerat justo eleifend. Sed facilisis efficitur metus eu vulputate. Nunc sit amet rutrum risus.',1,11,'2021-04-11 16:20:26'),(14,'test7','../images/16181580501317.jpg','Praesent non placerat nulla. Donec tempus elit ac interdum molestie. Ut sed pellentesque risus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Integer at metus enim. Nulla ultrices nibh vel nisl bibendum vestibulum. Sed eget dignissim justo. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Etiam quis euismod purus, non consequat eros. Cras sollicitudin pretium ante vel facilisis. Aenean bibendum massa velit, eget mollis ante convallis at. Vestibulum fringilla quis erat sed commodo. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nullam at lorem ultricies, lobortis mauris non, viverra orci.\r\n\r\nInteger quis pharetra nisi, sit amet accumsan leo. Etiam blandit dui finibus tincidunt blandit. Duis lorem velit, tempor eu ultrices et, ultricies ac tellus. Proin vitae tempor nunc, non placerat orci. Ut lobortis pellentesque nisl, vel auctor elit euismod et. In ac purus dignissim tortor faucibus semper non sit amet velit. Mauris mattis tincidunt enim, a dapibus nisi finibus eu. Donec id vestibulum purus. Nulla efficitur interdum mauris, quis mollis dui congue nec.\r\n\r\nNam vitae est mi. Duis gravida diam arcu, in rhoncus urna viverra at. Fusce varius mauris in condimentum ornare. Nunc vehicula ultrices convallis. Nulla auctor non massa quis viverra. Morbi dictum dui a orci vestibulum sagittis eu a justo. Nunc ullamcorper nulla nec risus vulputate, eu placerat justo eleifend. Sed facilisis efficitur metus eu vulputate. Nunc sit amet rutrum risus.',1,11,'2021-04-11 16:20:50'),(15,'test nicedit','../images/16182072094552.jpg','asdfads<font color=\"#ff3300\">fasdf</font>',1,6,'2021-04-12 06:00:09'),(16,'nicEdit test 2','../images/16182073802419.jpg','as<font face=\"impact\">d</font>fa<sub>d</sub><sup>s</sup><sub>f</sub><div><img src=\"https://images.ctfassets.net/hrltx12pl8hq/3MbF54EhWUhsXunc5Keueb/60774fbbff86e6bf6776f1e17a8016b4/04-nature_721703848.jpg?fit=fill&amp;w=480&amp;h=270\" alt=\"leaves\" align=\"none\"><span style=\"font-size: 12px;\"><br></span><div><sub><br></sub></div><div><sub><u><i>dfsdfa dsf</i></u></sub></div><div><sub><br></sub></div><div><sub><br></sub></div></div>',1,10,'2021-04-12 06:03:00'),(19,'test select2','../images/16182814819826.JPG','<h2 id=\"multi-select-boxes-pillbox\" style=\"margin: 0.85rem 0px 1.7rem; line-height: 61.2px; font-size: 2.55rem; text-rendering: optimizelegibility; font-family: Montserrat, Helvetica, Tahoma, Geneva, Arial, sans-serif; letter-spacing: -2px; color: rgb(85, 85, 85);\">Multi-select boxes (pillbox)<a class=\"anchorjs-link \" href=\"https://select2.org/getting-started/basic-usage#multi-select-boxes-pillbox\" aria-label=\"Anchor link for: multi select boxes pillbox\" data-anchorjs-icon=\"î§‹\" style=\"color: rgb(22, 148, 202); background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; opacity: 0; -webkit-font-smoothing: antialiased; font-variant-numeric: normal; font-variant-east-asian: normal; font-stretch: normal; font-size: 1em; line-height: 1; font-family: anchorjs-icons; padding-left: 0.375em;\"></a></h2><p style=\"margin: 1.7rem 0px; color: rgb(85, 85, 85); font-family: Muli, Helvetica, Tahoma, Geneva, Arial, sans-serif; font-size: 16.8px; letter-spacing: -0.48px;\">Select2 also supports multi-value select boxes. The select below is declared with the&nbsp;<code style=\"font-family: Inconsolata, monospace; font-size: 14.7px; color: rgb(156, 29, 61); vertical-align: bottom; background: rgb(249, 242, 244); padding: 0.2rem 0.4rem; border-radius: 3px;\">multiple</code><span class=\"copy-to-clipboard\" title=\"Copy to clipboard\" style=\"background-image: url(&quot;/user/themes/learn2/images/clippy.svg&quot;); background-position: 50% 50%; background-size: 16px 16px; background-repeat: no-repeat; width: 27px; height: 1.45rem; top: -1px; display: inline-block; vertical-align: middle; position: relative; color: rgb(60, 60, 60); background-color: rgb(249, 242, 244); margin-left: -0.2rem; cursor: pointer; border-radius: 0px 2px 2px 0px;\"></span>&nbsp;attribute.</p>',1,10,'2021-04-13 02:38:01');
/*!40000 ALTER TABLE `blogs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blogs_has_tags`
--

DROP TABLE IF EXISTS `blogs_has_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blogs_has_tags` (
  `blogs_id` int(11) NOT NULL,
  `tags_id` int(11) NOT NULL,
  PRIMARY KEY (`blogs_id`,`tags_id`),
  KEY `fk_blogs_has_tags_tags1_idx` (`tags_id`),
  KEY `fk_blogs_has_tags_blogs1_idx` (`blogs_id`),
  CONSTRAINT `fk_blogs_has_tags_blogs1` FOREIGN KEY (`blogs_id`) REFERENCES `blogs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_blogs_has_tags_tags1` FOREIGN KEY (`tags_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blogs_has_tags`
--

LOCK TABLES `blogs_has_tags` WRITE;
/*!40000 ALTER TABLE `blogs_has_tags` DISABLE KEYS */;
INSERT INTO `blogs_has_tags` VALUES (1,14),(1,24),(1,25),(2,10),(2,26),(3,13),(4,14),(4,26),(5,13),(5,22),(5,24),(6,26),(6,27),(6,28),(8,26),(9,26),(10,26),(11,26),(12,26),(13,22),(13,26),(14,26),(15,26),(16,10),(16,26),(19,14),(19,24),(19,26),(19,32),(19,33);
/*!40000 ALTER TABLE `blogs_has_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(25) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `category_name` (`category_name`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (11,'Inspiration'),(6,'Lifestyle'),(7,'Photography'),(1,'Travel'),(10,'Web-Design');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `comment_text` varchar(200) NOT NULL,
  `blog_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_to_bloggg_id` (`blog_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `fk_to_bloggg_id` FOREIGN KEY (`blog_id`) REFERENCES `blogs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_to_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (1,'This is a test comment1',2,1),(4,'This is a test comment4',4,1),(5,'This is a test comment5',2,5),(6,'@admin you are right',4,5),(7,'@James Leman thank you',4,1),(8,'@admin and thanks to me',4,1),(9,'ldfjlsdflj',4,1),(10,'@admin alsdfjlsdf',4,1),(11,'test',6,NULL),(12,'a;djsf',12,1);
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `likes`
--

DROP TABLE IF EXISTS `likes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `likes` (
  `blog_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  UNIQUE KEY `blog_id` (`blog_id`,`user_id`),
  KEY `like_fk_user` (`user_id`),
  CONSTRAINT `like_fk_blog` FOREIGN KEY (`blog_id`) REFERENCES `blogs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `like_fk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `likes`
--

LOCK TABLES `likes` WRITE;
/*!40000 ALTER TABLE `likes` DISABLE KEYS */;
INSERT INTO `likes` VALUES (1,1),(2,1),(3,1),(4,1),(6,1),(9,1),(10,1),(13,1),(14,1),(15,1);
/*!40000 ALTER TABLE `likes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tag_name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tag_unique` (`tag_name`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tags`
--

LOCK TABLES `tags` WRITE;
/*!40000 ALTER TABLE `tags` DISABLE KEYS */;
INSERT INTO `tags` VALUES (26,'art'),(25,'envato'),(13,'photos'),(29,'physical exercise'),(28,'running'),(32,'select2'),(33,'select2 example'),(27,'themeforest'),(22,'travelling'),(14,'tutorial'),(10,'videos'),(24,'youtube');
/*!40000 ALTER TABLE `tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `profile_pic_path` varchar(100) DEFAULT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','admin@abc.com','$2y$10$hIGupbSKEX5FGu5oyg5Hwun5d0uElop1ABKtjJk5t5LiB4Wp/cFva','../images/16178769927311.jpg',1),(5,'James Leman','user1@abc.com','$2y$10$GK6MzhQamvbn3KLvVx6JRepzpjeGy40FDqYhe/vx939YWOQC06JOu','../images/16178495574169.jpg',0);
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

-- Dump completed on 2021-04-13 16:44:19
