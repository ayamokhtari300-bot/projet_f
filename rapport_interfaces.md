# Chapitre : Présentation et Description des Interfaces Utilisateur

Cette section détaille les différentes interfaces graphiques (IHM) développées pour notre application. L'objectif principal lors de la conception de ces interfaces a été de garantir une expérience utilisateur (UX) fluide, intuitive et réactive (Responsive Design).

## 1. Page d'Authentification (Connexion / Inscription)
* **Description :** Point d'entrée sécurisé de l'application. Cette page permet d'authentifier les différents acteurs du système (Agent, Opérateur, Validateur, Administrateur).
* **Composants principaux :**
  * Formulaire de saisie (Email et Mot de passe).
  * Bouton "Se connecter".
  * Lien "Mot de passe oublié".
  * Message d'erreur en cas de saisie incorrecte.

## 2. Tableau de Bord (Dashboard)
* **Description :** Il s'agit de la page d'accueil de l'utilisateur une fois connecté. Elle sert de centre de contrôle et offre une vue d'ensemble sur l'activité du système, adaptée selon le rôle de l'utilisateur.
* **Composants principaux :**
  * **Cartes d'indicateurs (KPIs) :** Affichent des statistiques rapides (ex: nombre de missions en cours, nombre de véhicules disponibles, missions en attente de validation).
  * **Menu de navigation (Sidebar / Navbar) :** Permet d'accéder rapidement aux différents modules (Missions, Véhicules, Profil).
  * **Système de Notifications :** Une icône permettant à l'utilisateur de lire ses notifications récentes.

## 3. Module "Gestion des Missions"
Ce module est le coeur de l'application et se compose de plusieurs pages distinctes :

### A. Liste des Missions
* **Description :** Cette page affiche l'ensemble des missions enregistrées dans le système.
* **Composants :** Un tableau dynamique listant les missions (Titre, Destination, Dates, Statut actuel, Agent affecté). Chaque ligne possède des boutons d'actions (Voir, Modifier, Supprimer, Envoyer au Validateur, Affecter un véhicule) dont l'affichage dépend des permissions de l'utilisateur (Rôle).

### B. Formulaire de Création / Modification
* **Description :** Interfaces permettant à un opérateur de créer une nouvelle demande de mission ou de mettre à jour une mission existante.
* **Composants :** Un formulaire structuré demandant les informations essentielles telles que la destination, la date de départ, la date de retour, le motif de la mission, et la sélection dynamique d'accompagnateurs.

### C. Détails et Décision de la Mission
* **Description :** Page affichant les informations exhaustives d'une mission spécifique. C'est sur cette interface que le **Validateur** intervient.
* **Composants :** Résumé des informations de la mission, affichage du véhicule affecté. Pour le rôle Validateur, l'interface présente deux boutons d'action majeurs : **"Valider la mission"** et **"Refuser la mission"**.

## 4. Module "Gestion des Véhicules"
* **Description :** Page dédiée à la consultation et à la gestion de la flotte automobile.
* **Composants principaux :**
  * **Grille de Cartes :** Chaque véhicule est représenté par une carte affichant son matricule, son type et son statut actuel représenté par un badge coloré (Vert pour "Disponible", Rouge pour "Indisponible").
  * **Action de changement de statut :** Pour les utilisateurs ayant le rôle "Opérateur", un bouton permet de basculer instantanément le statut du véhicule (rendre disponible ou indisponible).

## 5. Gestion du Profil Utilisateur
* **Description :** Espace personnel permettant à chaque utilisateur de gérer son compte.
* **Composants principaux :**
  * Formulaire de mise à jour des informations personnelles (Nom, Email).
  * Formulaire de changement de mot de passe.
