# TD 2 : Prise en main de Magento 2

## 1. Installation de l'environnement Magento avec Docker

Installer Docker (avec Docker Compose) : https://docs.docker.com/engine/install/ubuntu/

Vérification que Docker est bien installé avec :
```bash
sudo docker run hello-world
docker compose version
```

Installer l'environnement Docker Magento de Mark Shust : https://github.com/markshust/docker-magento

Avant de commencer, récupérez des tokens (public et privé) qu'on vous demandera à l'étape `bin/download` en suivant ce tuto : https://experienceleague.adobe.com/en/docs/commerce-operations/installation-guide/prerequisites/authentication-keys

Puis exécuter les commandes suivantes une à unes :

```bash
mkdir -p magento
cd magento

# Installation de quelques dependances systemes
sudo apt install curl libnss3-tools unzip rsync

# Download the Docker Compose template:
curl -s https://raw.githubusercontent.com/markshust/docker-magento/master/lib/template | bash

# Copier/remplacer le contenu du fichier compose.dev-linux.yaml dans le fichier compose.dev.yaml
cp compose.dev-linux.yaml compose.dev.yaml

# Download the version of Magento you want to use with:
bin/download community 2.4.8-p3

# Run the setup installer for Magento
bin/setup magento.test

# Il y a souvent un probleme de droit avec le script suivant donc on va lui ajouter des droits d'executions
chmod a+x bin/init

# Initialize development environment with sample data and dev-related modules
bin/init

# Ouverture de la page web Magento (sans certificat SSL, c'est normal 😢)
open https://magento.test
```

### OSKOUR Ça démarre pas
Si vous rencontrez des problèmes et que vous souhaitez relancer l'installation, vous pouvez jouer la commande `bin/removeall`, vider le dossier src (`rm -rf src`) puis repartir à partir de l'étape `bin/download`.

Voici certains des problèmes rencontrés en TD et comment les contourner :

#### Un port est déjà utilisé par une autre application (généralement le 80 ou le 3306)

Avec `sudo ss -tunlp` vous pouvez trouver de quelle application il s'agit. En général, ça sera un serveur web sur le port 80 ou une instance de base de données sur le 3306.
Vous pouvez le stopper de cette façon : `sudo systemctl stop apache2` ou `sudo systemctl stop nginx` ou `sudo systemctl stop mariadb`

#### Bug lors du `bin/download`

Message d'erreur en lien avec l'authentification de Composer et le téléchargement des dépendances. Vous pouvez vérifier ou même supprimer sur votre poste le fichier `~/.composer/auth.json` qui contient vos clés Adobe.
En relancant la commande, les clés vous seront de nouveau demandées.

#### Bug lors du `bin/setup`
Vous rencontrez un message de ce style :
```SQLSTATE[HY000] [2002] php_network_getaddresses: getaddrinfo for db failed: Name or service not known In InstallCommand.php line 284: Parameter validation failed setup:install [...]```.
Il y a a priori un problème d'accès de Magento à la base de données. Je pense que vous pouvez essayer de relancer toute l'installation (soit le conteneur docker de la BDD ne fonctionne pas, soit Magento n'a pas la bonne configuration de connexion).

#### Bug lors du démarage de docker avec Opensearch
Opensearch peut fail sans raison au démarrage à cause d'un timeout. Vous pouvez juste stopper et relancer l'environnement `bin/restart`

#### Bug lors du démarrage ou au chargement d'une page
```Exception #0 (Zend_Db_Adapter_Exception): SQLSTATE[HY000] [2002] php_network_getaddresses: getaddrinfo for db failed: Name or service not known```
Le container db est corrompu, vous pouvez le stopper et le supprimer avec `bin/stop && docker compose rm -f db`

## 2. Configuration de Magento

Pour se connecter au backend, nous devons d'abord désactiver les modules qui gèrent la double authentification, elle ne fonctionnera pas en local.

```bash
# Desactiver la double auth
bin/magento module:disable Magento_AdminAdobeImsTwoFactorAuth Magento_AdminAdobeImsTwoFactorAuth Magento_TwoFactorAuth
bin/magento setup:di:compile
```

Accéder au back en ouvrant l'URL `https://magento.test/admin`

Se connecter avec les identifiants suivants :
```
Username: john.smith
Password: password123
```

Réaliser les étapes suivantes pour prendre en main le back et le front de Magento :

* Créer quelques catégories.

* Créer quelques attributs produit.

* Créer quelques articles et les afficher sur le site.

* Créer une homepage avec du contenu statique et des widgets.

* Créer des codes de réduction.

* Configurer des méthodes de livraison et une méthode de paiement.

* Créer un compte client, se connecter et vérifier qu'il est possible de passer une commande, d'utiliser la remise et de laisser un avis.

> Documentation de la version Commerce : https://experienceleague.adobe.com/en/docs/commerce
