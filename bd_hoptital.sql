-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 30 mai 2023 à 11:38
-- Version du serveur : 10.4.24-MariaDB
-- Version de PHP : 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `bd_hoptital`
--

DELIMITER $$
--
-- Procédures
--
DROP PROCEDURE IF EXISTS `ps_access`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `ps_access` (IN `_accessid` VARCHAR(36), IN `_userid` VARCHAR(36), IN `_username` VARCHAR(36), IN `_password` VARCHAR(256), IN `_expiredon` DATETIME, IN `_createdby` VARCHAR(256), IN `_action` VARCHAR(38))  NO SQL BEGIN
    IF (_action = 'Insert') THEN
        INSERT INTO access (accessid, userid, username, password, expiredon, createdby, createdon)
        VALUES (_accessid, _userid, _username, _password, _expiredon, _createdby, UTC_TIMESTAMP);
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

DROP PROCEDURE IF EXISTS `ps_detailsrdv`$$
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

DROP PROCEDURE IF EXISTS `ps_medecin`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `ps_medecin` (IN `_medecinid` VARCHAR(36), IN `_nom` VARCHAR(255), IN `_prenom` VARCHAR(255), IN `_datenaissance` DATE, IN `_email` VARCHAR(256), IN `_lieuhabitation` VARCHAR(256), IN `_photo` VARCHAR(256), IN `_createdby` VARCHAR(256), IN `_action` VARCHAR(38))  NO SQL BEGIN
    IF (_action = 'Insert') THEN
        INSERT INTO medecin (medecinid, nom, prenom, datenaissance, email, lieuhabitation, photo, createdby)
        VALUES (_medecinid, _nom, _prenom, _datenaissance, _email, _lieuhabitation, _photo, _createdby );
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
    END IF;
    
    IF (_action = 'SelectAll') THEN
        SELECT * FROM medecin WHERE status = 1;
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

DROP PROCEDURE IF EXISTS `ps_planningmedecin`$$
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

DROP PROCEDURE IF EXISTS `ps_rdv`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `ps_rdv` (IN `_rdvid` VARCHAR(36), IN `_userid` VARCHAR(36), IN `_specialitemedecinid` VARCHAR(256), IN `_createdby` VARCHAR(256), IN `_action` VARCHAR(38))  NO SQL BEGIN
    IF (_action = 'Insert') THEN
        INSERT INTO rdv (rdvid, userid, specialitemedecinid, createdby)
        VALUES (_rdvid, _userid, _dspecialitemedecin, _createdby);
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
        SELECT * FROM rdv r WHERE r.status = 1 AND r.rdvid = _rdvid;
    END IF;
    
    IF (_action = 'DeleteById') THEN
        UPDATE rdv r SET 
            r.status = 0,
            r.deletedby = _createdby,
            r.deletedon = UTC_TIMESTAMP
        WHERE r.rdvid = _rdvid;
    END IF;
END$$

DROP PROCEDURE IF EXISTS `ps_specialite`$$
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

DROP PROCEDURE IF EXISTS `ps_specialitemedecin`$$
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

DROP PROCEDURE IF EXISTS `ps_user`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `ps_user` (IN `_userid` VARCHAR(36), IN `_nom` VARCHAR(255), IN `_prenom` VARCHAR(255), IN `_datenaissance` DATE, IN `_contact` VARCHAR(20), IN `_email` VARCHAR(255), IN `_lieuhabitation` VARCHAR(255), IN `_photo` VARCHAR(255), IN `_codeuser` VARCHAR(255), IN `_createdby` VARCHAR(36), IN `_action` VARCHAR(100))   begin
	IF (_action = 'Insert') THEN
        INSERT INTO user (userid, nom, prenom, datenaissance, contact, email, lieuhabitation, photo, codeuser, createdby)
        VALUES (_userid, _nom, _prenom, _datenaissance, _contact, _email,_lieuhabitation, _photo, _codeuser, _createdby);
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
        SELECT * FROM user WHERE status = 1;
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

DROP TABLE IF EXISTS `access`;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `access`
--

INSERT INTO `access` (`id`, `accessid`, `userid`, `username`, `password`, `expiredon`, `createdon`, `createdby`, `updatedon`, `updatedby`, `deletedon`, `deletedby`, `status`) VALUES
(1, 'cacb0442-fec5-11ed-9828-8c1645c858fc', 'e7ad685c-f8c8-11ed-896b-c465163b1ae4', 'user', '1234', '2023-05-30 09:34:09', '2023-05-30 08:41:38', 'admin', '2023-05-30 09:34:09', 'admin', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Structure de la table `detailsrdv`
--

DROP TABLE IF EXISTS `detailsrdv`;
CREATE TABLE `detailsrdv` (
  `id` int(11) NOT NULL,
  `detailsrdvid` varchar(36) NOT NULL,
  `rdvid` varchar(36) NOT NULL,
  `date` date NOT NULL,
  `isfirstrdv` int(11) NOT NULL,
  `createdon` datetime NOT NULL DEFAULT current_timestamp(),
  `createdby` varchar(36) NOT NULL,
  `updatedon` datetime DEFAULT NULL,
  `updatedby` varchar(36) DEFAULT NULL,
  `deletedon` datetime DEFAULT NULL,
  `deletedby` varchar(36) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `medecin`
--

DROP TABLE IF EXISTS `medecin`;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `planningmedecin`
--

DROP TABLE IF EXISTS `planningmedecin`;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `rdv`
--

DROP TABLE IF EXISTS `rdv`;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `specialite`
--

DROP TABLE IF EXISTS `specialite`;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `specialitemedecin`
--

DROP TABLE IF EXISTS `specialitemedecin`;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `detailsrdv`
--
ALTER TABLE `detailsrdv`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `medecin`
--
ALTER TABLE `medecin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `planningmedecin`
--
ALTER TABLE `planningmedecin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `rdv`
--
ALTER TABLE `rdv`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `specialite`
--
ALTER TABLE `specialite`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `specialitemedecin`
--
ALTER TABLE `specialitemedecin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
