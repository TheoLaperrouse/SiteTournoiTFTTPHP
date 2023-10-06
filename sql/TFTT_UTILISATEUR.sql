CREATE TABLE `TFTT_UTILISATEUR` (
  `uti_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `uti_nom` varchar(50) DEFAULT NULL,
  `uti_prenom` varchar(50) DEFAULT NULL,
  `uti_mail` varchar(100) DEFAULT NULL,
  `uti_tel` varchar(20) DEFAULT NULL,
  `uti_password` varchar(20) DEFAULT NULL,
  `uti_admin` tinyint(1) DEFAULT NULL,
  `DATE_MODIF` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
