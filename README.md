# Plateforme Web pour Examens en Ligne:
Une plateforme sécurisée pour organiser et gérer des examens en ligne. Ce projet offre des fonctionnalités avancées pour empêcher la tricherie et garantir l'intégrité des examens.

## 🚀 Fonctionnalités principales
- **Authentification des utilisateurs** (administrateurs, enseignants, et étudiants).
- **Création et gestion des examens** par les enseignants.
- **Gestion des sessions** avec des mesures de temps strictes.
- **Surveillance lors des examens** (changement de fenetre, insertion d'une USB ou autre péripherique media).
- **Diversité des choix dans le type d'examen** (normal, canadien,multi-reponse juste)
- **Correction instantanée en considerant le type d'examen**
- **Affichage des notes de chaque étudiant dans son espace personnel** (seulment si le professeur l'approuve)

## 🛠️ Technologies utilisées
- **Framework Backend** : Laravel
- **Base de données** : MySQL
- **Frontend** : HTML, CSS, JavaScript




## 🖥️ Installation et configuration

1. **Clonez le dépôt :**
   git clone [<URL_DU_DEPOT>](https://github.com/Ismail-Bourahou/Laravel-Project.git)

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
