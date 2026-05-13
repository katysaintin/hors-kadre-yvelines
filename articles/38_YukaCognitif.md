# Partie technique — POC “Yuka Cognitif”

## Objectif technique du POC

Créer un prototype simple permettant de :

* référencer des chaînes, comptes, apps ou contenus numériques ;
* agréger des métadonnées publiques ;
* ajouter des critères qualitatifs ;
* produire un score lisible ;
* afficher une fiche claire façon “Yuka / Nutri-Score cognitif”.

L’objectif n’est pas d’avoir une vérité parfaite, mais un démonstrateur :

> rendre visible la qualité cognitive des contenus numériques.

---

# Stack possible

## Backend

* PHP
* MySQL / MariaDB
* API REST simple
* Cron jobs pour actualiser les données
* éventuellement Python pour classification IA ou traitement texte

## Frontend

* HTML / CSS / JavaScript
* Chart.js pour les graphiques
* DataTables pour les tableaux
* interface responsive mobile-first

## Hébergement

* hébergement mutualisé classique pour MVP
* ou VPS léger
* base MySQL
* cache local pour éviter trop d’appels API

---

# APIs et sources possibles

## 1. YouTube Data API

Permet de récupérer :

* nom de chaîne ;
* description ;
* statistiques ;
* vidéos récentes ;
* titres ;
* descriptions ;
* durée ;
* tags ;
* fréquence de publication ;
* catégories.

Usage possible :

* scoring des chaînes YouTube ;
* détection de clickbait ;
* analyse du rythme de publication ;
* ratio shorts / vidéos longues ;
* analyse sémantique des titres.

---

## 2. Common Sense Media

Base très proche de l’idée.

Peut fournir :

* âge recommandé ;
* violence ;
* sexualité ;
* langage ;
* peur ;
* messages positifs ;
* valeur éducative ;
* qualité du contenu ;
* avis parents / enfants.

Usage possible :

* enrichissement des fiches ;
* base de référence pour films, jeux, apps, chaînes YouTube.

---

## 3. TikTok Research API

Plus limitée, mais utile pour :

* hashtags ;
* métadonnées publiques ;
* tendances ;
* descriptions de vidéos ;
* volumes d’engagement.

Usage possible :

* analyse de tendances ;
* détection de contenus viraux ;
* étude de formats courts.

---

## 4. Instagram / Meta APIs

Accès plus restreint.

Peut permettre selon autorisations :

* comptes publics professionnels ;
* statistiques de posts ;
* descriptions ;
* hashtags ;
* fréquence de publication.

Usage possible :

* analyse de comptes publics ;
* scoring de comptes influenceurs ;
* suivi de thématiques.

---

## 5. Twitch API

Permet de récupérer :

* chaînes ;
* catégories ;
* jeux diffusés ;
* titres de streams ;
* fréquence ;
* nombre de viewers.

Usage possible :

* scoring de contenus live ;
* distinction gaming, discussion, éducation, création.

---

## 6. PEGI / ESRB

Pour les jeux vidéo.

Critères utiles :

* âge ;
* violence ;
* peur ;
* sexualité ;
* langage ;
* achats intégrés ;
* jeux d’argent simulés.

Usage possible :

* enrichir les fiches jeux ;
* comparer score officiel et score cognitif.

---

## 7. IMDb / TMDB

Pour films et séries.

Données utiles :

* âge recommandé ;
* genres ;
* synopsis ;
* mots-clés ;
* parental guides selon disponibilité ;
* popularité.

Usage possible :

* contenus vidéo longs ;
* comparaison entre classification classique et impact émotionnel.

---

# Données à stocker

## Table “contenus”

* id
* type : chaîne, app, film, série, jeu, compte social
* plateforme : YouTube, TikTok, Instagram, Twitch, Netflix, etc.
* nom
* URL
* description
* catégorie
* âge recommandé
* langue
* date d’ajout
* source des données

## Table “scores”

* contenu_id
* score_global
* score_attention
* score_passivité
* score_créativité
* score_éducatif
* score_violence
* score_sexualisation
* score_clickbait
* score_polarisation
* score_publicité
* score_utilité
* score_risque_addictif
* méthode de calcul
* date de calcul

## Table “sources”

* contenu_id
* API utilisée
* données brutes
* date de récupération
* fiabilité
* licence / conditions d’usage

---

# Exemple de scoring simple

## Score positif

* contenu éducatif
* contenu créatif
* format long favorisant l’attention
* faible densité publicitaire
* faible clickbait
* contenu coopératif
* contenu informatif
* diversité des sujets

## Score négatif

* scroll passif
* vidéos très courtes en boucle
* violence répétée
* humiliation
* sexualisation excessive
* peur / choc émotionnel
* polarisation
* titres manipulateurs
* fréquence excessive de publication
* forte incitation à rester connecté

---

# Affichage possible

Chaque fiche pourrait afficher :

## Score global

Exemple :

> B — plutôt sain cognitivement

## Détail

* attention : 72 / 100
* créativité : 80 / 100
* passivité : 35 / 100
* clickbait : 20 / 100
* violence : 10 / 100
* utilité : 75 / 100

## Message vulgarisé

Exemple :

> Cette chaîne semble plutôt créative et éducative. Elle utilise peu de clickbait et favorise des contenus longs. Risque attentionnel modéré.

Ou :

> Ce contenu repose fortement sur des vidéos courtes, émotionnelles et répétitives. Risque élevé de consommation passive.

---

# Classification IA possible

Une IA pourrait aider à classifier :

* titres ;
* descriptions ;
* transcriptions ;
* hashtags ;
* commentaires publics ;
* miniatures si analyse visuelle disponible.

Critères possibles :

* clickbait ;
* anxiété ;
* humiliation ;
* polarisation ;
* langage violent ;
* promesse irréaliste ;
* contenu éducatif ;
* contenu créatif ;
* manipulation émotionnelle.

Mais pour un POC, il vaut mieux garder :

* un modèle simple ;
* explicable ;
* corrigible manuellement.

---

# MVP réaliste

## Version 1

* 100 chaînes YouTube populaires chez les adolescents ;
* récupération via YouTube API ;
* enrichissement manuel ou semi-automatique ;
* scoring simple ;
* fiches publiques ;
* moteur de recherche ;
* comparateur.

## Version 2

* ajout TikTok / Instagram ;
* ajout avis utilisateurs ;
* ajout Common Sense Media ;
* ajout visualisation temps d’usage / type d’usage.

## Version 3

* extension navigateur ;
* application mobile ;
* scan d’URL ;
* score en temps réel ;
* recommandation d’alternatives plus saines.

---

# Précautions importantes

Le score doit être présenté comme :

* indicatif ;
* transparent ;
* discutable ;
* non médical ;
* non moral.

Il faut éviter :

* “bon / mauvais contenu” ;
* culpabilisation ;
* surveillance punitive ;
* biais culturels ;
* notation opaque.

Le bon positionnement :

> outil de littératie cognitive, pas outil de contrôle parental.

---

# Positionnement possible

Nom possible :

* Yuka Cognitif
* Nutri-Score Numérique
* Score Attentionnel
* Boussole Numérique
* WAIS des réseaux sociaux 😅
* Cogniscore
* RésoScore
* AttentionScore

Phrase de concept :

> Tous les temps d’écran ne se valent pas.

Ou :

> Ce n’est pas seulement combien de temps on passe en ligne, c’est ce que notre cerveau y fait.
