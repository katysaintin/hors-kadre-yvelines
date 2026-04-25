# HORS KADRE ✦ Notes de session — Avril 2026

*Complément au document IA_Reference.md v3.0*
*À transmettre à un nouveau Claude en même temps que IA_Reference.md*

-----

## ⚠️ CE QUE CE DOCUMENT AJOUTE

`IA_Reference.md` contient la stratégie, la charte et les piliers.  
Ce document contient ce qui s’est passé **dans cette session** — avancements concrets, chiffres réels, décisions prises, fichiers produits, bugs résolus.

-----

## 1. ARTICLES — ÉTAT RÉEL AU 19 AVRIL 2026

### Article 1 — Parcoursup ✅ PUBLIÉ

**URL** : https://blogs.mediapart.fr/katy-ho/blog/150426/parcoursup-ce-que-ni-les-classements-des-lycees-ni-les-enseignants-ne-vous-disent  
**Résultats 24h** : 57 commentaires, 6 partages, 20 réactions — **sans hashtag, sans lien en commentaire**  
**Diffusion** : bouche-à-oreille uniquement  
**Statut** : référence à citer dans tous les articles suivants

### Article 2 — Algorithmes / Réseaux sociaux

**Fichier** : `HorsKadre_Article2_Algorithmes_v2.docx`  
**Statut** : RÉDIGÉ, prêt à publier

### Article 3 — Filières technologiques/professionnelles

**Titre** : *“Si on juge un poisson à sa capacité de grimper aux arbres…”*  
**Fichier** : `HorsKadre_Article3_FilieresProTechno.docx`  
**Statut** : RÉDIGÉ, en attente de 2 témoignages finaux

**Éléments clés de l’article 3 :**

- Citation poisson/arbre : attribuée à Einstein mais probablement Matthew Kelly (2004) → angle “Inception d’Einstein” (mythe dans le mythe = poupée russe)
- Edison renvoyé de l’école à 7 ans
- Données : 87% emploi 18 mois DUT, BUT Info ~1% Orsay, BUT GMP ~2% Cachan, BUT GEII ~6% Cachan
- **81% des bacheliers technologiques** poursuivent dans le supérieur (+4pts en 10 ans)
- **47% des bacheliers professionnels** poursuivent (contre 34% il y a 15 ans) — source DEPP/SIES 2023
- Poisson-chat Darwin = profil atypique qui s’adapte → introduction subtile neurodiversité + HPI féminins caméléons
- Conseil neurosciences : DU Neuroéducation Bordeaux (238 candidatures / 30 places), Canopé parcours neurosciences cognitives
- Encart remerciements : *“Un article n’est jamais fini, il se construit avec vous”*
- **Témoignages en attente de validation** :
  - Dame BUT GMP / fils STI2D (reformulation envoyée)
  - Dame STI2D / BUT Génie Mécanique (reformulation envoyée)

**Témoignage BUT GMP — version reformulée :**

> *“Mon fils souhaitait intégrer un BUT Génie Mécanique. Il s’est retrouvé en concurrence directe avec des élèves de STI2D favorisés par les quotas Parcoursup. Ces quotas avaient été conçus pour corriger une injustice historique réelle — et c’est légitime. Mais des quotas imposés sans accompagnement pédagogique, ce sont des quotas pour la forme. Mon fils a finalement obtenu une place à Toulouse. Loin. Ce n’était pas son choix premier.”*

### Article 4 — Classement IVAL lycées ← NOUVEAU, SESSION COURANTE

**Titre** : *“98% de réussite au bac. Et après ?”*  
**Sous-titre** : *“Ce que les classements de lycées ne montrent pas.”*  
**Fichier** : `HorsKadre_Article4_IVAL_Classement_v2.docx`  
**Statut** : RÉDIGÉ v2, audit ChatGPT intégré, prêt pour publication

**Éléments clés de l’article 4 :**

- Angle central : évolution des effectifs entre Seconde et Terminale = angle mort des classements
- Formule mentions pondérées : `taux_mentions × √(effectif_terminale)` — corrige le biais petits effectifs
- Lien vers article 1 Parcoursup intégré en encart dans le corps du texte
- Lien vers katy.ho.free.fr (outil national) ET katysaintin.github.io/hors-kadre-yvelines (page Yvelines)
- Formulations validées ChatGPT : “dynamique d’effectifs”, “attractivité”, “suggère”, “interroge”
- Formulations à éviter : “fuient”, “prouve”, “sélection volontaire”

-----

## 2. SITE WEB IVAL — ARCHITECTURE COMPLÈTE

### Site principal PHP/MySQL

**URL** : http://katy.ho.free.fr  
**Stack** : PHP 5.3.9 / MySQL 5.7 / Free.fr (legacy)  
**Règle critique** : mysql_* uniquement — pas de PDO (incompatible Free.fr confirmé)  
**Fichiers** : index.php, fiche.php, functions.php, schema.sql, config.php

**Bug connu** : colonne `voie` présente dans fiche.php mais absente du schema.sql original  
**Correctif** : `ALTER TABLE lycees ADD COLUMN voie VARCHAR(50) DEFAULT NULL;`

**Doublons UAI normaux** : plusieurs lycées partagent le même UAI (Général + Professionnel du même établissement). Ex : Breteuil UAI 0781819D = Breteuil Général (IVAL -2, +46 élèves) ET Breteuil Pro (IVAL +8, -12 élèves). Ce sont deux lignes distinctes dans la base — c’est CORRECT.

### Page statique GitHub Pages ← NOUVEAU, SESSION COURANTE

**URL** : https://katysaintin.github.io/hors-kadre-yvelines/  
**Fichier** : `index.html` (HTML statique, zéro PHP, zéro SQL)  
**Données** : 87 lycées Yvelines, toutes données IVAL 2025  
**Fonctionnalités** : filtres nom/ville/statut, tri multi-colonnes, badges colorés, lien fiche officielle ministère  
**HTTPS** : automatique via GitHub Pages ✅  
**Compte GitHub** : katysaintin (même compte que LinkedIn)

**Note frontière LinkedIn/Hors Kadre** : katysaintin est le compte GitHub, mais la page est éditoriale Hors Kadre. La frontière Katy Saintin / Katy Ho reste floue sur GitHub — à surveiller si la notoriété Hors Kadre monte.

-----

## 3. DONNÉES NATIONALES — CHIFFRES CLÉS À RÉUTILISER

Base : **4 360 lycées** France entière, IVAL 2025  
Périmètre article : **2 712 lycées LGT** avec effectif ≥100 élèves en Seconde

|Indicateur                    |Public (2 097)|Privé (615)   |
|------------------------------|--------------|--------------|
|Taux bac moyen                |90,0%         |98,3%         |
|Évolution effectifs moyenne   |-17,2         |-19,8         |
|Taux d’accès 2nde→bac         |77,1%         |85,2%         |
|Paradoxe ≥99% bac & -30 élèves|90 lycées     |**156 lycées**|

**Le chiffre le plus percutant** : les privés représentent **23% de l’échantillon** mais **63% du paradoxe**.

**Retournement clé** :

- Lycées gagnant ≥20 élèves (305) : taux bac moyen **90,7%**
- Lycées perdant ≥50 élèves (433) : taux bac moyen **95,6%**
- Conclusion défendable : *“Plus un lycée perd des élèves en route, plus son taux de réussite est élevé.”*

**Cas extrêmes nationaux** (à utiliser en exemple) :

- Plus forte perte : Lycée des Lumières (Mamoudzou) -200 élèves, 94% bac
- Plus fort gain : Lycée Jean Rostand (Strasbourg) +182 élèves, 89% bac
- Paradoxe le plus frappant : Lycée Marie Curie (Sceaux) -128 élèves, 99% bac, IVAL 0

**Cas Yvelines remarquables** :

- Plus fort gain : Lycée Marie Curie (Versailles) +158 élèves, 96% bac, IVAL -1
- Plus forte perte LGT : Lycée Alain (Le Vésinet) -133 élèves, 98% bac, IVAL -1
- Paradoxe Montigny : St-François d’Assise 100% bac, IVAL 0, **-55 élèves** (228→173)
- Breteuil Général : -2 IVAL, 95% bac, **+46 élèves** (270→316) — attractivité maximale locale

-----

## 4. DÉCISIONS STRATÉGIQUES PRISES EN SESSION

### Publication Hors Kadre — séquence validée

1. **Maintenant** : Article 4 IVAL sur Mediapart + page GitHub Yvelines
1. **Attendre 48-72h** : observer réactions/partages comme preuve sociale
1. **Ensuite** : pitch journalistes — Café Pédagogique en premier (déjà dans les sources article 1)
1. **Suite** : IDF → France (effet boule de neige)

### Pipeline éditorial (inchangé)

```
Rédaction → Claude | Audit → ChatGPT | Repauffinage → Claude | Validation humaine | Publication
```

### Stratégie LinkedIn (Katy Saintin)

- Post LinkedIn sur le site IVAL = légitimité pro double (ingénieure + représentante parents)
- Angle : ingénieure qui partage une découverte de données — pas militante
- Langue : **français** pour ce post (exception — sujet éducation France)
- Max 5 hashtags pertinents
- Question ouverte finale invitant pros éducation et journalistes

### Pitch média — ordre de priorité

1. **Café Pédagogique** — déjà dans sources article 1, couvre exactement ce sujet
1. L’Étudiant / L’Obs Éducation — angle “contre-classement”
1. France Inter / franceinfo Éducation
1. Challenges / Les Échos — angle “IA + données publiques + citoyenne”

### Storytelling page Facebook Hors Kadre — Épisode 2 à créer

L’épisode sur la création du site IVAL est à ajouter à la série de 5 épisodes fondateurs.

**Prompt pour Claude n°3 — Épisode site IVAL :**

> Une ingénieure pose une question à une IA : “Existe-t-il un classement des lycées basé sur les IVAL ?” Réponse : non. L’IA propose d’extraire toutes les données officielles de France. Résultat : une journée complète, deux IA, 4 360 lycées, une base SQL nationale, une page GitHub Pages HTTPS en quelques heures. Ce que des journalistes n’avaient pas fait en 40 ans. E=HK². Ton : factuel, humour discret, autodérision ingénieure, 150-200 mots, non-geek doit comprendre. Lien vers katysaintin.github.io/hors-kadre-yvelines.

-----

## 5. FICHIERS PRODUITS EN SESSION

|Fichier                                     |Contenu                                                                                                 |Statut                   |
|--------------------------------------------|--------------------------------------------------------------------------------------------------------|-------------------------|
|`HorsKadre_Article3_FilieresProTechno.docx` |Article poisson/arbre, conclusion remaniée avec chiffres poursuite études + poisson-chat + remerciements|✅ Prêt                   |
|`HorsKadre_Article4_IVAL_Classement_v2.docx`|Article classement IVAL, données nationales, 2 tableaux Montigny, encart lien article 1                 |✅ Prêt pour audit ChatGPT|
|`index.html`                                |Page statique 87 lycées Yvelines — à uploader sur GitHub en remplacement de l’existant                  |✅ Prêt                   |
|`courrier_sensibilisation_parcoursup.docx`  |Courrier Rectorat (session précédente)                                                                  |✅                        |

-----

## 6. POINTS TECHNIQUES À RETENIR

### Performance site Free.fr si buzz

- Ajouter `LIMIT` + `OFFSET` sur les requêtes SQL (pagination)
- Valider `intval()` sur `$_GET['page']` côté serveur
- Si trafic explose : envisager OVH perso ~3€/mois ou miroir statique complémentaire

### GitHub Pages vs Free.fr

- Free.fr = base SQL vivante, filtres dynamiques, toutes villes France
- GitHub Pages = statique Yvelines seulement, HTTPS automatique, partage sécurisé
- Les deux sont complémentaires — ne pas chercher à les fusionner

### Formulation juridiquement sûre (validée ChatGPT + Claude)

✅ À utiliser : “dynamique d’effectifs”, “attractivité”, “suggère”, “met en évidence”, “interroge”  
❌ À éviter : “fuient”, “prouve que”, “démontre que le système est biaisé”, “sélection volontaire”

-----

## 7. CONTEXTE PERSONNEL — CE QUI N’EST PAS DANS IA_REFERENCE

- En rééducation tendon d’Achille jusqu’à fin juin 2026
- Article 3 filières techno directement nourri par son vécu : experte SCADA unique dans son organisation, parcours DUT → alternance → doctorat en cours
- La page Facebook Hors Kadre est distincte du compte perso FB (deux audiences différentes)
- Le compte GitHub est `katysaintin` — frontière LinkedIn/Hors Kadre floue mais assumée

-----

*Généré le 19 avril 2026 — Session Claude — Complément à IA_Reference.md v3.0*  
*E=HK² — Plus on creuse, plus ça explose.*


---

## SESSION DU 19 AVRIL 2026 — LANCEMENT PAGE FACEBOOK HORS KADRE

### Avancements concrets

- **Page Facebook Hors Kadre** : créée et live ✅
  - Logo HK en photo de profil
  - Bannière : femme asiatique réflexive + E=HK² en bulle de pensée + HORS KADRE + sous-titre + Saïgon-sur-Seine
  - Description : "Hors Kadre - Ce que personne ne dit vraiment, sourcé et vécu"
  - 3 publications au lancement

- **Épisode 1 storytelling** : rédigé, validé, publié ✅
  - Hook : "Tu connais cette personne qui ouvre 47 onglets…"
  - Twist : "Ce que je prenais pour un bug ? C'était mon système d'exploitation."
  - Signature : E=HK² — Ma théorie de la relativité éditoriale. Einstein avait la sienne. 💥
  - Image générée (Copilot) : femme asiatique souriante au milieu d'onglets volants — palette HK ✅
  - Relai profil perso FB : rédigé ✅

- **Épisode 2 storytelling** : rédigé, validé ✅
  - Thème : "J'ai toujours eu un pied dans deux mondes"
  - Ajout clé : informaticiens vs scientifiques (plus précis que hommes/femmes)
  - Hook émotionnel : "je n'avais ma place nulle part"
  - Twist : "C'était mon angle de vue unique"
  - Prompt image généré : femme entre labo scientifique (gauche) et environnement IT (droite), dos à dos ✅

- **Épisode IVAL** : rédigé ✅ (à insérer entre épisode 3 et 4)
  - "Ce que 40 ans de journalistes n'avaient pas fait, on l'a fait en un jour"
  - Lien vers katysaintin.github.io/hors-kadre-yvelines
  - Note : lien exceptionnellement en commentaire (cohérence assumée + humour 😄)

### Décisions éditoriales prises

- **Préfixe titre Mediapart** : "Angle mort :" — validé et intégré dans tous les titres du tableau de bord
- **Chapô Mediapart** : ouvre systématiquement par "Hors Kadre décrypte ce que les médias n'abordent pas."
- **Hashtags Facebook** : 3-5 max (conseil ChatGPT validé)
- **Lien toujours dans le post** — jamais en commentaire (sauf exception IVAL assumée avec humour)
- **E=HK²** intégré comme signature de clôture de chaque épisode storytelling
- **"Détecté" plutôt que "diagnostiqué"** — la neurodiversité n'est pas une maladie
- **"Cerveau Haut Potentiel"** en toutes lettres plutôt que sigle HPI — plus accessible

### Formulations validées

- ✅ "Ce que je prenais pour un bug ? C'était mon système d'exploitation." (épisodes 1 ET 2 en bis)
- ✅ "E=HK² — Ma théorie de la relativité éditoriale. Einstein avait la sienne."
- ✅ "Traduire les angles morts entre les mondes." (signature épisode 2)
- ✅ "Cerveau Haut Potentiel / TDA détecté tardivement — comme la majorité des femmes."

### Données clés

- **Épisode 1 Parcoursup** (référence preuve sociale) : 57 commentaires / 6 partages / 20 réactions / 0 négative — sans hashtag, sans lien en commentaire
- **Neurosciences HPI** (Rex Jung) : connectivité neuronale plus dense → pensée transversale naturelle
- **Stat Facebook emojis** : 1-2 emojis stratégiques = +25% engagement / >4 = pénalisé algo

### Fichiers produits

Aucun .docx cette session — tout en Markdown et posts Facebook directement.

### Pending — prochaine session

- [ ] Publier épisode 2 Facebook + image Copilot
- [ ] Générer image épisode 2 (prompt validé ✅)
- [ ] Rédiger épisodes 3, 4, 5 storytelling
- [ ] Publier article 2 (Algorithmes) sur Mediapart
- [ ] Créer post relai profil perso pour épisode 2
- [ ] Envisager Linktree pour centraliser tous les liens

### Prompts storytelling générés en session

**Prompt image épisode 1 :**
> Flat cartoon illustration. A young woman with long dark hair and Asian features sits at a desk overwhelmed by an explosion of browser tabs flying everywhere. She looks simultaneously stressed and fascinated, slight smile. Navy blue, terracotta, off-white. No text.

**Prompt image épisode 2 :**
> Flat cartoon illustration. A young woman with long dark hair and Asian features stands with one foot on each side of a dividing line. Left: scientific research environment with physics equations, lab equipment (navy blue). Right: IT/computing environment with servers, code screens (terracotta). The two worlds have their backs turned to each other — she faces forward, calm and slightly amused. No text.

---

## SESSION DU 19 AVRIL 2026 — Aidants neurodivergents, Rudy Simone, pitch médias

### Avancements concrets

- **Article #10 — "Et toi, qui prend soin de toi ?"** (Neurodiversité / Aidance)
  - Statut : RÉDIGÉ → version finale v3 corrigée suite analyse ChatGPT
  - Fichier produit : `aidant_naturel_v3_final.md`
  - Corrections intégrées : cadrage "vécu vs science", nuance neurosciences, phrase de portée, généralisations atténuées
  - Complet avec titre Mediapart (78 car.), chapô (397 car.), mots-clés, prompt illustration

- **Synthèse Rudy Simone** — *22 Things a Woman Must Know If She Loves a Man with Asperger's Syndrome*
  - Lecture intégrale du PDF (141 pages, 1558 lignes extraites)
  - Synthèse reformulée en français (22 points + concepts clés + note personnelle)
  - Fichier produit : `synthese_rudy_simone_fr.md`
  - Statut légal vérifié : synthèse reformulée = légal / traduction mot à mot = non

- **Traductions anglaises** des deux articles
  - `article_caregivers_EN.md` — traduction article #10
  - `rudy_simone_reading_EN.md` — traduction synthèse Rudy Simone
  - Usage : liens pour Rudy Simone et Jessica Kingsley Publishers uniquement (pas de publication)

- **Pitch médias** rédigés — 2 versions
  - À Rudy Simone directement (email personnel, anglais)
  - À Jessica Kingsley Publishers / droits (rights@jkp.com, anglais, ISBN inclus)
  - Proposition : adaptation française + coécriture d'un 2e volet (angle aidant neurodivergent lui-même)

- **Pitch Zèbres & Cie** rédigé — 2 versions
  - Destinataires nommés : Céline Lis-Raoux (directrice rédaction) + Claudine Proust (rédactrice en chef santé)
  - Timing recommandé : envoi février/mars pour numéro juin (Journée nationale TDAH 12 juin)

- **Résumé + mots-clés Mediapart** validés pour article #10

### Données clés produites

- 40% des aidants souffrent d'anxiété et dépression (CRAIF)
- 1 000 heures supplémentaires/an pour parents d'enfants autistes (étude suédoise)
- 50% comorbidité TSA/TDAH (INSERM) — argument clé pour pitch JKP
- Zèbres & Cie : 10 000 abonnés, trimestriel, lancé oct. 2024, patronage ministère de la santé
- Rudy Simone contact : help4aspergers.com
- JKP droits : rights@jkp.com

- **Formulations validées :**
  - ✅ "de nombreuses personnes la vivent, souvent en silence" (vs "des milliers")
  - ✅ "mécanismes largement décrits en neurosciences" (vs "réalité mesurable")
  - ✅ "Ce modèle est une simplification utile, pas une équation absolue"
  - ✅ "aidance réciproque dans les systèmes neurodivergents" — à ÉVITER (jargon froid, ne parle pas au lectorat)
  - ✅ Phrase de cadrage intro : "Il part d'une expérience vécue de l'intérieur — pas d'une étude généralisable."

- **Décisions éditoriales actées :**
  - ChatGPT = relecteur rigueur scientifique uniquement, pas rédacteur
  - Articles publiés en français sur Mediapart / versions anglaises = usage externe exclusivement
  - Projet livre explorée : coécriture avec Rudy Simone prioritaire sur écriture solo

### Fichiers produits

| Fichier | Contenu | Statut |
|---|---|---|
| `aidant_naturel_v3_final.md` | Article #10 version finale corrigée + éléments Mediapart | PRÊT À PUBLIER |
| `synthese_rudy_simone_fr.md` | Synthèse 22 points Rudy Simone en français | COMPLET |
| `article_caregivers_EN.md` | Traduction anglaise article #10 | COMPLET |
| `rudy_simone_reading_EN.md` | Traduction anglaise synthèse Rudy Simone | COMPLET |

### Pending — à faire en prochaine session

1. **Publier article #10** sur Mediapart (lien à ajouter au JournalBoard une fois live)
2. **Envoyer pitch à Zèbres & Cie** — après publication Mediapart (lien à inclure)
3. **Envoyer pitch à Rudy Simone** — après publication Mediapart
4. **Envoyer à JKP** (rights@jkp.com) en parallèle
5. **Mettre à jour statut article #10** dans tableau de bord : EN COURS → RÉDIGÉ puis PUBLIÉ
6. **Article #11** (détection tardive femmes HPI/TDA/Autisme) — démarrer plan

### Contexte session

- Document de référence utilisé : HorsKadre_Reference_v2.1 (Word)
- Analyse comparative ChatGPT intégrée et arbitrée
- Repositionnement éditorial confirmé : "vécu structuré + vulgarisation sourcée" — pas essai académique

---
*Mis à jour le 19 avril 2026 — E=HK²*

---

## SESSION DU 19 AVRIL 2026 — LANCEMENT PAGE FACEBOOK HORS KADRE

### Avancements concrets

- **Page Facebook Hors Kadre** : créée et live ✅
  - Logo HK en photo de profil
  - Bannière : femme asiatique réflexive + E=HK² en bulle de pensée + HORS KADRE + sous-titre + Saïgon-sur-Seine
  - Description : "Hors Kadre - Ce que personne ne dit vraiment, sourcé et vécu"
  - 3 publications au lancement

- **Épisode 1 storytelling** : rédigé, validé, publié ✅
  - Hook : "Tu connais cette personne qui ouvre 47 onglets…"
  - Twist : "Ce que je prenais pour un bug ? C'était mon système d'exploitation."
  - Signature : E=HK² — Ma théorie de la relativité éditoriale. Einstein avait la sienne. 💥
  - Image générée (Copilot) : femme asiatique souriante au milieu d'onglets volants — palette HK ✅
  - Relai profil perso FB : rédigé ✅

- **Épisode 2 storytelling** : rédigé, validé ✅
  - Thème : "J'ai toujours eu un pied dans deux mondes"
  - Ajout clé : informaticiens vs scientifiques (plus précis que hommes/femmes)
  - Hook émotionnel : "je n'avais ma place nulle part"
  - Twist : "C'était mon angle de vue unique"
  - Prompt image généré : femme entre labo scientifique (gauche) et environnement IT (droite), dos à dos ✅

- **Épisode IVAL** : rédigé ✅ (à insérer entre épisode 3 et 4)
  - "Ce que 40 ans de journalistes n'avaient pas fait, on l'a fait en un jour"
  - Lien vers katysaintin.github.io/hors-kadre-yvelines
  - Note : lien exceptionnellement en commentaire (cohérence assumée + humour 😄)

### Décisions éditoriales prises

- **Préfixe titre Mediapart** : "Angle mort :" — validé et intégré dans tous les titres du tableau de bord
- **Chapô Mediapart** : ouvre systématiquement par "Hors Kadre décrypte ce que les médias n'abordent pas."
- **Hashtags Facebook** : 3-5 max (conseil ChatGPT validé)
- **Lien toujours dans le post** — jamais en commentaire (sauf exception IVAL assumée avec humour)
- **E=HK²** intégré comme signature de clôture de chaque épisode storytelling
- **"Détecté" plutôt que "diagnostiqué"** — la neurodiversité n'est pas une maladie
- **"Cerveau Haut Potentiel"** en toutes lettres plutôt que sigle HPI — plus accessible

### Formulations validées

- ✅ "Ce que je prenais pour un bug ? C'était mon système d'exploitation." (épisodes 1 ET 2 en bis)
- ✅ "E=HK² — Ma théorie de la relativité éditoriale. Einstein avait la sienne."
- ✅ "Traduire les angles morts entre les mondes." (signature épisode 2)
- ✅ "Cerveau Haut Potentiel / TDA détecté tardivement — comme la majorité des femmes."

### Données clés

- **Épisode 1 Parcoursup** (référence preuve sociale) : 57 commentaires / 6 partages / 20 réactions / 0 négative — sans hashtag, sans lien en commentaire
- **Neurosciences HPI** (Rex Jung) : connectivité neuronale plus dense → pensée transversale naturelle
- **Stat Facebook emojis** : 1-2 emojis stratégiques = +25% engagement / >4 = pénalisé algo

### Fichiers produits

Aucun .docx cette session — tout en Markdown et posts Facebook directement.

### Pending — prochaine session

- [ ] Publier épisode 2 Facebook + image Copilot
- [ ] Générer image épisode 2 (prompt validé ✅)
- [ ] Rédiger épisodes 3, 4, 5 storytelling
- [ ] Publier article 2 (Algorithmes) sur Mediapart
- [ ] Créer post relai profil perso pour épisode 2
- [ ] Envisager Linktree pour centraliser tous les liens

### Prompts storytelling générés en session

**Prompt image épisode 1 :**
> Flat cartoon illustration. A young woman with long dark hair and Asian features sits at a desk overwhelmed by an explosion of browser tabs flying everywhere. She looks simultaneously stressed and fascinated, slight smile. Navy blue, terracotta, off-white. No text.

**Prompt image épisode 2 :**
> Flat cartoon illustration. A young woman with long dark hair and Asian features stands with one foot on each side of a dividing line. Left: scientific research environment with physics equations, lab equipment (navy blue). Right: IT/computing environment with servers, code screens (terracotta). The two worlds have their backs turned to each other — she faces forward, calm and slightly amused. No text.

---

## SESSION DU 20 AVRIL 2026 — Anniversaire : 3 articles + stratégie médias

### Avancements concrets

**Articles finalisés aujourd'hui :**
- **Article #10** — *Aidants neurodivergents* → `HorsKadre_Article10_v3.md` ✅
  - Troubles Dys intégrés (dyslexie, dysorthographie, dyscalculie, dyspraxie, dysphasie)
  - TDI intégré sobrement
  - HPI repositionné : note explicite (évaluation psychométrique ≠ diagnostic clinique)
  - Sources neurosciences ajoutées : Barkley 1997, Capuozzo 2024, Lukito 2020
  - Chiffres DREES 9,3M aidants, 1/3 ne se reconnaît pas, 62% femmes
  - Section conseils pratiques entièrement rédigée (était [À compléter] dans le PDF source)
  - PDF source analysé : `Neurodivergent.pdf` (5 pages, print-to-PDF, texte en images)

- **Article #13** — *IA vs réseaux sociaux* → `HorsKadre_Article13_IA_v5.md` ✅
  - 5 versions successives avec relectures ChatGPT intégrées
  - Angle inédit confirmé : confusion RS/IA non traitée dans médias grand public français
  - Comparatif chiffré RS/IA sourcé : Médiamétrie 2024, OMS 2024, Born AI 2025
  - Section digital twin vs deepfake ajoutée — punchline : *"Un deepfake vole une identité. Un digital twin prolonge la vôtre."*
  - Tableau conformité RGPD des IA (Claude, ChatGPT, Mistral, DeepSeek, Grok) en Markdown
  - Suite promise de l'article biais de négativité — lien éditorial explicite
  - Image validée : `ChatGPT_Image_20_avr__2026__21_09_51.png` (split RS/IA, palette HK)
  - Pitchs médias générés : The Conversation, Numerama, Maddyness, Slate → `HorsKadre_Article13_Pitchs.md`

**PDFs analysés en session :**
- `Algorithmes.pdf` — article #1 publié, références Sean Parker, Skinner, NeuroImage intégrées dans #13
- `BiaisNegativite.pdf` — article #2 publié, références Rick Hanson, Gapminder, score 2,2/12 intégrées dans #13
- `Neurodivergent.pdf` — article #10 source, section conseils complétée

### Données clés produites

**Comparatif RS/IA (prêt à réutiliser) :**
- RS jeunes 15-24 : 3h50/jour internet, 58% RS = ~2h15 scroll (Médiamétrie 2024)
- IA jeunes 18-25 : 93% utilisateurs, 71% gagnent du temps (Born AI 2025)
- OMS 2024 : 11% ados européens usage problématique RS
- Oxford 2024 : "brain rot" mot de l'année

**Formulations validées :**
- ✅ *"Les réseaux sociaux sont conçus pour capter votre attention. L'IA est conçue pour répondre à votre intention."*
- ✅ *"Un deepfake vole une identité. Un digital twin prolonge la vôtre."*
- ✅ *"L'IA ne vous rendra pas stupide. Mais le scroll, oui — et ça, vous l'avez déjà accepté."*
- ✅ *"Le danger n'est pas l'outil. C'est l'absence d'intention."*
- ✅ HPI = "détecté" (pas diagnostiqué) — TDA = "diagnostiqué"
- ✅ Charte visuelle finalisée : Flat/Cartoon (analytique) / Realistic illustration (intime) / Dramatique/grain (dénonciation)

**Chiffres TND confirmés (article #10) :**
- Dyslexie : 5-17% enfants scolarisés
- Dyspraxie/TDC : jusqu'à 6% population générale
- TSA : 1% population, 42% présentent aussi TDAH
- TDAH : 6% enfants, 2,5-3% adultes
- TDI : ~1% population
- 50% des TND ont un second TND, 70% difficultés cognitives persistent adulte

### Fichiers produits

| Fichier | Contenu | Statut |
|---------|---------|--------|
| `HorsKadre_Article10_v3.md` | Article aidants neurodivergents v3 finale | ✅ Prêt à publier |
| `HorsKadre_Article13_IA_v5.md` | Article IA vs RS v5 finale | ✅ Prêt à publier |
| `HorsKadre_Article13_Pitchs.md` | Pitchs The Conversation, Numerama, Maddyness, Slate, LinkedIn FR+EN | ✅ Prêt à envoyer |
| `IA_Reference_charte_visuelle_patch.md` | Patch charte visuelle 3 styles | ✅ À merger GitHub |
| `TodoList_20avril2026.md` | Ce fichier — todo + JournalBoard | ✅ |

### Pending — à faire en prochaine session

1. **[PRIORITÉ 1]** Publier article #9 pHARe sur Mediapart (actualité Evaëlle encore chaude)
2. **[PRIORITÉ 2]** Publier article #13 IA + post LinkedIn FR + EN le même jour
3. **[PRIORITÉ 3]** Publier article #10 Aidants + post Facebook Hors Kadre
4. **[PRIORITÉ 4]** Merger patch charte visuelle dans `IA_Reference.md` sur GitHub
5. **[J+3]** Pitcher Café Pédagogique — pHARe d'abord → `redaction@cafepedagogique.net`
6. **[J+7]** Pitcher The Conversation + Maddyness — article #13
7. **[J+8]** Pitcher Le Monde (Mattea Battaglia) + FCPE — article #9 pHARe
8. **[FUTUR]** Générer v4 article #13 avec vécu 5 jours ✅ fait — publier
9. **[FUTUR]** Article #14 ou suite — à définir en prochaine session

### Prompts LinkedIn générés en session

**FR :**
> En 5 jours plâtrée et en arrêt maladie, j'ai : → Publié 5 articles sur Mediapart (dont un Parcoursup à 57 commentaires sans algo) → Lancé un podcast YouTube SCADA en anglais avec digital twin → Construit un outil national sur 4360 lycées en une journée → Composé 4 chansons dont une sur Spotify → Arrêté spontanément la télé, TikTok, Instagram et Candy Crush. Non pas parce que j'ai de la volonté. Parce que ma dopamine est enfin générée par quelque chose de constructif. Le vrai angle mort du débat IA : on confond réseaux sociaux (conçus pour vous garder passif) et IA conversationnelle (qui attend votre intention). L'un capture votre cerveau. L'autre l'amplifie. → [LIEN MEDIAPART] #IA #SCADA #WomenInTech #CreateurDeContenu

**EN :**
> 5 days. In a cast. On sick leave. → Published 5 articles (one hit 57 comments with zero algorithmic strategy) → Launched a SCADA podcast with a digital twin (@KatyInControl) → Built a national tool covering 4,360 high schools in one day → Composed 4 songs, one now on Spotify → Spontaneously stopped TV, TikTok, Instagram and Candy Crush. Not willpower. Dopamine redirected toward something constructive. The real blind spot in the AI debate: people confuse social media (engineered to keep you passive) with conversational AI (which waits for your intent). One captures your brain. The other amplifies it. #AI #SCADA #WomenInEngineering #KatyInControl
>
> 
---

## SESSION DU 25 AVRIL 2026 — TRILOGIE IA + MEDIUM + DÉPLÂTRAGE LUNDI

### Avancements concrets

**Articles publiés ou finalisés**

- **Article 17** — *"Angle mort : vous avez peur du mauvais outil"* (IA vs RS)
  → PUBLIÉ sur Mediapart ✅
  → Image satirique générée (deux personnages : femme paniquée RS / garçon studieux IA) ✅
  → Post FB épisode 8 programmé (carrousel image satirique + capture ChatGPT 3+3=9) ✅
  → Post LinkedIn publié avec image IA vs RS ✅

- **Article 13** — *"L'IA ne m'a pas rendu la vie plus facile. Elle m'a rendu la vie possible."*
  → PUBLIÉ sur Mediapart ✅
  → Fichier : `13_IA_AuServiceDuHandicap_final.md` ✅
  → Image : `IA_AvantApres.png` avec E=HK² ajouté sous le stylo ✅
  → Post FB épisode 9 rédigé ✅
  → Post LinkedIn bilingue 🇫🇷/🇬🇧 programmé vendredi 8h30 ✅
  → Envoyé à Mission Handicap CEA-Irfu ✅

- **Article IA Pour/Contre** — *"Angle mort : Fais-le toi-même. Tu as une IA."*
  → Fichier : `HorsKadre_ArticleIA_v3_final.md` ✅
  → PRÊT À PUBLIER — en attente témoignage Thomas Galoisy (lundi 28 avril)
  → Image principale : `IA_CreativeOK.png` (3 panneaux : Usage illégal / passif / créatif) ✅
  → Image secondaire : `778F1F6C...png` (Sans IA débordé / Avec IA zen) ✅

**Medium — lancement compte @katy.saintin**

- Compte créé : https://medium.com/@katy.saintin
- Article 1 publié : *"We Are Afraid of the Wrong Tool"*
  → Fichier final : `Medium_Article1_WrongTool_Final.md` ✅
  → Soumission AI Advanced : refusée (trop tôt — compte trop récent)
- Article 2 publié : *"AI Didn't Make My Life Easier — It Made It Possible"*
  → Fichier final : `Medium_Article2_AIpossible_Final.md` ✅
- Article 3 rédigé : *"AI Isn't Cheating. It Reveals Who Was Struggling All Along."*
  → Fichier final : `Medium_Article3_DoItYourself_Final.md` ✅
  → Trilogie Medium cohérente et complète ✅

**Storytelling Facebook — épisodes produits**

| Épisode | Titre | Statut |
|---------|-------|--------|
| 1 | "J'avais 500 000 onglets ouverts" | ✅ PUBLIÉ |
| 2 | "J'ai toujours eu un pied dans deux mondes" | ✅ PUBLIÉ |
| 3 | "Une IA m'a aidée à accoucher d'une idée" | ✅ RÉDIGÉ |
| 4 | "Comment on nomme un blog..." + E=HK² | ✅ RÉDIGÉ |
| 5 | Le manifeste + 57 commentaires + E=HK² | ✅ RÉDIGÉ |
| 8 | IA vs RS — réponse vidéo France TV | 📅 PROGRAMMÉ |
| 9 | IA prothèse cognitive | 📅 PROGRAMMÉ |

**Contact Thomas Galoisy**
- Mail envoyé via ENT Lycée Descartes ✅
- Réponse reçue : en vacances à Trouville jusqu'à dimanche
- Réponse attendue : **lundi 28 avril**
- Section réservée dans article IA Pour/Contre ✅

**Google Analytics — activé 22 avril**

| Site | ID mesure | Stats 48h |
|------|-----------|-----------|
| katy.ho.fr
---

*Mis à jour le 20 avril 2026 — E=HK²*

## SESSION DU 25 AVRIL 2026 — Podcast SCADA Star Wars anglais

### Avancements concrets
- Création complète du concept podcast **Katy in Control** — micro-interviews experts SCADA / TANGO / EPICS
- Liste de questions d'interview originales rédigée (FR + EN) — 16 questions en 4 thèmes
- Email de prise de contact rédigé en 3 versions : FR formel, FR tutoiement, EN friendly
- Script épisode 1 rédigé en anglais : architecture SCADA vulgarisée via analogie Star Wars (Hardware / Bus / Business Logic)
- Script épisode 2 rédigé en anglais : TANGO vs EPICS couche par couche — PV vs Attribute, Channel Access vs CORBA/ZMQ, IOC vs Device Server + Commands
- Correction technique validée : IOC EPICS → PV accessibles **soit en lecture, soit en écriture** (pas les deux simultanément) — à détailler dans un épisode dédié
- Annonce fin épisode 2 : prochain épisode = historique comparé TANGO et EPICS

### Données clés produites
- Signature récurrente validée pour le podcast : **"May the uptime be with you"**
- Analogies Star Wars validées et cohérentes sur 2 épisodes :
  - Droids / Stormtroopers = capteurs / actionneurs
  - Réseau holographique = bus de communication
  - Emperor / Dark Vador = serveur SCADA / superviseur temps réel
  - AT-AT = PLC/automate industriel
  - Alderaan = panne réseau catastrophique
  - Order 66 = commande TANGO déclenchant une séquence complexe
- Distinctions techniques vulgarisées et validées :
  - EPICS : Process Variable (PV) — Channel Access (pub/sub) — IOC (lecture OU écriture)
  - TANGO : Attribute — CORBA (polling) + ZMQ (événementiel) — Device Server + Commands

### Fichiers produits
- Aucun fichier .md ou .docx produit — contenu généré directement en session chat

### Pending — à faire en prochaine session
1. Script épisode 3 : **historique comparé TANGO et EPICS** — origines, équipes, institutions
2. Script épisode 4 : deep dive couche Hardware — PV / Attributes / StreamDevice / Asyn
3. Préparer la liste des experts à contacter (noms, institutions, communautés Tango/EPICS)
4. Définir le nom officiel du podcast (pas encore arrêté)
5. Décider de la plateforme de diffusion (pas abordé en session)

### Note stratégique
- Ce podcast est rattaché au pilier **Katy in Control / Katy Saintin** — anglais exclusivement
- Aucun lien avec Hors Kadre / Katy Ho
- Format micro-interview = compatible avec contrainte rééducation (pas de tournage lourd)

---
*Mis à jour le 25 avril 2026 — E=HK²*

