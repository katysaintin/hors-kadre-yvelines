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

*Mis à jour le 19 avril 2026 — E=HK²*


