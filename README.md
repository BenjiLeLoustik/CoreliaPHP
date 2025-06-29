# 🚀 CoreliaPHP - Framework Minimal Extensible

**CoreliaPHP** est un micro-framework PHP moderne conçu pour être **extensible**, **lisible** et **modulaire**.  
Cette version initiale contient un **noyau simple mais fonctionnel**, prêt à être enrichi progressivement.

---

## ✅ Fonctionnalités déjà en place

### 1️⃣ Noyau (Kernel)
- ⚙️ Initialise le framework
- 🔁 Gère le cycle de vie HTTP (`Request -> Routing -> Controller -> Response`)
- 🛑 Gère les erreurs de base (fallback automatique si aucun contrôleur)

### 2️⃣ Routeur avec annotations PHP 8+
- 🏷️ Utilisation des attributs PHP 8 : `#[Route(path: "/")]`
- 🔍 Scan automatique des contrôleurs dans `src/Controllers/`
- 🚀 Appelle dynamiquement la méthode correspondant à la route

### 3️⃣ Container de services (ServiceContainer)
- 📦 Permet l'enregistrement et la résolution des services
- 🧠 Instanciation automatique des classes si non enregistrées (fallback)

### 4️⃣ HTTP
- 📥 `Request` : encapsule les données de la requête (GET, POST, etc.)
- 📤 `Response` : permet de retourner du contenu (texte, HTML, JSON)

### 5️⃣ Arborescence du projet

```
/App                  # Cœur du framework (Kernel, Container, HTTP, Routing)
├── Core
│   ├── Container     # Conteneur d'injection de dépendances (Service Container)
│   ├── Http          # Gestion des requêtes HTTP (Request, Response)
│   ├── Routing       # Routeur avec support des attributs PHP 8
│   └── Services      # Services internes du framework
/src                  # Code applicatif personnalisé
├── Controllers       # Contrôleurs utilisateurs avec les routes définies
└── Services          # Services métiers spécifiques à l'application
/public               # Point d'entrée public accessible via le serveur web (index.php)
/Storage              # Stockage des fichiers générés et temporaires
├── cache             # Cache des templates, assets, autres données temporaires
└── logs              # Fichiers de logs du framework
.env                  # Fichier de configuration environnementale
composer.json         # Gestionnaire de dépendances PHP (Composer)
```

---
## 🧪 Tester le Framework

### ▶️ Lancer le serveur local
```
php -S localhost:8000 -t public
```
### 🌐 Naviguer sur

[http://localhost:8000](http://localhost:8000)

Une page d’accueil par défaut vous indique que le framework fonctionne et vous guide pour créer vos premiers contrôleurs.


---

## 🚀 Commandes CLI disponibles

CoreliaPHP inclut une interface en ligne de commande pour automatiser certaines tâches. ⚙️

### 🆕 Création d’un nouveau contrôleur

```
php corelia make:controller Nom
```

- 🆕 Crée un nouveau fichier contrôleur dans `/src/Controllers/NomController.php`
- 🎨 Crée automatiquement la vue associée dans `/Views/Nom/index.ctpl`
- 🌐 Le chemin d’accès HTTP sera `/Nom`
- 📝 Le contrôleur inclut une méthode `index` avec route annotée et rendu de la vue

✅ Félicitations, votre page a bien été créée !

#### 🚀 D’autres commandes CLI seront ajoutées prochainement 

---

## 🛠️ Prochainement

🧩 ~~Ajouter~~ Améliorer le moteur de template `.ctpl`  
📦 Ajouter des modules dans `/Modules`  
🛡️ Ajouter middleware (CSRF, Auth...)  
🗄️ ORM simple avec Entités et Repositories  
🖥️ ~~Ajout~~ d’une CLI pour automatiser les tâches  
🪵 Logger / Fichiers de log  
⚠️ Gestion des erreurs personnalisée  
🤖 Insertion d'une aide IA pour le développeur  
🌗 Ajout d'un switch light/dark pour l'interface
 
---

## 📝 Notes

- 📄 Si aucun contrôleur n’est défini, une page d’accueil s’affiche automatiquement.
- 🧠 Le container instancie automatiquement toute classe valide non enregistrée.
- ⚙️ PHP **8.0** minimum requis.

---

## 📚✍️ Documentation

La documentation complète est en cours de rédaction ✏️📄  
Elle sera bientôt disponible ⏳🚀 pour vous guider dans l’utilisation et l’extension de CoreliaPHP.

---

## 🤝✨ Contribution

🙌 Les contributions sont les bienvenues !  
Merci de lire le fichier `CONTRIBUTING.md` 📖 pour connaître les règles et bonnes pratiques ✅.
