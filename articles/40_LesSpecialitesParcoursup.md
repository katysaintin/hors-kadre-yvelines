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
