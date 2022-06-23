-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- ホスト: localhost:8889
-- 生成日時: 2022-06-23 02:25:13
-- サーバのバージョン： 5.7.24
-- PHP のバージョン: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `kensyu_db`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL COMMENT 'カートID',
  `user_id` int(11) NOT NULL COMMENT 'ユーザID',
  `item_id` int(11) NOT NULL COMMENT '商品ID',
  `number` int(11) NOT NULL COMMENT '個数',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'タイムスタンプ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `favorite`
--

CREATE TABLE `favorite` (
  `id` int(11) NOT NULL COMMENT 'お気に入りID',
  `user_id` int(11) NOT NULL COMMENT 'ユーザーID',
  `item_id` int(11) NOT NULL COMMENT '商品ID',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'タイムスタンプ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `favorite`
--

INSERT INTO `favorite` (`id`, `user_id`, `item_id`, `created`) VALUES
(1, 23, 1, '2022-06-21 04:17:48');

-- --------------------------------------------------------

--
-- テーブルの構造 `history`
--

CREATE TABLE `history` (
  `id` int(11) NOT NULL COMMENT '注文履歴ID',
  `user_id` int(11) NOT NULL COMMENT 'ユーザーID',
  `name` varchar(255) NOT NULL COMMENT '商品名(購入時)',
  `price` int(11) NOT NULL COMMENT '価格(購入時)',
  `num` int(11) NOT NULL COMMENT 'なんこその商品を買ったか',
  `item_id` int(11) NOT NULL COMMENT '商品リンク',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '作成日'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `history`
--

INSERT INTO `history` (`id`, `user_id`, `name`, `price`, `num`, `item_id`, `created`) VALUES
(1, 16, '椅子', 2000, 0, 1, '2022-06-20 05:44:45'),
(2, 16, '椅子', 2000, 0, 1, '2022-06-20 06:05:23'),
(3, 1, '椅子', 2000, 0, 1, '2022-06-20 07:39:38'),
(4, 1, '椅子', 2000, 0, 1, '2022-06-20 07:40:00'),
(5, 16, '椅子', 2000, 0, 1, '2022-06-20 09:02:39'),
(6, 2, '俺のリンゴ', 4545, 0, 3, '2022-06-22 07:25:14'),
(7, 1, 'りんご', 123, 0, 13, '2022-06-23 01:13:01'),
(8, 1, 'saitou', 22, 0, 12, '2022-06-23 01:22:44');

-- --------------------------------------------------------

--
-- テーブルの構造 `inquery`
--

CREATE TABLE `inquery` (
  `id` int(11) NOT NULL COMMENT 'お問い合わせID',
  `email` varchar(255) NOT NULL COMMENT 'メールアドレス',
  `inquery_post` text NOT NULL COMMENT 'お問い合わせ内容',
  `kenmei` varchar(255) NOT NULL COMMENT '件名',
  `name` int(11) NOT NULL COMMENT '名前',
  `qreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '投稿日時'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL COMMENT 'アイテムID',
  `name` varchar(255) NOT NULL COMMENT '商品名',
  `price` int(11) NOT NULL COMMENT '値段',
  `jenre_id` int(11) NOT NULL COMMENT 'ジャンルID\r\n',
  `retention_stock` int(11) NOT NULL COMMENT '初期在庫の保持',
  `stock` int(11) NOT NULL COMMENT '在庫数',
  `setumei` varchar(255) NOT NULL COMMENT '商品説明',
  `syousai` varchar(255) NOT NULL COMMENT '詳細情報',
  `picture` varchar(255) NOT NULL COMMENT '商品画像',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '追加日時'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `items`
--

INSERT INTO `items` (`id`, `name`, `price`, `jenre_id`, `retention_stock`, `stock`, `setumei`, `syousai`, `picture`, `created`) VALUES
(14, 'イス', 2000, 0, 110, 110, 'とても座りやすいです', '高さ２２２ｃｍ', 'isu.png', '2022-06-23 02:17:50'),
(15, 'カート', 10200, 0, 200, 200, '女性です', 'いいにおいがします', 'publicdomainq-0043731gomdgf.jpg', '2022-06-23 02:18:32');

-- --------------------------------------------------------

--
-- テーブルの構造 `m_jenre`
--

CREATE TABLE `m_jenre` (
  `id` int(11) NOT NULL COMMENT 'ジャンルID',
  `jenre_name` varchar(255) NOT NULL COMMENT 'ジャンル名'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL COMMENT 'レビューID',
  `comment` varchar(255) NOT NULL COMMENT 'コメント',
  `star` int(11) NOT NULL COMMENT '評価１～５で表示',
  `user_id` int(11) NOT NULL COMMENT 'ユーザーID',
  `item_id` int(11) NOT NULL COMMENT 'アイテムID',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '作成日'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `reviews`
--

INSERT INTO `reviews` (`id`, `comment`, `star`, `user_id`, `item_id`, `created`) VALUES
(3, '', 4, 16, 1, '2022-06-20 06:44:16'),
(5, '', 5, 1, 1, '2022-06-20 07:42:53'),
(6, '私が神です', 1, 1, 11, '2022-06-22 08:23:32');

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL COMMENT 'ユーザーID',
  `name` varchar(255) NOT NULL COMMENT 'ユーザー名',
  `name_kana` varchar(255) NOT NULL COMMENT 'ユーザー仮名',
  `nickname` varchar(255) NOT NULL COMMENT 'ニックネーム',
  `sex` int(11) DEFAULT NULL COMMENT '性別',
  `birthday` date DEFAULT NULL COMMENT '誕生日',
  `zipcode` varchar(255) NOT NULL COMMENT '郵便番号',
  `address` varchar(255) NOT NULL COMMENT '住所',
  `tell` varchar(20) NOT NULL COMMENT '電話番号',
  `email` varchar(255) NOT NULL COMMENT 'メールアドレス',
  `pass` varchar(255) NOT NULL COMMENT 'パスワード',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '作成日',
  `updatetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`id`, `name`, `name_kana`, `nickname`, `sex`, `birthday`, `zipcode`, `address`, `tell`, `email`, `pass`, `created`, `updatetime`) VALUES
(1, '齋藤亮太', 'サウンド', '神', 2, NULL, '000-2222', 'ああああ', '000-2222-2222', 'manuke1290@gmail.com', '$2y$10$M39LZepiU55aLMrXCbubXeh8SNe.NiiJqxCoMXCoUyRdDRl5GHK1S', '2022-06-21 08:38:24', '2022-06-21 08:38:24'),
(2, 'sass', 'アア', 'ss', 2, NULL, '000-2222', 'fff', '000-2222-2222', 'saito@s.co.jp', '$2y$10$TxL.jbTGowQS4Ms7DvrPd.FVpkZ92rz9yq92NX0yKbCRYf5ozmZpC', '2022-06-21 08:43:54', '2022-06-21 08:43:54');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `favorite`
--
ALTER TABLE `favorite`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `inquery`
--
ALTER TABLE `inquery`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `m_jenre`
--
ALTER TABLE `m_jenre`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'カートID', AUTO_INCREMENT=3;

--
-- テーブルの AUTO_INCREMENT `favorite`
--
ALTER TABLE `favorite`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'お気に入りID', AUTO_INCREMENT=2;

--
-- テーブルの AUTO_INCREMENT `history`
--
ALTER TABLE `history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '注文履歴ID', AUTO_INCREMENT=9;

--
-- テーブルの AUTO_INCREMENT `inquery`
--
ALTER TABLE `inquery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'お問い合わせID';

--
-- テーブルの AUTO_INCREMENT `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'アイテムID', AUTO_INCREMENT=16;

--
-- テーブルの AUTO_INCREMENT `m_jenre`
--
ALTER TABLE `m_jenre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ジャンルID';

--
-- テーブルの AUTO_INCREMENT `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'レビューID', AUTO_INCREMENT=9;

--
-- テーブルの AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ユーザーID', AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
