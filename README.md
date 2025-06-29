# 🚀 CoreliaPHP

CoreliaPHP est un framework PHP moderne, léger ⚖️ et modulaire 🧩, conçu pour simplifier le développement d’applications web 🌐 tout en offrant une grande flexibilité 🔧.

## ⚙️ Caractéristiques principales

- 🛣️ Routing basé sur les annotations PHP8  
- 🖼️ Moteur de templates performant avec fichiers `.ctpl`  
- 🧩 Architecture modulaire avec gestion indépendante des modules et thèmes  
- 🛠️ Interface d’administration par défaut  
- 🌍 Système de traduction internationalisé (i18n)  
- 🔒 Middleware CSRF intégré pour la sécurité  
- ⚙️ Gestion des environnements DEV / PROD via fichier `.env`  
- 🗄️ Système de migrations pour gérer la base de données  
- 💻 CLI complet pour la gestion du framework, modules, thèmes, traductions, migrations, etc.  
- 🤖 Assistant IA intégré pour aider le développeur directement depuis l’interface  

## 🚀 Roadmap détaillé

### 1. Base du Framework

**Objectif :** Poser une fondation solide, propre et extensible

- **⚙️ Kernel**  
  - Initialisation du framework (boot)  
  - Chargement automatique des modules actifs  
  - Gestion du cycle de vie d’une requête HTTP  

- **🔧 Service Container (DI)**  
  - Implémentation d’un conteneur simple pour l’injection de dépendances  
  - Support d’enregistrements et résolution automatique des services  

- **🌐 HTTP**  
  - Classes Request et Response (encapsulation des requêtes/réponses HTTP)  
  - Gestion des en-têtes, corps, méthodes, cookies, sessions  

- **🛣️ Router avec annotations**  
  - Analyse des annotations PHP8 dans les contrôleurs pour définir les routes  
  - Support des méthodes HTTP, paramètres d’URL, contraintes  
  - Gestion d’une collection de routes et matching sur requête entrante  

- **🖼️ Moteur de templates `.ctpl`**  
  - Parser simple des templates  
  - Support des inclusions, variables, boucles, conditions  
  - Système d’extensions permettant d’ajouter des fonctions personnalisées  

- **🎨 Système de rendu**  
  - Méthode `render()` dans les contrôleurs  
  - Chargement des vues dans `/View` organisées par contrôleur  

---

### 2. Architecture et organisation

**Objectif :** Organisation claire, maintenable, modulaire

- Arborescence avec dossiers dédiés :  
  - `/App` : cœur du framework (core, HTTP, routing, services)  
  - `/src` : code applicatif (contrôleurs, services métiers, entités)  
  - `/Modules` : modules autonomes, installables/désinstallables sans modification du core  
  - `/Themes` : gestion des thèmes d’affichage indépendants  

- 💻 CLI principal `php corelia`  
  - Commandes extensibles dynamiquement par modules/thèmes  
  - Chargement automatique des commandes disponibles  

---

### 3. Modules essentiels

- **🛠️ Administration**  
  - Module par défaut avec interface d’administration basique  
  - Gestion utilisateurs, permissions, dashboard simple  

- **🌍 Traductions (i18n)**  
  - Extraction automatique des chaînes `.ctpl`  
  - Gestion des fichiers de langue  
  - Commandes CLI pour lister, supprimer, vérifier les traductions  

- **🎭 Thèmes**  
  - Système de thèmes indépendants  
  - Possibilité d’installer, activer, désactiver via CLI ou interface  
  - Chargement dynamique des vues et assets par thème actif  

- **🤖 IA (Assistant Développeur)**  
  - Module IA intégré dans le back-office ou directement sur le site  
  - Aide contextuelle, suggestions de code, documentation interactive  

---

### 4. Fonctionnalités avancées

- **🛡️ Middleware CSRF**  
  - Protection automatique sur toutes les requêtes modifiant les données (POST, PUT, DELETE)  
  - Injection et vérification de tokens CSRF dans les formulaires et requêtes  

- **📜 Logger**  
  - Système de logs centralisé  
  - Enregistrement des erreurs, événements importants, accès  
  - Support différents niveaux (DEBUG, INFO, ERROR)  

- **⚙️ Environnements DEV/PROD**  
  - Configuration automatique selon fichier `.env`  
  - Affichage d’une page de bienvenue si aucun contrôleur créé  
  - Mode debug détaillé en DEV, minimal en PROD  

---

### 5. Système de migrations

- Interface et classe abstraite pour les migrations  
  - Gestion versionnée avec nommage `Migration_VYYYYMMDDHHMMSS_Description`  
  - Table dédiée dans la base pour suivi des migrations appliquées  

- Commandes CLI pour :  
  - Exécuter les migrations (`migration:run`)  
  - Revenir en arrière (`migration:rollback`)  
  - Afficher l’état (`migration:status`)  

- Intégration avec la couche DB (connexion, requêtes)  

---

### 6. Système CLI complet

- Gestion centralisée des commandes CLI  
- Chargement dynamique des commandes fournies par modules et thèmes  
- Commandes principales prévues :  
  - Gestion des modules (installer, activer, désactiver)  
  - Gestion des thèmes (lister, installer, mettre à jour, supprimer)  
  - Gestion des traductions (extraire, lister, supprimer, vérifier)  
  - Gestion des migrations (run, rollback, status)  
  - Cache (vider, chauffer)  
  - Gestion utilisateurs (création, suppression)  
  - Assistant IA (aide, suggestions)  

---

### 7. Modules complémentaires (optionnels)

- **🗃️ Cache**  
  - Cache fichier, mémoire ou autre backend  
  - Commandes pour vider et chauffer le cache  

- **🌐 API REST**  
  - Gestion des endpoints API  
  - Authentification, gestion des permissions API  

- **📊 Analytics**  
  - Collecte et affichage de statistiques basiques  

- **🔔 Notifications**  
  - Envoi de mails, SMS, notifications push  

- **🎨 Asset Manager**  
  - Gestion centralisée des CSS, JS, minification, versioning  

- **🛒 Marketplace**  
  - Plateforme intégrée pour installer et gérer modules et thèmes tiers  

---

### 8. Tests & Documentation

- ✅ Mise en place de tests unitaires pour le core, modules, commandes  
- 📚 Documentation technique et guide utilisateur  
- 📖 Exemples et tutoriels pour démarrer rapidement 

## 🚀 Installation

```
git clone https://github.com/ton-utilisateur/coreliaphp.git
cd coreliaphp
composer install
```

## 🚀 Première utilisation

- 🔧 Configurez votre base de données dans le fichier `.env`  
- 📂 Créez votre premier contrôleur dans `/src/Controllers`  
- 🎨 Développez vos vues dans `/View`  
- 🚀 Lancez le serveur local PHP ou configurez votre serveur web  
- 🛠️ Utilisez les commandes CLI via `php corelia` pour gérer modules, thèmes, traductions, migrations, etc.

## 📚✍️ Documentation 

La documentation complète est en cours de rédaction ✏️📄 et sera bientôt disponible ⏳🚀.

## 🤝✨ Contribution

🙌 Les contributions sont les bienvenues !  
Merci de lire le fichier `CONTRIBUTING.md` 📖 pour les règles et bonnes pratiques ✅.