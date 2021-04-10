-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 10, 2021 at 08:25 AM
-- Server version: 10.1.32-MariaDB
-- PHP Version: 7.2.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `id16518670_new_blog_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` int(11) NOT NULL,
  `title_text` varchar(100) NOT NULL,
  `title_img_path` varchar(200) NOT NULL,
  `blog_text` varchar(5000) NOT NULL,
  `author_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `title_text`, `title_img_path`, `blog_text`, `author_id`, `category_id`, `created_at`) VALUES
(1, '5 WAYS MILLLENNIALS CAN START BUILDING THEIR FUTURE TODAY', '../images/16178492816506.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin feugiat feugiat dignissim. Nullam cursus accumsan nulla. Aenean posuere a nisi in ultricies. Donec nec sapien a nibh hendrerit elementum sagittis id lectus. Proin semper dolor eget interdum imperdiet. Aenean ornare ultricies nisl non pretium. Sed quis erat tempor, imperdiet nibh quis, interdum turpis. Aenean aliquet, massa et convallis mattis, lorem tortor ullamcorper ligula, in pretium leo lacus egestas lectus.\r\n\r\nPhasellus posuere nibh at tincidunt suscipit. Phasellus dui metus, varius ac facilisis venenatis, varius at urna. Duis tincidunt pharetra quam, eu sagittis ligula rutrum vel. Suspendisse ac massa eget metus fermentum efficitur et sit amet erat. Fusce ut dictum lacus. Ut sed pellentesque ligula, id cursus elit. Praesent volutpat quam id felis rhoncus, ut consequat velit convallis. Vestibulum pretium sed lacus ac cursus. Curabitur viverra, nibh ac ornare elementum, magna lectus interdum est, eget feugiat arcu felis ut felis.\r\n\r\nNunc viverra nec lacus aliquet pretium. Maecenas vitae ultricies tellus, quis condimentum libero. Fusce a ipsum a nibh commodo convallis sit amet vel nulla. Proin et ligula lacinia, congue nisl ut, lobortis sem. Phasellus tempus consequat augue placerat molestie. Nullam lectus risus, scelerisque eu magna vel, sagittis sollicitudin quam. Vestibulum ac tempor tellus. Sed eget lorem pulvinar, tincidunt ex et, venenatis libero. Proin eu nunc pulvinar, consectetur urna sed, rutrum lectus. Donec scelerisque leo a eros rutrum sodales.', 1, 11, '2021-04-08 02:34:41'),
(2, '10 Things To Do To Change Your Life Forever', '../images/16178494342116.jpg', 'Phasellus posuere nibh at tincidunt suscipit. Phasellus dui metus, varius ac facilisis venenatis, varius at urna. Duis tincidunt pharetra quam, eu sagittis ligula rutrum vel. Suspendisse ac massa eget metus fermentum efficitur et sit amet erat. Fusce ut dictum lacus. Ut sed pellentesque ligula, id cursus elit. Praesent volutpat quam id felis rhoncus, ut consequat velit convallis. Vestibulum pretium sed lacus ac cursus. Curabitur viverra, nibh ac ornare elementum, magna lectus interdum est, eget feugiat arcu felis ut felis.\r\n\r\nNunc viverra nec lacus aliquet pretium. Maecenas vitae ultricies tellus, quis condimentum libero. Fusce a ipsum a nibh commodo convallis sit amet vel nulla. Proin et ligula lacinia, congue nisl ut, lobortis sem. Phasellus tempus consequat augue placerat molestie. Nullam lectus risus, scelerisque eu magna vel, sagittis sollicitudin quam. Vestibulum ac tempor tellus. Sed eget lorem pulvinar, tincidunt ex et, venenatis libero. Proin eu nunc pulvinar, consectetur urna sed, rutrum lectus. Donec scelerisque leo a eros rutrum sodales.\r\n\r\nPraesent consequat leo et velit iaculis varius. Sed egestas urna vitae nibh interdum mattis. Phasellus scelerisque est ac dui dictum, a egestas nisi dictum. In eu leo quis quam tincidunt placerat tristique a quam. Maecenas ultrices, nunc nec lobortis vulputate, nisi erat elementum dolor, sit amet iaculis justo sem posuere ante. Nunc malesuada, erat nec vulputate posuere, arcu neque dignissim libero, vitae blandit nunc magna a nibh. Nullam sagittis pharetra nunc, lobortis eleifend neque pulvinar nec. Donec sit amet placerat felis. Mauris id condimentum augue. Cras ac sem rutrum, elementum quam vitae, cursus tellus. In lacinia consectetur ultricies. Praesent ac volutpat erat. Aliquam tempor est non diam consectetur, quis finibus libero semper.', 1, 6, '2021-04-08 02:37:14'),
(3, '4 Natural Ways To Have Young Skin', '../images/16178495254550.jpg', 'Phasellus posuere nibh at tincidunt suscipit. Phasellus dui metus, varius ac facilisis venenatis, varius at urna. Duis tincidunt pharetra quam, eu sagittis ligula rutrum vel. Suspendisse ac massa eget metus fermentum efficitur et sit amet erat. Fusce ut dictum lacus. Ut sed pellentesque ligula, id cursus elit. Praesent volutpat quam id felis rhoncus, ut consequat velit convallis. Vestibulum pretium sed lacus ac cursus. Curabitur viverra, nibh ac ornare elementum, magna lectus interdum est, eget feugiat arcu felis ut felis.\r\n\r\nNunc viverra nec lacus aliquet pretium. Maecenas vitae ultricies tellus, quis condimentum libero. Fusce a ipsum a nibh commodo convallis sit amet vel nulla. Proin et ligula lacinia, congue nisl ut, lobortis sem. Phasellus tempus consequat augue placerat molestie. Nullam lectus risus, scelerisque eu magna vel, sagittis sollicitudin quam. Vestibulum ac tempor tellus. Sed eget lorem pulvinar, tincidunt ex et, venenatis libero. Proin eu nunc pulvinar, consectetur urna sed, rutrum lectus. Donec scelerisque leo a eros rutrum sodales.\r\n\r\nPraesent consequat leo et velit iaculis varius. Sed egestas urna vitae nibh interdum mattis. Phasellus scelerisque est ac dui dictum, a egestas nisi dictum. In eu leo quis quam tincidunt placerat tristique a quam. Maecenas ultrices, nunc nec lobortis vulputate, nisi erat elementum dolor, sit amet iaculis justo sem posuere ante. Nunc malesuada, erat nec vulputate posuere, arcu neque dignissim libero, vitae blandit nunc magna a nibh. Nullam sagittis pharetra nunc, lobortis eleifend neque pulvinar nec. Donec sit amet placerat felis. Mauris id condimentum augue. Cras ac sem rutrum, elementum quam vitae, cursus tellus. In lacinia consectetur ultricies. Praesent ac volutpat erat. Aliquam tempor est non diam consectetur, quis finibus libero semper.', 5, 11, '2021-04-08 02:38:45'),
(4, '10 Singals From Your Body Telling You Should Sleep More', '../images/16178497408141.jpg', 'Phasellus posuere nibh at tincidunt suscipit. Phasellus dui metus, varius ac facilisis venenatis, varius at urna. Duis tincidunt pharetra quam, eu sagittis ligula rutrum vel. Suspendisse ac massa eget metus fermentum efficitur et sit amet erat. Fusce ut dictum lacus. Ut sed pellentesque ligula, id cursus elit. Praesent volutpat quam id felis rhoncus, ut consequat velit convallis. Vestibulum pretium sed lacus ac cursus. Curabitur viverra, nibh ac ornare elementum, magna lectus interdum est, eget feugiat arcu felis ut felis.\r\n\r\nNunc viverra nec lacus aliquet pretium. Maecenas vitae ultricies tellus, quis condimentum libero. Fusce a ipsum a nibh commodo convallis sit amet vel nulla. Proin et ligula lacinia, congue nisl ut, lobortis sem. Phasellus tempus consequat augue placerat molestie. Nullam lectus risus, scelerisque eu magna vel, sagittis sollicitudin quam. Vestibulum ac tempor tellus. Sed eget lorem pulvinar, tincidunt ex et, venenatis libero. Proin eu nunc pulvinar, consectetur urna sed, rutrum lectus. Donec scelerisque leo a eros rutrum sodales.\r\n\r\nPraesent consequat leo et velit iaculis varius. Sed egestas urna vitae nibh interdum mattis. Phasellus scelerisque est ac dui dictum, a egestas nisi dictum. In eu leo quis quam tincidunt placerat tristique a quam. Maecenas ultrices, nunc nec lobortis vulputate, nisi erat elementum dolor, sit amet iaculis justo sem posuere ante. Nunc malesuada, erat nec vulputate posuere, arcu neque dignissim libero, vitae blandit nunc magna a nibh. Nullam sagittis pharetra nunc, lobortis eleifend neque pulvinar nec. Donec sit amet placerat felis. Mauris id condimentum augue. Cras ac sem rutrum, elementum quam vitae, cursus tellus. In lacinia consectetur ultricies. Praesent ac volutpat erat. Aliquam tempor est non diam consectetur, quis finibus libero semper.', 5, 6, '2021-04-08 02:42:20'),
(5, 'The perfect weekend getaway', '../images/16178497793998.png', 'Phasellus posuere nibh at tincidunt suscipit. Phasellus dui metus, varius ac facilisis venenatis, varius at urna. Duis tincidunt pharetra quam, eu sagittis ligula rutrum vel. Suspendisse ac massa eget metus fermentum efficitur et sit amet erat. Fusce ut dictum lacus. Ut sed pellentesque ligula, id cursus elit. Praesent volutpat quam id felis rhoncus, ut consequat velit convallis. Vestibulum pretium sed lacus ac cursus. Curabitur viverra, nibh ac ornare elementum, magna lectus interdum est, eget feugiat arcu felis ut felis.\r\n\r\nNunc viverra nec lacus aliquet pretium. Maecenas vitae ultricies tellus, quis condimentum libero. Fusce a ipsum a nibh commodo convallis sit amet vel nulla. Proin et ligula lacinia, congue nisl ut, lobortis sem. Phasellus tempus consequat augue placerat molestie. Nullam lectus risus, scelerisque eu magna vel, sagittis sollicitudin quam. Vestibulum ac tempor tellus. Sed eget lorem pulvinar, tincidunt ex et, venenatis libero. Proin eu nunc pulvinar, consectetur urna sed, rutrum lectus. Donec scelerisque leo a eros rutrum sodales.\r\n\r\nPraesent consequat leo et velit iaculis varius. Sed egestas urna vitae nibh interdum mattis. Phasellus scelerisque est ac dui dictum, a egestas nisi dictum. In eu leo quis quam tincidunt placerat tristique a quam. Maecenas ultrices, nunc nec lobortis vulputate, nisi erat elementum dolor, sit amet iaculis justo sem posuere ante. Nunc malesuada, erat nec vulputate posuere, arcu neque dignissim libero, vitae blandit nunc magna a nibh. Nullam sagittis pharetra nunc, lobortis eleifend neque pulvinar nec. Donec sit amet placerat felis. Mauris id condimentum augue. Cras ac sem rutrum, elementum quam vitae, cursus tellus. In lacinia consectetur ultricies. Praesent ac volutpat erat. Aliquam tempor est non diam consectetur, quis finibus libero semper.', 5, 7, '2021-04-08 02:42:59'),
(6, 'Top 10 songs for running', '../images/16178499236803.jpg', 'Phasellus posuere nibh at tincidunt suscipit. Phasellus dui metus, varius ac facilisis venenatis, varius at urna. Duis tincidunt pharetra quam, eu sagittis ligula rutrum vel. Suspendisse ac massa eget metus fermentum efficitur et sit amet erat. Fusce ut dictum lacus. Ut sed pellentesque ligula, id cursus elit. Praesent volutpat quam id felis rhoncus, ut consequat velit convallis. Vestibulum pretium sed lacus ac cursus. Curabitur viverra, nibh ac ornare elementum, magna lectus interdum est, eget feugiat arcu felis ut felis.\r\n\r\nNunc viverra nec lacus aliquet pretium. Maecenas vitae ultricies tellus, quis condimentum libero. Fusce a ipsum a nibh commodo convallis sit amet vel nulla. Proin et ligula lacinia, congue nisl ut, lobortis sem. Phasellus tempus consequat augue placerat molestie. Nullam lectus risus, scelerisque eu magna vel, sagittis sollicitudin quam. Vestibulum ac tempor tellus. Sed eget lorem pulvinar, tincidunt ex et, venenatis libero. Proin eu nunc pulvinar, consectetur urna sed, rutrum lectus. Donec scelerisque leo a eros rutrum sodales.\r\n\r\nPraesent consequat leo et velit iaculis varius. Sed egestas urna vitae nibh interdum mattis. Phasellus scelerisque est ac dui dictum, a egestas nisi dictum. In eu leo quis quam tincidunt placerat tristique a quam. Maecenas ultrices, nunc nec lobortis vulputate, nisi erat elementum dolor, sit amet iaculis justo sem posuere ante. Nunc malesuada, erat nec vulputate posuere, arcu neque dignissim libero, vitae blandit nunc magna a nibh. Nullam sagittis pharetra nunc, lobortis eleifend neque pulvinar nec. Donec sit amet placerat felis. Mauris id condimentum augue. Cras ac sem rutrum, elementum quam vitae, cursus tellus. In lacinia consectetur ultricies. Praesent ac volutpat erat. Aliquam tempor est non diam consectetur, quis finibus libero semper.', 5, 9, '2021-04-08 02:45:23');

-- --------------------------------------------------------

--
-- Table structure for table `blogs_has_tags`
--

CREATE TABLE `blogs_has_tags` (
  `blogs_id` int(11) NOT NULL,
  `tags_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `blogs_has_tags`
--

INSERT INTO `blogs_has_tags` (`blogs_id`, `tags_id`) VALUES
(1, 14),
(1, 24),
(1, 25),
(2, 10),
(2, 26),
(3, 13),
(4, 14),
(4, 26),
(5, 13),
(5, 22),
(5, 24),
(6, 26),
(6, 27),
(6, 28);

-- --------------------------------------------------------

--
-- Table structure for table `blog_images`
--

CREATE TABLE `blog_images` (
  `id` int(11) NOT NULL,
  `path` varchar(200) NOT NULL,
  `blog_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `blog_images`
--

INSERT INTO `blog_images` (`id`, `path`, `blog_id`) VALUES
(1, '../images/16178497406170.jpg', 4),
(13, '../images/16178686276200.jpg', 5),
(14, '../images/1617868627301.jpg', 5),
(15, '../images/161786862795.jpg', 5);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category_name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`) VALUES
(9, 'Illustration'),
(11, 'Inspiration'),
(6, 'Lifestyle'),
(8, 'Philosophy'),
(7, 'Photography'),
(1, 'Travel'),
(10, 'Web-Design');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `comment_text` varchar(200) NOT NULL,
  `blog_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `comment_text`, `blog_id`, `user_id`) VALUES
(1, 'This is a test comment1', 2, 1),
(4, 'This is a test comment4', 4, 1),
(5, 'This is a test comment5', 2, 5),
(6, '@admin you are right', 4, 5),
(7, '@James Leman thank you', 4, 1),
(8, '@admin and thanks to me', 4, 1),
(9, 'ldfjlsdflj', 4, 1),
(10, '@admin alsdfjlsdf', 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `blog_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`blog_id`, `user_id`) VALUES
(2, 1),
(3, 1),
(4, 1),
(6, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` int(11) NOT NULL,
  `tag_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `tag_name`) VALUES
(26, 'art'),
(25, 'envato'),
(13, 'photos'),
(29, 'physical exercise'),
(28, 'running'),
(27, 'themeforest'),
(22, 'travelling'),
(14, 'tutorial'),
(10, 'videos'),
(24, 'youtube');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `profile_pic_path` varchar(100) DEFAULT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `profile_pic_path`, `is_admin`) VALUES
(1, 'admin', 'admin@abc.com', '$2y$10$hIGupbSKEX5FGu5oyg5Hwun5d0uElop1ABKtjJk5t5LiB4Wp/cFva', '../images/16178769927311.jpg', 1),
(2, 'Md. Abdulla Al Mamun', 'nayonabdulla@gmail.com', '$2y$10$VKTrImg2s8Sul5.piabpYO/kv.gc4LaiEjhnQmW4tACCAa5l7yv9e', '../images/dummy_pic.png', 0),
(5, 'James Leman', 'user1@abc.com', '$2y$10$GK6MzhQamvbn3KLvVx6JRepzpjeGy40FDqYhe/vx939YWOQC06JOu', '../images/16178495574169.jpg', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`,`author_id`),
  ADD KEY `fk_to_user_id` (`author_id`),
  ADD KEY `fk_to_categories` (`category_id`),
  ADD KEY `fk_to_blog_images` (`title_img_path`);

--
-- Indexes for table `blogs_has_tags`
--
ALTER TABLE `blogs_has_tags`
  ADD PRIMARY KEY (`blogs_id`,`tags_id`),
  ADD KEY `fk_blogs_has_tags_tags1_idx` (`tags_id`),
  ADD KEY `fk_blogs_has_tags_blogs1_idx` (`blogs_id`);

--
-- Indexes for table `blog_images`
--
ALTER TABLE `blog_images`
  ADD PRIMARY KEY (`id`,`blog_id`),
  ADD KEY `fk_to_blog__` (`blog_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `category_name` (`category_name`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`,`blog_id`,`user_id`),
  ADD KEY `blog_id` (`blog_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD UNIQUE KEY `blog_id` (`blog_id`,`user_id`),
  ADD KEY `like_fk_user` (`user_id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tag_unique` (`tag_name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `blog_images`
--
ALTER TABLE `blog_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blogs`
--
ALTER TABLE `blogs`
  ADD CONSTRAINT `fk_to_categories` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_to_user_id` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `blogs_has_tags`
--
ALTER TABLE `blogs_has_tags`
  ADD CONSTRAINT `fk_blogs_has_tags_blogs1` FOREIGN KEY (`blogs_id`) REFERENCES `blogs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_blogs_has_tags_tags1` FOREIGN KEY (`tags_id`) REFERENCES `tags` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `blog_images`
--
ALTER TABLE `blog_images`
  ADD CONSTRAINT `fk_to_blog__` FOREIGN KEY (`blog_id`) REFERENCES `blogs` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `fk_to_blog_id` FOREIGN KEY (`blog_id`) REFERENCES `blogs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_to_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `like_fk_blog` FOREIGN KEY (`blog_id`) REFERENCES `blogs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `like_fk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
