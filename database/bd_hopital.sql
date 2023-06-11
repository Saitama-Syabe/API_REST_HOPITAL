-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 12 juin 2023 à 00:08
-- Version du serveur : 10.4.27-MariaDB
-- Version de PHP : 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `bd_hopital`
--

DELIMITER $$
--
-- Procédures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `ps_access` (IN `_accessid` VARCHAR(36), IN `_userid` VARCHAR(36), IN `_username` VARCHAR(36), IN `_password` VARCHAR(256), IN `_expiredon` DATETIME, IN `_createdby` VARCHAR(256), IN `_action` VARCHAR(38))  NO SQL BEGIN
    IF (_action = 'Insert') THEN
        INSERT INTO access (accessid, userid, username, password, expiredon, createdby, createdon)
        VALUES (_accessid, _userid, _username, _password, _expiredon, _createdby, UTC_TIMESTAMP);
    END IF;

IF (_action = 'Connect') THEN
        SELECT u.userid, concat( u.nom , ' ', u.prenom) as nomuser, u.codeuser
        FROM access a
        inner join user u on u.userid = a.userid and u.status = 1
        WHERE a.username = _username
          and a.password = _password
          and a.status = 1;
    END IF;
    
    IF (_action = 'UpdateById') THEN
        UPDATE access a SET
            a.username = _username,
            a.password = _password,
            a.expiredon = _expiredon,
            a.updatedby = _createdby,
            a.updatedon = UTC_TIMESTAMP
        WHERE a.accessid = _accessid;
    END IF;

    IF (_action = 'SelectAll') THEN
        SELECT * FROM access WHERE status = 1;
    END IF;
    
    IF (_action = 'SelectById') THEN
        SELECT * FROM access a WHERE a.status = 1 AND a.accessid = _accessid;
    END IF;
    
    IF (_action = 'DeleteById') THEN
        UPDATE access a SET 
            a.status = 0,
            a.deletedby = _createdby,
            a.deletedon = UTC_TIMESTAMP
        WHERE a.accessid = _accessid;
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ps_detailsrdv` (IN `_detailsrdvid` VARCHAR(36), IN `_rdvid` VARCHAR(36), IN `_date` DATETIME, IN `_isfirstrdv` INT, IN `_createdby` VARCHAR(256), IN `_action` VARCHAR(38))  NO SQL BEGIN
    IF (_action = 'Insert') THEN
        INSERT INTO detailsrdv (detailsrdvid, rdvid, date, isfirstrdv, createdby)
        VALUES (_detailsrdvid, _rdvid, _date, _isfirstrdv, _createdby);
    END IF;

    IF (_action = 'UpdateById') THEN
        UPDATE detailsrdv d SET
                            d.rdvid = _rdvid,
                            d.date = _date,
                            d.isfirstrdv = _isfirstrdv,
                            d.updatedby = _createdby,
                            d.updatedon = UTC_TIMESTAMP
        WHERE d.detailsrdvid = _detailsrdvid;
    END IF;
    
    IF (_action = 'SelectAll') THEN
        SELECT * FROM detailsrdv WHERE status = 1;
    END IF;
    
    IF (_action = 'SelectById') THEN
        SELECT * FROM detailsrdv u WHERE u.status = 1 AND u.detailsrdvid = _detailsrdvid;
    END IF;
    
    IF (_action = 'DeleteById') THEN
        UPDATE detailsrdv d SET 
            d.status = 0,
            d.deletedby = _createdby,
            d.deletedon = UTC_TIMESTAMP
        WHERE d.detailsrdvid = _detailsrdvid;
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ps_medecin` (IN `_medecinid` VARCHAR(36), IN `_nom` VARCHAR(255), IN `_prenom` VARCHAR(255), IN `_datenaissance` DATE, IN `_email` VARCHAR(256), IN `_lieuhabitation` VARCHAR(256), IN `_photo` VARCHAR(256), IN `_specialiteid` VARCHAR(256), IN `_createdby` VARCHAR(256), IN `_action` VARCHAR(38))  NO SQL BEGIN
    IF (_action = 'Insert') THEN
        INSERT INTO medecin (medecinid, nom, prenom, datenaissance, email, lieuhabitation, photo, createdby)
        VALUES (_medecinid, _nom, _prenom, _datenaissance, _email, _lieuhabitation, _photo, _createdby );
        
        INSERT INTO specialitemedecin (specialitemedecinid, medecinid, specialiteid, date, createdby)
        VALUES (uuid(), _medecinid, _specialiteid, UTC_TIMESTAMP, _createdby);
    END IF;

    IF (_action = 'UpdateById') THEN
        UPDATE medecin m SET
                                m.nom = _nom,
                                m.prenom = _prenom,
                                m.datenaissance = _datenaissance,
                                m.email = _email,
                                m.lieuhabitation = _lieuhabitation,
                                m.photo = _photo,
                                m.updatedby = _createdby,
                                m.updatedon = UTC_TIMESTAMP
        WHERE m.medecinid = _medecinid;
        UPDATE specialitemedecin s SET
                                       s.status = 0,
                                       s.deletedby = _createdby,
                                       s.deletedon = UTC_TIMESTAMP
        WHERE s.medecinid = _medecinid;
        INSERT INTO specialitemedecin (specialitemedecinid, medecinid, specialiteid, date, createdby)
        VALUES (uuid(), _medecinid, _specialiteid, UTC_TIMESTAMP, _createdby);
    END IF;
    
    IF (_action = 'SelectAll') THEN
        SELECT m.medecinid,
               m.nom,
               m.prenom,
               m.datenaissance,
               m.email,
               m.lieuhabitation,
               m.photo,
               s.libelle as specialite,
               s.specialiteid,
               sm.specialitemedecinid
        FROM medecin m
                 inner join specialitemedecin sm on sm.medecinid = m.medecinid and sm.status = 1
                 inner join specialite s on s.specialiteid = sm.specialiteid and s.status = 1
        WHERE m.status = 1;
    END IF;
    
    IF (_action = 'SelectById') THEN
        SELECT * FROM medecin m WHERE m.status = 1 AND m.medecinid = _medecinid;
    END IF;
    
    IF (_action = 'DeleteById') THEN
        UPDATE medecin m SET 
            m.status = 0,
            m.updatedby = _createdby,
            m.createdon = UTC_TIMESTAMP
        WHERE m.medecinid = _medecinid;
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ps_planningmedecin` (IN `_planningmedecinid` VARCHAR(36), IN `_date` DATETIME, IN `_heuredebut` TIME, IN `_heurefin` TIME, IN `_createdby` VARCHAR(256), IN `_action` VARCHAR(38))  NO SQL BEGIN
    IF (_action = 'Insert') THEN
        INSERT INTO planningmedecin (planningmedecinid, date, heuredebut, heurefin, createdby)
        VALUES (_planningmedecinid, _date, _heuredebut, _heurefin, _createdby);
    END IF;

    IF (_action = 'UpdateById') THEN
        UPDATE planningmedecin p SET
                                p.date = _date,
                                p.heuredebut = _heuredebut,
                                p.heurefin = _heurefin,
                                p.updatedby = _createdby,
                                p.updatedon = UTC_TIMESTAMP
        WHERE p.planningmedecinid = _planningmedecinid;
    END IF;
    
    IF (_action = 'SelectAll') THEN
        SELECT * FROM planningmedecin WHERE status = 1;
    END IF;
    
    IF (_action = 'SelectById') THEN
        SELECT * FROM planningmedecin p WHERE p.status = 1 AND p.planningmedecinid = _planningmedecinid;
    END IF;
    
    IF (_action = 'DeleteById') THEN
        UPDATE planningmedecin p SET 
            p.status = 0, 
            p.heuredebut = _heuredebut, 
            p.heurefin = _heurefin
        WHERE p.planningmedecinid = _planningmedecinid;
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ps_rdv` (IN `_rdvid` VARCHAR(36), IN `_userid` VARCHAR(36), IN `_daterdv` DATETIME, IN `_specialitemedecinid` VARCHAR(256), IN `_createdby` VARCHAR(256), IN `_action` VARCHAR(38))  NO SQL BEGIN
    IF (_action = 'Insert') THEN
        INSERT INTO rdv (rdvid, userid, specialitemedecinid, createdby)
        VALUES (_rdvid, _userid, _specialitemedecinid, _createdby);

        INSERT INTO detailsrdv (detailsrdvid, rdvid, date, isfirstrdv, createdby)
        VALUES (uuid(), _rdvid, _daterdv, 1, _createdby);
    END IF;

    IF (_action = 'UpdateById') THEN
        UPDATE rdv r SET
            r.userid = _userid,
            r.specialitemedecinid = _specialitemedecinid,
            r.updatedby = _createdby,
            r.updatedon = UTC_TIMESTAMP
        WHERE r.rdvid = _rdvid;
    END IF;
    
    IF (_action = 'SelectAll') THEN
        SELECT * FROM rdv WHERE status = 1;
    END IF;
    
    IF (_action = 'SelectById') THEN
        SELECT r.rdvid, r.userid, r.specialitemedecinid,
               m.medecinid , concat(m.nom, ' ' , m.prenom) as medecin ,
               s.libelle as specialite, d.date as daterdv
        FROM rdv r
        inner join specialitemedecin sm on sm.specialitemedecinid = r.specialitemedecinid and sm.status = 1
        inner join medecin m on m.medecinid = sm.medecinid and m.status= 1
        inner join specialite s on s.specialiteid = sm.specialiteid and s.status = 1
        inner join detailsrdv d on d.rdvid = r.rdvid and d.status = 1
        WHERE r.status = 1
          AND r.userid = _userid;
    END IF;
    
    IF (_action = 'DeleteById') THEN
        UPDATE rdv r SET 
            r.status = 0,
            r.deletedby = _createdby,
            r.deletedon = UTC_TIMESTAMP
        WHERE r.rdvid = _rdvid;
        UPDATE detailsrdv dr SET
                         dr.status = 0,
                         dr.deletedby = _createdby,
                         dr.deletedon = UTC_TIMESTAMP
        WHERE dr.rdvid = _rdvid;
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ps_specialite` (IN `_specialiteid` VARCHAR(36), IN `_libelle` VARCHAR(256), IN `_description` VARCHAR(256), IN `_createdby` VARCHAR(256), IN `_action` VARCHAR(38))  NO SQL BEGIN
    IF (_action = 'Insert') THEN
        INSERT INTO specialite (specialiteid, libelle, description, createdby)
        VALUES (_specialiteid, _libelle, _description, _createdby);
    END IF;

    IF (_action = 'UpdateById') THEN
        UPDATE specialite s SET
                         s.libelle = _libelle,
                         s.description = _description,
                         s.updatedby = _createdby,
                         s.updatedon = UTC_TIMESTAMP
        WHERE s.specialiteid = _specialiteid;
    END IF;
    
    IF (_action = 'SelectAll') THEN
        SELECT * FROM specialite WHERE status = 1;
    END IF;
    
    IF (_action = 'SelectById') THEN
        SELECT * FROM specialite s WHERE s.status = 1 AND s.specialiteid = _specialiteid;
    END IF;
    
    IF (_action = 'DeleteById') THEN
        UPDATE specialite s SET
            s.status = 0,
            s.deletedby = _createdby,
            s.deletedon = UTC_TIMESTAMP
        WHERE s.specialiteid = _specialiteid;
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ps_specialitemedecin` (IN `_specialitemedecinid` VARCHAR(36), IN `_medecinid` VARCHAR(36), IN `_specialiteid` VARCHAR(36), IN `_date` DATETIME, IN `_createdby` VARCHAR(256), IN `_action` VARCHAR(38))  NO SQL BEGIN
    IF (_action = 'Insert') THEN
        INSERT INTO specialitemedecin (specialitemedecinid, medecinid, specialiteid, date, createdby)
        VALUES (_specialitemedecinid, _medecinid, _specialiteid, _date, _createdby);
    END IF;

    IF (_action = 'UpdateById') THEN
        UPDATE specialitemedecin s SET
                                s.specialiteid = _specialiteid,
                                s.medecinid = _medecinid,
                                s.date = _date,
                                s.updatedby = _createdby,
                                s.updatedon = UTC_TIMESTAMP
        WHERE s.specialitemedecinid = _specialitemedecinid;
    END IF;
    
    IF (_action = 'SelectAll') THEN
        SELECT * FROM specialitemedecin WHERE status = 1;
    END IF;
    
    IF (_action = 'SelectById') THEN
        SELECT * FROM specialitemedecin s WHERE s.status = 1 AND s.specialitemedecinid = _specialitemedecinid;
    END IF;
    
    IF (_action = 'DeleteById') THEN
        UPDATE specialitemedecin s SET
            s.status = 0,
            s.deletedby = _createdby,
            s.deletedon = UTC_TIMESTAMP
        WHERE s.specialitemedecinid = _specialitemedecinid;
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ps_user` (IN `_userid` VARCHAR(36), IN `_nom` VARCHAR(255), IN `_prenom` VARCHAR(255), IN `_datenaissance` DATE, IN `_contact` VARCHAR(20), IN `_email` VARCHAR(255), IN `_lieuhabitation` VARCHAR(255), IN `_photo` VARCHAR(255), IN `_password` VARCHAR(255), IN `_codeuser` VARCHAR(255), IN `_createdby` VARCHAR(36), IN `_action` VARCHAR(100))   begin
	IF (_action = 'Insert') THEN
        INSERT INTO user (userid, nom, prenom, datenaissance, contact, email, lieuhabitation, photo, codeuser, createdby)
        VALUES (_userid, _nom, _prenom, _datenaissance, _contact, _email,_lieuhabitation, _photo, _codeuser, _createdby);
	END IF;
    IF (_action = 'Suscribe') THEN
        INSERT INTO user (userid, nom, prenom, datenaissance, contact, email, lieuhabitation, photo, codeuser, createdby)
        VALUES (_userid, _nom, _prenom, _datenaissance, _contact, _email,_lieuhabitation, _photo, _codeuser, _createdby);
        
        INSERT INTO access (accessid, userid, username, password, expiredon, createdby, createdon)
        VALUES (uuid(), _userid, _contact, _password, UTC_TIMESTAMP, _createdby, UTC_TIMESTAMP);

    END IF;

    IF (_action = 'UpdateById') THEN
        UPDATE user u SET
            u.nom = _nom,
            u.prenom = _prenom,
            u.datenaissance = _datenaissance,
            u.contact = _contact,
            u.email = _email,
            u.lieuhabitation = _lieuhabitation,
            u.photo = _photo,
            u.codeuser = _codeuser,
            u.updatedby = _createdby,
            u.updatedon = UTC_TIMESTAMP
        WHERE u.userid = _userid;
    END IF;
                    
    IF (_action = 'SelectAll') THEN
        SELECT * FROM user WHERE status = 1 and codeuser = 1;
    END IF;
	
    IF (_action = 'SelectById') THEN
        SELECT * FROM user u WHERE u.status = 1 and u.userid = _userid;
    END IF;
	
    IF (_action = 'DeleteById') THEN
		UPDATE user u SET 
		    u.status = 0,
		    u.deletedby = _createdby,
		    u.deletedon = UTC_TIMESTAMP
		WHERE u.userid = _userid;
	END IF;

end$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `access`
--

CREATE TABLE `access` (
  `id` int(11) NOT NULL,
  `accessid` varchar(36) NOT NULL,
  `userid` varchar(36) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `expiredon` datetime NOT NULL,
  `createdon` datetime NOT NULL DEFAULT current_timestamp(),
  `createdby` varchar(36) NOT NULL,
  `updatedon` datetime DEFAULT NULL,
  `updatedby` varchar(36) DEFAULT NULL,
  `deletedon` datetime DEFAULT NULL,
  `deletedby` varchar(36) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `access`
--

INSERT INTO `access` (`id`, `accessid`, `userid`, `username`, `password`, `expiredon`, `createdon`, `createdby`, `updatedon`, `updatedby`, `deletedon`, `deletedby`, `status`) VALUES
(4, '88f0d89a-0884-11ee-9d61-80e82c9e34f4', '7b6b49d4-427f-4a81-df40-29cf7b72d963', '0747400349', '0101', '2023-06-11 18:19:42', '2023-06-11 18:19:42', 'admin', NULL, NULL, NULL, NULL, 1),
(1, 'cacb0442-fec5-11ed-9828-8c1645c858fc', 'e7ad685c-f8c8-11ed-896b-c465163b1ae4', 'admin', 'admin', '2023-05-30 09:34:09', '2023-05-30 08:41:38', 'admin', '2023-05-30 09:34:09', 'admin', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Structure de la table `detailsrdv`
--

CREATE TABLE `detailsrdv` (
  `id` int(11) NOT NULL,
  `detailsrdvid` varchar(36) NOT NULL,
  `rdvid` varchar(36) NOT NULL,
  `date` datetime NOT NULL,
  `isfirstrdv` int(11) NOT NULL,
  `createdon` datetime NOT NULL DEFAULT current_timestamp(),
  `createdby` varchar(36) NOT NULL,
  `updatedon` datetime DEFAULT NULL,
  `updatedby` varchar(36) DEFAULT NULL,
  `deletedon` datetime DEFAULT NULL,
  `deletedby` varchar(36) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `medecin`
--

CREATE TABLE `medecin` (
  `id` int(11) NOT NULL,
  `medecinid` varchar(36) NOT NULL,
  `nom` varchar(256) NOT NULL,
  `prenom` varchar(256) NOT NULL,
  `datenaissance` date NOT NULL,
  `email` varchar(256) NOT NULL,
  `lieuhabitation` varchar(256) NOT NULL,
  `photo` varchar(256) NOT NULL,
  `createdon` datetime NOT NULL DEFAULT current_timestamp(),
  `createdby` varchar(36) NOT NULL,
  `updatedon` datetime DEFAULT NULL,
  `updatedby` varchar(36) DEFAULT NULL,
  `deletedon` datetime DEFAULT NULL,
  `deletedby` varchar(36) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `medecin`
--

INSERT INTO `medecin` (`id`, `medecinid`, `nom`, `prenom`, `datenaissance`, `email`, `lieuhabitation`, `photo`, `createdon`, `createdby`, `updatedon`, `updatedby`, `deletedon`, `deletedby`, `status`) VALUES
(5, '38d80f4b-c958-4c05-a4a9-cc9d3944966f', 'Diabate', 'LAtif', '2014-02-11', 'pgadmin@terebei.com', 'Bingerville', 'diabate.jpg', '2023-06-11 13:53:40', 'admin', '2023-06-11 14:12:27', 'admin', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Structure de la table `planningmedecin`
--

CREATE TABLE `planningmedecin` (
  `id` int(11) NOT NULL,
  `planningmedecinid` varchar(36) NOT NULL,
  `date` date NOT NULL,
  `heuredebut` time NOT NULL,
  `heurefin` time NOT NULL,
  `createdon` datetime NOT NULL DEFAULT current_timestamp(),
  `createdby` varchar(36) NOT NULL,
  `updatedon` datetime DEFAULT NULL,
  `updatedby` varchar(36) DEFAULT NULL,
  `deletedon` datetime DEFAULT NULL,
  `deletedby` varchar(36) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `rdv`
--

CREATE TABLE `rdv` (
  `id` int(11) NOT NULL,
  `rdvid` varchar(36) NOT NULL,
  `userid` varchar(36) NOT NULL,
  `specialitemedecinid` varchar(36) NOT NULL,
  `createdon` datetime NOT NULL DEFAULT current_timestamp(),
  `createdby` varchar(36) NOT NULL,
  `updatedon` datetime DEFAULT NULL,
  `updatedby` varchar(36) DEFAULT NULL,
  `deletedon` datetime DEFAULT NULL,
  `deletedby` varchar(36) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `specialite`
--

CREATE TABLE `specialite` (
  `id` int(11) NOT NULL,
  `specialiteid` varchar(36) NOT NULL,
  `libelle` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `createdon` datetime NOT NULL DEFAULT current_timestamp(),
  `createdby` varchar(36) NOT NULL,
  `updatedon` datetime DEFAULT NULL,
  `updatedby` varchar(36) DEFAULT NULL,
  `deletedon` datetime DEFAULT NULL,
  `deletedby` varchar(36) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `specialite`
--

INSERT INTO `specialite` (`id`, `specialiteid`, `libelle`, `description`, `createdon`, `createdby`, `updatedon`, `updatedby`, `deletedon`, `deletedby`, `status`) VALUES
(6, '40973b30-2b34-4411-b7e7-16042524ad6d', 'Generaliste', 'RAS', '2023-06-11 13:04:08', 'admin', NULL, NULL, NULL, NULL, 1),
(4, '68cb76bc-266d-49e1-cfd5-4bd3c77254ab', 'Dentiste', 'RAS', '2023-06-11 13:03:20', 'admin', NULL, NULL, NULL, NULL, 1),
(5, 'fbc44e9d-24df-46b9-a1ee-2a517cefa1f6', 'Gynecologue', 'RAS', '2023-06-11 13:03:52', 'admin', NULL, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Structure de la table `specialitemedecin`
--

CREATE TABLE `specialitemedecin` (
  `id` int(11) NOT NULL,
  `specialitemedecinid` varchar(36) NOT NULL,
  `medecinid` varchar(36) NOT NULL,
  `specialiteid` varchar(36) NOT NULL,
  `date` datetime NOT NULL,
  `createdon` datetime NOT NULL DEFAULT current_timestamp(),
  `createdby` varchar(36) NOT NULL,
  `updatedon` datetime DEFAULT NULL,
  `updatedby` varchar(36) DEFAULT NULL,
  `deletedon` datetime DEFAULT NULL,
  `deletedby` varchar(36) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `specialitemedecin`
--

INSERT INTO `specialitemedecin` (`id`, `specialitemedecinid`, `medecinid`, `specialiteid`, `date`, `createdon`, `createdby`, `updatedon`, `updatedby`, `deletedon`, `deletedby`, `status`) VALUES
(6, 'fe8efe4e-0861-11ee-9d61-80e82c9e34f4', '38d80f4b-c958-4c05-a4a9-cc9d3944966f', 'fbc44e9d-24df-46b9-a1ee-2a517cefa1f6', '2023-06-11 14:12:27', '2023-06-11 14:12:27', 'admin', NULL, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `userid` varchar(36) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `datenaissance` date NOT NULL,
  `contact` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `lieuhabitation` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `codeuser` varchar(255) NOT NULL,
  `createdon` datetime NOT NULL DEFAULT current_timestamp(),
  `createdby` varchar(36) NOT NULL,
  `updatedon` datetime DEFAULT NULL,
  `updatedby` varchar(36) DEFAULT NULL,
  `deletedon` datetime DEFAULT NULL,
  `deletedby` varchar(36) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `userid`, `nom`, `prenom`, `datenaissance`, `contact`, `email`, `lieuhabitation`, `photo`, `codeuser`, `createdon`, `createdby`, `updatedon`, `updatedby`, `deletedon`, `deletedby`, `status`) VALUES
(10, '7b6b49d4-427f-4a81-df40-29cf7b72d963', 'Aidara ', 'Abdel Aziz', '2023-05-31', '0747400349', 'assitabebe@hotmail.com', 'Bingerville', 'f6d464cb.jpg', '1', '2023-06-11 18:19:42', 'admin', NULL, NULL, NULL, NULL, 1),
(3, 'e7ad685c-f8c8-11ed-896b-c465163b1ae4', 'admin', 'principal', '0000-00-00', '0000000000', 'admin@admin.com', 'admin', 'admin.jpg', '0', '2023-06-03 17:33:27', 'user', NULL, NULL, '2023-06-03 17:37:17', 'user', 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `access`
--
ALTER TABLE `access`
  ADD PRIMARY KEY (`accessid`),
  ADD KEY `access_id_index` (`id`);

--
-- Index pour la table `detailsrdv`
--
ALTER TABLE `detailsrdv`
  ADD PRIMARY KEY (`detailsrdvid`),
  ADD KEY `detailsrdv_id_index` (`id`);

--
-- Index pour la table `medecin`
--
ALTER TABLE `medecin`
  ADD PRIMARY KEY (`medecinid`),
  ADD KEY `medecin_id_index` (`id`);

--
-- Index pour la table `planningmedecin`
--
ALTER TABLE `planningmedecin`
  ADD PRIMARY KEY (`planningmedecinid`),
  ADD KEY `planningmedecin_id_index` (`id`);

--
-- Index pour la table `rdv`
--
ALTER TABLE `rdv`
  ADD PRIMARY KEY (`rdvid`),
  ADD KEY `rdv_id_index` (`id`);

--
-- Index pour la table `specialite`
--
ALTER TABLE `specialite`
  ADD PRIMARY KEY (`specialiteid`),
  ADD KEY `specialite_id_index` (`id`);

--
-- Index pour la table `specialitemedecin`
--
ALTER TABLE `specialitemedecin`
  ADD PRIMARY KEY (`specialitemedecinid`),
  ADD KEY `specialitemedecin_id_index` (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userid`),
  ADD KEY `user_id_index` (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `access`
--
ALTER TABLE `access`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `detailsrdv`
--
ALTER TABLE `detailsrdv`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `medecin`
--
ALTER TABLE `medecin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `planningmedecin`
--
ALTER TABLE `planningmedecin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `rdv`
--
ALTER TABLE `rdv`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `specialite`
--
ALTER TABLE `specialite`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `specialitemedecin`
--
ALTER TABLE `specialitemedecin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
