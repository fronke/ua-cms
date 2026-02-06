# TD 2 : Prise en main de Magento 2

## Installation de l'environnement Magento avec Docker

1. Installer Docker (avec Docker Compose) : https://docs.docker.com/engine/install/ubuntu/

Vérification que Docker est bien installé avec :
```bash
sudo docker run hello-world
docker compose version
```

2. Installer l'environnement Docker Magento de Mark Shust : https://github.com/markshust/docker-magento

Recuperer le token public et privé en suivant ce tuto : https://experienceleague.adobe.com/en/docs/commerce-operations/installation-guide/prerequisites/authentication-keys
On vous demandera les 2 clés à l'etape download

```bash
mkdir -p magento
cd magento

# Download the Docker Compose template:
curl -s https://raw.githubusercontent.com/markshust/docker-magento/master/lib/template | bash

# Copier/remplacer le contenu du fichier compose.dev-linux.yaml dans le fichier compose.dev.yaml

# Download the version of Magento you want to use with:
bin/download community 2.4.8-p3

# Installation de quelques dependances systemes
sudo apt install curl libnss3-tools unzip rsync

# Run the setup installer for Magento
bin/setup magento.test

# Initialize development environment with sample data and dev-related modules:
bin/init

open https://magento.test
```

```
# Pour tout relancer depuis le debut, vous pouvez utiliser bin/removeall juste avant
```


## Configuration de Magento

```
Acces au back
open https://magento.test/admin

# Desactiver la double auth
bin/magento module:disable Magento_AdminAdobeImsTwoFactorAuth Magento_AdminAdobeImsTwoFactorAuth Magento_TwoFactorAuth
bin/magento setup:di:compile

# Username: john.smith
# Password: password123
```

Documentation de la version Commerce : https://experienceleague.adobe.com/en/docs/commerce

* Créer quelques catégories.

* Créer quelques attributs produit.

* Créer quelques articles et les afficher sur le site.

* Créer une homepage avec du contenu statique et des widgets.

* Créer des codes de réduction.

* Configurer des méthodes de livraison et une méthode de paiement.

* Créer un compte client, se connecter et vérifier qu'il est possible de passer une commande, d'utiliser la remise et de laisser un avis.

