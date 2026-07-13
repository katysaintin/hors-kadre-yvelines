# Notes de recherche — Spécialités, IVAL et CPGE
## Matériau pour articles HK — données issues de katy.ho.free.fr
### Version de travail — mai 2026

---

## PARTIE 1 — LE MYTHE MATHS

### 1.1 Maths domine PARTOUT — mais pas pour les mêmes raisons

Données nationales 2024 — part des admis ayant la spécialité Maths :

| Filière | % admis avec Maths | Rang |
|---------|-------------------|------|
| CPGE Scientifique | **46,6%** | 🥇 |
| CPGE ECG (Commerce) | **41,6%** | 🥇 |
| BUT | **32%** | 🥇 |
| PASS (Médecine) | **23%** | 🥉 |
| CPGE Littéraire | **11,4%** | 5ème |
| Licence (toutes) | **15,9%** | 🥉 |

**📸 Screenshot suggéré :**
> `doublettes.php?filiere=CPGE&detail=PCSI&tab=solo` — onglet "Par spécialité"
> Montrer Maths à 46,6% en tête

**Observation :** Maths est en tête dans 5 filières sur 6. La seule exception —
CPGE Littéraire, où HGGSP (30,6%) et HLP (22,8%) dominent.
**La réforme 2019 a réussi pour les prépas littéraires. Pas pour le reste.**

---

### 1.2 NSI — la spécialité "informatique" qui ne domine pas en informatique

| Formation | Rang NSI | % admis |
|-----------|----------|---------|
| BUT Informatique | **5ème** | 6,7% |
| BUT (toutes filières) | **5ème** | 6,5% |
| CPGE Scientifique | Non classée | <2% |

Pendant ce temps dans le BUT Informatique :
- SES : **18,3%** (🥈 — devant NSI !)
- PC : **17,6%** (🥉)
- HGGSP : **8,4%**
- NSI : **6,7%** (5ème)

**📸 Screenshot suggéré :**
> `doublettes.php?filiere=BUT&detail=Informatique&tab=solo`
> Montrer le classement complet avec NSI en 5ème position

**Question à poser aux familles :**
*Si votre enfant veut faire de l'informatique, on lui conseille souvent NSI.
Mais seulement 6,7% des admis en BUT Informatique l'avaient.
Maths+SI (34,4%) ou Maths+NSI (27,2%) sont bien plus efficaces que NSI seule.*

---

### 1.3 La doublette Maths+PC — reine incontestée

| Formation | Doublette Maths+PC | Taux de conversion |
|-----------|-------------------|-------------------|
| CPGE MPSI/PCSI | Maths+PC | **41,4%** 🥇 |
| CPGE PCSI | Maths+PC | **~41%** |
| BUT GEII (Vélizy) | Maths+SI | **34,4%** 🥇 |
| PASS (Médecine) | PC+SVT | **48,6%** 🥇 |

**📸 Screenshot suggéré :**
> `doublette_detail.php?filiere=CPGE&detail=PCSI&sort=taux`
> Montrer le tableau trié par taux d'accès avec IVAL des lycées

---

## PARTIE 2 — SVT, LA SPÉCIALITÉ MÉDECINE QUI N'EST PAS LA PLUS EFFICACE

### 2.1 Pour le PASS — PC prime sur SVT

| Spécialité | % admis en PASS | Rang |
|-----------|----------------|------|
| PC | **44,3%** | 🥇 |
| SVT | **30,8%** | 🥈 |
| Maths | **23%** | 🥉 |
| SES | **0,8%** | 4ème |

**Ce que ça dit :** PC est plus présente que SVT chez les admis en médecine.
La doublette reine est **PC+SVT (48,6%)** — les deux ensemble.
SVT seule, sans PC, est peu représentée parmi les admis.

**📸 Screenshot suggéré :**
> `doublettes.php?filiere=PASS&tab=solo`
> Montrer PC en 🥇 devant SVT

**Paradoxe :** les familles entendent "médecine = SVT" depuis 30 ans.
La réalité 2024 : sans PC, SVT ouvre peu de portes en PASS.
SVT+LLCER ne fait que 14%. SVT+HGGSP : 12,2%.

---

## PARTIE 3 — IVAL ET CPGE : L'ILLUSION D'EXCELLENCE

### 3.1 Les lycées avec CPGE ont des IVAL faibles

Données Yvelines filtrées LGT, triées par IVAL décroissant :

| Rang | Lycée | IVAL | CPGE | Bac% |
|------|-------|------|------|------|
| 16 | St Exupéry (Mantes) | +2 | ⭐ | 95% |
| 17 | Charles de Gaulle (Poissy) | +1 | — | 98% |
| ... | ... | ... | ... | ... |
| bas | Louis Le Grand (Paris) | +1 | ⭐ | 100% |
| bas | Henri IV (Paris) | 0 | ⭐ | 99% |
| bas | Hoche (Versailles) | 0 | ⭐ | 99% |
| bas | Lakanal (Sceaux) | -1 | ⭐ | 98% |
| bas | Pierre de Fermat (Toulouse) | -1 | ⭐ | 98% |
| bas | Pasteur (Neuilly) | -2 | ⭐ | 97% |

**📸 Screenshot suggéré :**
> `doublette_detail.php?filiere=CPGE&detail=PCSI&sort=taux`
> Montrer le tableau avec IVAL — Louis Le Grand 7% accès, IVAL +1 ; Hoche 16%, IVAL 0

**Observation centrale :**
Les CPGE les plus sélectives (taux d'accès 7-20%) ont des IVAL nuls ou négatifs.
Bac% proche de 100% — mais pas grâce au lycée : grâce à la sélection à l'entrée.

---

### 3.2 Les lycées pro font mieux que les LGT avec CPGE

Données Yvelines — classement IVAL décroissant, toutes voies confondues :

| Rang | Lycée | Voie | IVAL | CPGE |
|------|-------|------|------|------|
| 1 | LP Vaucanson (Les Mureaux) | 🔧 LP | **+18** | — |
| 2 | LP Louis Blériot (Trappes) | 🔧 LP | **+13** | — |
| 3 | LP Lavoisier (Porcheville) | 🔧 LP | **+10** | — |
| 4 | LP Émilie de Breteuil (Montigny) | 🔧 LP | **+8** | — |
| **16** | **St Exupéry (Mantes)** | **🎓 LGT** | **+2** | **⭐ CPGE** |
| **17** | **Charles de Gaulle (Poissy)** | **🎓 LGT** | **+1** | **—** |

**📸 Screenshot suggéré :**
> `indexival.php?departement=YVELINES&sort=ival&order=desc`
> Montrer les 20 premières lignes — tous LP en tête, badges roses

**Le premier lycée général n'arrive qu'en 16ème position.
Et il héberge une CPGE.**

---

### 3.3 Descartes Montigny — le lycée qu'on vante, les chiffres qu'on cache

| Indicateur | Valeur |
|-----------|--------|
| IVAL | **0** |
| Taux bac | 98% |
| Taux mentions | 73% |
| CPGE hébergée | ⭐ PCSI |
| BTS hébergé | 📋 BTS |
| Taux accès PCSI | **39%** |

**La PCSI de Descartes est accessible (39%) — ce n'est pas Hoche (16%).**
IVAL = 0 : le lycée est dans la moyenne attendue pour ses élèves.
98% de réussite au bac : le lycée sélectionne bien, accompagne correctement.

*Note éditoriale : le BTS est "inexistant dans les communications du lycée"
selon le témoignage de la représentante de parents. Pourtant il figure
dans les données open data Parcoursup 2026.*

---

## PARTIE 4 — CE QUE LA RÉFORME 2019 A CHANGÉ (ET PAS CHANGÉ)

### 4.1 Ce qui a bien marché

| Filière | Spé dominante avant réforme | Spé dominante après (2024) |
|---------|---------------------------|--------------------------|
| CPGE L | Latin/Philo → | HGGSP (30,6%) HLP (22,8%) ✅ |
| CPGE ECG | Maths → | Maths (41,6%) + SES (33,5%) ✅ |
| BUT Techno | STI2D → | Maths+SI (34,4%) ✅ |

**La réforme a globalement réussi pour les filières littéraires et commerciales.**

### 4.2 Ce qui n'a pas changé

| Filière | Avant réforme | Après (2024) |
|---------|--------------|-------------|
| CPGE S | Maths/PC = obligatoire | Maths (46,6%) PC (45,2%) = identique |
| Ingénieurs (concours) | Maths/PC = obligatoire | Identique |
| NSI (espoir) | Nouvelle spé, censée ouvrir la filière info | 5ème position BUT Info |

**Les concours post-bac (CCINP, Centrale, X) n'ont pas changé leurs exigences.**
Les familles qui avaient la filière S ont reproduit le même réflexe avec Maths+PC.
NSI n'a pas remplacé PC dans l'imaginaire des formations techniques.

---

## PARTIE 5 — PÉPITES POUR L'ARTICLE

### Chiffre à mettre en gros

> **En Yvelines, les 15 lycées qui apportent le plus à leurs élèves
> sont tous des lycées professionnels.**
> Le premier lycée général n'arrive qu'en 16ème position.
> Il héberge une CPGE.

---

> **Pour le PASS médecine, PC (44%) est plus présente chez les admis que SVT (31%).**
> La spécialité "médecine" n'est pas celle qu'on croit.

---

> **NSI représente 6,7% des admis en BUT Informatique.**
> SES (18%) et PC (17%) sont devant.
> La "spécialité informatique" n'ouvre pas les portes de l'informatique mieux que SES.

---

> **Lycée Louis Le Grand, Paris : taux d'accès PCSI = 7%, IVAL = +1, Bac% = 100%.**
> Ce n'est pas le lycée qui fait progresser — c'est la sélection qui garantit le résultat.

---

### Citations pour intro / conclusion

*"Si on classe les lycées sur le taux de réussite au bac, le classement ne change pas
depuis 40 ans — et il ne changera pas. Si on les classe sur leur IVAL, tout bouge."*

*"Maths est en tête dans presque toutes les filières. Mais pour des raisons différentes.
Dans une CPGE scientifique, c'est logique. En BUT Informatique, c'est le signe
que NSI n'a pas encore convaincu les lycéens."*

---

## EMPLACEMENTS SCREENSHOTS — RÉCAPITULATIF

| # | URL | Ce qu'on montre |
|---|-----|----------------|
| 1 | `doublettes.php?filiere=CPGE&detail=PCSI&tab=solo` | Maths 46,6% en CPGE S |
| 2 | `doublettes.php?filiere=BUT&detail=Informatique&tab=solo` | NSI en 5ème position |
| 3 | `doublettes.php?filiere=PASS&tab=solo` | PC devant SVT en médecine |
| 4 | `doublette_detail.php?filiere=CPGE&detail=PCSI&sort=taux` | IVAL des lycées CPGE |
| 5 | `indexival.php?departement=YVELINES&sort=ival&order=desc` | LP en tête, LGT CPGE en bas |
| 6 | `indexival.php?departement=YVELINES&voie=LGT&sort=ival&order=desc` | LGT seuls, CPGE en queue |
| 7 | `doublettes.php?filiere=CPGE&detail=Lettres&tab=solo` | HGGSP+HLP dominent en prépa L |

---

## SOURCES

- Open Data Parcoursup 2024 — MESRI (spécialités des admis par filière)
- DEPP/RERS 2025 — IVAL lycées
- katy.ho.free.fr — traitement et visualisation Hors Kadre
- Données calculées : taux de conversion = nb_admis/nb_voeux par doublette

*Ces données couvrent l'ensemble de la France. Les réalités locales varient.*


------

# Notes de travail — Parcoursup : ce qui fonctionne vraiment

## Idée générale

Ne plus écrire un article sur "Parcoursup fait peur", mais sur :

> Parcoursup est imparfait, mais les données montrent qu'il fonctionne beaucoup mieux que son image médiatique.

Objectif :
- rassurer les familles ;
- déconstruire les idées reçues ;
- expliquer ce qui dépend réellement de Parcoursup... et ce qui n'en dépend pas.

---

# Positionnement éditorial

Je ne souhaite ni défendre aveuglément Parcoursup, ni l'attaquer.

Je souhaite expliquer :

- ce que fait réellement Parcoursup ;
- ce que Parcoursup ne fait pas ;
- où se trouvent les vraies difficultés ;
- ce qui fonctionne concrètement chez les élèves qui réussissent.

L'objectif est d'aider les familles à agir sur ce qu'elles peuvent réellement maîtriser.

---

# Ma légitimité

Après deux enfants, deux parcours très différents.

## Mon fils

Profil scientifique.

Pas premier de classe.

Bulletins sérieux.

Projet construit depuis la Seconde.

- stages
- salons
- JPO
- spécialités cohérentes
- motivation argumentée

Résultat :

- 4 admissions dès le premier jour
- 9 propositions au total

dont

- BUT GEII Cachan
- BUT GEII Ville d'Avray
- BUT Informatique
- licences sous tension

Le dossier n'était pas exceptionnel.

Le projet l'était davantage.

---

## Ma fille

Profil totalement différent.

Objectif :

journalisme, communication, international.

Choix assumés :

- AMC
- HGGSP
- SES
- Chinois LV3

Stages :

- Kering (finance internationale / Chine)
- communication mairie

Première publication :

une page entière dans le magazine municipal.

Projet futur :

stage linguistique Oxford/Cambridge.

Même logique.

Ce n'est pas le même profil que son frère.

C'est la même cohérence.

---

# Une idée forte

Les familles pensent souvent :

"Il faut choisir les maths."

Je voudrais montrer que la vraie question est plutôt :

> Est-ce que votre dossier raconte une histoire cohérente ?

Le jury doit pouvoir se dire :

"Cette candidature est logique."

---

# Ce que Parcoursup ne fait pas

Parcoursup ne décide pas des critères.

Les critères sont définis par chaque formation.

Les algorithmes locaux appartiennent aux formations.

Parcoursup :

- centralise
- transmet
- ordonne
- gère les réponses

Il ne choisit pas les meilleurs élèves.

Les établissements le font.

---

# Ce qui fonctionne réellement

Commencer tôt.

Dès la Seconde.

Construire progressivement.

Pas en Terminale.

Exemples :

- visites
- JPO
- stages
- salons
- rencontres
- curiosité
- lectures
- projets personnels

---

# Choisir une orientation plutôt qu'un métier

Un élève de Seconde ne connaît pas les centaines de métiers existants.

En revanche il peut savoir :

- j'aime expliquer
- j'aime programmer
- j'aime convaincre
- j'aime réparer
- j'aime dessiner
- j'aime écrire
- j'aime voyager
- j'aime comprendre le monde

Construire autour de cela.

---

# Les spécialités

Ne pas choisir une spécialité "par peur".

Ne pas choisir "Maths" uniquement parce que tout le monde dit qu'il faut faire Maths.

Choisir :

- ses points forts
- son mode de fonctionnement
- son projet

Puis rechercher les formations compatibles.

---

# Les données que je souhaite montrer

Les chiffres finaux.

Pas ceux du mois de juin.

Comparer :

début de procédure

↓

fin juillet

↓

septembre

↓

clôture.

Montrer :

combien obtiennent finalement une proposition.

Comparer avec les titres anxiogènes de la presse.

---

# Présentation aux parents

Titre possible

Parcoursup :
les idées reçues...
et les chiffres qui racontent une autre histoire.

ou

Parcoursup :
ce qui fonctionne vraiment.

ou

Parcoursup :
comprendre avant d'avoir peur.

---

# Structure de la conférence

1.
Comment fonctionne réellement Parcoursup ?

2.
Qui décide ?

3.
Que regarde une formation ?

4.
Les erreurs les plus fréquentes.

5.
Les idées reçues.

6.
Ce qui fait vraiment progresser un dossier.

7.
Questions.

---

# Message central

Le meilleur dossier n'est pas toujours celui qui a les meilleures notes.

C'est souvent celui qui est le plus cohérent.

---

# Citation possible

"On ne construit pas un dossier Parcoursup en janvier de Terminale.

On construit progressivement une histoire crédible à raconter."

---

# Lien avec mes autres articles

- Léopold Sédar Senghor
→ toutes les intelligences ne s'expriment pas de la même façon.

- Mme HorsKase
→ attention aux modèles uniques.

- ChatGPT et les impôts
→ un outil n'est ni bon ni mauvais.
Tout dépend de l'usage.

- Le tendon qui fait clac
→ l'expérience personnelle permet parfois de mieux comprendre un système.

---

# Idée de conclusion

Finalement, après avoir accompagné des centaines de familles, développé des outils, analysé les données publiques, vécu Parcoursup avec un profil scientifique puis avec un futur profil littéraire, je n'ai toujours pas trouvé de recette miracle.

En revanche, je retrouve presque toujours les mêmes ingrédients :

de la curiosité,
de la cohérence,
des expériences concrètes,
des rencontres,
des essais,
des erreurs...

Bref, un projet qui se construit.

Et c'est peut-être cela, plus que les notes, qui raconte le mieux un futur étudiant.
