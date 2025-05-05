-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 24, 2023 at 03:38 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `iclop_final`
--

-- --------------------------------------------------------

--
-- Table structure for table `academic_year`
--

CREATE TABLE `academic_year` (
  `id` bigint(20) NOT NULL,
  `name` varchar(10) NOT NULL,
  `semester` varchar(6) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` varchar(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `academic_year`
--

INSERT INTO `academic_year` (`id`, `name`, `semester`, `start_date`, `end_date`, `status`, `created_at`, `updated_at`) VALUES
(1, '2021/2022', 'Genap', '2023-01-01', '2023-01-31', 'Aktif', '2022-11-26 00:55:33', '2022-11-26 04:27:44'),
(2, '2021/2022', 'Ganjil', '2021-08-09', '2022-01-21', 'Selesai', '2022-12-04 17:04:12', '2022-12-04 17:25:43');

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `academic_year_id` bigint(20) DEFAULT NULL,
  `teacher_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`id`, `academic_year_id`, `teacher_id`, `name`, `created_at`, `updated_at`) VALUES
(5, 1, 1, 'TI-4H', '2022-11-26 08:09:15', '2022-11-26 10:22:03'),
(6, 1, 1, 'TI-4A', '2022-11-26 09:32:51', '2022-11-26 09:32:51'),
(7, 1, 1, 'TI-4B', '2022-11-26 09:34:42', '2022-11-26 09:34:42'),
(8, 1, 1, 'TI-4C', '2022-11-26 09:36:19', '2022-11-26 09:36:19');

-- --------------------------------------------------------

--
-- Table structure for table `class_student`
--

CREATE TABLE `class_student` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `class_id` bigint(20) UNSIGNED DEFAULT NULL,
  `student_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `class_student`
--

INSERT INTO `class_student` (`id`, `class_id`, `student_id`, `created_at`, `updated_at`) VALUES
(8, 7, 3, '2022-12-04 19:02:19', '2022-12-04 19:32:12'),
(14, 6, 4, '2022-12-10 19:04:33', '2022-12-10 19:04:33'),
(15, 7, 5, '2022-12-10 19:56:27', '2022-12-10 19:56:27'),
(16, 7, 6, '2022-12-10 20:39:45', '2022-12-10 20:39:45'),
(17, 5, 8, '2022-12-10 21:28:33', '2022-12-10 21:28:33');

-- --------------------------------------------------------

--
-- Table structure for table `daftar_soal`
--

CREATE TABLE `daftar_soal` (
  `id` bigint(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `topic` varchar(255) NOT NULL,
  `dbname` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `required_table` text DEFAULT NULL,
  `test_code` text DEFAULT NULL,
  `guide` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `daftar_soal`
--

INSERT INTO `daftar_soal` (`id`, `title`, `topic`, `dbname`, `description`, `required_table`, `test_code`, `guide`, `created_at`, `updated_at`) VALUES
(1, 'MEMBUAT DATABASE my_playlist', 'CREATE Database', 'my_playlist', 'membuat database', NULL, '#Tidak ada', 'Modul 1.pdf', NULL, '2022-10-13 01:01:20'),
(2, 'MEMBUAT TABLE playlists', 'CREATE Table', 'my_playlist', 'tipe data', NULL, 'CREATE EXTENSION IF NOT EXISTS pgtap;\r\nCREATE OR REPLACE FUNCTION public.testschema()\r\nRETURNS SETOF TEXT LANGUAGE plpgsql AS $$\r\nBEGIN\r\nRETURN NEXT has_table( \'playlists\', \'TABEL playlists\');\r\nRETURN NEXT has_column( \'playlists\', \'id\', \'KOLOM id\');\r\nRETURN NEXT has_column( \'playlists\', \'playlist_name\', \'KOLOM playlist_name\');\r\nRETURN NEXT col_type_is( \'playlists\', \'id\', \'integer\', \'TIPE KOLOM id\');\r\nRETURN NEXT col_type_is( \'playlists\', \'playlist_name\', \'character varying(50)\', \'TIPE KOLOM playlist_name\');\r\nEND;\r\n$$;\r\nSELECT * FROM runtests(\'public\'::name) OFFSET 1 LIMIT 5;', 'Modul 2.pdf', NULL, NULL),
(3, 'MEMBUAT TABEL artists', 'CREATE Table', 'my_playlist', 'primary key', NULL, 'CREATE EXTENSION IF NOT EXISTS pgtap;\r\nCREATE OR REPLACE FUNCTION public.testschema()\r\nRETURNS SETOF TEXT LANGUAGE plpgsql AS $$\r\nBEGIN\r\nRETURN NEXT has_table( \'artists\', \'TABEL artists\');\r\nRETURN NEXT has_column( \'artists\', \'id\', \'KOLOM id\');\r\nRETURN NEXT has_column( \'artists\', \'name\', \'KOLOM name\');\r\nRETURN NEXT col_type_is( \'artists\', \'id\', \'integer\', \'TIPE KOLOM id\');\r\nRETURN NEXT col_type_is( \'artists\', \'name\', \'character varying(50)\', \'TIPE KOLOM name\');\r\nRETURN NEXT col_is_pk( \'artists\', \'id\', \'KOLOM id PRIMARY KEY\');\r\nEND;\r\n$$;\r\nSELECT * FROM runtests(\'public\'::name)\r\nOFFSET 1 LIMIT 6;', 'Modul 3.pdf', '2022-08-08 08:28:57', '2022-09-09 06:19:13'),
(4, 'MEMBUAT TABEL albums', 'CREATE Table', 'my_playlist', 'null dan not null', NULL, 'CREATE EXTENSION IF NOT EXISTS pgtap; CREATE OR REPLACE FUNCTION public.testschema()\r\nRETURNS SETOF TEXT LANGUAGE plpgsql AS $$\r\nBEGIN\r\nRETURN NEXT has_table( \'users\', \'TABEL users\');\r\nRETURN NEXT has_column( \'users\', \'id\', \'KOLOM id\');\r\nRETURN NEXT has_column( \'users\', \'name\', \'KOLOM name\');\r\nRETURN NEXT has_column( \'users\', \'email\', \'KOLOM email\');\r\nRETURN NEXT has_column( \'users\', \'password\', \'KOLOM password\');\r\nRETURN NEXT col_type_is( \'users\', \'id\', \'integer\', \'TIPE KOLOM id\');\r\nRETURN NEXT col_type_is( \'users\', \'name\', \'character varying(50)\', \'TIPE KOLOM name\');\r\nRETURN NEXT col_type_is( \'users\', \'email\', \'character varying(50)\', \'TIPE KOLOM email\');\r\nRETURN NEXT col_not_null( \'users\', \'name\', \'KOLOM name NOT NULL\');\r\nRETURN NEXT col_not_null( \'users\', \'email\', \'KOLOM email adalah NOT NULL\');\r\nRETURN NEXT col_not_null( \'users\', \'password\', \'KOLOM password NOT NULL\');\r\nRETURN NEXT col_is_unique( \'users\', \'email\', \'KONLOM email UNIQUE\');\r\nRETURN NEXT col_is_pk( \'users\', \'id\', \'KOLOM id PRIMARY KEY\');\r\nEND;\r\n$$;\r\nSELECT * FROM runtests(\'public\'::name)\r\nOFFSET 1 LIMIT 13;', 'Modul 4.pdf', '2022-08-08 09:58:40', NULL),
(5, 'MEMBUAT TABEL playlists', 'CREATE Table', 'my_playlist', 'default', NULL, 'CREATE EXTENSION IF NOT EXISTS pgtap;\r\nCREATE OR REPLACE FUNCTION public.testschema()\r\nRETURNS SETOF TEXT LANGUAGE plpgsql AS $$\r\nBEGIN\r\nRETURN NEXT has_table( \'playlists\', \'TABEL playlists\');\r\nRETURN NEXT has_column( \'playlists\', \'id\', \'KOLOM id\');\r\nRETURN NEXT has_column( \'playlists\', \'playlist_name\', \'KOLOM name\');\r\nRETURN NEXT col_type_is( \'playlists\', \'id\', \'integer\', \'TIPE KOLOM id\');\r\nRETURN NEXT col_type_is( \'playlists\', \'playlist_name\', \'character varying(50)\', \'TIPE KOLOM playlist_name\');\r\nRETURN NEXT col_has_default( \'playlists\', \'playlist_name\', \'KOLOM playlist_name DEFAULT\');\r\nRETURN NEXT col_default_is( \'playlists\', \'playlist_name\', \'favourite\',\'NILAI DEFAULT KOLOM playlist_name\');\r\nRETURN NEXT col_is_pk( \'playlists\', \'id\', \'KOLOM id PRIMARY KEY\');\r\nEND;\r\n$$;\r\nSELECT * FROM runtests(\'public\'::name) OFFSET 1 LIMIT 8;', 'Modul 5.pdf', '2022-08-09 07:27:49', NULL),
(6, 'MEMBUAT TABEL songs', 'CREATE Table', 'my_playlist', 'unique', NULL, 'CREATE EXTENSION IF NOT EXISTS pgtap;\r\nCREATE OR REPLACE FUNCTION public.testschema()\r\nRETURNS SETOF TEXT LANGUAGE plpgsql AS $$\r\nBEGIN\r\nRETURN NEXT has_table( \'users\', \'TABEL users\');\r\nRETURN NEXT has_column( \'users\', \'id\', \'KOLOM id\');\r\nRETURN NEXT has_column( \'users\', \'name\', \'KOLOM name\');\r\nRETURN NEXT has_column( \'users\', \'email\', \'KOLOM email\');\r\nRETURN NEXT col_type_is( \'users\', \'id\', \'integer\', \'TIPE KOLOM id\');\r\nRETURN NEXT col_type_is( \'users\', \'name\', \'character varying(50)\', \'TIPE KOLOM name\');\r\nRETURN NEXT col_type_is( \'users\', \'email\', \'character varying(50)\', \'TIPE KOLOM email\');\r\nRETURN NEXT col_not_null( \'users\', \'name\', \'KOLOM name NOT NULL\');\r\nRETURN NEXT col_is_unique( \'users\', \'email\', \'KOLOM email UNIQUE\');\r\nRETURN NEXT col_is_pk( \'users\', \'id\', \'KOLOM id PRIMARY KEY\');\r\nEND;\r\n$$;\r\nSELECT * FROM runtests(\'public\'::name)\r\nOFFSET 1 LIMIT 10;', 'Modul 6.pdf', '2022-08-09 07:28:54', NULL),
(7, 'MODIFIKASI TABEL users', 'CREATE Table', 'my_playlist', 'check', 'CREATE TABLE users (\r\nid serial PRIMARY KEY,\r\nname VARCHAR(50) NOT NULL,\r\nemail VARCHAR(50)UNIQUE NOT NULL,\r\npassword VARCHAR (255) NOT NULL,\r\navatar VARCHAR (255) NOT NULL,\r\nis_admin BOOLEAN DEFAULT FALSE\r\n);', 'CREATE EXTENSION IF NOT EXISTS pgtap; CREATE OR REPLACE FUNCTION public.testschema()\r\nRETURNS SETOF TEXT LANGUAGE plpgsql AS $$\r\nBEGIN\r\nRETURN NEXT has_table( \'users\', \'Database my_playlist memiliki tabel users\');\r\nRETURN NEXT has_column( \'users\', \'id\', \'Tabel users memiliki kolom id\');\r\nRETURN NEXT has_column( \'users\', \'name\', \'Tabel users memiliki kolom name\');\r\nRETURN NEXT has_column( \'users\', \'email\', \'Tabel users memiliki kolom email\');\r\nRETURN NEXT has_column( \'users\', \'password\', \'Tabel users memiliki kolom password\');\r\nRETURN NEXT has_column( \'users\', \'is_admin\', \'Tabel users memiliki kolom is_admin\');\r\nRETURN NEXT has_column( \'users\', \'picture\', \'Tabel users memiliki kolom picture\');\r\nRETURN NEXT col_type_is( \'users\', \'id\', \'integer\', \'Tipe kolom id adalah INTEGER\');\r\nRETURN NEXT col_type_is( \'users\', \'name\', \'character varying(50)\', \'Tipe kolom name adalah VARCHAR(50)\');\r\nRETURN NEXT col_type_is( \'users\', \'email\', \'character varying(50)\', \'Tipe kolom email adalah VARCHAR(50)\');\r\nRETURN NEXT col_type_is( \'users\', \'password\', \'character varying(255)\', \'Tipe kolom password adalah VARCHAR(255)\');\r\nRETURN NEXT col_type_is( \'users\', \'picture\', \'character varying(255)\', \'Tipe kolom picture adalah VARCHAR(255)\');\r\nRETURN NEXT col_not_null( \'users\', \'name\', \'Kolom name adalah NOT NULL\');\r\nRETURN NEXT col_not_null( \'users\', \'email\', \'Kolom email adalah NOT NULL\');\r\nRETURN NEXT col_not_null( \'users\', \'password\', \'Kolom password NOT NULL\');\r\nRETURN NEXT col_not_null( \'users\', \'picture\', \'Kolom picture NOT NULL\');\r\nRETURN NEXT col_is_unique( \'users\', \'email\', \'Kolom email UNIQUE\');\r\nRETURN NEXT col_has_default( \'users\', \'is_admin\', \'Kolom is_admin DEFAULT\');\r\nRETURN NEXT col_default_is( \'users\', \'is_admin\', FALSE ,\'Nilai DEFAULT kolom is_admin adalah FALSE\');\r\nRETURN NEXT col_is_pk( \'users\', \'id\', \'Kolom id adalah PRIMARY KEY\');\r\nEND;\r\n$$;\r\nSELECT * FROM runtests(\'public\'::name);', 'Master.pdf', '2022-08-09 07:30:08', NULL),
(8, 'MODIFIKASI TABEL artists', 'ALTER Table', 'my_playlist', 'foreign key', 'CREATE TABLE artists (\r\nid serial PRIMARY KEY,\r\nname VARCHAR(50),\r\navatar varchar(255),\r\nborn date,\r\noccupation varchar(255),\r\nyears_active varchar(50)\r\n);', 'CREATE EXTENSION IF NOT EXISTS pgtap;\r\nCREATE OR REPLACE FUNCTION public.testschema()\r\nRETURNS SETOF TEXT LANGUAGE plpgsql AS $$\r\nBEGIN\r\nRETURN NEXT has_table( \'artists\', \'Database my_playlist memiliki tabel artists\');\r\nRETURN NEXT has_column( \'artists\', \'id\', \'Tabel artists memiliki kolom id\');\r\nRETURN NEXT has_column( \'artists\', \'name\', \'Tabel artists memiliki kolom name\');\r\nRETURN NEXT has_column( \'artists\', \'picture\', \'Tabel artists memiliki kolom picture\');\r\nRETURN NEXT has_column( \'artists\', \'born\', \'Tabel artists memiliki kolom born\');\r\nRETURN NEXT has_column( \'artists\', \'occupation\', \'Tabel artists memiliki kolom occupation\');\r\nRETURN NEXT has_column( \'artists\', \'years_active\', \'Tabel artists memiliki kolom years_active\');\r\nRETURN NEXT col_type_is( \'artists\', \'id\', \'integer\', \'Tipe kolom id adalah INTEGER\');\r\nRETURN NEXT col_type_is( \'artists\', \'name\', \'character varying(50)\', \'Tipe kolom name adalah VARCHAR(50)\');\r\nRETURN NEXT col_type_is( \'artists\', \'picture\', \'character varying(255)\', \'Tipe kolom picture adalah VARCHAR(255)\');\r\nRETURN NEXT col_type_is( \'artists\', \'born\', \'date\', \'Tipe kolom born adalah DATE\');\r\nRETURN NEXT col_type_is( \'artists\', \'occupation\', \'character varying(255)\', \'Tipe kolom occupation adalah VARCHAR(255)\');\r\nRETURN NEXT col_type_is( \'artists\', \'years_active\', \'character varying(50)\', \'Tipe kolom years_active adalah VARCHAR(50)\');\r\nRETURN NEXT col_is_pk( \'artists\', \'id\', \'Kolom id adalah PRIMARY KEY\');\r\nEND;\r\n$$;\r\nSELECT * FROM runtests(\'public\'::name);', NULL, '2022-08-09 07:31:06', NULL),
(9, 'MODIFIKASI TABEL users', 'ALTER Table', 'my_playlist', 'rename table', 'CREATE TABLE users ( \r\nid serial PRIMARY KEY, \r\nname VARCHAR(50) NOT NULL, \r\nemail VARCHAR(50)UNIQUE NOT NULL, \r\npassword VARCHAR(255) NOT NULL, \r\npicture VARCHAR(255) DEFAULT \'profile.jpg\',\r\nis_admin BOOLEAN DEFAULT FALSE\r\n);', 'CREATE EXTENSION IF NOT EXISTS pgtap; CREATE OR REPLACE FUNCTION public.testschema()\r\nRETURNS SETOF TEXT LANGUAGE plpgsql AS $$\r\nBEGIN\r\nRETURN NEXT has_table( \'users\', \'Database my_playlist memiliki tabel users\');\r\nRETURN NEXT has_column( \'users\', \'id\', \'Tabel users memiliki kolom id\');\r\nRETURN NEXT has_column( \'users\', \'name\', \'Tabel users memiliki kolom name\');\r\nRETURN NEXT has_column( \'users\', \'email\', \'Tabel users memiliki kolom email\');\r\nRETURN NEXT has_column( \'users\', \'password\', \'Tabel users memiliki kolom password\');\r\nRETURN NEXT has_column( \'users\', \'picture\', \'Tabel users memiliki kolom picture\');\r\nRETURN NEXT has_column( \'users\', \'is_admin\', \'Tabel users memiliki kolom is_admin\');\r\nRETURN NEXT col_type_is( \'users\', \'id\', \'integer\', \'Tipe kolom id adalah INTEGER\');\r\nRETURN NEXT col_type_is( \'users\', \'name\', \'character varying(50)\', \'Tipe kolom name adalah VARCHAR(50)\');\r\nRETURN NEXT col_type_is( \'users\', \'email\', \'character varying(255)\', \'Tipe kolom email adalah VARCHAR(255)\');\r\nRETURN NEXT col_type_is( \'users\', \'password\', \'character varying(255)\', \'Tipe kolom password adalah VARCHAR(255)\');\r\nRETURN NEXT col_type_is( \'users\', \'picture\', \'character varying(255)\', \'Tipe kolom picture adalah VARCHAR(255)\');\r\nRETURN NEXT col_not_null( \'users\', \'name\', \'Kolom name adalah NOT NULL\');\r\nRETURN NEXT col_not_null( \'users\', \'email\', \'Kolom email adalah NOT NULL\');\r\nRETURN NEXT col_not_null( \'users\', \'password\', \'Kolom password NOT NULL\');\r\nRETURN NEXT col_is_unique( \'users\', \'email\', \'Kolom email UNIQUE\');\r\nRETURN NEXT col_has_default( \'users\', \'is_admin\', \'Kolom is_admin DEFAULT\');\r\nRETURN NEXT col_default_is( \'users\', \'is_admin\', FALSE ,\'Nilai DEFAULT kolom is_admin adalah FALSE\');\r\nRETURN NEXT col_is_pk( \'users\', \'id\', \'Kolom id adalah PRIMARY KEY\');\r\nEND;\r\n$$;\r\nSELECT * FROM runtests(\'public\'::name);', 'Modul 9.pdf', '2022-08-09 07:31:42', NULL),
(10, 'MODIFIKASI TABEL artists', 'ALTER Table', 'my_playlist', 'rename kolom', 'CREATE TABLE artists (\r\nid serial PRIMARY KEY,\r\nname VARCHAR(50),\r\npicture varchar(255),\r\nborn date,\r\noccupation varchar(255),\r\nyears_active varchar(50)\r\n);', 'CREATE EXTENSION IF NOT EXISTS pgtap;\r\nCREATE OR REPLACE FUNCTION public.testschema()\r\nRETURNS SETOF TEXT LANGUAGE plpgsql AS $$\r\nBEGIN\r\nRETURN NEXT has_table( \'artists\', \'Database my_playlist memiliki tabel artists\');\r\nRETURN NEXT has_column( \'artists\', \'id\', \'Tabel artists memiliki kolom id\');\r\nRETURN NEXT has_column( \'artists\', \'name\', \'Tabel artists memiliki kolom name\');\r\nRETURN NEXT has_column( \'artists\', \'picture\', \'Tabel artists memiliki kolom picture\');\r\nRETURN NEXT has_column( \'artists\', \'born\', \'Tabel artists memiliki kolom born\');\r\nRETURN NEXT has_column( \'artists\', \'occupation\', \'Tabel artists memiliki kolom occupation\');\r\nRETURN NEXT has_column( \'artists\', \'years_active\', \'Tabel artists memiliki kolom years_active\');\r\nRETURN NEXT col_type_is( \'artists\', \'id\', \'integer\', \'Tipe kolom id adalah INTEGER\');\r\nRETURN NEXT col_type_is( \'artists\', \'name\', \'character varying(50)\', \'Tipe kolom name adalah VARCHAR(50)\');\r\nRETURN NEXT col_type_is( \'artists\', \'picture\', \'character varying(255)\', \'Tipe kolom picture adalah VARCHAR(255)\');\r\nRETURN NEXT col_type_is( \'artists\', \'born\', \'date\', \'Tipe kolom born adalah DATE\');\r\nRETURN NEXT col_type_is( \'artists\', \'occupation\', \'character varying(255)\', \'Tipe kolom occupationadalah VARCHAR(255)\');\r\nRETURN NEXT col_type_is( \'artists\', \'years_active\', \'character varying(50)\', \'Tipe kolom years_activeadalah VARCHAR(50)\');\r\nRETURN NEXT col_not_null( \'artists\', \'name\', \'Kolom name NOT NULL\');\r\nRETURN NEXT col_is_pk( \'artists\', \'id\', \'Kolom id adalah PRIMARY KEY\');\r\nEND;\r\n$$;\r\nSELECT * FROM runtests(\'public\'::name);', 'Modul 10.pdf', '2022-08-09 07:32:32', NULL),
(11, 'MODIFIKASI TABEL users', 'ALTER Table', 'my_playlist', 'tambah kolom', 'CREATE TABLE users (\r\nid serial PRIMARY KEY,\r\nname VARCHAR(50) NOT NULL,\r\nemail VARCHAR(50)UNIQUE NOT NULL,\r\npassword VARCHAR (255) NOT NULL,\r\npicture VARCHAR(255) NOT NULL,\r\nis_admin BOOLEAN DEFAULT FALSE\r\n);', 'CREATE EXTENSION IF NOT EXISTS pgtap; CREATE OR REPLACE FUNCTION public.testschema()\r\nRETURNS SETOF TEXT LANGUAGE plpgsql AS $$\r\nBEGIN\r\nRETURN NEXT has_table( \'users\', \'Database my_playlist memiliki tabel users\');\r\nRETURN NEXT has_column( \'users\', \'id\', \'Tabel users memiliki kolom id\');\r\nRETURN NEXT has_column( \'users\', \'name\', \'Tabel users memiliki kolom name\');\r\nRETURN NEXT has_column( \'users\', \'email\', \'Tabel users memiliki kolom email\');\r\nRETURN NEXT has_column( \'users\', \'password\', \'Tabel users memiliki kolom password\');\r\nRETURN NEXT has_column( \'users\', \'is_admin\', \'Tabel users memiliki kolom is_admin\');\r\nRETURN NEXT has_column( \'users\', \'picture\', \'Tabel users memiliki kolom picture\');\r\nRETURN NEXT col_type_is( \'users\', \'id\', \'integer\', \'Tipe kolom id adalah INTEGER\');\r\nRETURN NEXT col_type_is( \'users\', \'name\', \'character varying(50)\', \'Tipe kolom name adalah VARCHAR(50)\');\r\nRETURN NEXT col_type_is( \'users\', \'email\', \'character varying(50)\', \'Tipe kolom email adalah VARCHAR(50)\');\r\nRETURN NEXT col_type_is( \'users\', \'password\', \'character varying(255)\', \'Tipe kolom password adalah VARCHAR(255)\');\r\nRETURN NEXT col_type_is( \'users\', \'picture\', \'character varying(255)\', \'Tipe kolom picture adalah VARCHAR(255)\');\r\nRETURN NEXT col_type_is( \'users\', \'is_admin\', \'boolean\', \'Tipe kolom is_admin adalah boolean\');\r\nRETURN NEXT col_not_null( \'users\', \'name\', \'Kolom name adalah NOT NULL\');\r\nRETURN NEXT col_not_null( \'users\', \'email\', \'Kolom email adalah NOT NULL\');\r\nRETURN NEXT col_not_null( \'users\', \'password\', \'Kolom password NOT NULL\');\r\nRETURN NEXT col_is_null( \'users\', \'picture\', \'Kolom picture NULL\');\r\nRETURN NEXT col_is_unique( \'users\', \'email\', \'Kolom email UNIQUE\');\r\nRETURN NEXT col_has_default( \'users\', \'is_admin\', \'Kolom is_admin DEFAULT\');\r\nRETURN NEXT col_default_is( \'users\', \'is_admin\', FALSE ,\'Nilai DEFAULT kolom is_admin adalah FALSE\');\r\nRETURN NEXT col_is_pk( \'users\', \'id\', \'Kolom id adalah PRIMARY KEY\');\r\nEND;\r\n$$;\r\nSELECT * FROM runtests(\'public\'::name);', 'Modul 11.pdf', '2022-08-09 07:33:25', NULL),
(12, 'MODIFIKASI TABEL artists', 'ALTER Table', 'my_playlist', 'drop kolom', 'CREATE TABLE artists (\r\nid serial PRIMARY KEY,\r\nname VARCHAR(50) NOT NULL,\r\npicture varchar(255),\r\nborn date,\r\noccupation varchar(255),\r\nyears_active varchar(50)\r\n);', 'CREATE EXTENSION IF NOT EXISTS pgtap;\r\nCREATE OR REPLACE FUNCTION public.testschema()\r\nRETURNS SETOF TEXT LANGUAGE plpgsql AS $$\r\nBEGIN\r\nRETURN NEXT has_table( \'artists\', \'Database my_playlist memiliki tabel artists\');\r\nRETURN NEXT has_column( \'artists\', \'id\', \'Tabel artists memiliki kolom id\');\r\nRETURN NEXT has_column( \'artists\', \'name\', \'Tabel artists memiliki kolom name\');\r\nRETURN NEXT has_column( \'artists\', \'picture\', \'Tabel artists memiliki kolom picture\');\r\nRETURN NEXT has_column( \'artists\', \'born\', \'Tabel artists memiliki kolom born\');\r\nRETURN NEXT has_column( \'artists\', \'occupation\', \'Tabel artists memiliki kolom occupation\');\r\nRETURN NEXT has_column( \'artists\', \'years_active\', \'Tabel artists memiliki kolom years_active\');\r\nRETURN NEXT col_type_is( \'artists\', \'id\', \'integer\', \'Tipe kolom id adalah INTEGER\');\r\nRETURN NEXT col_type_is( \'artists\', \'name\', \'character varying(50)\', \'Tipe kolom name adalah VARCHAR(50)\');\r\nRETURN NEXT col_type_is( \'artists\', \'picture\', \'character varying(255)\', \'Tipe kolom picture adalah VARCHAR(255)\');\r\nRETURN NEXT col_type_is( \'artists\', \'born\', \'date\', \'Tipe kolom date adalah DATE\');\r\nRETURN NEXT col_type_is( \'artists\', \'occupation\', \'character varying(255)\', \'Tipe kolom occupation adalah VARCHAR(255)\');\r\nRETURN NEXT col_type_is( \'artists\', \'years_active\', \'character varying(50)\', \'Tipe kolom years_active adalah VARCHAR(50)\');\r\nRETURN NEXT col_has_default( \'artists\', \'occupation\', \'Kolom occupation DEFAULT\');\r\nRETURN NEXT col_default_is( \'artists\', \'occupation\',  \'SINGER\' ,\'Nilai DEFAULT kolom occupation adalah SINGER\');\r\nRETURN NEXT col_is_pk( \'artists\', \'id\', \'Kolom id adalah PRIMARY KEY\');\r\nEND;\r\n$$;\r\nSELECT * FROM runtests(\'public\'::name);', 'Modul 12.pdf', '2022-08-09 07:36:11', NULL),
(13, 'MODIFIKASI TABEL users', 'ALTER Table', 'my_playlist', 'ganti tipe data', 'CREATE TABLE users ( \r\nid serial PRIMARY KEY, \r\nname VARCHAR(50) NOT NULL, \r\nemail VARCHAR(50)UNIQUE NOT NULL, \r\npassword VARCHAR(255) NOT NULL, \r\npicture VARCHAR(255) NULL DEFAULT \'profile.jpg\',\r\nis_admin BOOLEAN DEFAULT FALSE\r\n);', 'CREATE EXTENSION IF NOT EXISTS pgtap; CREATE OR REPLACE FUNCTION public.testschema()\r\nRETURNS SETOF TEXT LANGUAGE plpgsql AS $$\r\nBEGIN\r\nRETURN NEXT has_table( \'users\', \'Database my_playlist memiliki tabel users\');\r\nRETURN NEXT has_column( \'users\', \'id\', \'Tabel users memiliki kolom id\');\r\nRETURN NEXT has_column( \'users\', \'name\', \'Tabel users memiliki kolom name\');\r\nRETURN NEXT has_column( \'users\', \'email\', \'Tabel users memiliki kolom email\');\r\nRETURN NEXT has_column( \'users\', \'password\', \'Tabel users memiliki kolom password\');\r\nRETURN NEXT has_column( \'users\', \'is_admin\', \'Tabel users memiliki kolom is_admin\');\r\nRETURN NEXT has_column( \'users\', \'picture\', \'Tabel users memiliki kolom picture\');\r\nRETURN NEXT col_type_is( \'users\', \'id\', \'integer\', \'Tipe kolom id adalah INTEGER\');\r\nRETURN NEXT col_type_is( \'users\', \'name\', \'character varying(50)\', \'Tipe kolom name adalah VARCHAR(50)\');\r\nRETURN NEXT col_type_is( \'users\', \'email\', \'character varying(50)\', \'Tipe kolom email adalah VARCHAR(50)\');\r\nRETURN NEXT col_type_is( \'users\', \'password\', \'character varying(255)\', \'Tipe kolom password adalah VARCHAR(255)\');\r\nRETURN NEXT col_type_is( \'users\', \'picture\', \'character varying(255)\', \'Tipe kolom picture adalah VARCHAR(255)\');\r\nRETURN NEXT col_type_is( \'users\', \'is_admin\', \'boolean\', \'Tipe kolom is_admin adalah boolean\');\r\nRETURN NEXT col_not_null( \'users\', \'name\', \'Kolom name adalah NOT NULL\');\r\nRETURN NEXT col_not_null( \'users\', \'email\', \'Kolom email adalah NOT NULL\');\r\nRETURN NEXT col_not_null( \'users\', \'password\', \'Kolom password NOT NULL\');\r\nRETURN NEXT col_is_null( \'users\', \'picture\', \'Kolom picture NOT NULL\');\r\nRETURN NEXT col_is_unique( \'users\', \'email\', \'Kolom email UNIQUE\');\r\nRETURN NEXT col_hasnt_default( \'users\', \'is_admin\', \'Kolom picture tidak memiliki nilai DEFAULT\');\r\nRETURN NEXT col_is_pk( \'users\', \'id\', \'Kolom id adalah PRIMARY KEY\');\r\nEND;\r\n$$;\r\nSELECT * FROM runtests(\'public\'::name);', 'Modul 13.pdf', '2022-08-09 07:37:09', NULL),
(14, 'MODIFIKASI TABEL artists', 'ALTER Table', 'my_playlist', 'ganti panjang data', 'CREATE TABLE artists (\r\nid serial PRIMARY KEY,\r\nname VARCHAR(50),\r\npicture varchar(255),\r\nborn date,\r\noccupation varchar(255) DEFAULT \'SINGER\',\r\nyears_active varchar(50)\r\n);', 'CREATE EXTENSION IF NOT EXISTS pgtap;\r\nCREATE OR REPLACE FUNCTION public.testschema()\r\nRETURNS SETOF TEXT LANGUAGE plpgsql AS $$\r\nBEGIN\r\nRETURN NEXT has_table( \'artists\', \'Database my_playlist memiliki tabel artists\');\r\nRETURN NEXT has_column( \'artists\', \'id\', \'Tabel artists memiliki kolom id\');\r\nRETURN NEXT has_column( \'artists\', \'name\', \'Tabel artists memiliki kolom name\');\r\nRETURN NEXT has_column( \'artists\', \'picture\', \'Tabel artists memiliki kolom picture\');\r\nRETURN NEXT has_column( \'artists\', \'born\', \'Tabel artists memiliki kolom born\');\r\nRETURN NEXT has_column( \'artists\', \'occupation\', \'Tabel artists memiliki kolom occupation\');\r\nRETURN NEXT col_type_is( \'artists\', \'id\', \'integer\', \'Tipe kolom id adalah INTEGER\');\r\nRETURN NEXT col_type_is( \'artists\', \'name\', \'character varying(50)\', \'Tipe kolom name adalah VARCHAR(50)\');\r\nRETURN NEXT col_type_is( \'artists\', \'picture\', \'character varying(255)\', \'Tipe kolom picture adalah VARCHAR(255)\');\r\nRETURN NEXT col_type_is( \'artists\', \'born\', \'date\', \'Tipe kolom born adalah DATE\');\r\nRETURN NEXT col_type_is( \'artists\', \'occupation\', \'character varying(255)\', \'Tipe kolom occupation adalah VARCHAR(255)\');\r\nRETURN NEXT col_has_default( \'artists\', \'occupation\', \'Kolom occupation DEFAULT\');\r\nRETURN NEXT col_default_is( \'artists\', \'occupation\', \'SINGER\' ,\'Nilai DEFAULT kolom occupation adalah SINGER\');\r\nRETURN NEXT hasnt_column(\'artists\', \'years_active\', \'Tabel artists tidak memiliki kolom years_active\');\r\nEND;\r\n$$;\r\nSELECT * FROM runtests(\'public\'::name);', 'Modul 14.pdf', '2022-08-09 07:38:21', NULL),
(15, 'MODIFIKASI TABEL albums', 'ALTER Table', 'my_playlist', 'menambah primary key', 'CREATE TABLE artists (\r\nid serial PRIMARY KEY,\r\nname VARCHAR(50),\r\navatar varchar(255),\r\nborn date,\r\noccupation varchar(255),\r\nyears_active varchar(50)\r\n);\r\nCREATE TABLE albums ( \r\nid serial PRIMARY KEY, \r\nartist_id integer, \r\nname VARCHAR(50) NOT NULL,\r\ncover VARCHAR(255) NULL,\r\nreleased date NOT NULL, \r\nlabel varchar(255) NOT NULL\r\n);', 'CREATE EXTENSION IF NOT EXISTS pgtap; CREATE OR REPLACE FUNCTION public.testschema()\r\nRETURNS SETOF TEXT LANGUAGE plpgsql AS $$\r\nBEGIN\r\nRETURN NEXT has_table( \'albums\', \'Database my_playlist memiliki tabel albums\');\r\nRETURN NEXT has_column( \'albums\', \'id\', \'Tabel albums memiliki kolom id\');\r\nRETURN NEXT has_column( \'albums\', \'artist_id\', \'Tabel albums memiliki kolom artist_id\');\r\nRETURN NEXT has_column( \'albums\', \'name\', \'Tabel albums memiliki kolom name\');\r\nRETURN NEXT has_column( \'albums\', \'cover\', \'Tabel albums memiliki kolom cover\');\r\nRETURN NEXT has_column( \'albums\', \'released\', \'Tabel albums memiliki kolom released\');\r\nRETURN NEXT has_column( \'albums\', \'label\', \'Tabel albums memiliki kolom id\');\r\nRETURN NEXT col_type_is( \'albums\', \'id\', \'integer\', \'Tipe kolom id adalah INTEGER\');\r\nRETURN NEXT col_type_is( \'albums\', \'artist_id\', \'integer\', \'Tipe kolom artist_id adalah INTEGER\');\r\nRETURN NEXT col_type_is( \'albums\', \'name\', \'character varying(50)\', \'Tipe kolom name adalah VARCHAR(50)\');\r\nRETURN NEXT col_type_is( \'albums\', \'cover\', \'character varying(255)\', \'Tipe kolom cover adalah VARCHAR(255)\');\r\nRETURN NEXT col_type_is( \'albums\', \'released\', \'date\', \'Tipe kolom released adalah date\');\r\nRETURN NEXT col_type_is( \'albums\', \'label\', \'character varying(255)\', \'Tipe kolom label adalah VARCHAR(255)\');\r\nRETURN NEXT col_is_pk( \'albums\', \'id\', \'Kolom id adalah PRIMARY KEY\');\r\nRETURN NEXT col_not_null( \'albums\', \'name\', \'Kolom name adalah NOT NULL\');\r\nRETURN NEXT col_is_null( \'albums\', \'cover\', \'Kolom cover adalah NULL\');\r\nRETURN NEXT col_not_null( \'albums\', \'released\', \'Kolom released adalah NOT NULL\');\r\nRETURN NEXT col_not_null( \'albums\', \'label\', \'Kolom label adalah NOT NULL\');\r\nRETURN NEXT fk_ok( \'albums\', \'artist_id\', \'artists\', \'id\', \'Kolom artists_id adalah FOREIGN KEY\');\r\nEND;\r\n$$;\r\nSELECT * FROM runtests(\'public\'::name);', 'Modul 15.pdf', '2022-08-09 07:39:51', NULL),
(16, 'MODIFIKASI TABEL albums', 'ALTER Table', 'my_playlist', 'menghapus primary key', 'CREATE TABLE artists (\r\nid serial PRIMARY KEY,\r\nname VARCHAR(50),\r\navatar varchar(255),\r\nborn date,\r\noccupation varchar(255),\r\nyears_active varchar(50)\r\n);\r\nCREATE TABLE albums ( \r\nid serial PRIMARY KEY, \r\nartist_id integer, \r\nname VARCHAR(50) NOT NULL,\r\ncover VARCHAR(255) NULL,\r\nreleased date NOT NULL, \r\nlabel varchar(255) NOT NULL,\r\n   CONSTRAINT fk_album_artist\r\n      FOREIGN KEY(artist_id) \r\n	  REFERENCES artists(id)\r\n);', 'CREATE EXTENSION IF NOT EXISTS pgtap; CREATE OR REPLACE FUNCTION public.testschema()\r\nRETURNS SETOF TEXT LANGUAGE plpgsql AS $$\r\nBEGIN\r\nRETURN NEXT has_table( \'albums\', \'Database my_playlist memiliki tabel albums\');\r\nRETURN NEXT has_column( \'albums\', \'id\', \'Tabel albums memiliki kolom id\');\r\nRETURN NEXT has_column( \'albums\', \'artist_id\', \'Tabel albums memiliki kolom artist_id\');\r\nRETURN NEXT has_column( \'albums\', \'name\', \'Tabel albums memiliki kolom name\');\r\nRETURN NEXT has_column( \'albums\', \'cover\', \'Tabel albums memiliki kolom cover\');\r\nRETURN NEXT has_column( \'albums\', \'released\', \'Tabel albums memiliki kolom released\');\r\nRETURN NEXT has_column( \'albums\', \'label\', \'Tabel albums memiliki kolom label\');\r\nRETURN NEXT col_type_is( \'albums\', \'id\', \'integer\', \'Tipe kolom id adalah INTEGER\');\r\nRETURN NEXT col_type_is( \'albums\', \'artist_id\', \'integer\', \'Tipe kolom artist_id adalah INTEGER\');\r\nRETURN NEXT col_type_is( \'albums\', \'name\', \'character varying(50)\', \'Tipe kolom name adalah VARCHAR(50)\');\r\nRETURN NEXT col_type_is( \'albums\', \'cover\', \'character varying(255)\', \'Tipe kolom cover adalah VARCHAR(255)\');\r\nRETURN NEXT col_type_is( \'albums\', \'released\', \'date\', \'Tipe kolom released adalah date\');\r\nRETURN NEXT col_type_is( \'albums\', \'label\', \'character varying(255)\', \'Tipe kolom label adalah VARCHAR(255)\');\r\nRETURN NEXT col_is_pk( \'albums\', \'id\', \'Kolom id adalah PRIMARY KEY\');\r\nRETURN NEXT col_not_null( \'albums\', \'name\', \'Kolom name adalah NOT NULL\');\r\nRETURN NEXT col_is_null( \'albums\', \'cover\', \'Kolom cover adalah NULL\');\r\nRETURN NEXT col_not_null( \'albums\', \'released\', \'Kolom released adalah NOT NULL\');\r\nRETURN NEXT col_not_null( \'albums\', \'label\', \'Kolom label adalah NOT NULL\');\r\nRETURN NEXT hasnt_fk( \'albums\', \'Tabel albums tidak memiliki FOREIGN KEY\');\r\nEND;\r\n$$;\r\nSELECT * FROM runtests(\'public\'::name);', 'Modul 16.pdf', '2022-08-09 07:40:55', NULL),
(17, 'MENGHAPUS TABEL playlists', 'DROP Table', 'my_playlist', 'menambah not null', 'CREATE Table playlists(\r\nid serial primary key,\r\nplaylist_name varchar(50)\r\n);', 'CREATE EXTENSION IF NOT EXISTS pgtap;\r\nCREATE OR REPLACE FUNCTION public.testschema()\r\nRETURNS SETOF TEXT LANGUAGE plpgsql AS $$\r\nBEGIN\r\nRETURN NEXT hasnt_table( \'playlists\', \'Database my_playlists tidak memiliki tabel playlists\');\r\nEND;\r\n$$;\r\nSELECT * FROM runtests(\'public\'::name);', 'Modul 17.pdf', '2022-08-09 07:42:13', NULL),
(18, 'MENGHAPUS DATABASE my_playlist', 'DROP Database', 'my_playlist', 'menghapus not null', NULL, NULL, 'Modul 18.pdf', '2022-08-09 07:43:08', NULL),
(19, 'menambah default', 'menambah default', 'menambah default', 'menambah default', NULL, NULL, 'Modul 19.pdf', NULL, NULL),
(20, 'mengganti nilai default', 'mengganti nilai default', 'mengganti nilai default', 'mengganti nilai default', NULL, NULL, 'Modul 20.pdf', NULL, NULL),
(21, 'menghapus default', 'menghapus default', 'menghapus default', 'menghapus default', NULL, NULL, 'Modul 21.pdf', NULL, NULL),
(22, 'menambah unique', 'menambah unique', 'menambah unique', 'menambah unique', NULL, NULL, 'Modul 22.pdf', NULL, NULL),
(23, 'menghapus unique', 'menghapus unique', 'menghapus unique', 'menghapus unique', NULL, NULL, 'Modul 23.pdf', NULL, NULL),
(24, 'menambah check', 'menambah check', 'menambah check', 'menambah check', NULL, NULL, 'Modul 24.pdf', NULL, NULL),
(25, 'mengganti check', 'mengganti check', 'mengganti check', 'mengganti check', NULL, NULL, 'Modul 25.pdf', NULL, NULL),
(26, 'menghapus check', 'menghapus check', 'menghapus check', 'menghapus check', NULL, NULL, NULL, NULL, NULL),
(27, 'menambah fk', 'menambah fk', 'menambah fk', 'menambah fk', NULL, NULL, NULL, NULL, NULL),
(28, 'menghapus fk', 'menghapus fk', 'menghapus fk', 'menghapus fk', NULL, NULL, NULL, NULL, NULL),
(29, 'drop table', 'drop table', 'drop table', 'drop table', NULL, NULL, NULL, NULL, NULL),
(30, 'drop database', 'drop database', 'drop database', 'drop database', NULL, NULL, NULL, NULL, NULL),
(31, 'asdfasdfasdf', 'CREATE Database', 'Nadine Brooks', 'Consequatur accusan', 'Corrupti cillum hic', 'Dolores eligendi min', 'Modul 1.pdf', NULL, '2022-08-28 15:13:53'),
(32, 'Provident vel rerum', 'DROP Table', 'Kerry Wiggins', 'In tempore et conse', 'Inventore maiores de', 'Quia dolore obcaecat', 'Modul 1.pdf', NULL, NULL),
(33, 'Est eveniet sequi p', 'DROP Table', 'Ira Robertson', 'Voluptas cupiditate', 'Occaecat mollitia se', 'Tempora voluptatem v', 'Modul 2.pdf', NULL, NULL),
(34, 'Excepturi iste quibu', 'DROP Table', 'Jennifer Branch', 'Ut est sint repreh', 'Explicabo Ut dolore', 'Perferendis alias fu', 'Modul 1.pdf', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `exercise`
--

CREATE TABLE `exercise` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `academic_year_id` bigint(20) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `exercise`
--

INSERT INTO `exercise` (`id`, `academic_year_id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 1, 'Latihan 1', 'Latihan 1 2021/2022', '2022-11-27 07:31:50', '2022-12-02 19:17:28'),
(2, 1, 'Latihan 2', 'Latihan 1 2021/2022', '2022-11-27 17:29:39', '2022-12-02 19:17:01'),
(3, 1, 'Latihan Dummy', 'Percobaan fitur', '2022-12-05 05:11:43', '2022-12-05 05:11:43');

-- --------------------------------------------------------

--
-- Table structure for table `exercise_question`
--

CREATE TABLE `exercise_question` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `exercise_id` bigint(20) UNSIGNED DEFAULT NULL,
  `question_id` bigint(20) UNSIGNED DEFAULT NULL,
  `no` int(11) NOT NULL,
  `isRemoved` tinyint(2) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `exercise_question`
--

INSERT INTO `exercise_question` (`id`, `exercise_id`, `question_id`, `no`, `isRemoved`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 1, 1, 1, 0, NULL, NULL, NULL),
(3, 1, 2, 2, 0, NULL, NULL, NULL),
(4, 1, 3, 3, 0, NULL, NULL, NULL),
(5, 1, 4, 4, 0, NULL, NULL, NULL),
(6, 1, 5, 5, 0, NULL, NULL, NULL),
(7, 2, 6, 1, 0, NULL, NULL, NULL),
(8, 2, 7, 2, 0, NULL, NULL, NULL),
(9, 2, 8, 3, 0, NULL, NULL, NULL),
(10, 2, 9, 6, 0, NULL, NULL, NULL),
(11, 2, 10, 7, 0, NULL, NULL, NULL),
(12, 2, 11, 8, 0, NULL, NULL, NULL),
(13, 1, 12, 6, 0, NULL, NULL, NULL),
(14, 1, 13, 7, 0, NULL, NULL, NULL),
(15, 1, 14, 8, 0, NULL, NULL, NULL),
(16, 1, 15, 9, 0, NULL, NULL, NULL),
(17, 1, 16, 10, 0, NULL, NULL, NULL),
(18, 1, 17, 11, 0, NULL, NULL, NULL),
(19, 1, 18, 12, 0, NULL, NULL, NULL),
(20, 1, 19, 13, 0, NULL, NULL, NULL),
(21, 1, 20, 14, 0, NULL, NULL, NULL),
(22, 1, 21, 15, 0, NULL, NULL, NULL),
(23, 2, 22, 4, 0, NULL, NULL, NULL),
(24, 2, 23, 5, 0, NULL, NULL, NULL),
(25, 2, 24, 6, 0, NULL, NULL, NULL),
(26, 2, 25, 7, 0, NULL, NULL, NULL),
(27, 2, 26, 8, 0, NULL, NULL, NULL),
(28, 2, 27, 9, 0, NULL, NULL, NULL),
(29, 2, 28, 10, 0, NULL, NULL, NULL),
(30, 2, 29, 11, 0, NULL, NULL, NULL),
(31, 2, 30, 12, 0, NULL, NULL, NULL),
(32, 1, 30, 20, 0, '2022-10-17 19:05:16', '2022-10-18 13:26:27', '2022-10-18 13:26:27'),
(33, 1, 32, 20, 0, '2022-10-18 13:27:07', '2022-10-18 13:27:07', NULL),
(34, 1, 32, 21, 0, '2022-10-18 13:31:23', '2022-10-18 13:31:27', '2022-10-18 13:31:27');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE `question` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `topic` varchar(255) DEFAULT NULL,
  `dbname` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `required_table` text DEFAULT NULL,
  `test_code` text DEFAULT NULL,
  `guide` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `question`
--

INSERT INTO `question` (`id`, `title`, `topic`, `dbname`, `description`, `required_table`, `test_code`, `guide`, `created_at`, `updated_at`) VALUES
(1, 'MEMBUAT DATABASE my_playlist', 'CREATE Database', 'my_playlist', 'membuat database', NULL, '#Tidak ada', 'Modul 1.pdf', NULL, '2022-10-12 18:01:20'),
(2, 'MEMBUAT TABLE playlists', 'CREATE Table', 'my_playlist', 'tipe data', NULL, 'CREATE EXTENSION IF NOT EXISTS pgtap;\r\nCREATE OR REPLACE FUNCTION public.testschema()\r\nRETURNS SETOF TEXT LANGUAGE plpgsql AS $$\r\nBEGIN\r\nRETURN NEXT has_table( \'playlists\', \'TABEL playlists\');\r\nRETURN NEXT has_column( \'playlists\', \'id\', \'KOLOM id\');\r\nRETURN NEXT has_column( \'playlists\', \'playlist_name\', \'KOLOM playlist_name\');\r\nRETURN NEXT col_type_is( \'playlists\', \'id\', \'integer\', \'TIPE KOLOM id\');\r\nRETURN NEXT col_type_is( \'playlists\', \'playlist_name\', \'character varying(50)\', \'TIPE KOLOM playlist_name\');\r\nEND;\r\n$$;\r\nSELECT * FROM runtests(\'public\'::name) OFFSET 1 LIMIT 5;', 'Modul 2.pdf', NULL, NULL),
(3, 'MEMBUAT TABEL artists', 'CREATE Table', 'my_playlist', 'primary key', NULL, 'CREATE EXTENSION IF NOT EXISTS pgtap;\nCREATE OR REPLACE FUNCTION public.testschema()\nRETURNS SETOF TEXT LANGUAGE plpgsql AS $$\nBEGIN\nRETURN NEXT has_table( \'artists\', \'TABEL artists\');\nRETURN NEXT has_column( \'artists\', \'id\', \'KOLOM id\');\nRETURN NEXT has_column( \'artists\', \'name\', \'KOLOM name\');\nRETURN NEXT col_type_is( \'artists\', \'id\', \'integer\', \'TIPE KOLOM id\');\nRETURN NEXT col_type_is( \'artists\', \'name\', \'character varying(50)\', \'TIPE KOLOM name\');\nRETURN NEXT col_is_pk( \'artists\', \'id\', \'KOLOM id PRIMARY KEY\');\nEND;\n$$;\nSELECT * FROM runtests(\'public\'::name)\nOFFSET 1 LIMIT 6;', 'Modul 3.pdf', '2022-08-08 01:28:57', '2022-09-08 23:19:13'),
(4, 'MEMBUAT TABEL albums', 'CREATE Table', 'my_playlist', 'null dan not null', NULL, 'CREATE EXTENSION IF NOT EXISTS pgtap; CREATE OR REPLACE FUNCTION public.testschema()\r\nRETURNS SETOF TEXT LANGUAGE plpgsql AS $$\r\nBEGIN\r\nRETURN NEXT has_table( \'users\', \'TABEL users\');\r\nRETURN NEXT has_column( \'users\', \'id\', \'KOLOM id\');\r\nRETURN NEXT has_column( \'users\', \'name\', \'KOLOM name\');\r\nRETURN NEXT has_column( \'users\', \'email\', \'KOLOM email\');\r\nRETURN NEXT has_column( \'users\', \'password\', \'KOLOM password\');\r\nRETURN NEXT col_type_is( \'users\', \'id\', \'integer\', \'TIPE KOLOM id\');\r\nRETURN NEXT col_type_is( \'users\', \'name\', \'character varying(50)\', \'TIPE KOLOM name\');\r\nRETURN NEXT col_type_is( \'users\', \'email\', \'character varying(50)\', \'TIPE KOLOM email\');\r\nRETURN NEXT col_not_null( \'users\', \'name\', \'KOLOM name NOT NULL\');\r\nRETURN NEXT col_not_null( \'users\', \'email\', \'KOLOM email adalah NOT NULL\');\r\nRETURN NEXT col_not_null( \'users\', \'password\', \'KOLOM password NOT NULL\');\r\nRETURN NEXT col_is_unique( \'users\', \'email\', \'KONLOM email UNIQUE\');\r\nRETURN NEXT col_is_pk( \'users\', \'id\', \'KOLOM id PRIMARY KEY\');\r\nEND;\r\n$$;\r\nSELECT * FROM runtests(\'public\'::name)\r\nOFFSET 1 LIMIT 13;', 'Modul 4.pdf', '2022-08-08 02:58:40', NULL),
(5, 'MEMBUAT TABEL playlists', 'CREATE Table', 'my_playlist', 'default', NULL, 'CREATE EXTENSION IF NOT EXISTS pgtap;\r\nCREATE OR REPLACE FUNCTION public.testschema()\r\nRETURNS SETOF TEXT LANGUAGE plpgsql AS $$\r\nBEGIN\r\nRETURN NEXT has_table( \'playlists\', \'TABEL playlists\');\r\nRETURN NEXT has_column( \'playlists\', \'id\', \'KOLOM id\');\r\nRETURN NEXT has_column( \'playlists\', \'playlist_name\', \'KOLOM name\');\r\nRETURN NEXT col_type_is( \'playlists\', \'id\', \'integer\', \'TIPE KOLOM id\');\r\nRETURN NEXT col_type_is( \'playlists\', \'playlist_name\', \'character varying(50)\', \'TIPE KOLOM playlist_name\');\r\nRETURN NEXT col_has_default( \'playlists\', \'playlist_name\', \'KOLOM playlist_name DEFAULT\');\r\nRETURN NEXT col_default_is( \'playlists\', \'playlist_name\', \'favourite\',\'NILAI DEFAULT KOLOM playlist_name\');\r\nRETURN NEXT col_is_pk( \'playlists\', \'id\', \'KOLOM id PRIMARY KEY\');\r\nEND;\r\n$$;\r\nSELECT * FROM runtests(\'public\'::name) OFFSET 1 LIMIT 8;', 'Modul 5.pdf', '2022-08-09 00:27:49', NULL),
(6, 'MEMBUAT TABEL songs', 'CREATE Table', 'my_playlist', 'unique', NULL, 'CREATE EXTENSION IF NOT EXISTS pgtap;\r\nCREATE OR REPLACE FUNCTION public.testschema()\r\nRETURNS SETOF TEXT LANGUAGE plpgsql AS $$\r\nBEGIN\r\nRETURN NEXT has_table( \'users\', \'TABEL users\');\r\nRETURN NEXT has_column( \'users\', \'id\', \'KOLOM id\');\r\nRETURN NEXT has_column( \'users\', \'name\', \'KOLOM name\');\r\nRETURN NEXT has_column( \'users\', \'email\', \'KOLOM email\');\r\nRETURN NEXT col_type_is( \'users\', \'id\', \'integer\', \'TIPE KOLOM id\');\r\nRETURN NEXT col_type_is( \'users\', \'name\', \'character varying(50)\', \'TIPE KOLOM name\');\r\nRETURN NEXT col_type_is( \'users\', \'email\', \'character varying(50)\', \'TIPE KOLOM email\');\r\nRETURN NEXT col_not_null( \'users\', \'name\', \'KOLOM name NOT NULL\');\r\nRETURN NEXT col_is_unique( \'users\', \'email\', \'KOLOM email UNIQUE\');\r\nRETURN NEXT col_is_pk( \'users\', \'id\', \'KOLOM id PRIMARY KEY\');\r\nEND;\r\n$$;\r\nSELECT * FROM runtests(\'public\'::name)\r\nOFFSET 1 LIMIT 10;', 'Modul 6.pdf', '2022-08-09 00:28:54', NULL),
(7, 'MODIFIKASI TABEL users', 'CREATE Table', 'my_playlist', 'check', 'CREATE TABLE users (\r\nid serial PRIMARY KEY,\r\nname VARCHAR(50) NOT NULL,\r\nemail VARCHAR(50)UNIQUE NOT NULL,\r\npassword VARCHAR (255) NOT NULL,\r\navatar VARCHAR (255) NOT NULL,\r\nis_admin BOOLEAN DEFAULT FALSE\r\n);', 'CREATE EXTENSION IF NOT EXISTS pgtap; CREATE OR REPLACE FUNCTION public.testschema()\r\nRETURNS SETOF TEXT LANGUAGE plpgsql AS $$\r\nBEGIN\r\nRETURN NEXT has_table( \'users\', \'Database my_playlist memiliki tabel users\');\r\nRETURN NEXT has_column( \'users\', \'id\', \'Tabel users memiliki kolom id\');\r\nRETURN NEXT has_column( \'users\', \'name\', \'Tabel users memiliki kolom name\');\r\nRETURN NEXT has_column( \'users\', \'email\', \'Tabel users memiliki kolom email\');\r\nRETURN NEXT has_column( \'users\', \'password\', \'Tabel users memiliki kolom password\');\r\nRETURN NEXT has_column( \'users\', \'is_admin\', \'Tabel users memiliki kolom is_admin\');\r\nRETURN NEXT has_column( \'users\', \'picture\', \'Tabel users memiliki kolom picture\');\r\nRETURN NEXT col_type_is( \'users\', \'id\', \'integer\', \'Tipe kolom id adalah INTEGER\');\r\nRETURN NEXT col_type_is( \'users\', \'name\', \'character varying(50)\', \'Tipe kolom name adalah VARCHAR(50)\');\r\nRETURN NEXT col_type_is( \'users\', \'email\', \'character varying(50)\', \'Tipe kolom email adalah VARCHAR(50)\');\r\nRETURN NEXT col_type_is( \'users\', \'password\', \'character varying(255)\', \'Tipe kolom password adalah VARCHAR(255)\');\r\nRETURN NEXT col_type_is( \'users\', \'picture\', \'character varying(255)\', \'Tipe kolom picture adalah VARCHAR(255)\');\r\nRETURN NEXT col_not_null( \'users\', \'name\', \'Kolom name adalah NOT NULL\');\r\nRETURN NEXT col_not_null( \'users\', \'email\', \'Kolom email adalah NOT NULL\');\r\nRETURN NEXT col_not_null( \'users\', \'password\', \'Kolom password NOT NULL\');\r\nRETURN NEXT col_not_null( \'users\', \'picture\', \'Kolom picture NOT NULL\');\r\nRETURN NEXT col_is_unique( \'users\', \'email\', \'Kolom email UNIQUE\');\r\nRETURN NEXT col_has_default( \'users\', \'is_admin\', \'Kolom is_admin DEFAULT\');\r\nRETURN NEXT col_default_is( \'users\', \'is_admin\', FALSE ,\'Nilai DEFAULT kolom is_admin adalah FALSE\');\r\nRETURN NEXT col_is_pk( \'users\', \'id\', \'Kolom id adalah PRIMARY KEY\');\r\nEND;\r\n$$;\r\nSELECT * FROM runtests(\'public\'::name);', 'Master.pdf', '2022-08-09 00:30:08', NULL),
(8, 'MODIFIKASI TABEL artists', 'ALTER Table', 'my_playlist', 'foreign key', 'CREATE TABLE artists (\r\nid serial PRIMARY KEY,\r\nname VARCHAR(50),\r\navatar varchar(255),\r\nborn date,\r\noccupation varchar(255),\r\nyears_active varchar(50)\r\n);', 'CREATE EXTENSION IF NOT EXISTS pgtap;\r\nCREATE OR REPLACE FUNCTION public.testschema()\r\nRETURNS SETOF TEXT LANGUAGE plpgsql AS $$\r\nBEGIN\r\nRETURN NEXT has_table( \'artists\', \'Database my_playlist memiliki tabel artists\');\r\nRETURN NEXT has_column( \'artists\', \'id\', \'Tabel artists memiliki kolom id\');\r\nRETURN NEXT has_column( \'artists\', \'name\', \'Tabel artists memiliki kolom name\');\r\nRETURN NEXT has_column( \'artists\', \'picture\', \'Tabel artists memiliki kolom picture\');\r\nRETURN NEXT has_column( \'artists\', \'born\', \'Tabel artists memiliki kolom born\');\r\nRETURN NEXT has_column( \'artists\', \'occupation\', \'Tabel artists memiliki kolom occupation\');\r\nRETURN NEXT has_column( \'artists\', \'years_active\', \'Tabel artists memiliki kolom years_active\');\r\nRETURN NEXT col_type_is( \'artists\', \'id\', \'integer\', \'Tipe kolom id adalah INTEGER\');\r\nRETURN NEXT col_type_is( \'artists\', \'name\', \'character varying(50)\', \'Tipe kolom name adalah VARCHAR(50)\');\r\nRETURN NEXT col_type_is( \'artists\', \'picture\', \'character varying(255)\', \'Tipe kolom picture adalah VARCHAR(255)\');\r\nRETURN NEXT col_type_is( \'artists\', \'born\', \'date\', \'Tipe kolom born adalah DATE\');\r\nRETURN NEXT col_type_is( \'artists\', \'occupation\', \'character varying(255)\', \'Tipe kolom occupation adalah VARCHAR(255)\');\r\nRETURN NEXT col_type_is( \'artists\', \'years_active\', \'character varying(50)\', \'Tipe kolom years_active adalah VARCHAR(50)\');\r\nRETURN NEXT col_is_pk( \'artists\', \'id\', \'Kolom id adalah PRIMARY KEY\');\r\nEND;\r\n$$;\r\nSELECT * FROM runtests(\'public\'::name);', NULL, '2022-08-09 00:31:06', NULL),
(9, 'MODIFIKASI TABEL users', 'ALTER Table', 'my_playlist', 'rename table', 'CREATE TABLE users ( \r\nid serial PRIMARY KEY, \r\nname VARCHAR(50) NOT NULL, \r\nemail VARCHAR(50)UNIQUE NOT NULL, \r\npassword VARCHAR(255) NOT NULL, \r\npicture VARCHAR(255) DEFAULT \'profile.jpg\',\r\nis_admin BOOLEAN DEFAULT FALSE\r\n);', 'CREATE EXTENSION IF NOT EXISTS pgtap; CREATE OR REPLACE FUNCTION public.testschema()\r\nRETURNS SETOF TEXT LANGUAGE plpgsql AS $$\r\nBEGIN\r\nRETURN NEXT has_table( \'users\', \'Database my_playlist memiliki tabel users\');\r\nRETURN NEXT has_column( \'users\', \'id\', \'Tabel users memiliki kolom id\');\r\nRETURN NEXT has_column( \'users\', \'name\', \'Tabel users memiliki kolom name\');\r\nRETURN NEXT has_column( \'users\', \'email\', \'Tabel users memiliki kolom email\');\r\nRETURN NEXT has_column( \'users\', \'password\', \'Tabel users memiliki kolom password\');\r\nRETURN NEXT has_column( \'users\', \'picture\', \'Tabel users memiliki kolom picture\');\r\nRETURN NEXT has_column( \'users\', \'is_admin\', \'Tabel users memiliki kolom is_admin\');\r\nRETURN NEXT col_type_is( \'users\', \'id\', \'integer\', \'Tipe kolom id adalah INTEGER\');\r\nRETURN NEXT col_type_is( \'users\', \'name\', \'character varying(50)\', \'Tipe kolom name adalah VARCHAR(50)\');\r\nRETURN NEXT col_type_is( \'users\', \'email\', \'character varying(255)\', \'Tipe kolom email adalah VARCHAR(255)\');\r\nRETURN NEXT col_type_is( \'users\', \'password\', \'character varying(255)\', \'Tipe kolom password adalah VARCHAR(255)\');\r\nRETURN NEXT col_type_is( \'users\', \'picture\', \'character varying(255)\', \'Tipe kolom picture adalah VARCHAR(255)\');\r\nRETURN NEXT col_not_null( \'users\', \'name\', \'Kolom name adalah NOT NULL\');\r\nRETURN NEXT col_not_null( \'users\', \'email\', \'Kolom email adalah NOT NULL\');\r\nRETURN NEXT col_not_null( \'users\', \'password\', \'Kolom password NOT NULL\');\r\nRETURN NEXT col_is_unique( \'users\', \'email\', \'Kolom email UNIQUE\');\r\nRETURN NEXT col_has_default( \'users\', \'is_admin\', \'Kolom is_admin DEFAULT\');\r\nRETURN NEXT col_default_is( \'users\', \'is_admin\', FALSE ,\'Nilai DEFAULT kolom is_admin adalah FALSE\');\r\nRETURN NEXT col_is_pk( \'users\', \'id\', \'Kolom id adalah PRIMARY KEY\');\r\nEND;\r\n$$;\r\nSELECT * FROM runtests(\'public\'::name);', 'Modul 9.pdf', '2022-08-09 00:31:42', NULL),
(10, 'MODIFIKASI TABEL artists', 'ALTER Table', 'my_playlist', 'rename kolom', 'CREATE TABLE artists (\r\nid serial PRIMARY KEY,\r\nname VARCHAR(50),\r\npicture varchar(255),\r\nborn date,\r\noccupation varchar(255),\r\nyears_active varchar(50)\r\n);', 'CREATE EXTENSION IF NOT EXISTS pgtap;\r\nCREATE OR REPLACE FUNCTION public.testschema()\r\nRETURNS SETOF TEXT LANGUAGE plpgsql AS $$\r\nBEGIN\r\nRETURN NEXT has_table( \'artists\', \'Database my_playlist memiliki tabel artists\');\r\nRETURN NEXT has_column( \'artists\', \'id\', \'Tabel artists memiliki kolom id\');\r\nRETURN NEXT has_column( \'artists\', \'name\', \'Tabel artists memiliki kolom name\');\r\nRETURN NEXT has_column( \'artists\', \'picture\', \'Tabel artists memiliki kolom picture\');\r\nRETURN NEXT has_column( \'artists\', \'born\', \'Tabel artists memiliki kolom born\');\r\nRETURN NEXT has_column( \'artists\', \'occupation\', \'Tabel artists memiliki kolom occupation\');\r\nRETURN NEXT has_column( \'artists\', \'years_active\', \'Tabel artists memiliki kolom years_active\');\r\nRETURN NEXT col_type_is( \'artists\', \'id\', \'integer\', \'Tipe kolom id adalah INTEGER\');\r\nRETURN NEXT col_type_is( \'artists\', \'name\', \'character varying(50)\', \'Tipe kolom name adalah VARCHAR(50)\');\r\nRETURN NEXT col_type_is( \'artists\', \'picture\', \'character varying(255)\', \'Tipe kolom picture adalah VARCHAR(255)\');\r\nRETURN NEXT col_type_is( \'artists\', \'born\', \'date\', \'Tipe kolom born adalah DATE\');\r\nRETURN NEXT col_type_is( \'artists\', \'occupation\', \'character varying(255)\', \'Tipe kolom occupationadalah VARCHAR(255)\');\r\nRETURN NEXT col_type_is( \'artists\', \'years_active\', \'character varying(50)\', \'Tipe kolom years_activeadalah VARCHAR(50)\');\r\nRETURN NEXT col_not_null( \'artists\', \'name\', \'Kolom name NOT NULL\');\r\nRETURN NEXT col_is_pk( \'artists\', \'id\', \'Kolom id adalah PRIMARY KEY\');\r\nEND;\r\n$$;\r\nSELECT * FROM runtests(\'public\'::name);', 'Modul 10.pdf', '2022-08-09 00:32:32', NULL),
(11, 'MODIFIKASI TABEL users', 'ALTER Table', 'my_playlist', 'tambah kolom', 'CREATE TABLE users (\r\nid serial PRIMARY KEY,\r\nname VARCHAR(50) NOT NULL,\r\nemail VARCHAR(50)UNIQUE NOT NULL,\r\npassword VARCHAR (255) NOT NULL,\r\npicture VARCHAR(255) NOT NULL,\r\nis_admin BOOLEAN DEFAULT FALSE\r\n);', 'CREATE EXTENSION IF NOT EXISTS pgtap; CREATE OR REPLACE FUNCTION public.testschema()\r\nRETURNS SETOF TEXT LANGUAGE plpgsql AS $$\r\nBEGIN\r\nRETURN NEXT has_table( \'users\', \'Database my_playlist memiliki tabel users\');\r\nRETURN NEXT has_column( \'users\', \'id\', \'Tabel users memiliki kolom id\');\r\nRETURN NEXT has_column( \'users\', \'name\', \'Tabel users memiliki kolom name\');\r\nRETURN NEXT has_column( \'users\', \'email\', \'Tabel users memiliki kolom email\');\r\nRETURN NEXT has_column( \'users\', \'password\', \'Tabel users memiliki kolom password\');\r\nRETURN NEXT has_column( \'users\', \'is_admin\', \'Tabel users memiliki kolom is_admin\');\r\nRETURN NEXT has_column( \'users\', \'picture\', \'Tabel users memiliki kolom picture\');\r\nRETURN NEXT col_type_is( \'users\', \'id\', \'integer\', \'Tipe kolom id adalah INTEGER\');\r\nRETURN NEXT col_type_is( \'users\', \'name\', \'character varying(50)\', \'Tipe kolom name adalah VARCHAR(50)\');\r\nRETURN NEXT col_type_is( \'users\', \'email\', \'character varying(50)\', \'Tipe kolom email adalah VARCHAR(50)\');\r\nRETURN NEXT col_type_is( \'users\', \'password\', \'character varying(255)\', \'Tipe kolom password adalah VARCHAR(255)\');\r\nRETURN NEXT col_type_is( \'users\', \'picture\', \'character varying(255)\', \'Tipe kolom picture adalah VARCHAR(255)\');\r\nRETURN NEXT col_type_is( \'users\', \'is_admin\', \'boolean\', \'Tipe kolom is_admin adalah boolean\');\r\nRETURN NEXT col_not_null( \'users\', \'name\', \'Kolom name adalah NOT NULL\');\r\nRETURN NEXT col_not_null( \'users\', \'email\', \'Kolom email adalah NOT NULL\');\r\nRETURN NEXT col_not_null( \'users\', \'password\', \'Kolom password NOT NULL\');\r\nRETURN NEXT col_is_null( \'users\', \'picture\', \'Kolom picture NULL\');\r\nRETURN NEXT col_is_unique( \'users\', \'email\', \'Kolom email UNIQUE\');\r\nRETURN NEXT col_has_default( \'users\', \'is_admin\', \'Kolom is_admin DEFAULT\');\r\nRETURN NEXT col_default_is( \'users\', \'is_admin\', FALSE ,\'Nilai DEFAULT kolom is_admin adalah FALSE\');\r\nRETURN NEXT col_is_pk( \'users\', \'id\', \'Kolom id adalah PRIMARY KEY\');\r\nEND;\r\n$$;\r\nSELECT * FROM runtests(\'public\'::name);', 'Modul 11.pdf', '2022-08-09 00:33:25', NULL),
(12, 'MODIFIKASI TABEL artists', 'ALTER Table', 'my_playlist', 'drop kolom', 'CREATE TABLE artists (\r\nid serial PRIMARY KEY,\r\nname VARCHAR(50) NOT NULL,\r\npicture varchar(255),\r\nborn date,\r\noccupation varchar(255),\r\nyears_active varchar(50)\r\n);', 'CREATE EXTENSION IF NOT EXISTS pgtap;\r\nCREATE OR REPLACE FUNCTION public.testschema()\r\nRETURNS SETOF TEXT LANGUAGE plpgsql AS $$\r\nBEGIN\r\nRETURN NEXT has_table( \'artists\', \'Database my_playlist memiliki tabel artists\');\r\nRETURN NEXT has_column( \'artists\', \'id\', \'Tabel artists memiliki kolom id\');\r\nRETURN NEXT has_column( \'artists\', \'name\', \'Tabel artists memiliki kolom name\');\r\nRETURN NEXT has_column( \'artists\', \'picture\', \'Tabel artists memiliki kolom picture\');\r\nRETURN NEXT has_column( \'artists\', \'born\', \'Tabel artists memiliki kolom born\');\r\nRETURN NEXT has_column( \'artists\', \'occupation\', \'Tabel artists memiliki kolom occupation\');\r\nRETURN NEXT has_column( \'artists\', \'years_active\', \'Tabel artists memiliki kolom years_active\');\r\nRETURN NEXT col_type_is( \'artists\', \'id\', \'integer\', \'Tipe kolom id adalah INTEGER\');\r\nRETURN NEXT col_type_is( \'artists\', \'name\', \'character varying(50)\', \'Tipe kolom name adalah VARCHAR(50)\');\r\nRETURN NEXT col_type_is( \'artists\', \'picture\', \'character varying(255)\', \'Tipe kolom picture adalah VARCHAR(255)\');\r\nRETURN NEXT col_type_is( \'artists\', \'born\', \'date\', \'Tipe kolom date adalah DATE\');\r\nRETURN NEXT col_type_is( \'artists\', \'occupation\', \'character varying(255)\', \'Tipe kolom occupation adalah VARCHAR(255)\');\r\nRETURN NEXT col_type_is( \'artists\', \'years_active\', \'character varying(50)\', \'Tipe kolom years_active adalah VARCHAR(50)\');\r\nRETURN NEXT col_has_default( \'artists\', \'occupation\', \'Kolom occupation DEFAULT\');\r\nRETURN NEXT col_default_is( \'artists\', \'occupation\',  \'SINGER\' ,\'Nilai DEFAULT kolom occupation adalah SINGER\');\r\nRETURN NEXT col_is_pk( \'artists\', \'id\', \'Kolom id adalah PRIMARY KEY\');\r\nEND;\r\n$$;\r\nSELECT * FROM runtests(\'public\'::name);', 'Modul 12.pdf', '2022-08-09 00:36:11', NULL),
(13, 'MODIFIKASI TABEL users', 'ALTER Table', 'my_playlist', 'ganti tipe data', 'CREATE TABLE users ( \r\nid serial PRIMARY KEY, \r\nname VARCHAR(50) NOT NULL, \r\nemail VARCHAR(50)UNIQUE NOT NULL, \r\npassword VARCHAR(255) NOT NULL, \r\npicture VARCHAR(255) NULL DEFAULT \'profile.jpg\',\r\nis_admin BOOLEAN DEFAULT FALSE\r\n);', 'CREATE EXTENSION IF NOT EXISTS pgtap; CREATE OR REPLACE FUNCTION public.testschema()\r\nRETURNS SETOF TEXT LANGUAGE plpgsql AS $$\r\nBEGIN\r\nRETURN NEXT has_table( \'users\', \'Database my_playlist memiliki tabel users\');\r\nRETURN NEXT has_column( \'users\', \'id\', \'Tabel users memiliki kolom id\');\r\nRETURN NEXT has_column( \'users\', \'name\', \'Tabel users memiliki kolom name\');\r\nRETURN NEXT has_column( \'users\', \'email\', \'Tabel users memiliki kolom email\');\r\nRETURN NEXT has_column( \'users\', \'password\', \'Tabel users memiliki kolom password\');\r\nRETURN NEXT has_column( \'users\', \'is_admin\', \'Tabel users memiliki kolom is_admin\');\r\nRETURN NEXT has_column( \'users\', \'picture\', \'Tabel users memiliki kolom picture\');\r\nRETURN NEXT col_type_is( \'users\', \'id\', \'integer\', \'Tipe kolom id adalah INTEGER\');\r\nRETURN NEXT col_type_is( \'users\', \'name\', \'character varying(50)\', \'Tipe kolom name adalah VARCHAR(50)\');\r\nRETURN NEXT col_type_is( \'users\', \'email\', \'character varying(50)\', \'Tipe kolom email adalah VARCHAR(50)\');\r\nRETURN NEXT col_type_is( \'users\', \'password\', \'character varying(255)\', \'Tipe kolom password adalah VARCHAR(255)\');\r\nRETURN NEXT col_type_is( \'users\', \'picture\', \'character varying(255)\', \'Tipe kolom picture adalah VARCHAR(255)\');\r\nRETURN NEXT col_type_is( \'users\', \'is_admin\', \'boolean\', \'Tipe kolom is_admin adalah boolean\');\r\nRETURN NEXT col_not_null( \'users\', \'name\', \'Kolom name adalah NOT NULL\');\r\nRETURN NEXT col_not_null( \'users\', \'email\', \'Kolom email adalah NOT NULL\');\r\nRETURN NEXT col_not_null( \'users\', \'password\', \'Kolom password NOT NULL\');\r\nRETURN NEXT col_is_null( \'users\', \'picture\', \'Kolom picture NOT NULL\');\r\nRETURN NEXT col_is_unique( \'users\', \'email\', \'Kolom email UNIQUE\');\r\nRETURN NEXT col_hasnt_default( \'users\', \'is_admin\', \'Kolom picture tidak memiliki nilai DEFAULT\');\r\nRETURN NEXT col_is_pk( \'users\', \'id\', \'Kolom id adalah PRIMARY KEY\');\r\nEND;\r\n$$;\r\nSELECT * FROM runtests(\'public\'::name);', 'Modul 13.pdf', '2022-08-09 00:37:09', NULL),
(14, 'MODIFIKASI TABEL artists', 'ALTER Table', 'my_playlist', 'ganti panjang data', 'CREATE TABLE artists (\r\nid serial PRIMARY KEY,\r\nname VARCHAR(50),\r\npicture varchar(255),\r\nborn date,\r\noccupation varchar(255) DEFAULT \'SINGER\',\r\nyears_active varchar(50)\r\n);', 'CREATE EXTENSION IF NOT EXISTS pgtap;\r\nCREATE OR REPLACE FUNCTION public.testschema()\r\nRETURNS SETOF TEXT LANGUAGE plpgsql AS $$\r\nBEGIN\r\nRETURN NEXT has_table( \'artists\', \'Database my_playlist memiliki tabel artists\');\r\nRETURN NEXT has_column( \'artists\', \'id\', \'Tabel artists memiliki kolom id\');\r\nRETURN NEXT has_column( \'artists\', \'name\', \'Tabel artists memiliki kolom name\');\r\nRETURN NEXT has_column( \'artists\', \'picture\', \'Tabel artists memiliki kolom picture\');\r\nRETURN NEXT has_column( \'artists\', \'born\', \'Tabel artists memiliki kolom born\');\r\nRETURN NEXT has_column( \'artists\', \'occupation\', \'Tabel artists memiliki kolom occupation\');\r\nRETURN NEXT col_type_is( \'artists\', \'id\', \'integer\', \'Tipe kolom id adalah INTEGER\');\r\nRETURN NEXT col_type_is( \'artists\', \'name\', \'character varying(50)\', \'Tipe kolom name adalah VARCHAR(50)\');\r\nRETURN NEXT col_type_is( \'artists\', \'picture\', \'character varying(255)\', \'Tipe kolom picture adalah VARCHAR(255)\');\r\nRETURN NEXT col_type_is( \'artists\', \'born\', \'date\', \'Tipe kolom born adalah DATE\');\r\nRETURN NEXT col_type_is( \'artists\', \'occupation\', \'character varying(255)\', \'Tipe kolom occupation adalah VARCHAR(255)\');\r\nRETURN NEXT col_has_default( \'artists\', \'occupation\', \'Kolom occupation DEFAULT\');\r\nRETURN NEXT col_default_is( \'artists\', \'occupation\', \'SINGER\' ,\'Nilai DEFAULT kolom occupation adalah SINGER\');\r\nRETURN NEXT hasnt_column(\'artists\', \'years_active\', \'Tabel artists tidak memiliki kolom years_active\');\r\nEND;\r\n$$;\r\nSELECT * FROM runtests(\'public\'::name);', 'Modul 14.pdf', '2022-08-09 00:38:21', NULL),
(15, 'MODIFIKASI TABEL albums', 'ALTER Table', 'my_playlist', 'menambah primary key', 'CREATE TABLE artists (\r\nid serial PRIMARY KEY,\r\nname VARCHAR(50),\r\navatar varchar(255),\r\nborn date,\r\noccupation varchar(255),\r\nyears_active varchar(50)\r\n);\r\nCREATE TABLE albums ( \r\nid serial PRIMARY KEY, \r\nartist_id integer, \r\nname VARCHAR(50) NOT NULL,\r\ncover VARCHAR(255) NULL,\r\nreleased date NOT NULL, \r\nlabel varchar(255) NOT NULL\r\n);', 'CREATE EXTENSION IF NOT EXISTS pgtap; CREATE OR REPLACE FUNCTION public.testschema()\r\nRETURNS SETOF TEXT LANGUAGE plpgsql AS $$\r\nBEGIN\r\nRETURN NEXT has_table( \'albums\', \'Database my_playlist memiliki tabel albums\');\r\nRETURN NEXT has_column( \'albums\', \'id\', \'Tabel albums memiliki kolom id\');\r\nRETURN NEXT has_column( \'albums\', \'artist_id\', \'Tabel albums memiliki kolom artist_id\');\r\nRETURN NEXT has_column( \'albums\', \'name\', \'Tabel albums memiliki kolom name\');\r\nRETURN NEXT has_column( \'albums\', \'cover\', \'Tabel albums memiliki kolom cover\');\r\nRETURN NEXT has_column( \'albums\', \'released\', \'Tabel albums memiliki kolom released\');\r\nRETURN NEXT has_column( \'albums\', \'label\', \'Tabel albums memiliki kolom id\');\r\nRETURN NEXT col_type_is( \'albums\', \'id\', \'integer\', \'Tipe kolom id adalah INTEGER\');\r\nRETURN NEXT col_type_is( \'albums\', \'artist_id\', \'integer\', \'Tipe kolom artist_id adalah INTEGER\');\r\nRETURN NEXT col_type_is( \'albums\', \'name\', \'character varying(50)\', \'Tipe kolom name adalah VARCHAR(50)\');\r\nRETURN NEXT col_type_is( \'albums\', \'cover\', \'character varying(255)\', \'Tipe kolom cover adalah VARCHAR(255)\');\r\nRETURN NEXT col_type_is( \'albums\', \'released\', \'date\', \'Tipe kolom released adalah date\');\r\nRETURN NEXT col_type_is( \'albums\', \'label\', \'character varying(255)\', \'Tipe kolom label adalah VARCHAR(255)\');\r\nRETURN NEXT col_is_pk( \'albums\', \'id\', \'Kolom id adalah PRIMARY KEY\');\r\nRETURN NEXT col_not_null( \'albums\', \'name\', \'Kolom name adalah NOT NULL\');\r\nRETURN NEXT col_is_null( \'albums\', \'cover\', \'Kolom cover adalah NULL\');\r\nRETURN NEXT col_not_null( \'albums\', \'released\', \'Kolom released adalah NOT NULL\');\r\nRETURN NEXT col_not_null( \'albums\', \'label\', \'Kolom label adalah NOT NULL\');\r\nRETURN NEXT fk_ok( \'albums\', \'artist_id\', \'artists\', \'id\', \'Kolom artists_id adalah FOREIGN KEY\');\r\nEND;\r\n$$;\r\nSELECT * FROM runtests(\'public\'::name);', 'Modul 15.pdf', '2022-08-09 00:39:51', NULL),
(16, 'MODIFIKASI TABEL albums', 'ALTER Table', 'my_playlist', 'menghapus primary key', 'CREATE TABLE artists (\r\nid serial PRIMARY KEY,\r\nname VARCHAR(50),\r\navatar varchar(255),\r\nborn date,\r\noccupation varchar(255),\r\nyears_active varchar(50)\r\n);\r\nCREATE TABLE albums ( \r\nid serial PRIMARY KEY, \r\nartist_id integer, \r\nname VARCHAR(50) NOT NULL,\r\ncover VARCHAR(255) NULL,\r\nreleased date NOT NULL, \r\nlabel varchar(255) NOT NULL,\r\n   CONSTRAINT fk_album_artist\r\n      FOREIGN KEY(artist_id) \r\n	  REFERENCES artists(id)\r\n);', 'CREATE EXTENSION IF NOT EXISTS pgtap; CREATE OR REPLACE FUNCTION public.testschema()\r\nRETURNS SETOF TEXT LANGUAGE plpgsql AS $$\r\nBEGIN\r\nRETURN NEXT has_table( \'albums\', \'Database my_playlist memiliki tabel albums\');\r\nRETURN NEXT has_column( \'albums\', \'id\', \'Tabel albums memiliki kolom id\');\r\nRETURN NEXT has_column( \'albums\', \'artist_id\', \'Tabel albums memiliki kolom artist_id\');\r\nRETURN NEXT has_column( \'albums\', \'name\', \'Tabel albums memiliki kolom name\');\r\nRETURN NEXT has_column( \'albums\', \'cover\', \'Tabel albums memiliki kolom cover\');\r\nRETURN NEXT has_column( \'albums\', \'released\', \'Tabel albums memiliki kolom released\');\r\nRETURN NEXT has_column( \'albums\', \'label\', \'Tabel albums memiliki kolom label\');\r\nRETURN NEXT col_type_is( \'albums\', \'id\', \'integer\', \'Tipe kolom id adalah INTEGER\');\r\nRETURN NEXT col_type_is( \'albums\', \'artist_id\', \'integer\', \'Tipe kolom artist_id adalah INTEGER\');\r\nRETURN NEXT col_type_is( \'albums\', \'name\', \'character varying(50)\', \'Tipe kolom name adalah VARCHAR(50)\');\r\nRETURN NEXT col_type_is( \'albums\', \'cover\', \'character varying(255)\', \'Tipe kolom cover adalah VARCHAR(255)\');\r\nRETURN NEXT col_type_is( \'albums\', \'released\', \'date\', \'Tipe kolom released adalah date\');\r\nRETURN NEXT col_type_is( \'albums\', \'label\', \'character varying(255)\', \'Tipe kolom label adalah VARCHAR(255)\');\r\nRETURN NEXT col_is_pk( \'albums\', \'id\', \'Kolom id adalah PRIMARY KEY\');\r\nRETURN NEXT col_not_null( \'albums\', \'name\', \'Kolom name adalah NOT NULL\');\r\nRETURN NEXT col_is_null( \'albums\', \'cover\', \'Kolom cover adalah NULL\');\r\nRETURN NEXT col_not_null( \'albums\', \'released\', \'Kolom released adalah NOT NULL\');\r\nRETURN NEXT col_not_null( \'albums\', \'label\', \'Kolom label adalah NOT NULL\');\r\nRETURN NEXT hasnt_fk( \'albums\', \'Tabel albums tidak memiliki FOREIGN KEY\');\r\nEND;\r\n$$;\r\nSELECT * FROM runtests(\'public\'::name);', 'Modul 16.pdf', '2022-08-09 00:40:55', NULL),
(17, 'MENGHAPUS TABEL playlists', 'DROP Table', 'my_playlist', 'menambah not null', 'CREATE Table playlists(\r\nid serial primary key,\r\nplaylist_name varchar(50)\r\n);', 'CREATE EXTENSION IF NOT EXISTS pgtap;\r\nCREATE OR REPLACE FUNCTION public.testschema()\r\nRETURNS SETOF TEXT LANGUAGE plpgsql AS $$\r\nBEGIN\r\nRETURN NEXT hasnt_table( \'playlists\', \'Database my_playlists tidak memiliki tabel playlists\');\r\nEND;\r\n$$;\r\nSELECT * FROM runtests(\'public\'::name);', 'Modul 17.pdf', '2022-08-09 00:42:13', NULL),
(18, 'MENGHAPUS DATABASE my_playlist', 'DROP Database', 'my_playlist', 'menghapus not null', NULL, NULL, 'Modul 18.pdf', '2022-08-09 00:43:08', NULL),
(19, 'menambah default', 'menambah default', 'menambah default', 'menambah default', NULL, NULL, 'Modul 19.pdf', NULL, NULL),
(20, 'mengganti nilai default', 'mengganti nilai default', 'mengganti nilai default', 'mengganti nilai default', NULL, NULL, 'Modul 20.pdf', NULL, NULL),
(21, 'menghapus default', 'menghapus default', 'menghapus default', 'menghapus default', NULL, NULL, 'Modul 21.pdf', NULL, NULL),
(22, 'menambah unique', 'menambah unique', 'menambah unique', 'menambah unique', NULL, NULL, 'Modul 22.pdf', NULL, NULL),
(23, 'menghapus unique', 'menghapus unique', 'menghapus unique', 'menghapus unique', NULL, NULL, 'Modul 23.pdf', NULL, NULL),
(24, 'menambah check', 'menambah check', 'menambah check', 'menambah check', NULL, NULL, 'Modul 24.pdf', NULL, NULL),
(25, 'mengganti check', 'mengganti check', 'mengganti check', 'mengganti check', NULL, NULL, 'Modul 25.pdf', NULL, NULL),
(26, 'menghapus check', 'menghapus check', 'menghapus check', 'menghapus check', NULL, NULL, NULL, NULL, NULL),
(27, 'menambah fk', 'menambah fk', 'menambah fk', 'menambah fk', NULL, NULL, NULL, NULL, NULL),
(28, 'menghapus fk', 'menghapus fk', 'menghapus fk', 'menghapus fk', NULL, NULL, NULL, NULL, NULL),
(29, 'drop table', 'drop table', 'drop table', 'drop table', NULL, NULL, NULL, NULL, NULL),
(30, 'drop database', 'drop database', 'drop database', 'drop database', NULL, NULL, NULL, NULL, NULL),
(31, 'asdfasdfasdf', 'CREATE Database', 'Nadine Brooks', 'Consequatur accusan', 'Corrupti cillum hic', 'Dolores eligendi min', 'Modul 1.pdf', NULL, '2022-08-28 08:13:53'),
(32, 'Provident vel rerum', 'DROP Table', 'Kerry Wiggins', 'In tempore et conse', 'Inventore maiores de', 'Quia dolore obcaecat', 'Modul 1.pdf', NULL, NULL),
(33, 'Est eveniet sequi p', 'DROP Table', 'Ira Robertson', 'Voluptas cupiditate', 'Occaecat mollitia se', 'Tempora voluptatem v', 'Modul 2.pdf', NULL, NULL),
(34, 'Excepturi iste quibu', 'DROP Table', 'Jennifer Branch', 'Ut est sint repreh', 'Explicabo Ut dolore', 'Perferendis alias fu', 'Modul 1.pdf', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` varchar(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 3, 'Aktif', '2022-11-27 01:39:49', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `submissions`
--

CREATE TABLE `submissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED DEFAULT NULL,
  `question_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `solution` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `submissions`
--

INSERT INTO `submissions` (`id`, `student_id`, `question_id`, `status`, `solution`, `created_at`, `updated_at`) VALUES
(1, 3, 5, 'Failed', 'CREATE Table playlists(\r\nid serial primary key,\r\nplaylist_nam varchar(50) default \'favourite\'\r\n);', '2022-12-02 20:11:40', '2022-12-10 19:44:34'),
(2, 4, 5, 'Passed', 'CREATE Table playlists(\r\nid serial primary key,\r\nplaylist_nae varchar(50) default \'favourite\'\r\n);', '2022-12-10 19:06:16', '2022-12-10 19:08:39'),
(3, 5, 5, 'Passed', 'CREATE Table playlists(\r\nid serial primary key,\r\nplaylist_name varchar(50) default \'favourite\'\r\n);', '2022-12-10 19:57:22', '2022-12-10 19:57:22'),
(4, 3, 2, 'Failed', 'CREATE TABLE playlists (\r\nid INT,\r\nplaylissst_name VARCHAR(50)\r\n);', '2022-12-10 20:13:43', '2022-12-10 20:13:47'),
(5, 6, 2, 'Passed', 'CREATE TABLE playlists (\r\nid INT,\r\nplaylist_name VARCHAR(50)\r\n);', '2022-12-10 20:41:07', '2022-12-10 20:41:07'),
(6, 6, 5, 'Passed', 'CREATE Table playlists(\r\nid serial primary key,\r\nplaylist_name varchar(50) default \'favourite\'\r\n)', '2022-12-10 20:42:26', '2022-12-10 20:43:03'),
(7, 8, 2, 'Passed', 'CREATE TABLE playlists (\r\nid INT,\r\nplaylist_name VARCHAR(50)\r\n);', '2022-12-10 21:30:08', '2022-12-10 21:30:08'),
(8, 8, 3, 'Passed', 'CREATE TABLE artists(\r\nid serial PRIMARY KEY,\r\nname varchar(50)\r\n);', '2022-12-10 21:31:25', '2022-12-10 21:31:59'),
(9, 3, 1, 'Failed', 'create database my_playist;', '2022-12-13 05:25:57', '2022-12-13 05:26:00');

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE `teacher` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 'Aktif', '2022-11-26 15:04:50', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@mail.com', 'admin', NULL, '$2y$10$x6Ms9h1/WtZ8u3tPM6zkCuWQU1KtYIsN1dGe1Nf7lDpQ0ec1TV84.', NULL, '2022-11-25 19:56:04', '2022-11-25 19:56:04'),
(2, 'Dwi Puspitasari, SKom, MKom', 'teacher@mail.com', 'teacher', NULL, '$2y$10$MnpYcZ8apcT4HoLpTG2qUOQDEi5k6rkbLrylpYTjkEFrCw7Tpf4A6', NULL, '2022-11-25 19:57:08', '2022-11-25 19:57:08'),
(3, 'Fajar Pandu', 'student@mail.com', 'student', NULL, '$2y$10$TLsfOvFoL1HaKeafqNFh5eW5fLNk8pFR9qGiiZpsjp0tqy.L031f6', NULL, '2022-11-25 19:57:32', '2022-11-25 19:57:32'),
(4, 'John', 'john@mail.com', 'student', NULL, '$2y$10$JcxkfhFJvoaGZXLAz4ip.u51pH.pV.4wHu36P1VxpfPn/YIAbFbrC', NULL, '2022-12-10 18:52:23', '2022-12-10 18:52:23'),
(5, 'Mark', 'mark@mail.com', 'student', NULL, '$2y$10$qetGEeIWqq9z9ae5tdoAsO1jgbH0H9S4mESZ7PW1IYB7eheUuVDye', NULL, '2022-12-10 19:55:43', '2022-12-10 19:55:43'),
(6, 'James', 'james@mail.com', 'student', NULL, '$2y$10$Qx5GcO5KjQqN5F5HjnYBiuAjhEc20kjfUOJOHQraCZZyxYnqWvehu', NULL, '2022-12-10 20:38:57', '2022-12-10 20:38:57'),
(7, 'Liam', 'liam@mail.com', 'student', NULL, '$2y$10$FkaodKdJjx1yDz7IkHB//OMjcJ49OLBv9JrLyQYwUonIDoeov19au', NULL, '2022-12-10 21:03:35', '2022-12-10 21:03:35'),
(8, 'Noah', 'noah@mail.com', 'student', NULL, '$2y$10$emxKcobrIAyHF2XvSMAph.tL45uQSpQFiILGHBf0ytrDabBZ1ShRO', NULL, '2022-12-10 21:27:44', '2022-12-10 21:27:44');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academic_year`
--
ALTER TABLE `academic_year`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`id`),
  ADD KEY `academic_year_id` (`academic_year_id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `class_student`
--
ALTER TABLE `class_student`
  ADD PRIMARY KEY (`id`),
  ADD KEY `class_id` (`class_id`),
  ADD KEY `class_student_ibfk_2` (`student_id`);

--
-- Indexes for table `daftar_soal`
--
ALTER TABLE `daftar_soal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exercise`
--
ALTER TABLE `exercise`
  ADD PRIMARY KEY (`id`),
  ADD KEY `academic_year_id` (`academic_year_id`);

--
-- Indexes for table `exercise_question`
--
ALTER TABLE `exercise_question`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exercise_id` (`exercise_id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `submissions`
--
ALTER TABLE `submissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `academic_year`
--
ALTER TABLE `academic_year`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `class_student`
--
ALTER TABLE `class_student`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `daftar_soal`
--
ALTER TABLE `daftar_soal`
  MODIFY `id` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `exercise`
--
ALTER TABLE `exercise`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `exercise_question`
--
ALTER TABLE `exercise_question`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `submissions`
--
ALTER TABLE `submissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `teacher`
--
ALTER TABLE `teacher`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `class`
--
ALTER TABLE `class`
  ADD CONSTRAINT `class_ibfk_1` FOREIGN KEY (`academic_year_id`) REFERENCES `academic_year` (`id`),
  ADD CONSTRAINT `class_ibfk_2` FOREIGN KEY (`teacher_id`) REFERENCES `teacher` (`id`);

--
-- Constraints for table `class_student`
--
ALTER TABLE `class_student`
  ADD CONSTRAINT `class_student_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `class` (`id`),
  ADD CONSTRAINT `class_student_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `exercise`
--
ALTER TABLE `exercise`
  ADD CONSTRAINT `exercise_ibfk_1` FOREIGN KEY (`academic_year_id`) REFERENCES `academic_year` (`id`);

--
-- Constraints for table `exercise_question`
--
ALTER TABLE `exercise_question`
  ADD CONSTRAINT `exercise_question_ibfk_1` FOREIGN KEY (`exercise_id`) REFERENCES `exercise` (`id`),
  ADD CONSTRAINT `exercise_question_ibfk_2` FOREIGN KEY (`question_id`) REFERENCES `question` (`id`);

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `submissions`
--
ALTER TABLE `submissions`
  ADD CONSTRAINT `submissions_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `submissions_ibfk_2` FOREIGN KEY (`question_id`) REFERENCES `question` (`id`);

--
-- Constraints for table `teacher`
--
ALTER TABLE `teacher`
  ADD CONSTRAINT `teacher_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
