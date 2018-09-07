-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Сен 07 2018 г., 19:36
-- Версия сервера: 5.7.20
-- Версия PHP: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `instagram`
--

-- --------------------------------------------------------

--
-- Структура таблицы `action`
--

CREATE TABLE `action` (
  `id` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `action`
--

INSERT INTO `action` (`id`, `type`, `title`) VALUES
(1, 'like', 'лайкинг'),
(2, 'follow', 'фоловинг'),
(3, 'comment', 'комментарии'),
(4, 'direct', 'директ сообщения');

-- --------------------------------------------------------

--
-- Структура таблицы `instagram_accounts`
--

CREATE TABLE `instagram_accounts` (
  `id` int(11) NOT NULL,
  `proxy_id` int(11) DEFAULT NULL,
  `login` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `registrated_at` datetime DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `post` int(11) DEFAULT NULL,
  `followers` int(11) DEFAULT NULL,
  `following` int(11) DEFAULT NULL,
  `request_counter` int(11) DEFAULT NULL,
  `states` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_lock` tinyint(1) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `instagram_accounts`
--

INSERT INTO `instagram_accounts` (`id`, `proxy_id`, `login`, `password`, `registrated_at`, `description`, `post`, `followers`, `following`, `request_counter`, `states`, `is_lock`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 2, '123', '123123', NULL, '123', NULL, NULL, NULL, NULL, 'baned', 0, '2018-09-06 23:09:01', '2018-09-06 23:32:01', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `limits`
--

CREATE TABLE `limits` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `amouth` int(11) NOT NULL,
  `min_delay` int(11) DEFAULT NULL,
  `max_delay` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `limits`
--

INSERT INTO `limits` (`id`, `title`, `description`, `amouth`, `min_delay`, `max_delay`) VALUES
(1, 'following', 'фоловинг, анфоловинг - пока ставим до 700 аккаунтов в день, распределяем рандомно в течении дня, минимальная задержка между действиями 1 мин', 700, 60, NULL),
(2, 'unfollowing', 'фоловинг, анфоловинг - пока ставим до 700 аккаунтов в день, распределяем рандомно в течении дня, минимальная задержка между действиями 1 мин', 700, 60, NULL),
(3, 'like', 'лайкинг - до 300 лайков в день, распределяем в течении дня, мин задержка между действиями 1 мин', 300, 60, NULL),
(4, 'comment', 'комментирование - до 100 комментов в день, распределяем в течении дня, мин задержка между действиями 5 мин', 100, 300, NULL),
(5, 'message', 'отправка сообщения в директ - до 60 сообщений в день, распределяем в течении дня, мин задержка между отправками 6 мин ', 60, 360, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `logger`
--

CREATE TABLE `logger` (
  `id` int(11) NOT NULL,
  `instagram_account_id` int(11) NOT NULL,
  `action` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `task_id` int(11) NOT NULL,
  `message` longtext COLLATE utf8mb4_unicode_ci,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `logger`
--

INSERT INTO `logger` (`id`, `instagram_account_id`, `action`, `status`, `created_at`, `updated_at`, `task_id`, `message`, `deleted_at`) VALUES
(1, 2, 'фоловинг', 'error', '2018-09-06 23:27:29', '2018-09-06 23:27:29', 1, 'some message', NULL),
(2, 2, 'фоловинг', 'error', '2018-09-06 23:27:31', '2018-09-06 23:27:31', 1, 'some message', NULL),
(3, 2, 'фоловинг', 'error', '2018-09-06 23:27:33', '2018-09-06 23:27:33', 1, 'some message', NULL),
(4, 2, 'фоловинг', 'error', '2018-09-06 23:27:35', '2018-09-06 23:27:35', 1, 'some message', NULL),
(5, 2, 'фоловинг', 'succes', '2018-09-06 23:27:47', '2018-09-06 23:27:47', 1, 'some message', NULL),
(6, 2, 'фоловинг', 'success', '2018-09-06 23:28:15', '2018-09-06 23:28:15', 1, 'some message', NULL),
(7, 2, 'фоловинг', 'success', '2018-09-06 23:28:16', '2018-09-06 23:28:16', 1, 'some message', NULL),
(8, 2, 'фоловинг', 'success', '2018-09-06 23:28:17', '2018-09-06 23:28:17', 1, 'some message', NULL),
(9, 2, 'фоловинг', 'success', '2018-09-06 23:28:18', '2018-09-06 23:28:18', 1, 'some message', NULL),
(10, 2, 'фоловинг', 'success', '2018-09-06 23:31:23', '2018-09-06 23:31:23', 1, 'some message', NULL),
(11, 2, 'фоловинг', 'success', '2018-09-06 23:31:24', '2018-09-06 23:31:24', 1, 'some message', NULL),
(12, 2, 'фоловинг', 'baned', '2018-09-06 23:32:01', '2018-09-06 23:32:01', 1, 'some message', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `migration_versions`
--

CREATE TABLE `migration_versions` (
  `version` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `migration_versions`
--

INSERT INTO `migration_versions` (`version`) VALUES
('20180902201822'),
('20180904171535'),
('20180905190533'),
('20180905194305'),
('20180906174459');

-- --------------------------------------------------------

--
-- Структура таблицы `proxy`
--

CREATE TABLE `proxy` (
  `id` int(11) NOT NULL,
  `login` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip_port` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `proxy`
--

INSERT INTO `proxy` (`id`, `login`, `password`, `ip_port`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, NULL, NULL, NULL, '2018-09-06 22:50:23', '2018-09-06 22:50:23', NULL),
(2, NULL, NULL, NULL, '2018-09-06 23:09:01', '2018-09-06 23:09:01', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `search`
--

CREATE TABLE `search` (
  `id` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `search`
--

INSERT INTO `search` (`id`, `type`, `title`) VALUES
(1, 'location', 'локация'),
(2, 'hashtag', 'хештег'),
(3, 'account', 'аккаунт');

-- --------------------------------------------------------

--
-- Структура таблицы `task`
--

CREATE TABLE `task` (
  `id` int(11) NOT NULL,
  `inst_account_id` int(11) DEFAULT NULL,
  `search_type_id` int(11) NOT NULL,
  `action_type_id` int(11) NOT NULL,
  `start_at` datetime DEFAULT NULL,
  `finish_at` datetime DEFAULT NULL,
  `resource_amount` int(11) NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` json DEFAULT NULL,
  `data` json DEFAULT NULL,
  `resource_amouth_don` int(11) DEFAULT NULL,
  `lock_time` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `task`
--

INSERT INTO `task` (`id`, `inst_account_id`, `search_type_id`, `action_type_id`, `start_at`, `finish_at`, `resource_amount`, `status`, `title`, `message`, `data`, `resource_amouth_don`, `lock_time`, `deleted_at`) VALUES
(1, 2, 1, 2, NULL, NULL, 7, 'error_baned_account', '123', '\"[]\"', '\"[]\"', 6, '2018-09-06 21:20:48', NULL);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `action`
--
ALTER TABLE `action`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `instagram_accounts`
--
ALTER TABLE `instagram_accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_2DFDAC24DB26A4E` (`proxy_id`);

--
-- Индексы таблицы `limits`
--
ALTER TABLE `limits`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `logger`
--
ALTER TABLE `logger`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_987E13F3A0E6FB4C` (`instagram_account_id`),
  ADD KEY `IDX_987E13F38DB60186` (`task_id`);

--
-- Индексы таблицы `migration_versions`
--
ALTER TABLE `migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Индексы таблицы `proxy`
--
ALTER TABLE `proxy`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `search`
--
ALTER TABLE `search`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_527EDB25170C3F2D` (`inst_account_id`),
  ADD KEY `IDX_527EDB25489D6309` (`search_type_id`),
  ADD KEY `IDX_527EDB251FEE0472` (`action_type_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `action`
--
ALTER TABLE `action`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `instagram_accounts`
--
ALTER TABLE `instagram_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `limits`
--
ALTER TABLE `limits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `logger`
--
ALTER TABLE `logger`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `proxy`
--
ALTER TABLE `proxy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `search`
--
ALTER TABLE `search`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `task`
--
ALTER TABLE `task`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `instagram_accounts`
--
ALTER TABLE `instagram_accounts`
  ADD CONSTRAINT `FK_2DFDAC24DB26A4E` FOREIGN KEY (`proxy_id`) REFERENCES `proxy` (`id`);

--
-- Ограничения внешнего ключа таблицы `logger`
--
ALTER TABLE `logger`
  ADD CONSTRAINT `FK_987E13F38DB60186` FOREIGN KEY (`task_id`) REFERENCES `task` (`id`),
  ADD CONSTRAINT `FK_987E13F3A0E6FB4C` FOREIGN KEY (`instagram_account_id`) REFERENCES `instagram_accounts` (`id`);

--
-- Ограничения внешнего ключа таблицы `task`
--
ALTER TABLE `task`
  ADD CONSTRAINT `FK_527EDB25170C3F2D` FOREIGN KEY (`inst_account_id`) REFERENCES `instagram_accounts` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `FK_527EDB251FEE0472` FOREIGN KEY (`action_type_id`) REFERENCES `action` (`id`),
  ADD CONSTRAINT `FK_527EDB25489D6309` FOREIGN KEY (`search_type_id`) REFERENCES `search` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
