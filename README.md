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

## Export des feuilles de tableau depuis PHPMyAdmin

- Se connecter à PhpMyAdmin
- Aller sur la base de données relative au tableau :
- Exporter
- Format CSV
- Sélectionner les tables
- Afficher les noms de lignes en première ligne
- Utiliser le script `exportTableaux.py`