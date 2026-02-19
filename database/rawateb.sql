-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 19 فبراير 2026 الساعة 12:10
-- إصدار الخادم: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rawateb`
--

-- --------------------------------------------------------

--
-- بنية الجدول `absence_reservations`
--

CREATE TABLE `absence_reservations` (
  `absence_reservation_id` int(11) NOT NULL,
  `YEAR` int(11) NOT NULL,
  `MONTH` int(11) NOT NULL,
  `STATUS` tinyint(1) NOT NULL,
  `Type` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `absence_reservation_employees`
--

CREATE TABLE `absence_reservation_employees` (
  `id` int(11) NOT NULL,
  `absence_reservation_id` int(11) DEFAULT NULL,
  `MATRI` varchar(20) DEFAULT NULL,
  `estab_mail_code` varchar(50) DEFAULT NULL,
  `NBR_DAYS` int(11) DEFAULT NULL,
  `DAY_FROM` date DEFAULT NULL,
  `DAY_TO` date DEFAULT NULL,
  `ABSENCE_TYPE` tinyint(1) DEFAULT NULL,
  `ACTIVE` tinyint(1) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `adms`
--

CREATE TABLE `adms` (
  `ADM` varchar(1) NOT NULL,
  `LIBTAB` varchar(30) DEFAULT NULL,
  `LIBTABA` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `adms`
--

INSERT INTO `adms` (`ADM`, `LIBTAB`, `LIBTABA`) VALUES
('0', NULL, 'الكل'),
('1', 'Pers.Ens. PRIMAIRE', 'موظفو التعليم الابتدائي'),
('2', 'Pers.Ens. PRIMAIRE', 'ادارة التعليم الايتدائي'),
('3', 'Pers.Ens ECOLE#FONDAMENTALE', 'اساتذة التعليم المتوسط'),
('4', 'Pers.Admi E.FONDAMENTALE', 'إدارة التعليم المتوسط'),
('5', 'Pers.Ens.LYCEE', 'اساتذة التعليم الثانوي'),
('6', 'PERS.ADMIN.LYCEE', 'ادارة التعليم الثانوي'),
('7', 'Pers.Direction.Education', ' مـــديـريـة التـربيـة'),
('A', 'agent contra moyen', 'اعوان متعاقدين متوسط'),
('B', 'agent contrac lycee', 'اعوان متعاقدين ثانوي'),
('C', 'agent contrac D.E', 'اعوان متعاقدين م التربية'),
('E', 'agent contrac D.E32-12', 'اعوان متعاقدين م التربية '),
('G', 'PRIMAIR SUP FAC', 'مستخلف م شاغر ايتدائي'),
('J', 'PRES.ENS PRIMAIRE SUP', 'متعاقدين ابتدائي عطل مرضية'),
('K', 'Pers.Ens Cem Vac', 'استاد تعليم متوسط مستخلف'),
('L', 'Sup Mat Mal Lycee', 'استاد تعليم ثانوي مستخلف');

-- --------------------------------------------------------

--
-- بنية الجدول `cnasemployees`
--

CREATE TABLE `cnasemployees` (
  `id` int(11) NOT NULL,
  `MATRI` varchar(20) NOT NULL,
  `NOM` varchar(20) DEFAULT NULL,
  `PRENOM` varchar(20) DEFAULT NULL,
  `NOMA` varchar(20) NOT NULL,
  `PRENOMA` varchar(20) NOT NULL,
  `ADM` varchar(1) DEFAULT NULL,
  `DATNAIS` date DEFAULT NULL,
  `DATENT` datetime DEFAULT NULL,
  `NUMSS` varchar(15) DEFAULT NULL,
  `AFFECT` int(11) UNSIGNED DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  `realAFFECT` int(11) DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `CODEFONC` varchar(6) DEFAULT NULL,
  `SITFAM` varchar(3) DEFAULT NULL,
  `CATEG` varchar(2) DEFAULT NULL,
  `ECH` varchar(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `dir_absence_reservations`
--

CREATE TABLE `dir_absence_reservations` (
  `dir_absence_reservation_id` int(11) NOT NULL,
  `YEAR` int(11) NOT NULL,
  `MONTH` int(11) NOT NULL,
  `STATUS` tinyint(1) NOT NULL,
  `Type` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `dir_absence_reservation_employees`
--

CREATE TABLE `dir_absence_reservation_employees` (
  `id` int(11) NOT NULL,
  `dir_absence_reservation_id` int(11) DEFAULT NULL,
  `id_absence_reservation_employee` int(11) DEFAULT NULL,
  `MATRI` varchar(20) DEFAULT NULL,
  `estab_mail_code` varchar(50) DEFAULT NULL,
  `NBR_DAYS` int(11) DEFAULT NULL,
  `DAY_FROM` date DEFAULT NULL,
  `DAY_TO` date DEFAULT NULL,
  `ABSENCE_TYPE` tinyint(1) DEFAULT NULL,
  `ACTIVE` tinyint(1) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `ed_megrations`
--

CREATE TABLE `ed_megrations` (
  `ID_MEGRATION` int(11) UNSIGNED NOT NULL,
  `MONTH` int(11) NOT NULL,
  `LOT` varchar(255) DEFAULT NULL,
  `YEAR` int(11) NOT NULL,
  `STATUS` tinyint(4) NOT NULL DEFAULT 0,
  `nbr_employees` int(11) DEFAULT NULL,
  `total_NETPAI` decimal(14,2) DEFAULT NULL,
  `total_TOTGAIN` decimal(14,2) DEFAULT NULL,
  `total_RETSS` decimal(14,2) DEFAULT NULL,
  `total_PARTSS` decimal(14,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `path` text NOT NULL,
  `log_path` text DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `RUN` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `MATRI` varchar(20) NOT NULL,
  `NOM` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `PRENOM` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `NOMA` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `PRENOMA` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `ADM` varchar(1) NOT NULL,
  `DATNAIS` date DEFAULT NULL,
  `DATENT` datetime DEFAULT NULL,
  `NUMSS` varchar(15) DEFAULT NULL,
  `AFFECT` int(11) UNSIGNED DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT 1,
  `SITPAI` int(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  `realAFFECT` int(11) DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `CODEFONC` varchar(6) DEFAULT NULL,
  `SITFAM` varchar(3) DEFAULT NULL,
  `CATEG` varchar(2) DEFAULT NULL,
  `ECH` varchar(2) DEFAULT NULL,
  `NIN` varchar(18) DEFAULT NULL,
  `RIB` varchar(20) DEFAULT NULL,
  `NOMPRENOM` varchar(255) DEFAULT NULL,
  `ACTIVENIN` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `emp_megrations`
--

CREATE TABLE `emp_megrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `MATRI` varchar(20) NOT NULL,
  `ID_MEGRATION` int(11) UNSIGNED NOT NULL,
  `CODEFONC` varchar(6) NOT NULL,
  `AFFECT` int(11) UNSIGNED NOT NULL,
  `SITFAM` varchar(3) DEFAULT NULL,
  `ENF10` varchar(2) DEFAULT NULL,
  `CATEG` varchar(2) DEFAULT NULL,
  `ECH` varchar(2) DEFAULT NULL,
  `ADM` varchar(1) DEFAULT NULL,
  `TOTGAIN` decimal(14,2) DEFAULT NULL,
  `NBRTRAV` int(11) DEFAULT NULL,
  `BRUTSS` decimal(14,2) DEFAULT NULL,
  `RETSS` decimal(14,2) DEFAULT NULL,
  `NETPAI` decimal(14,2) DEFAULT NULL,
  `PARTSS` decimal(14,2) DEFAULT NULL,
  `NUMCPT` varchar(20) DEFAULT NULL,
  `CLECPT` varchar(2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `establishments`
--

CREATE TABLE `establishments` (
  `id` int(11) NOT NULL,
  `estab_ar_name` text DEFAULT NULL,
  `estab_fr_name` varchar(255) DEFAULT NULL,
  `estab_administration` varchar(50) DEFAULT NULL,
  `estab_office` varchar(50) DEFAULT NULL,
  `estab_type` varchar(255) DEFAULT NULL,
  `estab_wilaya` text DEFAULT NULL,
  `estab_daira_name` text DEFAULT NULL,
  `estab_daira_id` int(11) DEFAULT NULL,
  `estab_cityhall_name` text DEFAULT NULL,
  `estab_cityhall_id` int(11) DEFAULT NULL,
  `estab_address` text DEFAULT NULL,
  `estab_pension_type` text DEFAULT NULL,
  `estab_micano` int(11) DEFAULT NULL,
  `estab_rawateb_user` int(11) DEFAULT NULL,
  `estab_mail_code` varchar(50) DEFAULT NULL,
  `estab_cct_index` text DEFAULT NULL,
  `estab_director_id` text DEFAULT NULL,
  `estab_accountant_id` text DEFAULT NULL,
  `estab_mail_director_id` varchar(50) DEFAULT NULL,
  `estab_cct_scmpt` text DEFAULT NULL,
  `estab_cct_cle` varchar(15) DEFAULT NULL,
  `estab_cct_cmpt` varchar(50) DEFAULT NULL,
  `estab_ccp_cmpt` text DEFAULT NULL,
  `estab_dir_fullname` varchar(50) DEFAULT NULL,
  `estab_dir_mobile` varchar(20) DEFAULT NULL,
  `estab_acc_fullname` varchar(50) DEFAULT NULL,
  `estab_acc_mobile` varchar(20) DEFAULT NULL,
  `estab_fax` varchar(20) DEFAULT NULL,
  `estab_fix_phone` text DEFAULT NULL,
  `estab_email` text DEFAULT NULL,
  `estab_info_update` tinyint(1) DEFAULT NULL,
  `estab_cct_user` int(11) DEFAULT NULL,
  `estab_rit` varchar(20) DEFAULT NULL,
  `estab_first_cct_credit` double DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `fonctions`
--

CREATE TABLE `fonctions` (
  `CODEFONC` varchar(6) NOT NULL,
  `LIBTAB` varchar(30) NOT NULL,
  `LIBTABA` varchar(30) DEFAULT NULL,
  `CATEG` varchar(2) NOT NULL,
  `TAUXPR` decimal(18,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `fonctions`
--

INSERT INTO `fonctions` (`CODEFONC`, `LIBTAB`, `LIBTABA`, `CATEG`, `TAUXPR`, `created_at`, `updated_at`) VALUES
('1000', 'PROF.PRINC.EN PRIMAIRE', 'أستاذ رئيسي للمدرسة الابتدائية', '12', 40.00, NULL, NULL),
('1001', 'PROF.PRIM.FORMAT', 'أستاذ ابتدائي مكون', '14', 40.00, NULL, NULL),
('1005', 'PROF ENS PRIMAIRE', 'أستاذ تعليم ابتدائي', '11', 40.00, NULL, NULL),
('1006', 'PROF ENS MOYENE.EN PRIMAIRE', 'أستاذ تعليم متوسط /(ابتدائي)', '12', 40.00, NULL, NULL),
('1007', 'PROF ENS SECOND.EN PRIMAIRE', 'أستاذ تعليم ثانوي/(ابتدائي)', '13', 40.00, NULL, NULL),
('1009', 'Professeur de l\'enseignement p', 'أستاذ التعليم الابتدائي قسم ثا', '14', 40.00, NULL, NULL),
('1010', 'Professeur émérite de l\'enseig', 'أستاذ مميز في التعليم الابتدائ', '15', 40.00, NULL, NULL),
('1012', 'Professeur de l\'enseignement p', 'أستاذ التعليم الابتدائي', '12', 40.00, NULL, NULL),
('1013', 'Professeur de l\'enseignement p', 'أستاذ التعليم الابتدائي قسم أو', '13', 40.00, NULL, NULL),
('1014', 'أستاذ تعليم ابتدائي قسم ثان', 'أستاذ تعليم ابتدائي قسم ثان', '14', 40.00, NULL, NULL),
('1015', 'METRE.ECOL.PRIMAIRE', 'أستاذ مميز في المدرسة الابتدائ', '10', 40.00, NULL, NULL),
('1020', 'M.E.F NIVEAU 3-INSTITUTEUR', 'معلم مدرسة ابتدائبة', '10', 40.00, NULL, NULL),
('1025', 'M.E.F NIVEAU 2.INSTRUCTEUR', 'معلم مساعد', '07', 40.00, NULL, NULL),
('1030', 'ALLOC.FAMILIALLE', 'منح عائلية', '10', 40.00, NULL, NULL),
('2000', 'Directeur Ecole Primaire', 'مدير مدرسة ابتدائية\'', '12', 40.00, NULL, NULL),
('2004', 'DIR. D\'ANNEXE', 'مدير مدرسة ابتدائية', '12', 40.00, NULL, NULL),
('2005', 'DIR. D\'ANNEXE E.F', 'مدير مدرسة ابتدائية', '14', 40.00, NULL, NULL),
('2006', 'DIR. D\'ANNEXE E.F', 'مدير مدرسة ابتدائية', '14', 40.00, NULL, NULL),
('2007', 'DIR. D\'ANNEXE E.F', 'مدير مدرسة ابتدائية', '14', 40.00, NULL, NULL),
('2010', 'INSTRUCTEUR DIR. ANNEXE E.F', 'مساعد مدير مدرسة ابتدائية', '12', 40.00, NULL, NULL),
('2015', 'نتتنننن', 'مشرف تربية في الابتدائي', '10', 40.00, NULL, NULL),
('2020', 'Ad D\'Education', 'مساعد مدير مدرسة ابتدائية', '12', 40.00, NULL, NULL),
('2025', 'Ad Education', 'مشرف تربوي', '10', 40.00, NULL, NULL),
('206', 'CONJ AV SCOLAIRES', 'مرافقة حياة مدرسية', '07', 30.00, NULL, NULL),
('3000', 'للل', 'استاذ نعليم متوسط منسق', '11', 40.00, NULL, NULL),
('3001', 'Enseignant de la composante', 'استاذ تعليم متوسط مكون', '15', 40.00, NULL, NULL),
('3002', 'PROF CERT MOY', 'ا تعليم متوسط مكون', '15', 40.00, NULL, NULL),
('3004', 'Enseignant de la composante', 'استاذ تعليم متوسط رئيسي', '13', 40.00, NULL, NULL),
('3005', 'Enseignant de la composante', 'استاذ تعليم متوسط', '12', 40.00, NULL, NULL),
('3006', 'PROF ENS MOY', 'استاد تعليم اساسي', '11', 40.00, NULL, NULL),
('3010', 'PROF.PRINC.D\'ENSEIG.FOND.', 'أسات\\ة رئيسيون في ت.أ', '14', 0.00, NULL, NULL),
('3012', 'Professeur de l\'enseignement m', 'أستاذ التعليم متوسط', '12', 40.00, NULL, NULL),
('3013', 'Professeur de l\'enseignement m', 'أستاذ التعليم متوسط قسم أول', '13', 40.00, NULL, NULL),
('3015', 'Professeur de l\'enseignement m', 'أستاذ التعليم متوسط قسم ثان', '15', 40.00, NULL, NULL),
('3016', 'Professeur émérite de l\'enseig', 'أستاذ مميز في التعليم متوسط', '16', 40.00, NULL, NULL),
('3020', 'PROF D\'ENSEIG.FOND.', 'الاسات\\ة في ت.ا', '14', 0.00, NULL, NULL),
('3021', 'ens lysee', 'أستاذ تعليم ثانوي', '13', 40.00, NULL, NULL),
('3030', 'Prof De Lenseignemen Maladi', 'استاذ تعليم متوسط عطل مرضية', '14', 40.00, NULL, NULL),
('4000', 'DIR.D\'ECOLE FOND.D\'APPLIC', 'مدير مدرسة اساسية مطبق', '16', 0.00, NULL, NULL),
('4001', 'prof princ ens moy', 'استاد رئيسي للتعليم المتوسط', '13', 40.00, NULL, NULL),
('4002', 'SOUS DIR ECOLE MOY', 'ناظر في التعليم المتوسط', '15', 40.00, NULL, NULL),
('4003', 'CONS PRINCIP OR ET PER', 'مستشار رئيسي للتوجيه مد و مهن', '14', 40.00, NULL, NULL),
('4004', 'ADD GENR EDUCATION', 'مشرف عام للتربية', '13', 40.00, NULL, NULL),
('4005', 'DIR. D\'ECOLE FONDAMENTALE', 'مدير متوسطة', '15', 40.00, NULL, NULL),
('4006', 'DIR. D\'ECOLE FONDAMENTALE', 'مدير متوسطة', '12', 40.00, NULL, NULL),
('4007', 'DIR. D\'ECOLE FONDAMENTALE', 'مدير متوسطة', '12', 40.00, NULL, NULL),
('4008', 'DIR. D\'ECOLE FONDAMENTALE', 'مدير متوسطة', '11', 40.00, NULL, NULL),
('4009', 'CONS ALIM SCOL', 'مستشار التغدية المدرسية', '12', 40.00, NULL, NULL),
('4010', 'INTENDANT PRINCIPAL', 'مقتصد رئيسي', '14', 40.00, NULL, NULL),
('4011', 'ATACH ADD LAB', 'ملحق مشرف بالمخبر', '12', 30.00, NULL, NULL),
('4012', 'ATACH PRINC LAB', 'ملحق رئيس بالمخبر', '11', 30.00, NULL, NULL),
('4015', 'cons educ princ', 'مستشار رئيسي للتربية', '14', 40.00, NULL, NULL),
('4020', 'ADMINISTRATEUR', 'متصرف اداري', '15', 0.00, NULL, NULL),
('4025', 'INTENDANT', 'مقتصد', '13', 40.00, NULL, NULL),
('4026', 'cons princ or scol', 'م ر للتوجيه المدرسي و المهني', '13', 40.00, NULL, NULL),
('4030', 'CONSEILLER D\'EDUCATION', 'مستشار التربية', '13', 40.00, NULL, NULL),
('4031', 'ADMIST', 'متصرف', '12', 30.00, NULL, NULL),
('4035', 'cons osp12', 'مستشار التوجيه المدرسي', '12', 40.00, NULL, NULL),
('4040', 'SOUS INTENDANT GEST.', 'نائب مقتصد مسير', '11', 40.00, NULL, NULL),
('4041', 'ADD EDUC PRINC', 'مشرف تربوي رئيسي', '11', 40.00, NULL, NULL),
('4045', 'add educ', 'مشرف تربوي', '10', 40.00, NULL, NULL),
('4046', 'attach lab princ', 'ملحق رئيسي بالمخبر', '10', 30.00, NULL, NULL),
('4047', 'ATTACH PRINC ADM', 'ملحق رئيسي لللادارة', '10', 30.00, NULL, NULL),
('4050', 'archiv', 'مساعد وثائقي امين محفوطات', '10', 30.00, NULL, NULL),
('4051', 'ADJ DOC ARCH', 'مساعد وثائقي امين محفوظات', '10', 30.00, NULL, NULL),
('4055', 'ATTACHEE ADMINISTRATIF', 'ملحق إداري', '09', 30.00, NULL, NULL),
('4057', 'ATTACHE DE LABORATOIR', 'ملحق بالمخبر', '08', 30.00, NULL, NULL),
('4058', 'TECNECIEN DE LABO ET MAINT', 'تقني في المخبر والصيانة', '08', 30.00, NULL, NULL),
('4060', 'SOUS INTENDANT', 'نائب مقتصد', '10', 40.00, NULL, NULL),
('4062', 'adj educ princ', 'مساعد تر رئيسي', '08', 40.00, NULL, NULL),
('4065', 'ADJOINT SCES ECO. GEST.', 'مساعد.م.إ.مسير', '08', 40.00, NULL, NULL),
('4067', 'ATTACHE LABORATOIR', 'ملحق بالمخبر', '08', 30.00, NULL, NULL),
('4070', 'ADJOINT TECHNIQUE', 'م.تقني للمخبرو ص', '07', 30.00, NULL, NULL),
('4071', 'ADJOINT TECHNIQUE de laboratoi', 'م.تقني للمخبر', '07', 30.00, NULL, NULL),
('4074', 'adj adm', 'مساعد متصرف', '11', 30.00, NULL, NULL),
('4075', 'AGENT ADM PRINC', 'عون اداري رئيسي', '08', 30.00, NULL, NULL),
('4076', 'op hors grade', 'ع م خارج الصنف', '06', 30.00, NULL, NULL),
('4080', 'CHEF MAGASINIER', 'مسؤول مخزن', '06', 30.00, NULL, NULL),
('4085', 'ADJOINT D\'EDUCATION', 'مساعد تربوي', '07', 40.00, NULL, NULL),
('4090', 'CHEF CUISINIER DE CANTINE', 'مسؤول مطبخ', '06', 30.00, NULL, NULL),
('4095', 'ADJOINT SCES ECO.', 'م.مصلحة .إ', '07', 40.00, NULL, NULL),
('4100', 'AGENT PREV 2 NIV', 'عون الوقاية من المستوى 2', '07', 30.00, NULL, NULL),
('4105', 'CHAUFFEURD POIDS LOURD', 'سائق وزن ثقيل', '03', 30.00, NULL, NULL),
('4110', 'CUISINIER DE CANTINE', 'طباخ ص1', '05', 30.00, NULL, NULL),
('4115', 'MAGASINIER', 'مخزني', '05', 30.00, NULL, NULL),
('4120', 'AGENT POLYV. 1ERE CAT.', 'ع.مهني ص1', '05', 30.00, NULL, NULL),
('4122', 'Agent P Niveau 3', ' ( ع م المستوى الثالث ( ع م خ', '05', 30.00, NULL, NULL),
('4125', 'AGENT PREV 1 NIV', 'عون الوقاية من المستوى 1', '05', 30.00, NULL, NULL),
('4130', 'AIDE SOIGNANT', 'مساعد ممرض', '07', 30.00, NULL, NULL),
('4135', 'AGENT TECHNIQUE', 'عون تقني للمخبر وص', '05', 30.00, NULL, NULL),
('4140', 'AGENT ADMINIDTARTIF', 'عون إداري', '07', 30.00, NULL, NULL),
('4145', 'MAITRESSE LINGERE', 'مسوؤل الغسيل', '05', 30.00, NULL, NULL),
('4150', 'SECRETAIRE', 'كاتب', '06', 30.00, NULL, NULL),
('4151', 'Agant de bureaux', 'عون مكتب', '05', 30.00, NULL, NULL),
('4155', 'CHAUFFEUR VEHI. LEGER', 'سائق وزن خفيف', '02', 30.00, NULL, NULL),
('4157', 'Chauffeur Veicule Niveau 1', 'سائق سيارة من المستوى الأول', '02', 30.00, NULL, NULL),
('4160', 'AGENT POLYV. 2EME CAT.', 'ع.مهني ص2', '03', 30.00, NULL, NULL),
('4162', 'Agent P Niveau 2', ' ( ع م  المستوى الثاني (ع م خ', '03', 30.00, NULL, NULL),
('4165', 'CONCIERGE D\'ETS SCOLAIRE', 'بواب مؤسسة', '03', 30.00, NULL, NULL),
('4167', 'A P N 2 (CONCIERGE)', ' ( ع م المستوى الثاني  (حاجب', '03', 30.00, NULL, NULL),
('4170', 'AGENT DACTYLO', 'عون حفظ البيانات', '05', 30.00, NULL, NULL),
('4175', 'CUISINIER CANTINE 2EME CAT', 'ط.م مدرسي ص2', '03', 30.00, NULL, NULL),
('4177', 'A P N 2 (cuisinier)', ' ( ع م المستوى الثاني   (طباخ', '03', 30.00, NULL, NULL),
('4180', 'AGENT PREV 1 NIV', 'عون الوقاية من المستوى 1', '05', 30.00, NULL, NULL),
('4185', 'LINGERE RAVAUDEUSE', 'بياضة مرقعة', '07', 30.00, NULL, NULL),
('4190', 'AGENT POLYV. 3EME CAT.', 'ع.مهني ص3', '01', 30.00, NULL, NULL),
('4191', 'o p2', 'عامل مهني صنف2', '01', 30.00, NULL, NULL),
('4192', 'Agent P Niveau 1', 'عامل مهني مستوى أول', '01', 30.00, NULL, NULL),
('5000', 'PROF. AGREGE', 'استا\\ مبرز', '17', 0.00, NULL, NULL),
('5005', 'PROF. INGENIEUR', 'استاذ مهندس', '13', 40.00, NULL, NULL),
('5006', 'PROF.CERT ENSEIG. FONDAMENT', 'الاساتذة مكونين للثانوي', '16', 40.00, NULL, NULL),
('5007', 'PROF.CERT ENSEIG. FONDAMENT', 'الاساتذة رئيسيون في الثانوي', '14', 40.00, NULL, NULL),
('5010', 'PROF.PRIC.D\'ENSEIG. SEC.', 'استاذ مبرز', '14', 40.00, NULL, NULL),
('5013', 'Professeur de l\'enseignement s', 'أستاذ التعليم ثانوي', '13', 40.00, NULL, NULL),
('5014', 'Professeur de l\'enseignement s', 'أستاذ التعليم ثانوي قسم أول', '14', 40.00, NULL, NULL),
('5015', 'PROF.D\'ENS .SEC.RESP. MAT', 'استاذ ثانوي منسق', '13', 40.00, NULL, NULL),
('5016', 'Professeur de l\'enseignement s', 'أستاذ التعليم ثانوي قسم ثان', '16', 40.00, NULL, NULL),
('5017', 'Professeur émérite de l\'enseig', 'أستاذ مميز في التعليم ثانوي', '17', 40.00, NULL, NULL),
('5020', 'PROF. D\'ENS. SECONDAIRE', 'استاذ تعليم ثانوي', '13', 40.00, NULL, NULL),
('5021', 'dfdsq', 'ا.ت.ثانوي 12', '12', 40.00, NULL, NULL),
('5023', 'rgfsdfgsdf', 'استاذ التعليم المتوسط', '12', 40.00, NULL, NULL),
('5025', 'PROF.TECH.LYCEE- CHEF TRAVAUX', 'استاذ تعليم ثانوي متعاقد', '12', 40.00, NULL, NULL),
('5026', 'PCEF', 'استا\\ مجاز للتعليم الاساسي', '14', 0.00, NULL, NULL),
('5030', 'PROF.TECH.LYCEE- CHEF ATELIER', 'استاذ ثانوي رئيس ورشة', '11', 40.00, NULL, NULL),
('5035', 'PROF. PRINC. ENS. FOND.', 'استاذ منسق في المتوسط', '11', 40.00, NULL, NULL),
('5040', 'PROF. TECH DE LYCEE', 'أ.ت.تقني للثانويات', '10', 40.00, NULL, NULL),
('5045', 'PROF. ENS. FOND.', 'استاذ التعليم الاساسي', '11', 40.00, NULL, NULL),
('5050', 'MAITRE ECOLE FONDAMENTALE', 'معلم مدرسة اساسية', '13', 0.00, NULL, NULL),
('5055', 'dhbdfg', 'استاذ تعليم ثانوي', '13', 40.00, NULL, NULL),
('5500', 'profe lessy', 'استاذ تعليم ثانوي (منح عائلية)', '13', 40.00, NULL, NULL),
('6000', 'DIRECT.D\'ETAB D\'ENSEI SECOND', 'مدير ثانوية', '16', 40.00, NULL, NULL),
('6005', 'S.DIRECT/ETUDES ETS D\'ENS SECO', 'نـــاظر ثــانوية', '14', 40.00, NULL, NULL),
('6007', 'Sous Directeur En CEM', 'ناظر في التعليم المتوسط', '15', 40.00, NULL, NULL),
('6010', 'INTENDANT PRINCIPAL', 'مقتصد رئيسي', '14', 40.00, NULL, NULL),
('6015', 'CONSEILLER PRINCIPAL EDU', 'مستشار رئيس للتربية', '14', 40.00, NULL, NULL),
('6020', 'INTENDANT', 'مقتصد', '13', 40.00, NULL, NULL),
('6025', 'CONSEILLER PRINCIPAL EDU', 'مستشار للتربية رئيسي', '13', 40.00, NULL, NULL),
('6030', 'CONSEILLER  D\'EDUCAT', 'مستشار  للتربية', '13', 40.00, NULL, NULL),
('6032', 'CONSEILLER OSP principal', 'مستشار رئيس للتوجيه المدرسي', '16', 40.00, NULL, NULL),
('6034', 'CONSEILLER OSP principal', 'مستشار رئيسي للتو ارش مدرسي', '14', 40.00, NULL, NULL),
('6035', 'CONSEILLER OSP principal', 'مستشار رئيسي للتو ارشاد مد ومه', '13', 40.00, NULL, NULL),
('6036', 'Adj General D\'Ducation', 'مشرف عام للتربية', '13', 40.00, NULL, NULL),
('6037', 'Cons Analyste OSP', 'مستشار محلل للتو الإرش مدرسي', '13', 40.00, NULL, NULL),
('6040', 'CONSEILLER OSP', 'مستشار توجيه و ارشاد مدرسي', '12', 40.00, NULL, NULL),
('6045', 'INFERMIER BREVETE', 'ممرض  متخصص للصحة العمومية', '12', 30.00, NULL, NULL),
('6050', 'S/intendant gestion', 'ممرض  للصحة العمومية', '11', 30.00, NULL, NULL),
('6055', 'SOUS-INTENDANT GESTIONNAIRE', 'نائب مقتصد مسير', '11', 40.00, NULL, NULL),
('6058', 'Ad Princip D\'Education', 'مشرف رئيس للتربية', '12', 40.00, NULL, NULL),
('6060', 'add education principal', 'مشرف رئيسي للتربية', '11', 40.00, NULL, NULL),
('6065', 'Conseiller  d\'O.S.P.', 'م وثائقي أمين م رئيسي', '11', 30.00, NULL, NULL),
('6067', 'Attache Adj Labo', 'ملحق مشرف بالمخابر', '12', 30.00, NULL, NULL),
('6068', 'Attache Labo principal', 'ملحق رئيس بالمخابر', '11', 30.00, NULL, NULL),
('6070', 'Attache Labo principal', 'ملحق رئيسي للمخبر', '10', 30.00, NULL, NULL),
('6075', 'TECHNICIEN SUPERIEUR', 'تقني سامي في المخبر والصيانة', '10', 30.00, NULL, NULL),
('6080', 'AID ARCHIV', 'مساعد وثائقي امين محفوظات', '10', 30.00, NULL, NULL),
('6085', 'SOUS INTEND', 'نائب مقتصد', '10', 40.00, NULL, NULL),
('6088', 'Ad Princ Education', 'مشرف رئيسي للتربية', '11', 40.00, NULL, NULL),
('6090', 'ad.education', 'مشرف تربوي', '10', 40.00, NULL, NULL),
('6095', 'ATT ADM PRINC', 'ملحق رئيسي للإدارة', '10', 30.00, NULL, NULL),
('6100', 'attachee ADMINISTRATIF', 'ملحق اداري', '09', 30.00, NULL, NULL),
('6105', 'Infermier breveté', 'ممرض مؤهلس', '09', 30.00, NULL, NULL),
('6110', 'AIDE SOIGNANT princ', 'مساعد ممرض رئيسي في الصحة', '09', 30.00, NULL, NULL),
('6115', 'AIDE SOIGNANT', 'مساعد ممرض في الصحة', '08', 30.00, NULL, NULL),
('6120', 'adjoint de educatin principal', 'مساعد ت رئيسي', '08', 40.00, NULL, NULL),
('6125', 'Attache Labo', 'ملحق بالمخبر', '08', 30.00, NULL, NULL),
('6130', 'TEC LABO', 'تقني في المخبر و الصيانة', '08', 30.00, NULL, NULL),
('6135', 'AGENT ADM PRINC', 'عون إداري رئيسي', '08', 30.00, NULL, NULL),
('6140', 'secretaire direction', 'كاتب مديرية', '08', 30.00, NULL, NULL),
('6145', 'AGENT ADMINISTRATIF', 'عون اداري', '07', 30.00, NULL, NULL),
('6150', 'ADJOINT TECHNIQUE delabo et ma', 'معاون تقني للمخبر والصيانة', '07', 30.00, NULL, NULL),
('6155', 'ADJOINT TECHNIQUE de laboratoi', 'معاون تقني للمخبر', '07', 30.00, NULL, NULL),
('6160', 'ADJOINT D\'EDUCATION', 'مساعد تربوي', '07', 40.00, NULL, NULL),
('6165', 'ADJOINT DES SERVICES ECONOMIQ', 'مساعد مصالح اقتصادية', '07', 40.00, NULL, NULL),
('6166', 'ADJOINT DES SERVS ECONO GESTIO', 'عون مصالح اقتصادية مسير', '08', 40.00, NULL, NULL),
('6170', 'SECRETAIRE', 'كاتب', '06', 30.00, NULL, NULL),
('6175', 'AGENT DE BUREAU', 'عون مكتب', '05', 30.00, NULL, NULL),
('6180', 'AGENT TECNIQUE', 'عون تقني للمخبر والصيانة', '05', 30.00, NULL, NULL),
('6185', 'AGENT TECNIQUE de laboratoir', 'عون تقني للمخبر', '05', 30.00, NULL, NULL),
('6190', 'AGENT SAISI', 'عون حفظ  البيانات', '05', 30.00, NULL, NULL),
('6195', 'Chauffeur veicul niveau 1', 'سائق سيارة من صنف  01', '03', 30.00, NULL, NULL),
('6200', 'CHAUFFEUR VEHICULE LEGER', 'سائق سيارة من صنف  02', '02', 30.00, NULL, NULL),
('6205', 'RESPONSABLE DE SERVICE INTER', 'عامل مهني خارج الصنف', '06', 30.00, NULL, NULL),
('6210', 'AGENT POLYVALENT DE 1ere CATEG', 'عامل مهني الصنف الاول', '05', 30.00, NULL, NULL),
('6215', 'AGENT POLYVALENT 2eme CATEGOR', 'عامل مهني الصنف الثاني', '03', 30.00, NULL, NULL),
('6220', 'AGENT POLYVALENT 3eme CATEGOR', 'عامل مهني الصنف الثالث', '01', 30.00, NULL, NULL),
('6235', 'LINGERE RAVAUDEUSE', 'بياضةو مرقعة', '03', 0.00, NULL, NULL),
('6600', 'maladie longe duree', 'عطل مرضية طويلة المدى', '13', 0.00, NULL, NULL),
('7000', 'DIREC D\'EDUCATION', 'مدير التربية', '0B', 40.00, NULL, NULL),
('7001', 'INSP ORI SCOL', 'مفتش ت مد و مه للثانويات', 'S1', 40.00, NULL, NULL),
('7002', 'INSP LUCEE SPEC MATIERS', 'مفتش ت ثانوي تخصص المواد', 'S1', 40.00, NULL, NULL),
('7003', 'INSP LYCE SPEC ADM LYCEE', 'مفتش ت ثا نوي تخصص ادا. ثانويا', 'S1', 40.00, NULL, NULL),
('7004', 'INSP MOY SPEC DIR MOY', 'مفتش ت متوسط تخصص ا متوسط', '17', 40.00, NULL, NULL),
('7005', 'SECRETAIR GENERAL', 'أمين عــام', '14', 40.00, NULL, NULL),
('7006', 'secrt', 'امين عام', '16', 40.00, NULL, NULL),
('7007', 'chef serv comt', 'رئيس مصلحة البرمجة و المتابعة', '15', 40.00, NULL, NULL),
('7008', 'chef serv pers int', 'رئيس مصلحة المستخدمين مقتصد', '13', 40.00, NULL, NULL),
('7009', 'INTEND', 'مقتصد', '13', 40.00, NULL, NULL),
('7010', 'CHEF SERVICE', 'رئيس مصلحة', '14', 30.00, NULL, NULL),
('7011', 'CHEF SER SOUS DIREC', 'ر مصلحة ناظر ثانوية', '16', 40.00, NULL, NULL),
('7012', 'CHEF SERVICE', 'رئيس مصلحة', '14', 40.00, NULL, NULL),
('7013', 'CHEF SERV DIRECT ECOL PRIM', 'رئيس مصلحة مدير ابتدائي', '14', 40.00, NULL, NULL),
('7014', 'CHEF SERV INT PRINC', 'رئيس مصلحة مقتصد رئيسي', '14', 40.00, NULL, NULL),
('7015', 'CHEF DE SERVICE', 'رئيس مصلحة', '13', 40.00, NULL, NULL),
('7016', 'CHEF SERV DIR ECOL PRIM', 'ر مصلحة مدير ابتدائي', '15', 40.00, NULL, NULL),
('7017', 'CHEF BUR DIR ECOL PRIM', 'ر مكتب م ابتدائي', '15', 40.00, NULL, NULL),
('7018', 'CHEF BUR SOUS DIR MOY', 'ر مكتب ناظر في المتوسط', '15', 40.00, NULL, NULL),
('7019', 'INSP MOY SPEC MATIERS', 'مفتش ت متوسط تخصص المواد', '17', 40.00, NULL, NULL),
('7020', 'CHEF DE SERVICE', 'رئيس مصلحة', '12', 40.00, NULL, NULL),
('7021', 'INSP PRIM SPEC MATIERS', 'مفتش ت ابتدائي تخصص المواد', '17', 40.00, NULL, NULL),
('7022', 'INSPEC.EDUC ET FORM IEF', 'مفتش.ت. والتكوين', '18', 0.00, NULL, NULL),
('7023', 'SECRT GENR', 'امين عام', '17', 40.00, NULL, NULL),
('7024', 'CHEF BUR', 'رئيس مكتب', '14', 30.00, NULL, NULL),
('7025', 'CHEF BUREAU', 'رئيس مكتب', '14', 40.00, NULL, NULL),
('7026', 'CHEF BUREAUX', 'رئيس مكتب مدير ابتدائي', '14', 40.00, NULL, NULL),
('7029', 'CHEF DE BUREAU', 'رئيس مكتب', '16', 40.00, NULL, NULL),
('7030', 'CHEF DE BUREAU', 'رئيس مكتب', '13', 40.00, NULL, NULL),
('7031', 'chef bur', 'رئيس مكتب', '13', 40.00, NULL, NULL),
('7032', 'chef bur', 'رئيس مكتب التعليم الاساسي', '13', 40.00, NULL, NULL),
('7033', 'chef bur form', 'رئيس مكتب التفتيش', '13', 40.00, NULL, NULL),
('7034', 'CHEF BUREAUX', 'رئيس مكتب مساعد مدير ابتدائي', '12', 40.00, NULL, NULL),
('7035', 'CHEF BUREAU', 'رئيس مكتب', '12', 30.00, NULL, NULL),
('7036', 'doct genr', 'طبيب عام', '16', 30.00, NULL, NULL),
('7037', 'chef bur sante', 'رئيس مكتب النشاط الاجتماعي و ا', '15', 40.00, NULL, NULL),
('7038', 'CHEF BUREAU', 'رئيس مكتب', '11', 40.00, NULL, NULL),
('7039', 'CHEF DE BUREAU', 'رئيس مكتب', '12', 40.00, NULL, NULL),
('7040', 'CHEF BUREAU', 'رئيس مكتب', '11', 40.00, NULL, NULL),
('7041', 'CHEF BUR SUR CONS EDUC', 'رئيس مكتب ناظر في المتوسط', '15', 40.00, NULL, NULL),
('7042', 'CHEF BUR DIR ECOL MOY', 'رئيس مكتب مدير متوسط', '16', 40.00, NULL, NULL),
('7045', 'CHEF BUREAU', 'رئيس مكتب', '10', 30.00, NULL, NULL),
('7050', 'INSPEC D\'EDUCAT ET FORMATION', 'مفتش التربية الوطنية', '17', 40.00, NULL, NULL),
('7051', 'INSPECTEUR D\'EDUC NATIONAL', 'مفتش التربية الوطنية', '13', 40.00, NULL, NULL),
('7052', 'prof ecole prim', 'استاد مكون في المدرسة الابتدائ', '14', 40.00, NULL, NULL),
('7053', 'INSPECT D\'EDUCATION NATIONAl', 'مفتش التربية الوطنية', '13', 40.00, NULL, NULL),
('7055', 'INSPEC D\'ENSEI MOYEN', 'مفتش التعليم المتوسط', '16', 40.00, NULL, NULL),
('7056', 'INSPEC D\'ENSEI MOYEN', 'مفتش التعليم المتوسط', '13', 40.00, NULL, NULL),
('7060', 'INSPEC D\'ENSEIN MOYEN', 'مفتش التعليم المتوسط', '12', 40.00, NULL, NULL),
('7061', 'adm cons', 'متصرف مستشار', '16', 30.00, NULL, NULL),
('7062', 'chef bur adm cons', 'رئيس مكتب متصرف مستشار', '16', 30.00, NULL, NULL),
('7063', 'chef bur scol', 'رئيس مكتب الخريطة المدرسية', '16', 40.00, NULL, NULL),
('7065', 'INSPEC D\'ENSEI PRIMAIR', 'مفتش التعليم الابتدائي', '15', 40.00, NULL, NULL),
('7066', 'INSP PRIM SPEC ALIM SCOLAIRE', 'مفتش ابتدائي تخصص تغذية مدرسية', '15', 40.00, NULL, NULL),
('7070', 'INSPEC D\'ENSEI PRIMAIR', 'مفتش التعليم الابتدائي', '12', 40.00, NULL, NULL),
('7075', 'INSPEC D\'ENSEI PRIMAIR', 'مفتش التعليم الابتدائي', '11', 40.00, NULL, NULL),
('7077', 'INSPECT ENS PRIM', 'مفتش التعليم الابتدائي', '11', 40.00, NULL, NULL),
('7080', 'DIREC CENT ORI SCOL', 'مدير مركز التوجيه المدرسي', '13', 40.00, NULL, NULL),
('7085', 'INSPEC D\'ALI SCOL', 'مفتش التغذية المدرسية', '11', 40.00, NULL, NULL),
('7086', 'INSPECT ENS SCOL', 'مفتش التوجيهو الارشاد المدرسيو', '15', 40.00, NULL, NULL),
('7089', 'DIRECT ECOL PRIM', 'مدير مدرسة ابتدائية', '15', 40.00, NULL, NULL),
('7090', 'DIREC D\'ECOLE PRIMAIR', 'مدير مدرسة ابتدائية', '12', 40.00, NULL, NULL),
('7095', 'DIREC D\'ECOL PRIMAIRE', 'مدير مدرسة ابتدائية', '11', 40.00, NULL, NULL),
('7100', 'ADMINISTRATEUR PRICIP', 'متصرف رئيسي', '14', 30.00, NULL, NULL),
('7103', 'adm pol', 'متصرف محال', '13', 30.00, NULL, NULL),
('7104', 'adj adm', 'مساعد متصرف', '11', 30.00, NULL, NULL),
('7105', 'ADMINIS', 'متصرف إداري', '12', 30.00, NULL, NULL),
('7106', 'psycho sante generale', 'نفساني عيادي للصحة عمومية', '12', 40.00, NULL, NULL),
('7107', 'ADMINIST', 'متصرف إداري', '12', 30.00, NULL, NULL),
('7108', 'ing inf princ', 'مهندس في الاعلام الالي رئيسي', '14', 30.00, NULL, NULL),
('7109', 'adm chef bur', 'متصرف رئيس مكتب', '12', 30.00, NULL, NULL),
('7110', 'INGENIEUR', 'مهندس دولة', '13', 30.00, NULL, NULL),
('7111', 'chef serv adm princ', 'رئيس مصلحة متصرف اداري', '14', 30.00, NULL, NULL),
('7112', 'adm princ', 'متصرف رئيسي', '14', 30.00, NULL, NULL),
('7114', 'رئيس مكتب مستخدمي التعليم', 'chef bur', '14', 30.00, NULL, NULL),
('7115', 'INTENDEN chef bur', 'مقتصد رئيس مكتب', '13', 40.00, NULL, NULL),
('7116', 'chef bur int princ', 'رئيس مكتب مقتصد رئيسي', '14', 40.00, NULL, NULL),
('7117', 'intendant princ', 'مقتصد رئيسي', '14', 40.00, NULL, NULL),
('7118', 'CONS EDUCAT', 'مستشار للتربية', '13', 40.00, NULL, NULL),
('7119', 'CONS PRINC ORIE SCOL', 'مستشار رئيسي لتوجيه المدرسي', '13', 40.00, NULL, NULL),
('7120', 'CONS ORI  SCOLAIR', 'مستشار ارشاد وتوجيه مدرسي', '12', 40.00, NULL, NULL),
('7121', 'CONS PRIN ORI EDUC', 'مستشار رئيس توجته مد و مهن', '16', 40.00, NULL, NULL),
('7122', 'CONS ALIM SCOL', 'مستشار التغدية المدرسية', '12', 40.00, NULL, NULL),
('7123', 'CONS ADD ORI SCOLAIRES', 'مستشار محلل ت مدرسي و مهن', '13', 40.00, NULL, NULL),
('7124', 'CONS PRINC ORI SCOL', 'مستشار رئيسي توج و ارشاد مهن', '14', 40.00, NULL, NULL),
('7125', 'CONS D\'ALI SCOL', 'مستشار التغذية المدرسية', '11', 40.00, NULL, NULL),
('7126', 'ADD GENR EDUC', 'مشرف عام للتربية', '13', 40.00, NULL, NULL),
('7130', 'PROF ECOLE PRIMAIR', 'أستاذ مدرسة ابتدائية', '11', 40.00, NULL, NULL),
('7134', 'prof ensein primair', 'استاذ مدرسة ابتدائية', '11', 40.00, NULL, NULL),
('7135', 'ENSEI ECOLE PRIMAIRE', 'معلم مدرسة ابتدائية', '10', 40.00, NULL, NULL),
('7140', 'SOUS INTENDENT', 'نائب مقتصد', '10', 40.00, NULL, NULL),
('7141', 'SOUS INTENDENT gest', 'نائب مقتصد مسير', '11', 40.00, NULL, NULL),
('7144', 'adj inj 1niv inf', 'مساعد مهندس مستوى 1 اعلام الي', '11', 30.00, NULL, NULL),
('7145', 'TEC SUP INFORMATIQUE', 'تقني سامي في الاعلام الالي', '10', 30.00, NULL, NULL),
('7146', 'لللل', 'مساعد مهندس  مستوي 2', '12', 30.00, NULL, NULL),
('7147', 'inf sant gen', 'ممرض للصحة العمومية', '11', 30.00, NULL, NULL),
('7148', 'SOUIN SANT GENR', 'ممرض في الصحة العمومية', '12', 30.00, NULL, NULL),
('7150', 'ATTACH PRINC D\'ADMIN', 'ملحق ادارة رئيسي', '10', 30.00, NULL, NULL),
('7155', 'ATTACH ADMINIS', 'ملحق اداري', '09', 30.00, NULL, NULL),
('7160', 'AID DOC ARCHI', 'مساعد وثائقي أمين محفوظات', '10', 30.00, NULL, NULL),
('7165', 'AGENT ADM PRINC', 'عون ادارة رئيسي', '08', 30.00, NULL, NULL),
('7170', 'TEC D\'INFORMATIQUE', 'تقني في الاعلام الالي', '08', 30.00, NULL, NULL),
('7171', 'cont adm princ', 'محاسب اداري رئيسي', '10', 30.00, NULL, NULL),
('7175', 'COMP ADMINISTRATIF', 'محاسب اداري', '08', 30.00, NULL, NULL),
('7180', 'AGENT ADMINIS', 'عون اداري', '07', 30.00, NULL, NULL),
('7185', 'SECRETAIR', 'كاتب', '06', 30.00, NULL, NULL),
('7190', 'AID COMPTABLE', 'مساعد محاسب', '05', 30.00, NULL, NULL),
('7195', 'AGENT SESIE', 'عون حفظ بيانات', '05', 30.00, NULL, NULL),
('7200', 'AGENT BUREAU', 'عون مكتب', '05', 30.00, NULL, NULL),
('7205', 'AGENT PR NIV 2', 'عون وقاية مستوى 2', '07', 30.00, NULL, NULL),
('7210', 'CHEF CUISINIER', 'رئيس مطبخ', '06', 30.00, NULL, NULL),
('7212', 'op hors grade', 'ع م خارج الصنف', '06', 30.00, NULL, NULL),
('7215', 'AGENT PRI NIV 1', 'عون وقاية مستوى 1', '05', 30.00, NULL, NULL),
('7217', 'AGEN PRI NIV 1', 'عون وقاية مستوى 1', '05', 30.00, NULL, NULL),
('7220', 'OP1', 'عامل مهني ص 1', '05', 30.00, NULL, NULL),
('7225', 'CHAUF CAT 1', 'سائق سيارة ص 1', '03', 30.00, NULL, NULL),
('7230', 'OP2', 'عامل مهني ص 2', '03', 30.00, NULL, NULL),
('7235', 'CUISINIER CAT 2', 'طباخ ص 2', '03', 30.00, NULL, NULL),
('7240', 'PINTRE', 'عامل مهني دهان', '03', 30.00, NULL, NULL),
('7245', 'CHAUF  CAT 2', 'سائق ص 2', '02', 30.00, NULL, NULL),
('7250', 'OP3', 'عامل مهني ص 3', '01', 30.00, NULL, NULL),
('7255', 'JARDINIER', 'عامل مهني ص 3 بستاني', '01', 30.00, NULL, NULL),
('7260', 'GARDIEN', 'عامل مهني ص 3 حارس', '01', 30.00, NULL, NULL),
('7265', 'EMP NIV2', 'عامل مهني مستوى 2', '03', 30.00, NULL, NULL),
('7270', 'CHAUF NIV 1', 'سائق سيارة مستوى 1', '02', 30.00, NULL, NULL),
('7275', 'MONITEUR', 'ممرن في منصب معلم', '10', 0.00, NULL, NULL),
('7280', 'CHEF GROUP PREV ET SECU 10/2', 'رئيس فرقة امن ووقاية', '10', 0.00, NULL, NULL),
('7290', 'AGENT TECHNIQUE', 'عون تقني', '10', 0.00, NULL, NULL),
('7295', 'SECRETAIRE STENODACTYLO', 'كاتب الة راقنة', '10', 0.00, NULL, NULL),
('7300', 'AGENT ADMINISTRATIF', 'عون اداري', '10', 0.00, NULL, NULL),
('7305', 'AGENT PREV ET SECU 10/1', 'عون أمن ووقاية10', '10', 0.00, NULL, NULL),
('7310', 'AGENT POLY 1ERE CAT', 'ع.م.الخدمات ص 1', '10', 0.00, NULL, NULL),
('7315', 'CHEF ATELIER DE REPROGRAPHIE', 'رئيس ورشة تصوير', '10', 0.00, NULL, NULL),
('7320', 'MAGASINIER', 'مخزني', '10', 0.00, NULL, NULL),
('7325', 'CHAUFFEUR POIDS LOURD', 'سائق وزن ثقيل', '10', 0.00, NULL, NULL),
('7330', 'SECRETAIRE DACTYLO', 'كاتب راقن', '09', 0.00, NULL, NULL),
('7335', 'TELEXISTE', NULL, '09', 0.00, NULL, NULL),
('7340', 'CHAUFFEUR VEHI LEGER', 'سائق وزن خفيف', '09', 0.00, NULL, NULL),
('7345', 'AGENT DACTYLO', 'عون راقن', '08', 0.00, NULL, NULL),
('7350', 'AGENT POLY 2EME CAT', 'عون صيانة ص 2', '08', 0.00, NULL, NULL),
('7355', 'MAGASINIER 2EME CAT', 'مخزنــي ص 2', '08', 0.00, NULL, NULL),
('7360', 'MACON 2EME CAT', 'بناء ص 2', '08', 0.00, NULL, NULL),
('7365', 'CUISINIER CANTINE2 2EME CAT', 'طباخ مطعم مدرسي ص2', '08', 0.00, NULL, NULL),
('7370', 'MASSICOTIER', NULL, '08', 0.00, NULL, NULL),
('7375', 'INSP EDUC ET FORM. I.E.F.', 'مفتش التربية والتكوين', '18', 0.00, NULL, NULL),
('7380', 'AGENT DE BUREAU', 'عون مكتب', '08', 0.00, NULL, NULL),
('7385', 'PEINTRE 2EME CAT', 'دهان ص2', '08', 0.00, NULL, NULL),
('7390', 'PLOMBIER 2EME CAT', 'سباك ص 2', '08', 0.00, NULL, NULL),
('7395', 'ELECTRICIEN 2EME CAT', 'كهربائي ص 2', '08', 0.00, NULL, NULL),
('7400', 'AGENT DE REPOROGRAPHIE', 'ع.إ. أنتاج الوثائق', '08', 0.00, NULL, NULL),
('7405', 'STANDARDISTE', 'موزع الهاتف', '08', 0.00, NULL, NULL),
('7410', 'AGENT PREV ET SECU 8/1', 'عون أمن ووقاية8', '08', 0.00, NULL, NULL),
('7415', 'AGENT HYGIENE ET SECU', NULL, '08', 0.00, NULL, NULL),
('7420', 'MANOEUVRE TRAV ORDINAIRES', 'عون صيانة', '07', 0.00, NULL, NULL),
('7425', 'JARDINIER ENTRETIEN', 'بستاني صيانة', '06', 0.00, NULL, NULL),
('7430', 'AGENT POLY 3EME CAT', 'ع.م.الخدمات ص3', '06', 0.00, NULL, NULL),
('7435', 'GARDIEN', 'حارس', '06', 0.00, NULL, NULL),
('7440', 'APPARITEUR PRINCIPAL', NULL, '05', 0.00, NULL, NULL),
('7445', 'APPARITEUR', NULL, '04', 0.00, NULL, NULL),
('7450', 'FEMME DE MENAGE', 'منظفة', '04', 0.00, NULL, NULL),
('7451', 'sous dir chef bur', 'رئيس مكتب ناظر ثانوية', '14', 40.00, NULL, NULL),
('88888', '1', 'تست11', '11', 1100.00, '2025-10-05 07:31:36', '2025-10-05 07:57:08'),
('A120', 'AG NIV 4', 'عامل مهني مستوى الرابع', '06', 30.00, NULL, NULL),
('A122', 'AGENT P N 3', 'عامل مهني مستوي الثالث', '05', 30.00, NULL, NULL),
('A124', 'APN3 MAGAZ', 'ع م مستوي 3 مخزني', '05', 30.00, NULL, NULL),
('A157', 'CHAUFFEUR VEICULE N1', 'سائق سيارة مستوي 1', '02', 30.00, NULL, NULL),
('A162', 'OPN2', 'عامل مهني مستوي الثاني', '03', 30.00, NULL, NULL),
('A167', 'APN2 CONCIERGE', ' عون.م.مستوي 2(حاجب)', '03', 30.00, NULL, NULL),
('A177', 'APN2 CUISINIER', 'عون م المستوي 2 (طباخ)', '03', 40.00, NULL, NULL),
('A180', 'AGENT PREV 1 NIV', 'عون وقاية مستوي 1', '05', 30.00, NULL, NULL),
('A192', 'AGENT P NIV 1', 'عامل مهني مستوي الاول', '01', 30.00, NULL, NULL),
('A193', 'FGFGDFGHDHDG', 'ع م م 1 عطل مرضية', '01', 30.00, NULL, NULL),
('A467', 'A PN2  CONCIERGE', 'عون م المستوي الثاني (حاجب)', '03', 30.00, NULL, NULL),
('B065', 'A DE PREV N 2', 'عون وقاية مستوي 2', '07', 30.00, NULL, NULL),
('B140', 'A DE PREV N 2', 'عون  وقاية مستوي 02', '07', 30.00, NULL, NULL),
('B157', 'AGENT P NIV 3 MAG', 'ع م مستوي 3 مخزني', '05', 30.00, NULL, NULL),
('B162', 'AG P NIV 3', 'ع مهني مستوي 3', '05', 30.00, NULL, NULL),
('B165', 'A D PREV NIV 1', 'ع وقاية مستوي  1', '05', 30.00, NULL, NULL),
('B202', 'CHAUFEUR V N 1', 'سائق سيارة مستوي 1', '02', 30.00, NULL, NULL),
('B207', 'APN2', 'ع مهني مستوي 2', '03', 30.00, NULL, NULL),
('B212', 'APN 2  CONSIERG', 'ع م مستوي 2 حاجب', '03', 0.00, NULL, NULL),
('B222', 'APN 2 CUISINIER', 'ع م مستوي 2 طباخ', '03', 30.00, NULL, NULL),
('B225', 'A DE PREV NIV 1', 'ع وقاية مستوي 1', '05', 30.00, NULL, NULL),
('B242', 'AGENT P NIV 1', 'عامل مهني مستوي 1', '01', 30.00, NULL, NULL),
('B243', 'O?HJIOGVHVHJI', 'ع م م 1 عطل مرضية', '01', 30.00, NULL, NULL),
('C205', 'A BRO NIV 2', 'عون وقاية م 2', '07', 30.00, NULL, NULL),
('C206', 'CONJ AV SCO', 'مرافق حياة مدرسية', '07', 30.00, NULL, NULL),
('C215', 'A BRO NIV 1', 'عون وقاية م 1', '05', 30.00, NULL, NULL),
('C217', 'A BRO NIV 1', 'عون وقاية م 1', '05', 30.00, NULL, NULL),
('C218', 'sgddsfg', 'عامل مهني المستوي الاول بالتوق', '01', 30.00, NULL, NULL),
('C220', 'CHAUFFEUR VEICULE N1', 'سائق سيارة مستوى 1', '02', 30.00, NULL, NULL),
('C221', 'AGP NIV3', 'عامل مهني مستوى 3', '05', 30.00, NULL, NULL),
('C222', 'OPN2', 'عامل مهني مستوى 02', '03', 30.00, NULL, NULL),
('C223', 'AGENT P NIV 1', 'عامل مهني مستوى 01', '01', 30.00, NULL, NULL),
('D218', 'GDGFHJHFJFH', 'عامل مهني المستوي الاول بالتوق', '01', 30.00, NULL, NULL),
('i5020', 'profess.ens.second', 'استاذ تعليم ثانوي', '13', 40.00, NULL, NULL),
('j005', 'PROF ENS FOND D\'APPL', 'استاد تعليم ابتدائي', '11', 40.00, NULL, NULL);

-- --------------------------------------------------------

--
-- بنية الجدول `grants`
--

CREATE TABLE `grants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `MATRI` varchar(20) NOT NULL,
  `ID_MEGRATION` int(10) UNSIGNED NOT NULL,
  `IND` varchar(3) NOT NULL,
  `ADM` varchar(1) NOT NULL,
  `BASENBR` decimal(14,2) NOT NULL,
  `TAUX` decimal(14,2) NOT NULL,
  `MONTANT` decimal(14,2) NOT NULL,
  `MFIX` decimal(14,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `grants_new`
--

CREATE TABLE `grants_new` (
  `id` int(11) NOT NULL,
  `MATRI` varchar(255) DEFAULT NULL,
  `ID_MEGRATION` int(11) NOT NULL,
  `IND` varchar(255) DEFAULT NULL,
  `ADM` varchar(255) DEFAULT NULL,
  `BASENBR` int(11) DEFAULT NULL,
  `TAUX` decimal(10,2) DEFAULT NULL,
  `MONTANT` decimal(10,2) DEFAULT NULL,
  `MFIX` decimal(10,2) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci
PARTITION BY RANGE (`ID_MEGRATION`)
(
PARTITION p1 VALUES LESS THAN (1) ENGINE=InnoDB,
PARTITION p2 VALUES LESS THAN (2) ENGINE=InnoDB,
PARTITION p3 VALUES LESS THAN (3) ENGINE=InnoDB,
PARTITION p4 VALUES LESS THAN (4) ENGINE=InnoDB,
PARTITION p5 VALUES LESS THAN (5) ENGINE=InnoDB,
PARTITION p6 VALUES LESS THAN (6) ENGINE=InnoDB,
PARTITION p7 VALUES LESS THAN (7) ENGINE=InnoDB,
PARTITION p8 VALUES LESS THAN (8) ENGINE=InnoDB,
PARTITION p9 VALUES LESS THAN (9) ENGINE=InnoDB,
PARTITION p10 VALUES LESS THAN (10) ENGINE=InnoDB,
PARTITION p11 VALUES LESS THAN (11) ENGINE=InnoDB,
PARTITION p12 VALUES LESS THAN (12) ENGINE=InnoDB,
PARTITION p13 VALUES LESS THAN (13) ENGINE=InnoDB,
PARTITION p14 VALUES LESS THAN (14) ENGINE=InnoDB,
PARTITION p15 VALUES LESS THAN (15) ENGINE=InnoDB,
PARTITION p16 VALUES LESS THAN (16) ENGINE=InnoDB,
PARTITION p17 VALUES LESS THAN (17) ENGINE=InnoDB,
PARTITION p18 VALUES LESS THAN (18) ENGINE=InnoDB,
PARTITION p19 VALUES LESS THAN (19) ENGINE=InnoDB,
PARTITION p20 VALUES LESS THAN (20) ENGINE=InnoDB,
PARTITION p21 VALUES LESS THAN (21) ENGINE=InnoDB,
PARTITION p22 VALUES LESS THAN (22) ENGINE=InnoDB,
PARTITION p23 VALUES LESS THAN (23) ENGINE=InnoDB,
PARTITION p24 VALUES LESS THAN (24) ENGINE=InnoDB,
PARTITION p25 VALUES LESS THAN (25) ENGINE=InnoDB,
PARTITION p26 VALUES LESS THAN (26) ENGINE=InnoDB,
PARTITION p27 VALUES LESS THAN (27) ENGINE=InnoDB,
PARTITION p28 VALUES LESS THAN (28) ENGINE=InnoDB,
PARTITION p29 VALUES LESS THAN (29) ENGINE=InnoDB,
PARTITION p30 VALUES LESS THAN (30) ENGINE=InnoDB,
PARTITION p31 VALUES LESS THAN (31) ENGINE=InnoDB,
PARTITION p32 VALUES LESS THAN (32) ENGINE=InnoDB,
PARTITION p33 VALUES LESS THAN (33) ENGINE=InnoDB,
PARTITION p34 VALUES LESS THAN (34) ENGINE=InnoDB,
PARTITION p35 VALUES LESS THAN (35) ENGINE=InnoDB,
PARTITION p36 VALUES LESS THAN (36) ENGINE=InnoDB,
PARTITION p37 VALUES LESS THAN (37) ENGINE=InnoDB,
PARTITION p38 VALUES LESS THAN (38) ENGINE=InnoDB,
PARTITION p39 VALUES LESS THAN (39) ENGINE=InnoDB,
PARTITION p40 VALUES LESS THAN (40) ENGINE=InnoDB,
PARTITION p41 VALUES LESS THAN (41) ENGINE=InnoDB,
PARTITION p42 VALUES LESS THAN (42) ENGINE=InnoDB,
PARTITION p43 VALUES LESS THAN (43) ENGINE=InnoDB,
PARTITION p44 VALUES LESS THAN (44) ENGINE=InnoDB,
PARTITION p45 VALUES LESS THAN (45) ENGINE=InnoDB,
PARTITION p46 VALUES LESS THAN (46) ENGINE=InnoDB,
PARTITION p47 VALUES LESS THAN (47) ENGINE=InnoDB,
PARTITION p48 VALUES LESS THAN (48) ENGINE=InnoDB,
PARTITION p49 VALUES LESS THAN (49) ENGINE=InnoDB,
PARTITION p50 VALUES LESS THAN (50) ENGINE=InnoDB,
PARTITION p51 VALUES LESS THAN (51) ENGINE=InnoDB,
PARTITION p52 VALUES LESS THAN (52) ENGINE=InnoDB,
PARTITION p53 VALUES LESS THAN (53) ENGINE=InnoDB,
PARTITION p54 VALUES LESS THAN (54) ENGINE=InnoDB,
PARTITION p55 VALUES LESS THAN (55) ENGINE=InnoDB,
PARTITION p56 VALUES LESS THAN (56) ENGINE=InnoDB,
PARTITION p57 VALUES LESS THAN (57) ENGINE=InnoDB,
PARTITION p58 VALUES LESS THAN (58) ENGINE=InnoDB,
PARTITION p59 VALUES LESS THAN (59) ENGINE=InnoDB,
PARTITION p60 VALUES LESS THAN (60) ENGINE=InnoDB,
PARTITION p61 VALUES LESS THAN (61) ENGINE=InnoDB,
PARTITION p62 VALUES LESS THAN (62) ENGINE=InnoDB,
PARTITION p63 VALUES LESS THAN (63) ENGINE=InnoDB,
PARTITION p64 VALUES LESS THAN (64) ENGINE=InnoDB,
PARTITION p65 VALUES LESS THAN (65) ENGINE=InnoDB,
PARTITION p66 VALUES LESS THAN (66) ENGINE=InnoDB,
PARTITION p67 VALUES LESS THAN (67) ENGINE=InnoDB,
PARTITION p68 VALUES LESS THAN (68) ENGINE=InnoDB,
PARTITION p69 VALUES LESS THAN (69) ENGINE=InnoDB,
PARTITION p70 VALUES LESS THAN (70) ENGINE=InnoDB,
PARTITION p71 VALUES LESS THAN (71) ENGINE=InnoDB,
PARTITION p72 VALUES LESS THAN (72) ENGINE=InnoDB,
PARTITION p73 VALUES LESS THAN (73) ENGINE=InnoDB,
PARTITION p74 VALUES LESS THAN (74) ENGINE=InnoDB,
PARTITION p75 VALUES LESS THAN (75) ENGINE=InnoDB,
PARTITION p76 VALUES LESS THAN (76) ENGINE=InnoDB,
PARTITION p77 VALUES LESS THAN (77) ENGINE=InnoDB,
PARTITION p78 VALUES LESS THAN (78) ENGINE=InnoDB,
PARTITION p79 VALUES LESS THAN (79) ENGINE=InnoDB,
PARTITION p80 VALUES LESS THAN (80) ENGINE=InnoDB,
PARTITION p81 VALUES LESS THAN (81) ENGINE=InnoDB,
PARTITION p82 VALUES LESS THAN (82) ENGINE=InnoDB,
PARTITION p83 VALUES LESS THAN (83) ENGINE=InnoDB,
PARTITION p84 VALUES LESS THAN (84) ENGINE=InnoDB,
PARTITION p85 VALUES LESS THAN (85) ENGINE=InnoDB,
PARTITION p86 VALUES LESS THAN (86) ENGINE=InnoDB,
PARTITION p87 VALUES LESS THAN (87) ENGINE=InnoDB,
PARTITION p88 VALUES LESS THAN (88) ENGINE=InnoDB,
PARTITION p89 VALUES LESS THAN (89) ENGINE=InnoDB,
PARTITION p90 VALUES LESS THAN (90) ENGINE=InnoDB,
PARTITION p91 VALUES LESS THAN (91) ENGINE=InnoDB,
PARTITION p92 VALUES LESS THAN (92) ENGINE=InnoDB,
PARTITION p93 VALUES LESS THAN (93) ENGINE=InnoDB,
PARTITION p94 VALUES LESS THAN (94) ENGINE=InnoDB,
PARTITION p95 VALUES LESS THAN (95) ENGINE=InnoDB,
PARTITION p96 VALUES LESS THAN (96) ENGINE=InnoDB,
PARTITION p97 VALUES LESS THAN (97) ENGINE=InnoDB,
PARTITION p98 VALUES LESS THAN (98) ENGINE=InnoDB,
PARTITION p99 VALUES LESS THAN (99) ENGINE=InnoDB,
PARTITION p100 VALUES LESS THAN (100) ENGINE=InnoDB,
PARTITION p101 VALUES LESS THAN (101) ENGINE=InnoDB,
PARTITION p102 VALUES LESS THAN (102) ENGINE=InnoDB,
PARTITION p103 VALUES LESS THAN (103) ENGINE=InnoDB,
PARTITION p104 VALUES LESS THAN (104) ENGINE=InnoDB,
PARTITION p105 VALUES LESS THAN (105) ENGINE=InnoDB,
PARTITION p106 VALUES LESS THAN (106) ENGINE=InnoDB,
PARTITION p107 VALUES LESS THAN (107) ENGINE=InnoDB,
PARTITION p108 VALUES LESS THAN (108) ENGINE=InnoDB,
PARTITION p109 VALUES LESS THAN (109) ENGINE=InnoDB,
PARTITION p110 VALUES LESS THAN (110) ENGINE=InnoDB,
PARTITION p111 VALUES LESS THAN (111) ENGINE=InnoDB,
PARTITION p112 VALUES LESS THAN (112) ENGINE=InnoDB,
PARTITION p113 VALUES LESS THAN (113) ENGINE=InnoDB,
PARTITION p114 VALUES LESS THAN (114) ENGINE=InnoDB,
PARTITION p115 VALUES LESS THAN (115) ENGINE=InnoDB,
PARTITION p116 VALUES LESS THAN (116) ENGINE=InnoDB,
PARTITION p117 VALUES LESS THAN (117) ENGINE=InnoDB,
PARTITION p118 VALUES LESS THAN (118) ENGINE=InnoDB,
PARTITION p119 VALUES LESS THAN (119) ENGINE=InnoDB,
PARTITION p120 VALUES LESS THAN (120) ENGINE=InnoDB,
PARTITION p121 VALUES LESS THAN (121) ENGINE=InnoDB,
PARTITION p122 VALUES LESS THAN (122) ENGINE=InnoDB,
PARTITION p123 VALUES LESS THAN (123) ENGINE=InnoDB,
PARTITION p124 VALUES LESS THAN (124) ENGINE=InnoDB,
PARTITION p125 VALUES LESS THAN (125) ENGINE=InnoDB,
PARTITION p126 VALUES LESS THAN (126) ENGINE=InnoDB,
PARTITION p127 VALUES LESS THAN (127) ENGINE=InnoDB,
PARTITION p128 VALUES LESS THAN (128) ENGINE=InnoDB,
PARTITION p129 VALUES LESS THAN (129) ENGINE=InnoDB,
PARTITION p130 VALUES LESS THAN (130) ENGINE=InnoDB,
PARTITION p131 VALUES LESS THAN (131) ENGINE=InnoDB,
PARTITION p132 VALUES LESS THAN (132) ENGINE=InnoDB,
PARTITION p133 VALUES LESS THAN (133) ENGINE=InnoDB,
PARTITION p134 VALUES LESS THAN (134) ENGINE=InnoDB,
PARTITION p135 VALUES LESS THAN (135) ENGINE=InnoDB,
PARTITION p136 VALUES LESS THAN (136) ENGINE=InnoDB,
PARTITION p137 VALUES LESS THAN (137) ENGINE=InnoDB,
PARTITION p138 VALUES LESS THAN (138) ENGINE=InnoDB,
PARTITION p139 VALUES LESS THAN (139) ENGINE=InnoDB,
PARTITION p140 VALUES LESS THAN (140) ENGINE=InnoDB,
PARTITION p141 VALUES LESS THAN (141) ENGINE=InnoDB,
PARTITION p142 VALUES LESS THAN (142) ENGINE=InnoDB,
PARTITION p143 VALUES LESS THAN (143) ENGINE=InnoDB,
PARTITION p144 VALUES LESS THAN (144) ENGINE=InnoDB,
PARTITION p145 VALUES LESS THAN (145) ENGINE=InnoDB,
PARTITION p146 VALUES LESS THAN (146) ENGINE=InnoDB,
PARTITION p147 VALUES LESS THAN (147) ENGINE=InnoDB,
PARTITION p148 VALUES LESS THAN (148) ENGINE=InnoDB,
PARTITION p149 VALUES LESS THAN (149) ENGINE=InnoDB,
PARTITION p150 VALUES LESS THAN (150) ENGINE=InnoDB,
PARTITION p151 VALUES LESS THAN (151) ENGINE=InnoDB,
PARTITION p152 VALUES LESS THAN (152) ENGINE=InnoDB,
PARTITION p153 VALUES LESS THAN (153) ENGINE=InnoDB,
PARTITION p154 VALUES LESS THAN (154) ENGINE=InnoDB,
PARTITION p155 VALUES LESS THAN (155) ENGINE=InnoDB,
PARTITION p156 VALUES LESS THAN (156) ENGINE=InnoDB,
PARTITION p157 VALUES LESS THAN (157) ENGINE=InnoDB,
PARTITION p158 VALUES LESS THAN (158) ENGINE=InnoDB,
PARTITION p159 VALUES LESS THAN (159) ENGINE=InnoDB,
PARTITION p160 VALUES LESS THAN (160) ENGINE=InnoDB,
PARTITION p161 VALUES LESS THAN (161) ENGINE=InnoDB,
PARTITION p162 VALUES LESS THAN (162) ENGINE=InnoDB,
PARTITION p163 VALUES LESS THAN (163) ENGINE=InnoDB,
PARTITION p164 VALUES LESS THAN (164) ENGINE=InnoDB,
PARTITION p165 VALUES LESS THAN (165) ENGINE=InnoDB,
PARTITION p166 VALUES LESS THAN (166) ENGINE=InnoDB,
PARTITION p167 VALUES LESS THAN (167) ENGINE=InnoDB,
PARTITION p168 VALUES LESS THAN (168) ENGINE=InnoDB,
PARTITION p169 VALUES LESS THAN (169) ENGINE=InnoDB,
PARTITION p170 VALUES LESS THAN (170) ENGINE=InnoDB,
PARTITION p171 VALUES LESS THAN (171) ENGINE=InnoDB,
PARTITION p172 VALUES LESS THAN (172) ENGINE=InnoDB,
PARTITION p173 VALUES LESS THAN (173) ENGINE=InnoDB,
PARTITION p174 VALUES LESS THAN (174) ENGINE=InnoDB,
PARTITION p175 VALUES LESS THAN (175) ENGINE=InnoDB,
PARTITION p176 VALUES LESS THAN (176) ENGINE=InnoDB,
PARTITION p177 VALUES LESS THAN (177) ENGINE=InnoDB,
PARTITION p178 VALUES LESS THAN (178) ENGINE=InnoDB,
PARTITION p179 VALUES LESS THAN (179) ENGINE=InnoDB,
PARTITION p180 VALUES LESS THAN (180) ENGINE=InnoDB,
PARTITION p181 VALUES LESS THAN (181) ENGINE=InnoDB,
PARTITION p182 VALUES LESS THAN (182) ENGINE=InnoDB,
PARTITION p183 VALUES LESS THAN (183) ENGINE=InnoDB,
PARTITION p184 VALUES LESS THAN (184) ENGINE=InnoDB,
PARTITION p185 VALUES LESS THAN (185) ENGINE=InnoDB,
PARTITION p186 VALUES LESS THAN (186) ENGINE=InnoDB,
PARTITION p187 VALUES LESS THAN (187) ENGINE=InnoDB,
PARTITION p188 VALUES LESS THAN (188) ENGINE=InnoDB,
PARTITION p189 VALUES LESS THAN (189) ENGINE=InnoDB,
PARTITION p190 VALUES LESS THAN (190) ENGINE=InnoDB,
PARTITION p191 VALUES LESS THAN (191) ENGINE=InnoDB,
PARTITION p192 VALUES LESS THAN (192) ENGINE=InnoDB,
PARTITION p193 VALUES LESS THAN (193) ENGINE=InnoDB,
PARTITION p194 VALUES LESS THAN (194) ENGINE=InnoDB,
PARTITION p195 VALUES LESS THAN (195) ENGINE=InnoDB,
PARTITION p196 VALUES LESS THAN (196) ENGINE=InnoDB,
PARTITION p197 VALUES LESS THAN (197) ENGINE=InnoDB,
PARTITION p198 VALUES LESS THAN (198) ENGINE=InnoDB,
PARTITION p199 VALUES LESS THAN (199) ENGINE=InnoDB,
PARTITION p200 VALUES LESS THAN (200) ENGINE=InnoDB,
PARTITION p201 VALUES LESS THAN (201) ENGINE=InnoDB
);

-- --------------------------------------------------------

--
-- بنية الجدول `grant_infos`
--

CREATE TABLE `grant_infos` (
  `IND` varchar(3) NOT NULL,
  `LIBIND` varchar(250) NOT NULL,
  `LIBINDA` varchar(250) NOT NULL,
  `SENS` varchar(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `grant_infos`
--

INSERT INTO `grant_infos` (`IND`, `LIBIND`, `LIBINDA`, `SENS`, `created_at`, `updated_at`) VALUES
('001', 'Salaire de Base', 'الاجر القاعدي', '+', NULL, NULL),
('101', 'Indemnités  Expérience Professionnelle', 'منحة الخبرة المهنية', '+', NULL, NULL),
('102', 'ICR', 'منحة تكملية دخل', '+', NULL, NULL),
('103', 'Indemnités Expérience Pedagogique', 'تعويض الخبرة البيداغوجية', '+', NULL, NULL),
('104', 'BONIF A.L.N', 'م.مجاهدين', '+', NULL, NULL),
('105', 'Indemnité de poste spécifique', 'منحة المنصب العالي', '+', NULL, NULL),
('108', 'ind rev', 'منخة التعويض', '+', NULL, NULL),
('187', 'Indemnité différentiel de revenu', 'تعويض فارق الدخل', '+', NULL, NULL),
('188', 'Bonoification de 10%', 'تعويض فارق درجتين', '+', NULL, NULL),
('205', 'IND SERV PERM', 'تعويض جزافي عن الخدمة', '+', NULL, NULL),
('206', 'Indemnité de nuisance', 'تعويض الضرر', '+', NULL, NULL),
('207', 'Indemnité de nuisance', 'تعويض الضرر', '+', NULL, NULL),
('208', 'Indemnité forfaitaire compensatrice', 'منحة جزافية تعويضية', '+', NULL, NULL),
('210', 'Indemnités de risque et d\'astreinte', 'تعويض الخطر والالزام', '+', NULL, NULL),
('211', 'Indemnité de logement', 'تعويض السكن', '+', NULL, NULL),
('215', 'Indemnités de responsabilité', 'م.مسؤولية', '+', NULL, NULL),
('216', 'Bonification de 10%', 'تعويض فارق درجتين', '+', NULL, NULL),
('217', 'IND DE POSTE', 'م.المنصب', '+', NULL, NULL),
('220', 'IND VEHICULE', 'م.سيارة', '+', NULL, NULL),
('225', 'Indemnités à caractère local et de zone', 'منحة المنطقة', '+', NULL, NULL),
('226', 'Indemnité de zone géographique', 'منحة المنطقة', '+', NULL, NULL),
('227', 'Indemnités de représentation', 'منحة التمثيل', '+', NULL, NULL),
('228', 'Indemnités de responsabilité', 'منحة المسؤولية', '+', NULL, NULL),
('229', 'Indemnités spécifique d\'astreinte', 'منحة الالزام', '+', NULL, NULL),
('230', 'ISS C.C STAG.', 'م.ت.متربص', '+', NULL, NULL),
('235', 'ISS AG. SECU', 'م.عون امن', '+', NULL, NULL),
('240', 'Prime de l\'amélioration des performances et rendement', 'تعويض علاوة تحسين الاداء التربوي والمردودية', '+', NULL, NULL),
('241', 'Inde de gestion financière et matérieI', 'منحة التسيير المالي والمادي', '+', NULL, NULL),
('242', 'Indemnité de direction d\'ètablissement d\'enseignement', 'منحة تسيير مؤسسة تعليمية', '+', NULL, NULL),
('246', 'Indemnité de qualification', 'تعويض التأهيل', '+', NULL, NULL),
('250', 'ISS FONC SUP', 'م.مناصب عليا', '+', NULL, NULL),
('260', 'Indemnité spécifique de poste', 'تعويض عن المنصب', '+', NULL, NULL),
('261', 'Indemnité spécifique de poste', 'منحة المنصب', '+', NULL, NULL),
('270', 'Indemnités des services administratifs communs', 'تعويض الخدمات الإدارية المشتركة', '+', NULL, NULL),
('271', 'Rémunération des Services Techniques Partagés', 'تعويض  الخدمات التقنية المشترك', '+', NULL, NULL),
('272', 'Indemnités  des services techniques communs', 'تعويض الخدمات التقنية', '+', NULL, NULL),
('273', 'Indemnité de soutien aux activités de l\'administration', 'تعويض دعم نشاطات الادارة', '+', NULL, NULL),
('280', 'Indemnisation pour soutien scolaire et traitement pédagogique', 'تعويض الدعم المدرسي والمعالجة البيداغوجية', '+', NULL, NULL),
('290', 'Indemnité de documentation pédagogique', 'تعويض التوثيق التربوي', '+', NULL, NULL),
('301', 'Retenue d\'absence', 'اقتطاع غياب', '-', NULL, NULL),
('302', 'Retenue grève', 'اقتطاع الاضراب', '-', NULL, NULL),
('303', 'Opposition', 'اق.معارضة', '-', NULL, NULL),
('304', 'Retenue  Spc Servi', 'اقتطاع خاص بالمصلحة', '-', NULL, NULL),
('305', 'i.p.s', 'منحة المنصب العالي', '+', NULL, NULL),
('333', 'Prime de Rendement', 'مخلف فارق المردودية', '+', NULL, NULL),
('334', 'Prime de Rendement', 'مخلف فارق المردودیة', '+', NULL, NULL),
('388', 'RETENUE FSR', 'اق.تقاعد', '-', NULL, NULL),
('395', 'Retenue Trésor', 'اقتطاع الخزينة', '-', NULL, NULL),
('396', 'DROIT U.G.T.A', 'ح.إ.ع.ع.ج', '-', NULL, NULL),
('397', 'Retenue coopérative1', 'اقتطاع الخدمات 1', '-', NULL, NULL),
('398', 'Retenue coopérative2', 'اقتطاع الخدمات 2', '-', NULL, NULL),
('399', 'Retenue des œuvres sociales', 'اقتطاع الخدمات الاجتماعية', '-', NULL, NULL),
('401', 'Salaire unique', 'منحة الاجر الوحيد', '+', NULL, NULL),
('402', 'I.P.S.U', 'م.ا.وحيد', '+', NULL, NULL),
('444', 'Heures Supplémentaires', 'Heures Supplémentaires', '+', NULL, NULL),
('610', 'Retenue  Sécurité sociale', 'اقتطاع الضمان الاجتماعي', '-', NULL, NULL),
('660', 'Retenue Mutuelle', 'اقتطاع التعاضدية', '-', NULL, NULL),
('980', 'Retenue IRG', 'اقتطاع الضريبة', '-', NULL, NULL),
('990', 'Allocations familiales', 'المنح العائلية', '+', NULL, NULL),
('991', 'Majoration enf >10ans', 'الاطفال > من 10س', '+', NULL, NULL),
('992', 'MAJ A.F 300 DA', 'من 300دج', '+', NULL, NULL),
('999', 'Net à Payer', 'الصافي المدفوع', '-', NULL, NULL),
('XXX', 'Indem IEPP', 'خ. المهنية لبيداغوجية', '+', NULL, NULL);

-- --------------------------------------------------------

--
-- بنية الجدول `invalid_employee_migrations`
--

CREATE TABLE `invalid_employee_migrations` (
  `id` int(11) NOT NULL,
  `ID_MEGRATION` int(11) DEFAULT NULL,
  `MATRI` varchar(50) DEFAULT NULL,
  `CODEFONC` varchar(255) DEFAULT NULL,
  `ADM` varchar(255) DEFAULT NULL,
  `SITFAM` varchar(255) DEFAULT NULL,
  `CATEG` varchar(255) DEFAULT NULL,
  `ECH` varchar(255) DEFAULT NULL,
  `SITPAI` varchar(255) DEFAULT NULL,
  `reason` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `megrations`
--

CREATE TABLE `megrations` (
  `ID_MEGRATION` int(11) UNSIGNED NOT NULL,
  `MONTH` int(11) NOT NULL,
  `LOT` varchar(255) DEFAULT NULL,
  `YEAR` int(11) NOT NULL,
  `STATUS` tinyint(4) NOT NULL DEFAULT 0,
  `nbr_employees` int(11) DEFAULT NULL,
  `total_NETPAI` decimal(14,2) DEFAULT NULL,
  `total_TOTGAIN` decimal(14,2) DEFAULT NULL,
  `total_RETSS` decimal(14,2) DEFAULT NULL,
  `total_PARTSS` decimal(14,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `path` text NOT NULL,
  `log_path` text DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `RUN` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `mouvements`
--

CREATE TABLE `mouvements` (
  `id` int(11) NOT NULL,
  `MATRI` varchar(20) NOT NULL,
  `ESTAB_FROM` int(11) UNSIGNED NOT NULL,
  `ESTAB_TO` int(11) UNSIGNED NOT NULL,
  `STATUS` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- القوادح `mouvements`
--
DELIMITER $$
CREATE TRIGGER `prevent_duplicate_pending` BEFORE INSERT ON `mouvements` FOR EACH ROW BEGIN
    IF NEW.STATUS = 0 THEN
        IF EXISTS (
            SELECT 1 FROM mouvements
            WHERE MATRI = NEW.MATRI
              AND ESTAB_FROM = NEW.ESTAB_FROM
              AND ESTAB_TO = NEW.ESTAB_TO
              AND STATUS = 0
        ) THEN
            SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'هذا الموظف لديه طلب غير منتهي بين نفس المؤسستين.';
        END IF;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- بنية الجدول `mv_megrations`
--

CREATE TABLE `mv_megrations` (
  `id` tinyint(1) NOT NULL,
  `PERIOD_MOUV` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `notes`
--

CREATE TABLE `notes` (
  `id` int(11) NOT NULL,
  `text` text NOT NULL,
  `type` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `permissions`
--

CREATE TABLE `permissions` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `permission_role`
--

CREATE TABLE `permission_role` (
  `permission_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `rappel_grants`
--

CREATE TABLE `rappel_grants` (
  `MATRI` varchar(10) NOT NULL,
  `SEQ` varchar(2) NOT NULL,
  `OLDNEW` varchar(1) NOT NULL,
  `RG` varchar(1) NOT NULL,
  `IND` varchar(3) NOT NULL,
  `ADM` varchar(1) NOT NULL DEFAULT '',
  `BASENBR` decimal(14,2) DEFAULT NULL,
  `TAUX` decimal(14,2) DEFAULT NULL,
  `MONTANT` decimal(14,2) DEFAULT NULL,
  `MFIX` decimal(14,2) DEFAULT NULL,
  `CATEG` varchar(2) DEFAULT NULL,
  `SECT` varchar(1) DEFAULT NULL,
  `ECH` varchar(2) DEFAULT NULL,
  `ID_MEGRATION_RA` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `rappel_grant_dues`
--

CREATE TABLE `rappel_grant_dues` (
  `MATRI` varchar(10) NOT NULL,
  `SEQ` varchar(2) NOT NULL,
  `OLDNEW` varchar(1) DEFAULT NULL,
  `RG` varchar(1) NOT NULL,
  `IND` varchar(3) NOT NULL,
  `ADM` varchar(1) NOT NULL DEFAULT '',
  `BASENBR` decimal(14,2) DEFAULT NULL,
  `TAUX` decimal(14,2) DEFAULT NULL,
  `MONTANT` decimal(14,2) DEFAULT NULL,
  `MFIX` decimal(14,2) DEFAULT NULL,
  `CATEG` varchar(2) DEFAULT NULL,
  `SECT` varchar(1) DEFAULT NULL,
  `ECH` varchar(2) DEFAULT NULL,
  `ID_MEGRATION_RA` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `rappel_megrations`
--

CREATE TABLE `rappel_megrations` (
  `MATRI` varchar(10) NOT NULL,
  `SEQ` varchar(2) NOT NULL,
  `ADM` varchar(1) NOT NULL DEFAULT '',
  `CODEFONC` varchar(6) DEFAULT NULL,
  `DATDEB` date DEFAULT NULL,
  `DATFIN` date DEFAULT NULL,
  `CATEG` varchar(2) DEFAULT NULL,
  `ECH` varchar(2) DEFAULT NULL,
  `TOTGAIN` decimal(14,2) DEFAULT NULL,
  `NBRJ` int(11) DEFAULT NULL,
  `ID_MEGRATION_RA` int(11) NOT NULL,
  `NETPAI` decimal(14,2) DEFAULT NULL,
  `RETSS` decimal(14,2) DEFAULT NULL,
  `PARTSS` decimal(14,2) DEFAULT NULL,
  `NUMCPT` varchar(20) DEFAULT NULL,
  `CLECPT` varchar(2) DEFAULT NULL,
  `NUMSS` varchar(15) DEFAULT NULL,
  `JRABS` decimal(14,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `rappel_rasits`
--

CREATE TABLE `rappel_rasits` (
  `MATRI` varchar(10) NOT NULL,
  `SEQ` varchar(2) NOT NULL,
  `OLDNEW` varchar(1) NOT NULL,
  `ADM` varchar(1) NOT NULL DEFAULT '',
  `SITFAM` varchar(3) DEFAULT NULL,
  `ENF10` varchar(2) DEFAULT NULL,
  `CODEFONC` varchar(6) DEFAULT NULL,
  `CATEG` varchar(2) DEFAULT NULL,
  `ECH` varchar(2) DEFAULT NULL,
  `BRUTSS` decimal(14,2) DEFAULT NULL,
  `RETSS` decimal(14,2) DEFAULT NULL,
  `TOTGAIN` decimal(14,2) DEFAULT NULL,
  `ID_MEGRATION_RA` int(11) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `rappel_reservations`
--

CREATE TABLE `rappel_reservations` (
  `rappel_reservation_id` int(11) NOT NULL,
  `YEAR` int(11) NOT NULL,
  `TITLE` text NOT NULL,
  `STATUS` tinyint(1) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `rappel_reservations_statistics`
--

CREATE TABLE `rappel_reservations_statistics` (
  `id` int(11) NOT NULL,
  `rappel_reservation_id` int(11) NOT NULL,
  `reserved` int(11) NOT NULL,
  `establishment_id` int(11) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 0,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `rappel_reservation_employees`
--

CREATE TABLE `rappel_reservation_employees` (
  `id` int(11) NOT NULL,
  `MATRI` varchar(20) NOT NULL,
  `rappel_reservation_id` int(11) DEFAULT NULL,
  `rappel_type` int(1) DEFAULT NULL,
  `rappel_val` varchar(20) DEFAULT NULL,
  `rappel_date` date DEFAULT NULL,
  `rapeel_notes` varchar(150) DEFAULT NULL,
  `establishment_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `rap_rend_grants`
--

CREATE TABLE `rap_rend_grants` (
  `id` int(11) NOT NULL,
  `MATRI` varchar(10) NOT NULL,
  `SEQ` varchar(2) DEFAULT NULL,
  `OLDNEW` varchar(1) DEFAULT NULL,
  `RG` varchar(1) DEFAULT NULL,
  `IND` varchar(3) DEFAULT NULL,
  `ADM` varchar(1) DEFAULT NULL,
  `BASENBR` decimal(14,2) DEFAULT NULL,
  `TAUX` decimal(14,2) DEFAULT NULL,
  `MONTANT` decimal(14,2) DEFAULT NULL,
  `MFIX` decimal(14,2) DEFAULT NULL,
  `CATEG` varchar(2) DEFAULT NULL,
  `SECT` varchar(1) DEFAULT NULL,
  `ECH` varchar(2) DEFAULT NULL,
  `ID_MEGRATION_RA_RE` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `rap_rend_megrations`
--

CREATE TABLE `rap_rend_megrations` (
  `id` int(11) NOT NULL,
  `MATRI` varchar(10) NOT NULL,
  `SEQ` varchar(2) NOT NULL,
  `ADM` varchar(1) DEFAULT NULL,
  `DATNAIS` date DEFAULT NULL,
  `SITFAM` varchar(3) DEFAULT NULL,
  `ENF10` varchar(2) DEFAULT NULL,
  `CODEFONC` varchar(6) DEFAULT NULL,
  `DATDEB` date DEFAULT NULL,
  `DATFIN` date DEFAULT NULL,
  `NUMSS` varchar(15) DEFAULT NULL,
  `AFFECT` varchar(6) DEFAULT NULL,
  `CATEG` varchar(2) DEFAULT NULL,
  `ECH` varchar(2) DEFAULT NULL,
  `SALBASE` decimal(14,2) DEFAULT NULL,
  `BRUTSS` decimal(14,2) DEFAULT NULL,
  `RETSS` decimal(14,2) DEFAULT NULL,
  `TOTGAIN` decimal(14,2) DEFAULT NULL,
  `RETITS` decimal(14,2) DEFAULT NULL,
  `NETPAI` decimal(14,2) DEFAULT NULL,
  `PARTSS` decimal(14,2) DEFAULT NULL,
  `NBRJ` int(11) DEFAULT NULL,
  `TAUX` decimal(14,4) DEFAULT NULL,
  `JRPRIME` decimal(14,2) DEFAULT NULL,
  `TAUXAF` decimal(14,2) DEFAULT NULL,
  `ID_MEGRATION_RA_RE` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `rap_rend_rasits`
--

CREATE TABLE `rap_rend_rasits` (
  `id` int(11) NOT NULL,
  `MATRI` varchar(10) NOT NULL,
  `SEQ` varchar(2) NOT NULL,
  `OLDNEW` varchar(1) NOT NULL,
  `ADM` varchar(1) DEFAULT NULL,
  `SITFAM` varchar(3) DEFAULT NULL,
  `ENF10` varchar(2) DEFAULT NULL,
  `CODEFONC` varchar(6) DEFAULT NULL,
  `CATEG` varchar(2) DEFAULT NULL,
  `ECH` varchar(2) DEFAULT NULL,
  `INDICE` varchar(4) DEFAULT NULL,
  `SALBASE` decimal(14,2) DEFAULT NULL,
  `TAUX` decimal(14,4) DEFAULT NULL,
  `BRUTSS` decimal(14,2) DEFAULT NULL,
  `RETSS` decimal(14,2) DEFAULT NULL,
  `TOTGAIN` decimal(14,2) DEFAULT NULL,
  `RETITS` decimal(14,2) DEFAULT NULL,
  `NETPAI` decimal(14,2) DEFAULT NULL,
  `TAUXAF` decimal(14,2) DEFAULT NULL,
  `ENFSCO` varchar(2) DEFAULT NULL,
  `ID_MEGRATION_RA_RE` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `ra_megrations`
--

CREATE TABLE `ra_megrations` (
  `ID_MEGRATION_RA` int(11) NOT NULL,
  `YEAR` int(11) NOT NULL,
  `TITLE` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `STATUS` tinyint(1) NOT NULL DEFAULT 0,
  `ACTIVE` tinyint(1) NOT NULL DEFAULT 0,
  `RUN` tinyint(1) NOT NULL DEFAULT 0,
  `LOT` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `path` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `log_path` text CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `nbr_employees` int(11) DEFAULT NULL,
  `total_NETPAI` decimal(14,2) DEFAULT NULL,
  `total_TOTGAIN` decimal(14,2) DEFAULT NULL,
  `total_RETSS` decimal(14,2) DEFAULT NULL,
  `total_PARTSS` decimal(14,2) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `ra_re_megrations`
--

CREATE TABLE `ra_re_megrations` (
  `YEAR` int(11) NOT NULL,
  `TITLE` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `STATUS` tinyint(1) NOT NULL DEFAULT 0,
  `ACTIVE` tinyint(1) NOT NULL DEFAULT 0,
  `RUN` tinyint(1) NOT NULL DEFAULT 0,
  `ID_MEGRATION_RA_RE` int(11) NOT NULL,
  `LOT` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `nbr_employees` int(11) DEFAULT NULL,
  `total_NETPAI` decimal(14,2) DEFAULT NULL,
  `total_TOTGAIN` decimal(14,2) DEFAULT NULL,
  `total_RETSS` decimal(14,2) DEFAULT NULL,
  `total_PARTSS` decimal(14,2) DEFAULT NULL,
  `log_path` text CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `path` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `rendement_reservations`
--

CREATE TABLE `rendement_reservations` (
  `id` int(11) NOT NULL,
  `TRIMESTRE` int(1) NOT NULL,
  `year` int(4) NOT NULL,
  `absTotal` int(11) NOT NULL DEFAULT 90,
  `status` tinyint(1) DEFAULT 0,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `rendement_reservations_statistics`
--

CREATE TABLE `rendement_reservations_statistics` (
  `id` int(11) NOT NULL,
  `rendement_reservations_id` int(11) NOT NULL,
  `reserved` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `establishment_id` int(11) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 0,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `ziroPoint` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `rendement_reservation_employees`
--

CREATE TABLE `rendement_reservation_employees` (
  `id` int(11) NOT NULL,
  `MATRI` varchar(10) NOT NULL,
  `abs` int(11) NOT NULL,
  `point` float DEFAULT NULL,
  `rendement_reservations_id` int(11) NOT NULL,
  `estab_mail_code` varchar(50) DEFAULT NULL,
  `affect` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `rend_megrations`
--

CREATE TABLE `rend_megrations` (
  `MATRI` varchar(10) NOT NULL,
  `SEQ` varchar(2) NOT NULL,
  `ADM` varchar(1) NOT NULL,
  `DATNAIS` date DEFAULT NULL,
  `SITFAM` varchar(3) DEFAULT NULL,
  `ENF10` varchar(2) DEFAULT NULL,
  `CODFONC` varchar(6) DEFAULT NULL,
  `DATENT` date DEFAULT NULL,
  `DATSOR` date DEFAULT NULL,
  `NUMSS` varchar(15) DEFAULT NULL,
  `AFFECT` varchar(6) DEFAULT NULL,
  `CATEG` varchar(2) DEFAULT NULL,
  `ECH` varchar(2) DEFAULT NULL,
  `IEPSECT` varchar(1) DEFAULT NULL,
  `IEPIND` varchar(4) DEFAULT NULL,
  `SALBASE` decimal(14,2) DEFAULT NULL,
  `BRUTSS` decimal(14,2) DEFAULT NULL,
  `RETSS` decimal(14,2) DEFAULT NULL,
  `TOTGAIN` decimal(14,2) DEFAULT NULL,
  `RETITS` decimal(14,2) DEFAULT NULL,
  `NETPAI` decimal(14,2) DEFAULT NULL,
  `PARTSS` decimal(14,2) DEFAULT NULL,
  `TAUX` decimal(14,4) DEFAULT NULL,
  `JRPRIME` decimal(14,2) DEFAULT NULL,
  `JRABS` decimal(14,2) DEFAULT NULL,
  `TAUXAF` decimal(14,2) DEFAULT NULL,
  `TAUXF` decimal(14,2) DEFAULT NULL,
  `MONTF` decimal(14,2) DEFAULT NULL,
  `ID_MEGRATION_RE` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `re_megrations`
--

CREATE TABLE `re_megrations` (
  `ID_MEGRATION_RE` int(11) NOT NULL,
  `TRIMESTRE` int(11) NOT NULL,
  `YEAR` int(11) NOT NULL,
  `STATUS` tinyint(1) NOT NULL DEFAULT 0,
  `ACTIVE` tinyint(4) NOT NULL DEFAULT 0,
  `RUN` tinyint(1) NOT NULL DEFAULT 0,
  `TITLE` text CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `path` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `nbr_employees` int(11) DEFAULT NULL,
  `total_NETPAI` decimal(14,2) DEFAULT NULL,
  `total_TOTGAIN` decimal(14,2) DEFAULT NULL,
  `total_RETSS` decimal(14,2) DEFAULT NULL,
  `total_PARTSS` decimal(14,2) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'manager', '2024-02-06 22:00:00', '2024-02-06 22:00:00'),
(2, 'abs-admin', '2024-10-14 22:00:00', '2024-10-22 12:52:38'),
(3, 'director', '2024-11-05 22:00:00', '2024-11-13 22:00:00'),
(4, 'printer', '2025-11-03 08:35:29', '2025-11-03 08:35:29');

-- --------------------------------------------------------

--
-- بنية الجدول `role_user`
--

CREATE TABLE `role_user` (
  `role_id` int(11) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `role_user`
--

INSERT INTO `role_user` (`role_id`, `user_id`) VALUES
(1, 363),
(1, 389),
(1, 402),
(1, 453),
(1, 463),
(1, 467),
(1, 2449),
(1, 3132),
(1, 3763),
(2, 363),
(2, 2458),
(2, 2473),
(2, 3132),
(3, 351),
(3, 379),
(3, 3132),
(4, 3752),
(4, 3756);

-- --------------------------------------------------------

--
-- بنية الجدول `rw_absences`
--

CREATE TABLE `rw_absences` (
  `MATRI` varchar(10) NOT NULL,
  `start` date NOT NULL,
  `end` date NOT NULL,
  `number` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `id_month` int(11) NOT NULL,
  `description` text NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `tamadres`
--

CREATE TABLE `tamadres` (
  `id` int(11) NOT NULL,
  `ID_MEGRATION_TA` int(11) NOT NULL,
  `MATRI` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `ADM` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `PRENOMA` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `NOMA` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `FAMMILYCHILD` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `NUMBERCHILD` int(11) DEFAULT NULL,
  `AFFECT` int(11) NOT NULL,
  `CODEFONC` int(11) NOT NULL,
  `NOTES` text CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `CATEG` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `ECH` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `SITFAM` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `tamadres_megrations`
--

CREATE TABLE `tamadres_megrations` (
  `MATRI` varchar(10) NOT NULL,
  `SEQ` varchar(2) NOT NULL,
  `ADM` varchar(1) NOT NULL,
  `DATNAIS` date DEFAULT NULL,
  `SITFAM` varchar(3) DEFAULT NULL,
  `ENF10` varchar(2) DEFAULT NULL,
  `CODEFONC` varchar(6) DEFAULT NULL,
  `DATENT` date DEFAULT NULL,
  `DATSOR` date DEFAULT NULL,
  `NUMSS` varchar(15) DEFAULT NULL,
  `AFFECT` varchar(6) DEFAULT NULL,
  `CATEG` varchar(2) DEFAULT NULL,
  `ECH` varchar(2) DEFAULT NULL,
  `BRUTSS` decimal(14,2) DEFAULT NULL,
  `RETSS` decimal(14,2) DEFAULT NULL,
  `TOTGAIN` decimal(14,2) DEFAULT NULL,
  `NETPAI` decimal(14,2) DEFAULT NULL,
  `PARTSS` decimal(14,2) DEFAULT NULL,
  `TAUX` decimal(14,4) DEFAULT NULL,
  `TAUXAF` decimal(14,2) DEFAULT NULL,
  `ENFSCO` varchar(2) DEFAULT NULL,
  `TAUXF` decimal(14,2) DEFAULT NULL,
  `ID_MEGRATION_TA` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `tamadres_reservations`
--

CREATE TABLE `tamadres_reservations` (
  `tamadres_reservation_id` int(11) NOT NULL,
  `YEAR` int(11) NOT NULL,
  `TITLE` text NOT NULL,
  `STATUS` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `tamadres_reservation_employees`
--

CREATE TABLE `tamadres_reservation_employees` (
  `id` int(11) NOT NULL,
  `MATRI` varchar(20) NOT NULL,
  `tamadres_reservation_id` int(11) NOT NULL,
  `NBRCHILDSCO` int(2) DEFAULT NULL,
  `tamadres_notes` varchar(150) DEFAULT NULL,
  `establishment_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `tamadres_reservation_statistics`
--

CREATE TABLE `tamadres_reservation_statistics` (
  `id` int(11) NOT NULL,
  `tamadres_reservation_id` int(11) NOT NULL,
  `establishment_id` int(11) NOT NULL,
  `TOTAL` int(11) NOT NULL,
  `RESERVED` int(11) NOT NULL,
  `STATUS` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `ta_megrations`
--

CREATE TABLE `ta_megrations` (
  `ID_MEGRATION_TA` int(11) NOT NULL,
  `TITLE` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `LOT` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `YEAR` int(11) NOT NULL,
  `RUN` tinyint(1) NOT NULL DEFAULT 0,
  `STATUS` tinyint(1) NOT NULL DEFAULT 0,
  `ACTIVE` tinyint(1) NOT NULL DEFAULT 0,
  `path` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `nbr_employees` int(11) DEFAULT NULL,
  `total_NETPAI` decimal(14,2) DEFAULT NULL,
  `total_TOTGAIN` decimal(14,2) DEFAULT NULL,
  `total_RETSS` decimal(14,2) DEFAULT NULL,
  `total_PARTSS` decimal(14,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `testtabes`
--

CREATE TABLE `testtabes` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `tresor_employees`
--

CREATE TABLE `tresor_employees` (
  `id` int(11) NOT NULL,
  `MATRI` varchar(20) NOT NULL,
  `NIN` varchar(18) DEFAULT NULL,
  `DATNAIS` date DEFAULT NULL,
  `establishment_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `tresor_employees_stat`
--

CREATE TABLE `tresor_employees_stat` (
  `establishment_id` int(11) NOT NULL,
  `TOTAL` int(11) NOT NULL,
  `RESERVED` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_username` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_status` int(11) NOT NULL,
  `user_fullname` varchar(255) NOT NULL,
  `user_profession_code` varchar(255) NOT NULL,
  `user_profession` varchar(255) NOT NULL,
  `user_mobile` varchar(255) DEFAULT NULL,
  `user_email` varchar(255) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `phone` varchar(255) DEFAULT NULL,
  `two_factor_enabled` tinyint(1) NOT NULL DEFAULT 0,
  `two_factor_method` varchar(255) DEFAULT NULL,
  `two_factor_code` varchar(255) DEFAULT NULL,
  `two_factor_expires_at` timestamp NULL DEFAULT NULL,
  `google2fa_secret` varchar(255) DEFAULT NULL,
  `google2fa_enabled` tinyint(1) NOT NULL DEFAULT 0,
  `data_policy_agreement` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `visa`
--

CREATE TABLE `visa` (
  `MATRI` varchar(20) NOT NULL,
  `IND` varchar(3) NOT NULL,
  `NUMVISA` int(10) NOT NULL,
  `DATEVISA` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `visa_info`
--

CREATE TABLE `visa_info` (
  `IND` varchar(3) NOT NULL,
  `LIBIND` varchar(250) NOT NULL,
  `LIBINDA` varchar(250) NOT NULL,
  `SENS` varchar(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absence_reservations`
--
ALTER TABLE `absence_reservations`
  ADD PRIMARY KEY (`absence_reservation_id`);

--
-- Indexes for table `absence_reservation_employees`
--
ALTER TABLE `absence_reservation_employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `adms`
--
ALTER TABLE `adms`
  ADD PRIMARY KEY (`ADM`);

--
-- Indexes for table `cnasemployees`
--
ALTER TABLE `cnasemployees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `MATRI` (`MATRI`),
  ADD KEY `index_search` (`NOMA`,`PRENOMA`,`AFFECT`) USING BTREE;

--
-- Indexes for table `dir_absence_reservations`
--
ALTER TABLE `dir_absence_reservations`
  ADD PRIMARY KEY (`dir_absence_reservation_id`);

--
-- Indexes for table `dir_absence_reservation_employees`
--
ALTER TABLE `dir_absence_reservation_employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ed_megrations`
--
ALTER TABLE `ed_megrations`
  ADD PRIMARY KEY (`ID_MEGRATION`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `MATRI` (`MATRI`),
  ADD KEY `index_search` (`NOMA`,`PRENOMA`,`AFFECT`) USING BTREE;

--
-- Indexes for table `emp_megrations`
--
ALTER TABLE `emp_megrations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `MATRI` (`MATRI`,`ID_MEGRATION`,`ADM`),
  ADD KEY `MATRI_2` (`MATRI`,`ID_MEGRATION`,`ADM`);

--
-- Indexes for table `establishments`
--
ALTER TABLE `establishments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `estab_administration` (`estab_administration`,`estab_office`,`estab_type`),
  ADD KEY `estab_micano` (`estab_micano`),
  ADD KEY `estab_mail_code` (`estab_mail_code`),
  ADD KEY `estab_rawateb_user` (`estab_rawateb_user`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `fonctions`
--
ALTER TABLE `fonctions`
  ADD PRIMARY KEY (`CODEFONC`);

--
-- Indexes for table `grants`
--
ALTER TABLE `grants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ID_MEGRATION` (`ID_MEGRATION`),
  ADD KEY `MATRI` (`MATRI`,`ID_MEGRATION`);

--
-- Indexes for table `grants_new`
--
ALTER TABLE `grants_new`
  ADD PRIMARY KEY (`id`,`ID_MEGRATION`),
  ADD KEY `MATRI` (`MATRI`,`ID_MEGRATION`),
  ADD KEY `ADM` (`ADM`);

--
-- Indexes for table `grant_infos`
--
ALTER TABLE `grant_infos`
  ADD PRIMARY KEY (`IND`);

--
-- Indexes for table `invalid_employee_migrations`
--
ALTER TABLE `invalid_employee_migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `megrations`
--
ALTER TABLE `megrations`
  ADD PRIMARY KEY (`ID_MEGRATION`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mouvements`
--
ALTER TABLE `mouvements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mv_megrations`
--
ALTER TABLE `mv_megrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `rappel_grants`
--
ALTER TABLE `rappel_grants`
  ADD PRIMARY KEY (`MATRI`,`SEQ`,`OLDNEW`,`RG`,`IND`,`ADM`,`ID_MEGRATION_RA`);

--
-- Indexes for table `rappel_grant_dues`
--
ALTER TABLE `rappel_grant_dues`
  ADD PRIMARY KEY (`MATRI`,`SEQ`,`RG`,`IND`,`ADM`,`ID_MEGRATION_RA`);

--
-- Indexes for table `rappel_megrations`
--
ALTER TABLE `rappel_megrations`
  ADD PRIMARY KEY (`MATRI`,`SEQ`,`ADM`,`ID_MEGRATION_RA`);

--
-- Indexes for table `rappel_rasits`
--
ALTER TABLE `rappel_rasits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rappel_reservations`
--
ALTER TABLE `rappel_reservations`
  ADD PRIMARY KEY (`rappel_reservation_id`);

--
-- Indexes for table `rappel_reservations_statistics`
--
ALTER TABLE `rappel_reservations_statistics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rappel_reservation_employees`
--
ALTER TABLE `rappel_reservation_employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rap_rend_grants`
--
ALTER TABLE `rap_rend_grants`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `rap_rend_megrations`
--
ALTER TABLE `rap_rend_megrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rap_rend_rasits`
--
ALTER TABLE `rap_rend_rasits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ra_megrations`
--
ALTER TABLE `ra_megrations`
  ADD PRIMARY KEY (`ID_MEGRATION_RA`);

--
-- Indexes for table `ra_re_megrations`
--
ALTER TABLE `ra_re_megrations`
  ADD PRIMARY KEY (`ID_MEGRATION_RA_RE`);

--
-- Indexes for table `rendement_reservations`
--
ALTER TABLE `rendement_reservations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rendement_reservations_statistics`
--
ALTER TABLE `rendement_reservations_statistics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rendement_reservation_employees`
--
ALTER TABLE `rendement_reservation_employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rend_megrations`
--
ALTER TABLE `rend_megrations`
  ADD PRIMARY KEY (`MATRI`,`ADM`,`ID_MEGRATION_RE`);

--
-- Indexes for table `re_megrations`
--
ALTER TABLE `re_megrations`
  ADD PRIMARY KEY (`ID_MEGRATION_RE`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`role_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tamadres`
--
ALTER TABLE `tamadres`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tamadres_megrations`
--
ALTER TABLE `tamadres_megrations`
  ADD PRIMARY KEY (`MATRI`,`ID_MEGRATION_TA`);

--
-- Indexes for table `tamadres_reservations`
--
ALTER TABLE `tamadres_reservations`
  ADD PRIMARY KEY (`tamadres_reservation_id`);

--
-- Indexes for table `tamadres_reservation_employees`
--
ALTER TABLE `tamadres_reservation_employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tamadres_reservation_statistics`
--
ALTER TABLE `tamadres_reservation_statistics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ta_megrations`
--
ALTER TABLE `ta_megrations`
  ADD PRIMARY KEY (`ID_MEGRATION_TA`);

--
-- Indexes for table `testtabes`
--
ALTER TABLE `testtabes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tresor_employees`
--
ALTER TABLE `tresor_employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tresor_employees_stat`
--
ALTER TABLE `tresor_employees_stat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_username` (`user_username`);

--
-- Indexes for table `visa_info`
--
ALTER TABLE `visa_info`
  ADD PRIMARY KEY (`IND`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absence_reservations`
--
ALTER TABLE `absence_reservations`
  MODIFY `absence_reservation_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `absence_reservation_employees`
--
ALTER TABLE `absence_reservation_employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cnasemployees`
--
ALTER TABLE `cnasemployees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dir_absence_reservations`
--
ALTER TABLE `dir_absence_reservations`
  MODIFY `dir_absence_reservation_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dir_absence_reservation_employees`
--
ALTER TABLE `dir_absence_reservation_employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ed_megrations`
--
ALTER TABLE `ed_megrations`
  MODIFY `ID_MEGRATION` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emp_megrations`
--
ALTER TABLE `emp_megrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `establishments`
--
ALTER TABLE `establishments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `grants`
--
ALTER TABLE `grants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `grants_new`
--
ALTER TABLE `grants_new`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invalid_employee_migrations`
--
ALTER TABLE `invalid_employee_migrations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `megrations`
--
ALTER TABLE `megrations`
  MODIFY `ID_MEGRATION` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mouvements`
--
ALTER TABLE `mouvements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rappel_rasits`
--
ALTER TABLE `rappel_rasits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rappel_reservations`
--
ALTER TABLE `rappel_reservations`
  MODIFY `rappel_reservation_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rappel_reservations_statistics`
--
ALTER TABLE `rappel_reservations_statistics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rappel_reservation_employees`
--
ALTER TABLE `rappel_reservation_employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rap_rend_grants`
--
ALTER TABLE `rap_rend_grants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rap_rend_megrations`
--
ALTER TABLE `rap_rend_megrations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rap_rend_rasits`
--
ALTER TABLE `rap_rend_rasits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ra_megrations`
--
ALTER TABLE `ra_megrations`
  MODIFY `ID_MEGRATION_RA` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ra_re_megrations`
--
ALTER TABLE `ra_re_megrations`
  MODIFY `ID_MEGRATION_RA_RE` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rendement_reservations`
--
ALTER TABLE `rendement_reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rendement_reservations_statistics`
--
ALTER TABLE `rendement_reservations_statistics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rendement_reservation_employees`
--
ALTER TABLE `rendement_reservation_employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `re_megrations`
--
ALTER TABLE `re_megrations`
  MODIFY `ID_MEGRATION_RE` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tamadres`
--
ALTER TABLE `tamadres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tamadres_reservations`
--
ALTER TABLE `tamadres_reservations`
  MODIFY `tamadres_reservation_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tamadres_reservation_employees`
--
ALTER TABLE `tamadres_reservation_employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tamadres_reservation_statistics`
--
ALTER TABLE `tamadres_reservation_statistics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ta_megrations`
--
ALTER TABLE `ta_megrations`
  MODIFY `ID_MEGRATION_TA` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `testtabes`
--
ALTER TABLE `testtabes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tresor_employees`
--
ALTER TABLE `tresor_employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tresor_employees_stat`
--
ALTER TABLE `tresor_employees_stat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- قيود الجداول المُلقاة.
--

--
-- قيود الجداول `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `permission_role_ibfk_1` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `permission_role_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
