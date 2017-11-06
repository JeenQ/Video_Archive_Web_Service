-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- 생성 시간: 17-11-06 06:52
-- 서버 버전: 5.6.38
-- PHP 버전: 5.6.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 데이터베이스: `archive_db`
--

-- --------------------------------------------------------

--
-- 테이블 구조 `tb_account`
--

CREATE TABLE `tb_account` (
  `key_num` int(10) NOT NULL COMMENT '고유번호',
  `id` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_mysql500_ci NOT NULL COMMENT '아이디',
  `password` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_mysql500_ci NOT NULL COMMENT '암호',
  `name` varchar(20) NOT NULL COMMENT '이름',
  `position` varchar(20) NOT NULL COMMENT '직급',
  `level` tinyint(1) NOT NULL COMMENT '프로그램에서 권한',
  `last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '마지막 로그인 시간'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 테이블의 덤프 데이터 `tb_account`
--

INSERT INTO `tb_account` (`key_num`, `id`, `password`, `name`, `position`, `level`, `last_login`) VALUES
(14, 'admin', 'Big@1', 'admin', 'admin', 1, '2017-11-06 14:46:20');

-- --------------------------------------------------------

--
-- 테이블 구조 `tb_category`
--

CREATE TABLE `tb_category` (
  `key_num` int(3) NOT NULL COMMENT 'catogory key number',
  `category` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_mysql500_ci NOT NULL COMMENT 'category name'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 테이블 구조 `tb_company`
--

CREATE TABLE `tb_company` (
  `company_name` varchar(100) NOT NULL COMMENT '회사명'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 테이블의 덤프 데이터 `tb_company`
--

INSERT INTO `tb_company` (`company_name`) VALUES
('KAI'),
('LIG NEXT');

-- --------------------------------------------------------

--
-- 테이블 구조 `tb_file`
--

CREATE TABLE `tb_file` (
  `file_key` int(10) NOT NULL,
  `file_name` varchar(100) DEFAULT NULL,
  `account_key` int(10) DEFAULT NULL,
  `group_key` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 테이블의 덤프 데이터 `tb_file`
--

INSERT INTO `tb_file` (`file_key`, `file_name`, `account_key`, `group_key`) VALUES
(21, 'file14_20171106065044.pdf', 14, 1509979844);

-- --------------------------------------------------------

--
-- 테이블 구조 `tb_video`
--

CREATE TABLE `tb_video` (
  `video_key` int(10) NOT NULL,
  `shoot_date` varchar(100) DEFAULT NULL COMMENT '촬영날짜',
  `title` varchar(100) DEFAULT NULL COMMENT '제목',
  `company` varchar(100) DEFAULT NULL COMMENT '업체',
  `place` varchar(100) DEFAULT NULL COMMENT '촬영장소',
  `cameraman` varchar(100) DEFAULT NULL COMMENT '촬영자',
  `equipment` varchar(100) DEFAULT NULL COMMENT '촬영장비',
  `detail` varchar(1000) DEFAULT NULL COMMENT '세부내용',
  `extra` varchar(100) DEFAULT NULL COMMENT '비고',
  `creater_key` int(10) DEFAULT NULL COMMENT '작성자',
  `group_key` int(10) DEFAULT NULL,
  `path` varchar(200) DEFAULT NULL COMMENT '파일경로',
  `size` varchar(20) DEFAULT NULL COMMENT 'MB 단위의 영상 크기',
  `upload_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '업로드 날짜',
  `length` varchar(15) DEFAULT NULL COMMENT '영상의 길이',
  `resolution` varchar(15) DEFAULT NULL COMMENT '해상도'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 테이블의 덤프 데이터 `tb_video`
--

INSERT INTO `tb_video` (`video_key`, `shoot_date`, `title`, `company`, `place`, `cameraman`, `equipment`, `detail`, `extra`, `creater_key`, `group_key`, `path`, `size`, `upload_date`, `length`, `resolution`) VALUES
(37, '2017-11-06', '토르: 라그나로크 THOR: Ragnarok 1차 공식 예고편', 'KAI', 'test입니다', 'test입니다', 'test입니다', '• 원제: Thor: Ragnarok\r\n• 감독: Taika Waititi\r\n• 북미 개봉일: 2017년 11월 3일\r\n• 한국 개봉일: 2017년 10월 25일', '', 14, 1509979844, 'video14_20171106065044.mp4', '26.46', '2017-11-06 14:50:44', NULL, NULL);

--
-- 덤프된 테이블의 인덱스
--

--
-- 테이블의 인덱스 `tb_account`
--
ALTER TABLE `tb_account`
  ADD PRIMARY KEY (`key_num`),
  ADD UNIQUE KEY `id` (`id`);

--
-- 테이블의 인덱스 `tb_category`
--
ALTER TABLE `tb_category`
  ADD PRIMARY KEY (`key_num`);

--
-- 테이블의 인덱스 `tb_company`
--
ALTER TABLE `tb_company`
  ADD PRIMARY KEY (`company_name`);

--
-- 테이블의 인덱스 `tb_file`
--
ALTER TABLE `tb_file`
  ADD PRIMARY KEY (`file_key`);

--
-- 테이블의 인덱스 `tb_video`
--
ALTER TABLE `tb_video`
  ADD PRIMARY KEY (`video_key`);

--
-- 덤프된 테이블의 AUTO_INCREMENT
--

--
-- 테이블의 AUTO_INCREMENT `tb_account`
--
ALTER TABLE `tb_account`
  MODIFY `key_num` int(10) NOT NULL AUTO_INCREMENT COMMENT '고유번호', AUTO_INCREMENT=16;

--
-- 테이블의 AUTO_INCREMENT `tb_category`
--
ALTER TABLE `tb_category`
  MODIFY `key_num` int(3) NOT NULL AUTO_INCREMENT COMMENT 'catogory key number';

--
-- 테이블의 AUTO_INCREMENT `tb_file`
--
ALTER TABLE `tb_file`
  MODIFY `file_key` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- 테이블의 AUTO_INCREMENT `tb_video`
--
ALTER TABLE `tb_video`
  MODIFY `video_key` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
