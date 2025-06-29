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


CoreliaPHP/
├── App/
│   └── Core/                 → Noyau du framework
│       ├── Container/        → Service container
│       ├── Http/             → Request / Response
│       └── Routing/          → Router + #[Route()]
├── public/                   → Point d’entrée (index.php)
├── src/
│   └── Controllers/          → Vos contrôleurs
├── views/                    → Vues .ctpl si moteur activé
├── storage/                  → Cache, logs (à venir)
├── .env                      → Configuration environnement
├── composer.json             → Autoload PSR-4, dépendances
└── README.txt                → Ce fichier

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

## 🧱 Exemple de contrôleur minimal

---
<?php
namespace Src\Controllers;

use CoreliaPHP\Http\Request;
use CoreliaPHP\Http\Response;
use CoreliaPHP\Routing\Route;

class DefaultController
{
    #[Route(path: "/")]
    public function home(Request $request): Response
    {
        return new Response("Hello world from CoreliaPHP!");
    }
}
?>
---

## 🛠️ Étapes suivantes possibles

- 🧩 Ajouter moteur de template `.ctpl`
- 📦 Ajouter des modules dans `/Modules`
- 🛡️ Ajouter middleware (CSRF, Auth...)
- 🗄️ ORM simple avec Entités et Repositories
- 🖥️ Ajout d’une CLI pour automatiser les tâches
- 🪵 Logger / Fichiers de log
- ⚠️ Gestion des erreurs personnalisée

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
