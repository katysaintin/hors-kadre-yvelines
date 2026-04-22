# 98 % de réussite au bac. Et après ?

*Ce que les classements de lycées ne montrent pas.*

**Par Katy Ho — Hors Kadre | Avril 2026**

---

**98 % de réussite au baccalauréat.**

Sur le papier, difficile de faire mieux.

Pourtant, ce chiffre ne dit pas tout.

Derrière les classements largement relayés chaque année dans la presse, une question reste rarement posée : **combien d'élèves arrivent réellement jusqu'au bac dans le même établissement ?**

**1. Ce que les classements ne montrent pas**

Le taux de réussite au bac mesure une chose : la proportion d'élèves **présentés** à l'examen qui l'obtiennent. Ce qu'il ne mesure pas : combien d'élèves ont disparu entre la Seconde et la Terminale.

La question que personne ne pose : ***« Où sont passés les autres ?»***

Un lycée qui accueille 300 élèves en Seconde et en présente 173 au bac avec 100 % de réussite a perdu 127 élèves en route. Ces élèves ne sont pas dans les statistiques. Ils ne ruinent pas le taux. Ils sont ... partis.

Deuxième angle mort : le taux de mentions. 100 % de mentions sur un effectif de 23 élèves, c'est très différent de 73 % sur 313 élèves. Pourtant les classements traitent ces deux cas à égalité. La taille de l'établissement ne compte pas. L'effort pédagogique réel non plus.

| **🔍 Qu'est-ce que l'IVAL ?** |
| |
| L'IVAL — Indicateur de Valeur Ajoutée des Lycées — est un indicateur officiel publié par le Ministère de l'Éducation nationale. Il compare les résultats réels d'un lycée à ceux attendus compte tenu du profil scolaire et social de ses élèves. |
| |
| Un IVAL **positif** = le lycée fait mieux que prévu. Un IVAL **négatif** = il fait moins bien que des établissements comparables. Un IVAL **à zéro** = il fait exactement ce qu'on attendait. |
| |
| Ces données sont publiques, sur education.gouv.fr/recherche-ival. Juste ... bien cachées. |

**2. Comment cet outil est né — une journée avec une IA**

Tout a commencé par une question simple posée à une intelligence artificielle : *« Existe-t-il un classement des lycées basé sur les IVAL ?»*

Réponse : non. Puis : *« Je peux extraire toutes les données officielles de France si tu veux.»* Là, j'ai halluciné. 😄

Ce qui a suivi : une journée complète. L'IA extrait les données. Je propose le format HTML. Elle suggère une base de données. Je dis que je sais coder en MySQL et PHP. Et là --- on a passé notre journée ensemble. Deux IA, une ingénieure, et 40 ans de classements officiels non exploités.

Le résultat : un site entièrement codé à la main, avec une base SQL nationale, accessible librement à l'adresse **katy.ho.free.fr**. Cherchez votre lycée, votre ville, votre département.

Ce que des journalistes de L'Étudiant, du Parisien ou du Monde n'avaient pas fait en 40 ans de classements annuels, une ingénieure et deux IA l'ont fait en un jour. **E=HK².** 😄

**3. Comment lire cet outil — les indicateurs expliqués**

**L'IVAL — ce que le ministère calcule déjà**

Déjà expliqué ci-dessus. C'est l'indicateur le plus solide — et le plus ignoré des classements médiatiques.

**Évolution des effectifs — l'angle mort**

La différence entre le nombre d'élèves en Seconde et en Terminale. Un chiffre négatif suggère des départs — réorientations, changements d'établissement, ou autre. On ne préjuge pas des raisons. On observe. Et on se pose des questions.

**Mentions pondérées — la formule que personne ne publie**

C'est l'indicateur que j'ai développé spécifiquement pour corriger un biais majeur des classements habituels.

**Mentions pondérées = taux de mentions × √(effectif de Terminale)**

Pourquoi ? Parce que 100 % de mentions sur 23 élèves, c'est statistiquement très différent de 73 % sur 313 élèves. La racine carrée de l'effectif permet de pondérer sans écraser les petits établissements — mais sans les sur-valoriser non plus.

Concrètement : un lycée avec 100 % de mentions sur 23 élèves obtient un score de 100 × √23 ≈ 480. Un lycée avec 73 % sur 313 élèves obtient 73 × √313 ≈ 1 291. **Le mérite collectif l'emporte sur le taux brut.**

| **💡 Astuce de lecture** |
| |
| Si vous triez le tableau par taux de réussite au bac, vous obtenez le même classement que celui des journaux. Exactement le même. Puis triez par IVAL, ou par évolution des effectifs, ou par mentions pondérées. Le classement change. Parfois radicalement. |
| |
| Vous tirerez vos propres conclusions. |

| **👉 Cet article fait suite** |
| |
| Notre premier article — **« Parcoursup : ce que ni les classements des lycées ni les enseignants ne vous disent »** — a circulé sans hashtag, sans lien en commentaire, uniquement par bouche-à-oreille. Il montrait comment la notation sévère en lycée impacte directement les admissions sur Parcoursup. Ce deuxième article va plus loin : il montre ce que les classements de lycées eux-mêmes ne révèlent pas. |

**4. Ce que les données nationales révèlent — sur 2 712 lycées**

L'exemple des Yvelines n'est pas une exception locale. Pour vérifier, j'ai étendu l'analyse à l'ensemble des lycées LGT de France avec un effectif significatif — soit 2 712 établissements, dont 2 097 publics et 615 privés. Voici ce que les données officielles IVAL 2025 disent.

**Le paradoxe privé — 63 % du phénomène pour 23 % de l'échantillon**

 ----------------------------------------------------------------------------------------------------------
 **Indicateur** **Lycées publics** **Lycées privés**
 ---------------------------------------- ------------------------------ ----------------------------------
 Taux de réussite moyen au bac 90,0 % **98,3 %**

 Taux d'accès 2nde→bac moyen 77,1 % **85,2 %**

 Évolution moyenne des effectifs -17,2 élèves **-19,8 élèves**

 Paradoxe ≥99 % bac & perte \>30 élèves 90 lycées (14 % des publics) **156 lycées (25 % des privés)**
 ----------------------------------------------------------------------------------------------------------

*Source : données IVAL officielles 2025 — Ministère de l'Éducation nationale — Analyse exploratoire Hors Kadre sur 2 712 lycées LGT*

Le fait le plus parlant : les lycées privés représentent **23 % de l'échantillon** mais **63 % du paradoxe** — les établissements qui affichent 99-100 % de réussite tout en perdant plus de 30 élèves entre la Seconde et la Terminale. Cet écart est statistiquement significatif.

**Le retournement qui résume tout**

En croisant les données des établissements qui **gagnent** des élèves avec ceux qui en **perdent**, le résultat est contre-intuitif :

 ----------------------------------------------------------------------------------------
 **Catégorie** **Taux bac moyen** **Attractivité**
 ------------------------------------------------ -------------------- ------------------
 Lycées gagnant ≥20 élèves (305 établissements) 90,7 % **+20 à +182**

 Lycées perdant ≥50 élèves (433 établissements) **95,6 %** **-50 à -200**
 ----------------------------------------------------------------------------------------

*Source : même base, données IVAL 2025*

Traduction : **plus un lycée perd des élèves en route, plus son taux de réussite est élevé.** C'est mécanique. Et c'est exactement ce que les classements habituels ne vous montrent pas.

Ces écarts observés suggèrent une corrélation entre dynamique des effectifs et taux de réussite affiché. Ils n'en établissent pas la causalité. Mais ils posent une question que les classements médiatiques ne posent jamais : *« Pourquoi certains établissements conservent-ils leurs élèves jusqu'au bac, quand d'autres en perdent une part importante en cours de parcours ?»*

Voici une lecture exploratoire sur les lycées de Montigny-le-Bretonneux, triée par attractivité — c'est-à-dire par dynamique d'effectifs entre la Seconde et la Terminale. Les observations ci-dessous sont des constats statistiques. Elles n'impliquent aucun jugement sur les équipes pédagogiques. Les raisons d'un écart peuvent être multiples. Les données invitent à poser des questions, pas à donner des verdicts.

**Trier par attractivité — le classement que personne ne publie**

 ----------------------------------------------------------------------------------------------------------------
 **Lycée** **Statut** **IVAL** **Bac %** **Seconde** **Terminale** **Évolution**
 ------------------------------ ------------ ---------- ----------- ------------- --------------- ---------------
 Émilie de Breteuil (Général) Public -2,0 95 % 270 316 **+46 🔵**

 René Cassin (Pro) Public +8,0 72 % 40 43 +3

 Descartes Public 0,0 98 % 312 313 +1

 Saint-Exupéry Privé +1,0 100 % 117 116 -1

 Émilie de Breteuil (Pro) Public +8,0 91 % 35 23 -12

 Jean XXIII Privé 0,0 99 % 174 145 -29

 St-François d'Assise Privé 0,0 100 % 228 173 **-55**
 ----------------------------------------------------------------------------------------------------------------

*Source : données IVAL officielles 2025 — Ministère de l'Éducation nationale — Analyse exploratoire Hors Kadre / katy.ho.free.fr*

**Trier par taux de réussite — le classement habituel**

Si vous triez ce même tableau par taux de réussite au bac, vous obtenez Saint-François d'Assise et Saint-Exupéry en tête à 100 %. C'est exactement le classement que publient les journaux chaque année.

Saint-François d'Assise : 100 % de réussite. 228 élèves en Seconde. 173 en Terminale. **-55 élèves** qui ne figurent plus dans les statistiques de réussite.

Breteuil Général : 95 % de réussite. 270 élèves en Seconde. 316 en Terminale. **+46 élèves** — le lycée est *plus attractif à l'arrivée qu'au départ*. Les élèves viennent d'ailleurs pour y finir leur parcours.

Deux lycées voisins. Des dynamiques radicalement différentes. Même classement dans la presse.

Vous tirerez vos propres conclusions. C'est fait exprès. 😄

**5. Ce que ça change pour vous**

Vous choisissez un lycée pour votre enfant. Vous regardez le taux de réussite. Vous regardez les classements. Et si vous regardiez aussi :

1. **L'IVAL** — sur education.gouv.fr/recherche-ival. Gratuit, officiel, ignoré.

2. **L'évolution des effectifs** — combien d'élèves partent entre la 2nde et la Terminale ?

3. **Les mentions pondérées** — 100 % sur 20 élèves ou 70 % sur 300 ? La comparaison n'est pas la même.

4. **Mon outil exploratoire** — **katy.ho.free.fr** — disponible librement, sans commentaire, sans pub, sans agenda. Juste des données.

| **📋 Note méthodologique — ce que cet outil est et n'est pas** |
| |
| **Ce que c'est :** |
| |
| Une analyse exploratoire indépendante, basée sur des données officielles publiques (IVAL, effectifs, résultats bac — Ministère de l'Éducation nationale). Pondération : 40 % IVAL, 25 % évolution effectifs, 15 % taux de réussite, 20 % mentions pondérées. |
| |
| **Ce que ce n'est pas :** |
| |
| Un classement officiel. Une preuve. Une accusation. Les écarts observés suggèrent des questions — ils n'y répondent pas. Le site est fermé aux commentaires et n'affiche aucun contenu éditorial. Les données parlent d'elles-mêmes. |
| |
| **Hypothèse testée :** |
| |
| *« Les classements traditionnels des lycées, basés principalement sur les résultats au bac, ne reflètent pas nécessairement la capacité réelle des établissements à accompagner tous les élèves.»* |

**Conclusion**

Un lycée peut afficher d'excellents résultats au bac. Mais cela ne suffit pas à comprendre ce que vivent réellement les élèves entre la Seconde et la Terminale.

L'IVAL dit ce que le taux de réussite ne dit pas. L'évolution des effectifs dit ce que l'IVAL ne dit pas. Les mentions pondérées disent ce que les taux bruts masquent. Aucun indicateur seul ne raconte l'histoire complète.

C'est pour ça que j'ai croisé les données. C'est pour ça que j'ai construit cet outil. Et c'est pour ça que je le partage : parce que l'information utile ne devrait pas rester enfouie dans des rapports officiels que personne ne lit.

Les conclusions ? Je vous laisse les tirer. C'est fait exprès. 😄

**E=HK²** — plus on creuse, plus ça explose.

> *👉 Explorez les données :* **katy.ho.free.fr** *--- Pour comprendre comment les notes du contrôle continu impactent Parcoursup : notre premier article sur **Mediapart**. — Suivez Hors Kadre sur **Facebook**.*

―――

**Sources et références**

IVAL — Indicateurs de valeur ajoutée des lycées — education.gouv.fr/recherche-ival

Données effectifs et résultats bac — Open Data Ministère de l'Éducation nationale — data.education.gouv.fr

Méthodologie IVAL — DEPP, Direction de l'évaluation, de la prospective et de la performance

Parcoursup : ce que ni les classements des lycées ni les enseignants ne vous disent — Hors Kadre / Mediapart, avril 2026

*Mots-clés : IVAL, classement lycées, valeur ajoutée, taux de réussite bac, Yvelines, académie de Versailles, Parcoursup, orientation, Hors Kadre*

*Prompt image : « A magnifying glass over a school report card showing 100% success but hiding a trail of empty desks — flat editorial illustration, navy blue and terracotta palette, no text, wide format 1200x630 »*

*Article publié sur Mediapart / Le Club — Hors Kadre — Katy Ho — Avril 2026*

---

*Publié sur [Mediapart — Blog Hors Kadre](https://blogs.mediapart.fr/katy-ho) | Outil national : [katy.ho.free.fr](http://katy.ho.free.fr) | Yvelines : [katysaintin.github.io/hors-kadre-yvelines](https://katysaintin.github.io/hors-kadre-yvelines)*

*E=HK² — Plus on creuse, plus ça explose.*
