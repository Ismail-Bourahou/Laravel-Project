# Plateforme Web pour Examens en Ligne

Une plateforme sécurisée pour organiser et gérer des examens en ligne. Ce projet offre des fonctionnalités avancées pour empêcher la tricherie et garantir l'intégrité des examens.

## 📖 Description
Cette plateforme web, développée avec **Laravel**, permet aux enseignants et aux administrateurs d'organiser des examens en ligne en toute sécurité. Elle intègre des mécanismes anti-tricherie, comme :
- **Surveillance active** (détection des changements d'onglets).
- **Gestion des sessions** avec des mesures de temps strictes.
- **Authentification sécurisée** des candidats.

Le frontend utilise les technologies **HTML**, **CSS**, et **JavaScript** pour offrir une interface utilisateur intuitive et réactive.

## 🚀 Fonctionnalités principales
- **Authentification des utilisateurs** (administrateurs, enseignants, et étudiants).
- **Création et gestion des examens** par les enseignants.
- **Surveillance des examens** avec des alertes en cas de comportement suspect.
- **Support multi-navigateurs** pour une expérience fluide.

## 🛠️ Technologies utilisées
- **Framework Backend** : Laravel
- **Base de données** : MySQL
- **Frontend** : HTML, CSS, JavaScript
- **Autres outils** :
  - **AJAX** pour des interactions dynamiques sans rechargement de page.
  - **Bootstrap** pour un design réactif.
  - **Middleware Laravel** pour la gestion de la sécurité.

## 🖥️ Installation et configuration

1. **Clonez le dépôt :**
   git clone <URL_DU_DEPOT>
   cd <Nom_Dossier_Projet>

2. **Installez les dépendances PHP :**
    composer install

3. **Installez les dépendances frontend :**
    npm install && npm run dev
    
4. **Configurez l'environnement :**
    - Copiez le fichier .env.example et renommez-le en .env :
        cp .env.example .env
    - Remplissez les variables nécessaires, comme les informations de base de données.

5. **Générez la clé de l'application :**
    php artisan key:generate

6. **Mettez à jour la base de données :**
    php artisan migrate

7. **Lancez le serveur local :**
    php artisan serve

    
Accédez à l'application sur http://localhost:8000.

🌟 Contribution
Les contributions sont les bienvenues ! Ouvrez une issue ou une pull request pour signaler un problème ou proposer des améliorations.

📄 Licence
Ce projet est sous licence MIT.
