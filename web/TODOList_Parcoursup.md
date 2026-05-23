# TODO PARCOURSUP — VERSION SIMPLE FALC

## ✅ TERMINÉ
- [x] Refaire la page UNAAPE mobile
- [x] Ajouter le sommaire
- [x] Simplifier l’UX
- [x] Ajouter les 4 accès
- [x] Ajouter le bloc “À propos”
- [x] Ajouter Virginie
- [x] Ajouter contact UNAAPE
- [x] Ajouter mention visio possible

---

# 🔵 MAINTENANT

## 1. Vérification finale mobile
À faire sur téléphone.

Checklist :
- [x] Tous les liens fonctionnent
- [x] Les PDF s’ouvrent bien
- [x] Les outils chargent
- [x] Les ancres du sommaire marchent
- [x] Pas de bug Safari
- [x] Pas de texte cassé
- [x] Temps de chargement OK

⚠️ IMPORTANT :
ne PAS refaire le design 😄

---

## 2. Préparer le post FB perso public
Compte : Katy Saintin

Avec :
- ton texte validé
- image navy
- lien UNAAPE unique

---

## 3. Programmer / publier le post
Idéal :
- dimanche soir
OU
- lundi matin / midi

---

## 4. Diffusion groupes FB
Méthode :
- repartager TON post public
- petit message sobre
- pas de copier/coller énorme

Exemple :
> Ressource gratuite créée pour aider les familles à mieux comprendre Parcoursup.  
> Si cela peut aider certains parents 🙂

---

## 5. Cas particulier Café pédagogique
⚠️ PAS un repost.

Faire :
- post séparé
- ton utile
- pas autopromo
- lien direct dans le corps

---

## 6. Observer pendant 48h
Regarder :
- commentaires
- questions récurrentes
- clics
- partages
- demandes parents

⚠️ IMPORTANT :
ne PAS modifier toute la page toutes les 2h 😄

---

# 🔵 PLUS TARD (PAS maintenant)

## 7. Préparer la visio UNAAPE
Plus tard seulement.

Quand :
- questions arrivent
- besoin visible
- intérêt confirmé

---

## 8. Choisir l’outil visio
👉 Zoom Montigny probablement.

---

## 9. Préparer replay + FAQ
Plus tard.

---

# RÈGLE IMPORTANTE

## STOP à :
- nouvelles refontes
- nouvelles idées annexes
- nouveaux outils
- nouveaux designs

## OBJECTIF ACTUEL :
👉 publier
👉 diffuser
👉 observer

# OUTIL STATISTIQUE V2 — VERSION CORRIGÉE

Projet : Hors Kadre — katy.ho.free.fr  
Stack : PHP legacy mysql_* sur free.fr, JS vanilla, MySQL

==================================================
CONTEXTE
==================================================

Le test d’orientation :
- orientation_test.html
- resultat.html

génère 6 profils :
- luffy
- eleven
- sasuke
- steve
- wednesday
- tanjiro

La page tendances.html affiche actuellement :
- des statistiques statiques
- via data/profils_stats.json

==================================================
OBJECTIF V2
==================================================

Transformer tendances.html en :

→ observatoire participatif des parcours post-bac.

Les utilisateurs pourront contribuer volontairement :
- à leur profil
- à leur parcours d’orientation
- à leur formation choisie

afin d’enrichir les statistiques affichées publiquement.

IMPORTANT :
Le ton du projet doit rester :
- pédagogique
- rassurant
- non compétitif
- non anxiogène

L’objectif n’est PAS :
- de classer les élèves
- de définir des “bons profils”
- ni de prédire des métiers

Mais de :
- montrer la diversité des parcours
- rendre visibles plusieurs façons de réussir
- aider les familles à se projeter

==================================================
TABLE SQL
==================================================

CREATE TABLE tendances_communaute (
  id                   INT AUTO_INCREMENT PRIMARY KEY,
  profil_id            VARCHAR(20),
  departement          VARCHAR(50),
  ville                VARCHAR(100),
  uai_lycee            VARCHAR(10),
  nom_lycee            VARCHAR(150),
  formation_envisagee  VARCHAR(50),
  formation_choisie    VARCHAR(50),
  statut_utilisateur   ENUM('lyceen','etudiant','parent','autre'),
  consentement         TINYINT(1) DEFAULT 1,
  created_at           TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

==================================================
FICHIERS À CRÉER
==================================================

1. formulaire_tendance.php
----------------------------------

Objectif :
permettre à l’utilisateur de contribuer son parcours.

Fonctionnement :
- récupération profil_id depuis resultat.html (GET)
- formulaire simple mobile-first
- UX très fluide

CHAMPS :
- département
- ville
- lycée
- formation envisagée
- formation choisie
- statut utilisateur
- consentement RGPD obligatoire

==================================================
IMPORTANT UX
==================================================

Éviter menus cascade lourds.

Préférer :
🔍 recherche lycée autocomplete AJAX

Source :
table existante :
lycees_france_ival_2025

Fonctionnement :
- recherche dynamique nom lycée
- affichage suggestions
- stockage UAI caché

Beaucoup plus simple sur mobile.

==================================================
FORMATIONS
==================================================

Liste :
- BUT
- BTS
- CPGE
- Licence
- PASS
- Commerce
- École ingénieur post-bac
- Alternance
- Autre
- Pas encore dans le supérieur

==================================================
STATUT UTILISATEUR
==================================================

Ne pas utiliser le mot “statut”.

Préférer :

“Vous êtes :”

○ Lycéen  
○ Étudiant  
○ Parent  
○ Autre

==================================================
RGPD
==================================================

Aucune donnée personnelle :
- pas de nom
- pas de prénom
- pas d’email

Consentement obligatoire :

☑ J’accepte que mes réponses soient utilisées
de manière anonyme pour produire des statistiques agrégées.

==================================================
SOUMISSION
==================================================

INSERT INTO tendances_communaute

Puis :
redirect vers :
tendances.html

==================================================
2. resultats_communaute.php
==================================================

Objectif :
affichage public des tendances observées.

UNIQUEMENT données agrégées.

Aucune donnée individuelle affichée.

==================================================
STATISTIQUES À AFFICHER
==================================================

- profil × formation choisie
- profil × type de lycée
- profil × IVAL
- profil × département
- profil × parcours envisagé vs choisi

==================================================
IMPORTANT
==================================================

Le rendu ne doit jamais ressembler à :
- un classement scolaire
- un dashboard administratif
- un outil de notation

Mais plutôt :
- un observatoire pédagogique
- une cartographie des parcours
- un média éducatif interactif

==================================================
3. tendances.html
==================================================

Ajouter :

📊 Contribuer mon parcours

Lien :
formulaire_tendance.php

==================================================
AFFICHAGE
==================================================

Conserver :
- JSON statique existant
- statistiques générales profils

Ajouter :
- statistiques communautaires temps réel
- séparées visuellement

==================================================
CHARTE GRAPHIQUE
==================================================

navy      #1B3A6B
terra     #C4572A
offwhite  #F5F0EB
gold      #B8860B
gray      #555555

Style :
- chaleureux
- éditorial premium
- beaucoup d’espace blanc
- très lisible mobile
- animations discrètes

==================================================
VISION PRODUIT
==================================================

Le projet doit montrer :

→ qu’il existe plusieurs manières de réussir après le lycée
→ que les parcours réels sont variés
→ que les BUT/BTS/Licences ont aussi du sens
→ qu’un “bon élève” n’a pas une seule voie possible

Le projet doit rester :
- humain
- rassurant
- accessible
- non élitiste
- basé sur les données réelles
