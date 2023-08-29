SET @num_license = 3524012;
INSERT INTO tableauC (`numLicence`, `prenom`, `nom`, `nombrePoints`, `club`) SELECT * FROM tableauA WHERE `numLicence` = @num_license;
DELETE FROM tableauA WHERE `numLicence` = @num_license;