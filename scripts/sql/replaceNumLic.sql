SET @num_license = '3524012';
SET @tableauDepart = 'tableauA';
SET @tableauArrivee = 'tableauC';

SET @sql = '';

SET @sql = CONCAT('
    INSERT INTO ', @tableauArrivee, ' (numLicence, prenom, nom, nombrePoints, club)
    SELECT *
    FROM ', @tableauDepart, '
    WHERE "numLicence" = ''', @num_license, ''';
');

PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @sql = CONCAT('
    DELETE FROM ', @tableauDepart, '
    WHERE "numLicence" = ''', @num_license, ''';
');

PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SELECT 'Transfert effectué avec succès.' AS message;