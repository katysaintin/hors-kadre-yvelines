# Mme HorsKase cherche sa case désespérément

*(spoiler : elle finit par la trouver)*

*Par Katy Ho — Hors Kadre | Mai 2026*

---

**Chapô** — Hors Kadre décrypte ce que les médias n'abordent pas. Tu es une femme. Tu es bizarre depuis toujours. Tu t'en sors quand même. Félicitations : tu n'existes pas dans le système. Sourcé, vécu, et légèrement énervé.

---

*Ce texte n'est pas pour les HPI. Pas pour les TDAH.*
*Il est pour toi — si tu t'es déjà senti dans la mauvaise case.*
*Ou dans aucune.*
*Ou dans trop à la fois.*
*C'est-à-dire : pour presque tout le monde.*

---

## 0. Le programme

*Pour les non-développeurs : un switch/case c'est comme un portier de boîte de nuit avec une liste. Si ton nom est dessus — tu rentres. Sinon — tu restes dehors. Même si t'as réservé.*

*Pour les développeurs : vous avez déjà compris le problème.*

---

**🖼️ IMAGE ECLIPSE VERSION SIMPLE — à remplacer**

```java
// Système de détection neurodiversité v1.0
// Testé sur : garçons, enfants agités
// Dernière mise à jour : jamais

switch (qui_tu_es) {
  case GARÇON_AGITÉ:    donner_ritaline();   break;
  case GARÇON_BRILLANT: sauter_classe();     break;
  default:              débrouille_toi();    break;
}
```

---

Voilà ce que le système médical fait quand tu arrives avec ton cerveau atypique.

Si tu es un garçon agité — tu rentres. On te donne de la Ritaline et une chaise au fond de la classe.

Si tu es un garçon brillant qui s'ennuie — tu rentres aussi. On te fait sauter une classe et on te félicite.

Et si tu es... autre chose ?

`default: débrouille-toi.`

Trente ans que ce code tourne en production. Personne n'a fait la mise à jour.

---

**🖼️ IMAGE ECLIPSE VERSION DÉTAILLÉE — à remplacer**

```java
// Système de détection neurodiversité v1.0
// Testé sur : garçons, enfants agités
// Dernière mise à jour : jamais

try {
  if (patient == GARÇON) {
    switch (profil) {
      case HPI:  sauter_des_classes(); break;
      case TDAH: donner_ritaline();    break;
      default:   débrouille_toi();     break;
    }
  }

} catch (FemmeHPIetTDAH e) {

  switch (qui_tu_es_vraiment) {
    case FEMME:   // à traiter
    case FILLE:   // à traiter
    case HPI:     // à traiter
    case TDAH_F:  // à traiter
    default:
      // TODO : prévu pour 2099.
      // En attendant : avez-vous essayé le yoga ?
  }
}
```

---

Et regarde bien le `catch`. Même quand le système "attrape" ton cas — il ouvre un nouveau switch. Et tous les cases sont vides.

`// TODO : prévu pour 2099.`

`// En attendant : avez-vous essayé le yoga ?`

Je ne rigole pas. Enfin si. Mais quand même.

**Ou bien c'est toi qui étais malade ?** 😄

---

## 1. Dr CaseFermée et le mail bienveillant

Un psychiatre spécialiste. Auteur de livres de référence sur le TDAH. Recommandé par ses médecins.

Mme HorsKase lui envoie son dossier. Ses bilans. Ses anamnèses. Son vécu.

Il répond par mail.

Pas de rendez-vous. Pas d'entretien. Un mail.

---

> *"Beaucoup des symptômes recensés actuellement dans le bilan de 2023 ne sont pas spécifiques : ils peuvent se rencontrer dans d'autres pathologies que le TDAH, fréquentes chez les adultes."*

Traduction pour les humains : *tes symptômes sont banals. Tout le monde est fatigué, chérie.*

> *"Les critères diagnostiques du TDAH chez l'adulte stipulent que l'on doit retrouver des signes présents de façon significative **avant 12 ans**."*

Avant 12 ans.

Tu sais ce qui se passait avant ses 12 ans ? Elle était une petite fille sage. Bonne élève. Discrète. Elle compensait, elle s'adaptait, elle souriait.

Exactement ce que les petites filles sont supposées faire.

Exactement ce que le manuel ne sait pas lire.

Parce que le manuel a été écrit pour les garçons qui **ne font pas** ça.

Dr CaseFermée a ouvert son switch. Il a cherché sa case. Il n'a pas trouvé. Il a fermé le dossier. Par mail.

`default: pas de TDAH détecté. Bonne journée.`

Ce qu'il n'a pas dit — ce que le DSM-5 murmure discrètement dans ses notes de bas de page — c'est que ce critère "avant 12 ans" a été construit sur des garçons hyperactifs et bruyants. Pas sur des filles qui ont appris très tôt qu'être sage, c'est une survie.

Sa case n'existait pas dans son système.

Donc elle n'existait pas.

---

*Mme HorsKase a lu ce mail une fois. Elle n'a pas compris.*
*Elle l'a relu. Idem.*
*Cinq fois. Dix fois. Vingt fois.*
*Et puis elle a compris.*
*Et elle a pleuré.*

---

## 2. Mme BienveillanceFatale — l'amie qui rate quand même

Il y a pire que le spécialiste derrière son mail.

Il y a l'amie.

Celle qui te connaît. Qui te voit depuis des années. Qui sait que tu es à 100 à l'heure sur tous les fronts simultanément.

Mme BienveillanceFatale est orthophoniste. Elle connaît les troubles. Elle connaît les profils. Elle connaît Mme HorsKase.

Mme HorsKase lui pose la question. Prudemment. Timidement. Parce que demander *"est-ce que je suis TDAH ?"* à quelqu'un qui te connaît — c'est s'exposer vraiment.

Mme BienveillanceFatale réfléchit. La regarde. Et répond — en amie, en professionnelle, avec toute sa bienveillance :

*"Non. Toi t'es juste surmenée."*

Et pour la fille de Mme HorsKase — 145 au WISC, 6 ans, tout va bien — même verdict :

*"Je ne conseillerais de faire passer le test que si ça ne va pas."*

La fille a passé le test quand même. Elle a dit que c'était rigolo.

145.

```java
default:
  switch (ce_qu_ils_voient) {
    case FATIGUE:      "T'es surmenée.";          break;
    case TROP_BIEN:    "Pourquoi tester alors ?"; break;
    case FILLE_SAGE:   "Elle va bien.";           break;
    default:           "Essaie le yoga.";         break;
  }
```

Le `default` n'est pas le vide.

C'est un autre switch/case. Déguisé en bienveillance. Livré avec le sourire.

C'est le bug le plus difficile à débugger.

Parce qu'il vient des gens qui t'aiment.

---

> 💡 *Pour aller plus loin — Doris Perrodin-Carlen, psychologue spécialiste du HPI féminin, cite ce type de cas dans ses conférences : attendre que "ça aille mal" pour tester une fille, c'est lui laisser le temps de construire une vie entière en se croyant idiote. Son livre* Et si elle était surdouée ? *(2015) reste la référence francophone sur le sujet.*

---

*Mme HorsKase a entendu ces mots une fois. Elle n'a pas compris.*
*Elle les a entendus encore. Idem.*
*Cinq fois. Dix fois. Vingt fois.*
*Et puis elle a compris.*
*Et elle a pleuré.*

---

## 3. M. et Mme SautDeClasse — l'ANPEIP et ses cases dorées

Il existe des associations de parents d'enfants HPI.

Des parents bienveillants. Investis. Qui veulent le meilleur pour leurs enfants.

Mme HorsKase arrive à sa première réunion. Son fils vient d'être détecté. 147 au WISC-IV. Sa fille : 145.

Dans la salle — que des garçons. Comme par hasard.

M. SautDeClasse se retourne vers elle, l'œil brillant.

*"147 — ouaaah. Alors il a sauté des classes ?"*

*"Non. Il est bien. Il a ses amis. Il ne voulait pas."*

Silence gêné. Ce n'est pas la bonne réponse.

Dans le switch/case de M. SautDeClasse :

`case HPI: sauter_classe(); break;`

Pas d'autre issue. Son fils est en `default`. Lui aussi.

---

Puis vient le moment où elle pose la question pour sa fille.

Elle s'ennuie. Elle ne brille pas. Elle est sage. Bonne élève. Pas enquiquinante.

Mme HorsKase parle à sa prof. Mme CopierColler.

*"Elle a 145 au WISC."*

> *"Si vous saviez le nombre de parents qui viennent me voir en prétendant que leur gamin est surdoué ! Un test de QI ça veut rien dire. Et puis faut pas pousser vos enfants."*

*"Elle est en CP."*

> *"Si vous saviez..... faut pas pousser vos enfants."*

*"Elle fait de la programmation Scratch toute seule."*

> *"Si vous saviez..... faut pas pousser vos enfants."*

```java
// Mme CopierColler v1.0
String réponse = "Si vous saviez le nombre de parents..." +
                 "Un test de QI ça veut rien dire." +
                 "Et puis faut pas pousser vos enfants.";

while (parent_parle) {
  afficher(réponse); // toujours la même
}

// Note du développeur :
// Aucune mise à jour prévue.
// Fonctionne depuis 1987.
```

---

> 💡 *Pour aller plus loin — Une méta-analyse portant sur 130 études (ScienceDirect, 2013) montre que les garçons ont 1,19 fois plus de chances d'être identifiés comme surdoués. L'écart est particulièrement marqué chez les préadolescents — et quand le critère d'identification est le comportement visible en classe.*

---

*Mme HorsKase a entendu ces mots une fois. Elle n'a pas compris.*
*Elle les a entendus encore. Idem.*
*Cinq fois. Dix fois. Vingt fois.*
*Et puis elle a compris.*
*Et elle a pleuré.*

---

## 4. Mme AuthentiqueOuRien et le compliment assassin

Il existe des groupes Facebook réservés aux HPI **testés**.

Pas les zèbres. Pas les hypersensibles. Les **testés**. WISC, WAIS, QI vérifié, tampon officiel. Un switch/case de plus. Juste avec un velours rouge devant.

Mme HorsKase poste un article. Sourcé, vécu, écrit avec son cerveau qui carbure à 4 000 tours.

Une dame commente.

> *"J'ai apprécié votre article. Le rythme, la fluidité. J'ai lu jusqu'au bout. Mais dommage que votre texte ait été optimisé par de l'IA."*

Être HPI dans sa case à elle, ça ressemble à quoi ? Calculer sans calculatrice ? Écrire sans correcteur ? Souffrir sans aide ?

Mme HorsKase est TDAH. L'IA c'est sa prothèse cognitive. Comme les lunettes pour les myopes. Personne ne dit à un myope *"dommage que tes yeux aient été optimisés par des verres."*

`// Utiliser ses outils = tricher`
`// Souffrir en silence = authentique`
`// Ce raisonnement a un bug. Cherchez-le.`

---

*Mme HorsKase a lu ce commentaire une fois. Elle n'a pas compris.*
*Elle l'a relu. Idem.*
*Cinq fois. Dix fois. Vingt fois.*
*Et puis elle a compris.*
*Et elle a pleuré.*

---

## 5. "Les femmes à QI élevé sont souvent autistes" — ou la pub qui ment deux fois

Mme HorsKase scrolle Facebook.

Entre le post de sa voisine sur son chat et une recette de quiche — une publicité.

**🖼️ IMAGE PUB FACEBOOK — à remplacer**

> **"Les femmes à QI élevé sont souvent autistes."**
> *"Si vous pouvez répondre à ces 15 questions intellectuelles complexes, votre QI est supérieur à 130. Passez le test maintenant."*

**Mensonge n°1 :** 15 questions Facebook = QI supérieur à 130.

Non.

Un QI ça se mesure avec un WAIS ou un WISC. Passé par un psychologue. En plusieurs heures. Avec des subtests, des indices, une analyse qualitative. Pas avec un formulaire entre la recette de quiche et le chat de la voisine.

**Mensonge n°2 :** femme HPI = autiste.

Non.

Il existe des femmes HPI autistes. Il existe des femmes autistes sans HPI. Il existe des femmes HPI sans autisme.

Mme HorsKase est HPI. Mme HorsKase est TDAH. Mme HorsKase n'est pas autiste.

Son mari est Asperger. Son fils est Asperger. Elle connaît l'autisme de l'intérieur — pas comme étiquette, comme réalité quotidienne vécue et aimée.

Ce n'est pas la même case.

Et coller ces cases ensemble parce que *"les femmes sont discrètes"* — c'est encore du switch/case. Plus fin. Plus bienveillant en apparence. Même bug.

Le système médical met les femmes en `default`.
Les algorithmes Facebook les mettent toutes dans la même case.
Les deux ratent la cible.

**La différence ?**

Le système médical, au moins, ne te facture pas l'abonnement premium.

*Je dis ça. Je dis rien.* 😄

---

> 💡 *Pour aller plus loin — Le phénomène de "camouflage" chez les femmes atypiques est documenté scientifiquement. Lai et al. (2017, PMC) montrent que les femmes masquent davantage leurs difficultés — ce qui retarde le diagnostic en moyenne de 4 à 9 ans par rapport aux hommes. La ressemblance des profils ne signifie pas l'identité des profils.*

---

*Mme HorsKase a lu cette pub une fois. Elle n'a pas compris.*
*Elle l'a relue. Idem.*
*Cinq fois. Dix fois. Vingt fois.*
*Et puis elle a compris.*
*Cette fois — elle n'a pas pleuré. Elle a ri.*
*Puis elle a écrit cet article.* 😄

---

## 6. Et puis zut — le vrai problème des cases

Mme HorsKase est une femme différente et unique.

Comme toutes les femmes sur terre.

Comme tous les humains sur terre, d'ailleurs.

Et elle n'a pas besoin de case.

Sauf que.

Pour avoir un PAP — il faut porter un diagnostic DYS.
Pour avoir une RQTH — il faut porter un handicap reconnu.
Pour être prise au sérieux — il faut un tampon, un code, une case cochée dans le bon formulaire.

Le problème des cases — ce n'est pas qu'elles existent.

C'est qu'elles sont devenues la **seule monnaie d'échange** pour accéder à ce dont tu as besoin.

Pas de case ? Pas de droits.
Mauvaise case ? Mauvais droits.
Plusieurs cases ? Le système plante.

`// Les gens sans case :`
`// la majorité silencieuse`
`// qui compense seule`
`// depuis toujours`

C'est injuste pour ceux qui n'ont pas de case.

C'est injuste pour ceux qui ont la *"chance"* d'en trouver une — et qui ont dû se battre des années pour y arriver.

C'est injuste pour tout le monde.

Sauf pour le système.

Lui, il dort très bien.

---

## 7. À toi qui ne coches aucune case

Cet article est pour toi.

Pas seulement si tu es TDAH. Pas seulement si tu es HPI. Pas seulement si tu as un tampon, un dossier, une case cochée.

Pour toi aussi — toi qui fonctionnes "normalement" selon les critères du système. Toi qui n'as jamais eu de diagnostic. Toi qui t'es juste parfois senti à côté. Pas tout à fait à ta place. Pas tout à fait reconnu pour ce que tu es vraiment.

Parce que les cases — elles écrasent tout le monde.

Elles disent au garçon brillant qu'il doit sauter des classes.
Elles disent à la fille sage qu'elle va bien.
Elles disent au parent inquiet qu'il pousse trop.
Elles disent à l'adulte épuisé qu'il est juste surmené.

Et à tous les autres — ceux qui ne rentrent dans aucune case, ceux qui rentrent dans la mauvaise, ceux qui rentrent dans trop — elles disent la même chose :

`default: débrouille-toi.`

Tu n'as pas besoin de sauter des classes pour être intelligent.
Tu n'as pas besoin d'un diagnostic pour avoir de la valeur.
Tu n'as pas besoin d'être en difficulté pour mériter qu'on s'intéresse à toi.
Tu n'as pas besoin d'une case pour exister.

Le système a besoin de cases pour fonctionner.

**Toi, non.**

`// Toi`
`// Statut : UnknownException`
`// Traduction : inexploré`
`// Potentiel : non mesuré`
`// Valeur : non nulle`

Mme HorsKase te voit.

---

## Chute

Avec toutes les incompréhensions. Avec toutes les larmes versées. Avec tous les mails relus vingt fois. Avec tous les *"débrouillez-vous"* et les *"avez-vous essayé le yoga"*.

Mme HorsKase a lu. Elle a compris. Et elle a arrêté de pleurer.

Elle a trouvé sa case. Le monde.

---

Cette Mme HorsKase — c'était moi.

---

Recalée chez Unilog — test de QI.
Recalée à Ingénieurs 2000 — test de QI.
Admise au CEFIPA — concours pratique. Électronique. Maths appliquées. Vrai problème. Vraie solution.

Apprentie. Puis ingénieure. Puis experte.

Aujourd'hui je pilote le système de contrôle-commande d'un des IRM les plus puissants au monde. Je prépare une certification IA. Je cherche un directeur de thèse.

Mon WAIS : 130. Ma mémoire de travail : bof. Je compense autrement.

Mon TDAH : diagnostiqué à 46 ans. Neuf ans après mon HPI. Détecté grâce à mes enfants — pas grâce au système.

La nuit avant mon WAIS, je me disais : *"pour qui je me prends. Je vais avoir 2. Je suis trop nulle."*

Ma fille de 6 ans, elle, a dit que c'était rigolo.

145.

Même famille. Même gène. Deux générations.

Elle n'aura pas à attendre ses 37 ans pour se comprendre.

C'est pour ça que j'écris.

---

*Cet article sur les cases — il a été lu jusqu'au bout.*
*Par une TDAH qui n'existait pas dans le système.*
*La preuve que c'est possible.*
*Sans jargon. Sans cases. Sans yoga.*

---

*Si tu as lu jusqu'ici.*

*Et que tu t'es reconnu dans Dr CaseFermée.*
*Ou dans Mme CopierColler.*
*Ou dans Mme AuthentiqueOuRien.*

*Et que tu étais convaincu que le système de cases — il n'y a que ça de vrai.*

*Et que tu as un doute maintenant.*

*Alors.*

*Tu as lu jusqu'au bout.*
*Un article sans cases.*
*Écrit par quelqu'un qui n'existait pas dans ton système.*

*Le bug est confirmé.*

*Je dis ça.*
*Je dis rien.* 😄

---

`// catch (UnknownPatientException e)`
`// "Ce profil n'existe pas."`
`// Spoiler : si.`

**E=HK² 💥**

---

## Sources

- DSM-5 (révision 2013) — Critères diagnostiques TDAH et biais de genre — APA
- HAS (2024) — Recommandations TDAH adulte — has-sante.fr
- Lai et al. (2017) — *Quantifying and exploring camouflaging in men and women with autism* — PMC
- ScienceDirect (2013) — *Gender differences in identification of gifted youth* — méta-analyse 130 études
- Doris Perrodin-Carlen — *Et si elle était surdouée ?* (2015) — référence francophone HPI féminin
- WAIS-IV / WISC-V — Échelles d'intelligence de Wechsler — documentation clinique
- Inserm (2025) — Dossier TDAH chez l'adulte
- Expérience personnelle — 46 ans de running gag médical, beaucoup de café, une fille qui trouvait ça rigolo ✅

---

*Titre Mediapart :* `Mme HorsKase cherche sa case désespérément`
*(44 caractères ✅)*

*Chapô :* `Hors Kadre décrypte ce que les médias n'abordent pas. Tu es une femme. Tu es bizarre depuis toujours. Tu t'en sors quand même. Félicitations : tu n'existes pas dans le système. Sourcé, vécu, et légèrement énervé.`
*(216 caractères ✅)*

*Mots-clés :* neurodiversité, TDAH, HPI, femmes, diagnostic tardif, switch case, DSM-5, bilan cognitif, test QI, RQTH, cases, invisibilité, masking, camouflage, Hors Kadre

*Numéro article :* **26**

*Prompt image couverture :* `Flat cartoon with dramatic grain. A woman stands in front of a giant bouncer holding a clipboard. The bouncer points to a list: "GARÇON AGITÉ ✓ / GARÇON BRILLANT ✓ / AUTRE : default". The woman holds a sign: "Je suis là." The bouncer looks confused. Navy blue, terracotta, off-white. No text except signs. Wide format 1200x630.`

*Article — Hors Kadre — Katy Ho — Mai 2026*
