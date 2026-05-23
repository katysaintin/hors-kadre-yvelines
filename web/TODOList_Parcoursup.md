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

# OUTIL STATISTIQUE V2

Projet : Hors Kadre — katy.ho.free.fr
Stack : PHP legacy mysql_* sur free.fr, JS vanilla, MySQL

CONTEXTE
========
Le test d'orientation (orientation_test.html + resultat.html) 
génère 6 profils : luffy, eleven, sasuke, steve, wednesday, tanjiro.
La page tendances.html affiche des stats statiques depuis data/profils_stats.json.

OBJECTIF V2
===========
Transformer tendances.html en observatoire participatif.
Les utilisateurs contribuent volontairement leur parcours
pour enrichir les données affichées publiquement.

TABLE SQL À CRÉER
=================
CREATE TABLE tendances_communaute (
  id                  INT AUTO_INCREMENT PRIMARY KEY,
  profil_id           VARCHAR(20),
  departement         VARCHAR(50),
  ville               VARCHAR(100),
  uai_lycee           VARCHAR(10),
  nom_lycee           VARCHAR(150),
  formation_envisagee VARCHAR(50),
  formation_reelle    VARCHAR(50),
  statut              ENUM('lyceen','etudiant','parent','autre'),
  consentement        TINYINT(1) DEFAULT 1,
  created_at          TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

FICHIERS À CRÉER
================
1. formulaire_tendance.php
   - Reçoit profil_id depuis resultat.html (GET)
   - Menus en cascade : département → ville → lycée
     (AJAX depuis lycees_france_ival_2025 existante)
   - Formation envisagée (BUT/BTS/CPGE/Licence/Commerce/PASS/Autre)
   - Formation réelle (même liste + "Pas encore dans le sup")
   - Statut (lycéen/étudiant/parent/autre)
   - Case RGPD obligatoire
   - Soumission → insert dans tendances_communaute
   - Redirect vers tendances.html après validation

2. resultats_communaute.php
   - Affichage public des contributions
   - Croisements : profil × lycée IVAL × formation choisie
   - Requêtes agrégées uniquement (pas de données individuelles)
   - Même charte graphique navy/terra/offwhite

3. Modifier tendances.html
   - Ajouter bouton "Contribuer mon parcours →"
   - Afficher stats temps réel depuis tendances_communaute
     en complément du JSON statique

RÈGLES
======
- Aucune donnée personnelle (nom, email, prénom)
- Consentement explicite obligatoire
- Affichage public = données agrégées uniquement
- Compatible free.fr mysql_*
- Lien avec lycees_france_ival_2025 via uai_lycee
  pour croiser profil × IVAL × formation

CHARTE
======
navy #1B3A6B · terra #C4572A · offwhite #F5F0EB · gold #B8860B
Ton : rassurant, pédagogique, non compétitif

