# Site Internet pour le tournoi Annuel de Thorigné Fouilard

## Technologie et Principe

Utilisation de PHP(MySQL), HTML et JavaScript

Mise à jour d'une base de données à l'aide d'un formulaire PHP.

Le site est disponible à l'adresse https://thorigne-tt.net/tournoi/

Les utilisateurs renseignent les différentes données les concernant, et s'inscrivent ensuite aux différents tableaux du tournoi
Chaque utilisateur a le droit de s'inscrire à deux tableaux par jour, ses points FFTT doivent être inférieur à la limite du tableau auquel il souhaite s'inscrire.

## Déploiement d'un environnement local :

Lancer une stack en local (mySQL, phpMyAdmin, front):
`docker-compose up`

Le phpMyAdmin est disponible à http://localhost:8000

L'accès est possible en utilisant ces logins :
- Utilisateur : user
- Mot de passe : test

Créer les tableaux en exécutant la requête sql dans le fichier `createTableTournoi.sql`

L'application est alors disponible et fonctionnelle sur http://localhost:80

## Clôture des inscriptions

### Export depuis PhpMyAdmin

1. Se connecter à PhpMyAdmin
2. Se rendre dans l'onglet Exporter
3. Mode avancée
4. Custom - display all possible options
5. Décocher les table inutiles pour ne garder que les tables relatives au tournoi 'tableauA' jusqu'à tableauN (Vous pouvez passer par la première ligne du tableau pour ne pas à avoir à tout désélectionner)
6. Changer le format en CSV
7. Renseigner le champ :
  - Lines terminated with -> ';' au lieu de ','

### Modification pour envoi (Python)

1. Enregistrer et renommer l'export en 'thorigne.csv' et le mettre dans le même dossier que le script de modification, à savoir `scripts/python/exportTableaux.py`
2. Installer les dépendances du script : `pip install -r requirements.txt`
3. Lancer le script : `python3 exportTableaux.py` ou `python exportTableaux.py`
4. Récupérer le fichier xlsx, vérifier les informations et envoyer

### Fermeture des inscriptions (FTP)

1. Se connecter via FTP
2. Supprimer /tournoi/inscript.php et /tournoi/index.html
3. Renommer finInscript.html en index.html

