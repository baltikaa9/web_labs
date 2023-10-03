-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 03, 2023 at 10:39 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `game_discs`
--

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

CREATE TABLE `games` (
  `id` int(11) NOT NULL,
  `img` varchar(45) DEFAULT NULL,
  `name` varchar(45) NOT NULL,
  `genre_id` int(11) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `cost` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `games`
--

INSERT INTO `games` (`id`, `img`, `name`, `genre_id`, `description`, `cost`) VALUES
(1, 'dota.jpg', 'Dota 2', 2, 'Ежедневно миллионы игроков по всему миру сражаются от лица одного из более сотни героев Dota 2, и даже после тысячи часов в ней есть чему научиться. Благодаря регулярным обновлениям игра живёт своей жизнью: геймплей, возможности и герои постоянно преображ', 0),
(2, 'cities_skylines.jpg', 'Cities: Skylines', 2, 'Cities: Skylines предлагает по-новому взглянуть на классический жанр градостроительного симулятора. Эта игра как нельзя лучше передает возникающие перед градоначальником трудности и позволяет создать настоящий мегаполис, одновременно привнося в игру прият', 220),
(3, 'eu4.jpg', 'Europa Universalis IV', 2, 'В Europa Universalis IV вы сможете провести страну сквозь четыре насыщенных столетия. Правьте землями и добивайтесь мирового господства, наслаждаясь свободой действий, проработанным игровым процессом и исторической точностью.', 1300),
(4, 'crus_kings.jpg', 'Crusader Kings III', 2, 'Любовь, война, интриги и величие. Определите наследие своего знатного рода в безграничной глобальной стратегии Crusader Kings III.', 1600),
(5, 'csgo.jpg', 'Counter-Strike: Global Offensive', 1, 'Counter-Strike: Global Offensive (CS:GO) расширяет границы ураганной командной игры, представленной ещё 19 лет назад.\r\n\r\nCS:GO включает в себя новые карты, персонажей, оружие и режимы игры, а также улучшает классическую составляющую CS (de_dust2 и т. п.).', 0),
(6, 'party_animals.jpg', 'Party Animals', 1, 'Сражайтесь с друзьями в роли щенков, котят и других пушистых существ в PARTY ANIMALS! Разберитесь с друзьями в сети и офлайн. Взаимодействуйте с миром при помощи нашего реалистичного движка. Я уже упоминал ЩЕНКОВ?', 1238),
(7, 'apex.jpg', 'Apex Legends', 1, 'Побеждайте с характером в Apex Legends™ — бесплатном героическом шутере*, где легендарные персонажи с мощными способностями сражаются за славу и богатства на дальних рубежах Фронтира.', 0),
(8, 'pubg.jpg', 'PUBG: BATTLEGROUNDS', 1, 'Играйте В PUBG: BATTLEGROUNDS бесплатно. Высаживайтесь в стратегически важных местах, добывайте оружие и припасы и постарайтесь выжить и остаться последней командой на одном из многочисленных полей боя.', 0),
(9, 'terraria.jpg', 'Terraria', 3, 'Копайте, сражайтесь, исследуйте, стройте! Нет ничего невозможного в этой насыщенной событиями приключенческой игре. Весь мир — ваше полотно, а вся земля — ваши краски!\r\nХватайте инструменты и вперед! Создавайте оружие, чтобы сражаться с различными врагами', 300),
(10, 'bald_gate.jpg', 'Baldur`s Gate 3', 3, 'Соберите отряд и вернитесь в Забытые Королевства. Вас ждет история о дружбе и предательстве, выживании и самопожертвовании, о сладком зове абсолютной власти.', 1999),
(11, 'stray.jpg', 'Stray', 3, 'Потерявшемуся, одинокому, оторванному от семьи бродячему коту предстоит разгадать древнюю тайну, вырваться из давно заброшенного кибергорода и найти дорогу домой.', 697),
(12, 'backrooms.jpg', 'Escape the Backrooms', 3, 'Escape the Backrooms это кооперативная игра в жанре хоррор для 1-4 игроков. Пройдите через жуткие подсобные помещения, избегая сущностей и других опасностей, чтобы попытаться спастись.', 207),
(13, 'beamng.jpg', 'BeamNG.drive', 4, 'Основанный на физике мягких объектов автомобильный симулятор, способный практически на всё.', 465),
(14, 'farm_sim.jpg', 'Farming Simulator 22', 4, 'Создайте свою ферму и начинайте растить! Собирайте урожай, ухаживайте за животными, распределяйте продукцию и проходите сезонные испытания.', 1359),
(15, 'stardew.jpg', 'Stardew Valley', 4, 'Вам досталась старая дедушкина ферма в долине Стардью. С горстью монет в кармане и старыми инструментами в руках вы начинаете новую жизнь. Сможете ли вы превратить пустырь в цветущий сад?', 299),
(16, 'moonstone.jpg', 'Moonstone Island', 4, 'Moonstone Island – это более 100 островов для исследования в открытом мире. Заводите друзей, варите зелья, приручайте духов (Spirits) и испытайте свои силы в карточных сражениях, чтобы стать настоящим мастером алхимии!', 639),
(17, 'fishing.jpg', 'Russian Fishing 4', 5, 'Russian Fishing 4 - это рыболовный симулятор с элементами RPG, игровой процесс которого основан на концепции открытого мира и полной свободе действий игрока.', 0),
(18, 'f1.jpg', 'F1® 23', 5, 'Тормозите позже всех в EA SPORTS™ F1® 23, официальной видеоигре чемпионата FIA Formula One World Championship™ 2023.', 1359),
(19, 'ass_corsa.jpg', 'Assetto Corsa', 5, 'Assetto Corsa v1.16 introduces the new \"Laguna Seca\" laser-scanned track, 7 new cars among which the eagerly awaited Alfa Romeo Giulia Quadrifoglio! Check the changelog for further info!', 435),
(20, 'golf.jpg', 'Golf It!', 5, 'Embark on an exciting journey with Golf It! Seize your putter, rally your friends, and immerse yourself in an epic minigolf adventure. Conquer countless courses, create lasting memories, and refine your skills to emerge as the ultimate minigolf champion. ', 400);

-- --------------------------------------------------------

--
-- Table structure for table `genres`
--

CREATE TABLE `genres` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `genres`
--

INSERT INTO `genres` (`id`, `name`) VALUES
(3, 'Приключение'),
(4, 'Симулятор'),
(5, 'Спорт'),
(2, 'Стратегия'),
(1, 'Экшен');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(45) NOT NULL,
  `date_of_birth` date NOT NULL,
  `address` varchar(100) NOT NULL,
  `sex` varchar(6) NOT NULL,
  `interests` text DEFAULT NULL,
  `vk` varchar(100) NOT NULL,
  `blood_type` varchar(8) NOT NULL,
  `rh_factor` varchar(17) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `full_name`, `date_of_birth`, `address`, `sex`, `interests`, `vk`, `blood_type`, `rh_factor`) VALUES
(18, 'sergey4016@mail.ru', '$2y$10$II5kE2tYPUahHILJi/ZKA.Z/GR7rxpGj2WBiaVx8IjJS0KR5tkAbW', 'Сергей', '2023-10-04', 'А', 'female', '', '1', '2', 'plus');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`id`),
  ADD KEY `foreign_key` (`genre_id`);

--
-- Indexes for table `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_uniq` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `games`
--
ALTER TABLE `games`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `genres`
--
ALTER TABLE `genres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `games`
--
ALTER TABLE `games`
  ADD CONSTRAINT `foreign_key` FOREIGN KEY (`genre_id`) REFERENCES `genres` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
