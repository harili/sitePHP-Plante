# sitePHP-Plante
Site en PHP : Développement en PHP POO d'un site permettant permettant d'inventorier l'ensemble des bio-agresseurs (maladies et ravageurs) susceptibles de s'attaquer aux différentes plantes existantes. 

## Cahier des charges fonctionnel

### Consultation des informations
Toutes des informations présentes sur la base de données seront accessibles à tous les internautes. Il doit être possible d'afficher pour chaque plante la liste de maladies et de ravageurs qui peuvent l'attaquer. Il doit être possible pour chaque maladie d'afficher la liste des plantes susceptibles de contracter cette maladie, la liste des organes affectés ainsi que la liste des traitements proposés. Il doit être possible pour chaque ravageur d'afficher la liste des plantes susceptibles de subir une attaque, la liste des organes affectés ainsi que la liste des traitements proposés. Il doit être possible, pour chaque bioagresseur et chaque plante susceptible d'être affectée par celui-ci, de consulter la cartographie correspondante (zone et nombre cas constatés).

### Inscription et identification
Les salariés de l'institut Français de Recherche Agronomique autorisés à modifier le contenu de la base de données disposeront d'un login (adresse mail) et d'un mot de passe individuel. Les observateurs disposeront d'un login (adresse mail) et d'un mot de passe individuel et seront uniquement autorisés à saisir, modifier et supprimer leurs observations. Seul le directeur des ressources humaines de l'institut sera autorisé à créer les comptes des utilisateurs autorisés (salariés et observateurs).

### Les Plantes
Les utilisateurs autorisés doivent pouvoir ajouter, modifier ou supprimer des plantes dans la base de données via l'application à développer.Pour chaque plante il doit être possible de sélectionner les maladies et les ravageurs dont elle
peut être victime.

### Les Maladies
Les utilisateurs autorisés doivent pouvoir ajouter, modifier ou supprimer des maladies dans la base de données via l'application à développer. Pour chaque maladie il doit être possible de sélectionner les plantes qui peuvent être sensibles à celle-ci. Pour chaque maladie il doit être possible d'indiquer les organes de la plante qui seront affectés par celle-ci. Pour chaque maladie il doit être possible d'indiquer les traitements proposés.

### Les Ravageurs
Les utilisateurs autorisés doivent pouvoir ajouter, modifier ou supprimer des ravageurs dans la base de données via l'application à développer. Pour chaque ravageur il doit être possible de sélectionner les plantes qui peuvent être attaquées par ceux-ci. Pour chaque ravageur il doit être possible d'indiquer les organes de la plante qui seront
affectés par l'attaque. Pour chaque ravageur il doit être possible d'indiquer les traitements proposés.

### L'épidémiologie
Les utilisateurs autorisés doivent pouvoir consulter, ajouter, modifier ou supprimer leurs observations (infections ou attaques constatées) dans la base de données via l'application à développer.

## Cahier des charges Technique
L'application web disposera en plus de son serveur web, un serveur de base de données.
La solution sera développée avec les outils et méthodes couramment utilisés ci - dessous : 
- Développement en PHP objet.
- Respect du modèle MVC.
- Mise en œuvre du SGBD MySQL pour la gestion des données.



