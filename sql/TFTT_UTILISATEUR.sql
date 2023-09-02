
CREATE TABLE `TFTT_UTILISATEUR` (
  `uti_id` int(11) NOT NULL,
  `uti_nom` varchar(50) DEFAULT NULL,
  `uti_prenom` varchar(50) DEFAULT NULL,
  `uti_mail` varchar(100) DEFAULT NULL,
  `uti_tel` varchar(20) DEFAULT NULL,
  `uti_password` varchar(20) DEFAULT NULL,
  `uti_admin` tinyint(1) DEFAULT NULL,
  `DATE_MODIF` datetime DEFAULT NULL,
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

ALTER TABLE `TFTT_UTILISATEUR`
  ADD PRIMARY KEY (`uti_id`);

ALTER TABLE `TFTT_UTILISATEUR`
  MODIFY `uti_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
COMMIT;
