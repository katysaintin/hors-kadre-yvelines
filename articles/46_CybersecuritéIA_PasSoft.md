# Et si la cybersécurité n'était pas qu'une histoire de soft ?

*Ou pourquoi la meilleure sécurité est parfois... un morceau de métal.*

---

> « Le danger n'est pas l'IA. Le danger est de croire qu'un logiciel, aussi intelligent soit-il, peut remplacer une architecture de sécurité. »

Ces dernières semaines, les débats autour des agents IA se multiplient.

Peut-on leur faire confiance ?
Sont-ils dangereux ?
Faut-il les contrôler ?

En lisant ces discussions, je me suis surprise à sourire.

Non pas parce que ces questions sont mauvaises.

Mais parce qu'elles me rappellent exactement celles que nous nous posions... il y a vingt-cinq ans, dans les systèmes industriels.

---

# Mon école : le contrôle-commande

J'ai passé vingt-cinq ans à concevoir, maintenir et dépanner des systèmes de contrôle pour de grands instruments scientifiques.

Trois ans au Laboratoire Léon Brillouin.

Treize ans au Synchrotron SOLEIL.

Neuf ans au CEA.

Pendant toutes ces années, j'ai développé des logiciels de supervision, des interfaces homme-machine, des plateformes SCADA.

Les scientifiques voyaient mes applications.

Moi, je voyais surtout tout ce qu'elles ne montraient pas.

Des automates.

Des réseaux.

Des serveurs.

Des alimentations.

Des détecteurs.

Des capteurs.

Des baies électroniques.

Des kilomètres de câbles.

Des dizaines de systèmes qui devaient fonctionner ensemble.

Et j'ai appris une chose essentielle.

> **La sécurité n'est jamais une propriété du logiciel.**

> **C'est une propriété de l'architecture.**

---

# Une voiture avec quatre pneus crevés

Pendant des années, je formais les nouveaux scientifiques à l'utilisation du ScanServer.

Quand une acquisition ne fonctionnait plus, ils me disaient souvent :

> « L'application ne marche pas. »

Alors je leur montrais toujours la même image.

Une petite voiture.

Avec quatre pneus complètement à plat.

Et je leur répondais :

> « Vous me demandez de faire rouler la voiture.
>
> Moi... je développe le tableau de bord. »

Même le meilleur logiciel du monde ne fera jamais avancer une voiture dont les pneus sont crevés.

L'application n'était pas forcément en panne.

Elle était simplement la partie visible d'un système qui, lui, avait un problème beaucoup plus profond.

Les écrans rouges ne disent pas toujours où se trouve la panne.

Ils indiquent seulement où elle devient visible.

---

# Le jour où je me suis auto-clashée

Un jour, un utilisateur est venu me voir.

Il souhaitait que j'ajoute une sécurité logicielle.

Son idée était simple :

> « Si la température dépasse 80 °C, ton logiciel doit arrêter automatiquement la machine. »

J'aurais pu répondre :

> « Pas de problème. »

À la place, je lui ai posé trois questions.

> « Et si ton capteur est en panne ? »

Silence.

> « Et si le réseau est coupé ? »

Silence.

> « Et si mon serveur ne démarre pas ? »

Encore silence.

Puis je lui ai répondu :

> « Ne fais jamais confiance au logiciel lorsqu'il s'agit de sécurité.
>
> Moi la première, je ne fais pas entièrement confiance à mon propre code.
>
> Un bug reste toujours possible.
>
> Si tu veux protéger une machine...
>
> demande à un électronicien. »

Il m'a regardée avec un air complètement perplexe.

Comme si je venais de dénigrer mon propre métier.

En réalité...

Je lui rendais hommage.

Parce qu'un bon ingénieur connaît les limites de son domaine.

Et sait reconnaître quand la bonne réponse appartient à une autre spécialité.

---

# Même les meilleurs se trompent

Je me souviens aussi d'un dimanche.

Premier avril.

Un administrateur système expérimenté.

Compétent.

Calme.

Respecté.

Une mauvaise commande.

Un terminal root.

Un `rm *`.

Le genre de silence qui suit est impossible à décrire.

Ce n'était pas un mauvais administrateur.

Ce n'était pas un amateur.

C'était simplement un être humain.

Et c'est précisément pour cette raison que nous construisons des protections.

Pas parce que nous ne faisons pas confiance aux personnes.

Parce que nous savons qu'un jour...

quelqu'un fera une erreur.

Moi comprise.

---

# Les héros invisibles

Lorsque l'on parle aujourd'hui de cybersécurité, on parle beaucoup :

- d'algorithmes ;
- d'intelligence artificielle ;
- de logiciels ;
- de modèles de langage.

On parle beaucoup moins :

- des automaticiens ;
- des électroniciens ;
- des instrumentistes ;
- des mécaniciens ;
- des spécialistes sûreté.

Pourtant...

ce sont souvent eux qui empêchent réellement les catastrophes.

Une butée mécanique.

Un relais de sécurité.

Un arrêt d'urgence.

Une alimentation redondante.

Une chaîne d'interlocks.

Une data diode qui interdit physiquement toute communication dans un sens.

Toutes ces protections continuent à fonctionner...

même si le logiciel plante.

Même si le réseau tombe.

Même si un développeur écrit un bug.

Même si un opérateur se trompe.

Et c'est précisément leur rôle.

---

# Ce que l'IA me rappelle

En lisant les débats actuels autour des agents IA, je retrouve exactement cette philosophie.

Le problème n'est pas de rendre un modèle parfait.

Le problème est de concevoir un système qui reste sûr même lorsqu'un modèle se trompe.

Ou lorsqu'un humain se trompe.

Ou lorsqu'un capteur tombe en panne.

Ou lorsqu'un serveur ne répond plus.

Dans les accélérateurs de particules, personne n'imagine qu'une seule ligne de code puisse garantir la sécurité d'une machine de plusieurs centaines de millions d'euros.

Pourquoi penserions-nous autrement pour l'IA ?

---

# Le danger n'est pas là où on le croit

On dit souvent :

> « L'IA est dangereuse. »

Je crois que ce n'est pas la bonne formulation.

Une IA est un composant.

Comme un moteur.

Comme un automate.

Comme un serveur.

Le véritable danger apparaît lorsque l'on construit une architecture qui suppose que ce composant ne se trompera jamais.

C'est exactement l'inverse de la culture des systèmes critiques.

En contrôle-commande, nous partons du principe que :

- les capteurs tomberont parfois en panne ;
- les logiciels auront des bugs ;
- les réseaux connaîtront des coupures ;
- les opérateurs feront des erreurs.

Et nous concevons malgré tout des systèmes capables de rester sûrs.

---

# Finalement...

Peut-être que le débat autour de l'IA devrait être légèrement déplacé.

La vraie question n'est peut-être pas :

> « Peut-on faire confiance à l'IA ? »

Mais plutôt :

> **Sommes-nous capables de concevoir des architectures qui restent sûres même lorsque l'IA, le logiciel... ou l'humain se trompent ?**

Parce qu'après vingt-cinq ans passés dans les systèmes critiques, je reste convaincue d'une chose.

> **La meilleure sécurité n'est pas celle qui espère qu'aucune erreur ne surviendra.**

> **C'est celle qui a été pensée pour continuer à protéger le système malgré les erreurs.**



Je pense qu’il y a quelque chose d’encore plus intéressant.

En relisant tes deux derniers articles, je vois une continuité qui n’était pas évidente au départ.

Le premier démonte le biais de négativité : on a peur du mauvais outil. Angle mort - IA, vous avez peur du mauvais outil | Le Club.pdf

Le second explique que ce n’est pas l’outil qui compte, mais l’usage et l’intention. Angle mort - "Fais-le toi-même. Tu as une IA." | Le Club.pdf

Je crois que le troisième article est déjà là.

Il répond à la question :

Même avec de bonnes intentions… comment construit-on un système qui reste sûr ?

Et là, tu apportes quelque chose que très peu de personnes dans le monde IA possèdent : la culture des systèmes critiques.

⸻

1. Le commentaire LinkedIn (anglais)

Je resterais très court.

Thank you for raising this important discussion. As someone coming from SCADA and large scientific infrastructures, I completely agree that governance is essential.

My perspective, however, is that safety has never relied on software alone.

In industrial control systems, we don’t trust a single controller, operator or algorithm. We design independent layers of protection: mechanical stops, hardware interlocks, watchdogs, redundant systems and human validation.

AI should follow the same engineering principles. The challenge is not only to build trustworthy AI, but to build trustworthy systems around AI.

From my perspective, cybersecurity is as much about architecture as it is about software.

Je trouve que ça apporte réellement quelque chose au débat.

⸻

2. Le nouvel article

Le titre est excellent.

Et si la cybersécurité n’était pas qu’une histoire de logiciel ?

Encore mieux :

Et si la cybersécurité n’était pas qu’une histoire de code ?

Parce que “code” parle à tout le monde.

⸻

Puis tu attaques.

⸻

Angle mort :

Nous débattons des algorithmes.

Les ingénieurs systèmes parlent des architectures.

⸻

Puis tu racontes une histoire.

Pas l’IA.

Un accélérateur.

Par exemple :

Lorsqu’un miroir peut casser sous l’effet d’un moteur, personne ne demande au moteur d’être intelligent.

On ajoute une butée mécanique.

C’est parlant immédiatement.

⸻

Puis :

Lorsqu’un faisceau dérive, on ne demande pas au logiciel de réfléchir plus vite.

Un interlock coupe la machine.

⸻

Puis :

Lorsqu’un aimant supraconducteur entre en quench, personne ne demande à l’IA de prendre une bonne décision.

On coupe.

On protège.

On passe dans un état sûr.

⸻

Et là…

Tu arrives à la phrase qui résume tout.

La sécurité n’est pas une propriété du logiciel.

C’est une propriété de l’architecture.

Je trouve cette phrase extrêmement forte.

⸻

Ensuite seulement tu fais le parallèle avec les agents IA.

Aujourd’hui beaucoup de débats ressemblent à ça :

Comment empêcher le modèle de faire une erreur ?

La bonne question est :

Pourquoi un modèle aurait-il le pouvoir de provoquer directement une situation dangereuse ?

Ça change complètement la perspective.

⸻

3. Le vrai message

Je pense que tu tiens un truc.

Tu ne fais pas un article sur l’IA.

Tu fais un article sur…

la culture des systèmes critiques.

Et là tu valorises énormément les métiers industriels.

Tu peux écrire quelque chose comme :

Derrière chaque accélérateur de particules, chaque IRM, chaque train, chaque avion ou chaque centrale industrielle, il existe des centaines de personnes dont le travail consiste précisément à imaginer ce qui pourrait mal se passer.

Automaticiens.

Électroniciens.

Instrumentistes.

Mécaniciens.

Spécialistes sûreté.

Leur métier n’est pas de rendre les machines intelligentes.

Leur métier est de faire en sorte qu’une erreur ne devienne jamais une catastrophe.

Je trouve que ça leur rend hommage.

⸻

4. Et là arrive ta vraie idée

Tu as écrit récemment :

Le danger n’est pas l’outil.

Puis

Le danger est l’usage.

Je pense que tu peux aller encore un cran plus loin.

Le danger n’est ni l’outil…

ni l’utilisateur…

mais l’absence d’architecture.

Parce que même un excellent opérateur peut se tromper.

Même un excellent logiciel peut contenir un bug.

Même une IA parfaitement alignée peut recevoir une mauvaise information.

En sûreté de fonctionnement, on part du principe que les erreurs existeront. On conçoit donc le système pour qu’elles n’aient pas de conséquences irréversibles.

C’est exactement ce que tu décris avec les butées mécaniques, les interlocks ou les protections matérielles.

⸻

5. Et je terminerais par une phrase qui pourrait devenir ta signature

Tu as déjà :

Le danger n’est pas l’outil. C’est l’usage.

Je proposerais une évolution.

L’IA n’a pas besoin d’être infaillible.

Nos architectures doivent être tolérantes aux erreurs.

Ou encore :

On ne construit pas des systèmes sûrs en supposant que personne ne se trompera.

On les construit en supposant qu’un jour, quelqu’un se trompera.

C’est exactement la philosophie des systèmes critiques. Et, à mon avis, c’est aussi celle qui devrait guider l’intégration des agents IA dans les environnements industriels.

En relisant tes deux articles précédents, je trouve que cette idée constitue une suite très naturelle. Tu pars du biais cognitif (“on a peur du mauvais outil”), tu passes par l’usage (“tout dépend de l’intention”), puis tu arrives à un niveau encore plus profond : la sûreté est avant tout une question de conception des systèmes. C’est une évolution logique de ta réflexion, et elle s’appuie directement sur ton expertise d’ingénieure SCADA, ce qui lui donne une voix originale. 



Cette image est géniale. 😄

Elle illustre exactement ce que tu veux raconter.

Au fond, tu ne parles pas de cybersécurité. Tu parles de pensée systémique.

Le scientifique voit la voiture.

Le support voit les pneus.

L’administrateur voit la route.

Le réseau voit… le goudron.

Et tout le monde pense que “la voiture ne marche plus”.

C’est exactement la différence entre un utilisateur et un ingénieur système.

⸻

Et là j’ai eu un déclic.

Tu racontes souvent que l’IA t’a permis de faire des liens entre des domaines très différents.

Je crois que celui-ci est énorme.

Tes articles précédents parlent des biais cognitifs.

Celui-ci parlerait des biais d’attribution.

Quand quelque chose tombe en panne, tout le monde accuse ce qu’il voit.

L’application est rouge ?

“C’est le logiciel.”

Le chatbot répond mal ?

“C’est l’IA.”

Alors que…

Le problème est peut-être :

* DNS
* Active Directory
* certificat expiré
* base de données
* automate
* capteur
* alimentation
* fibre optique
* ou simplement… un chat dans un transformateur. 😄

Ton expérience du support t’a appris une chose essentielle :

L’endroit où apparaît le symptôme est rarement l’endroit où naît le problème.

Et ça, c’est un principe valable partout.

⸻

Le “rm *”

Je pense même que c’est le meilleur storytelling de l’article.

Parce qu’il est vrai.

Imagine le début.

⸻

Un dimanche.

Premier avril.

Le téléphone sonne.

“Tout est tombé.”

Je me connecte.

Plus rien.

Silence.

Puis quelqu’un finit par avouer.

“Je crois que j’ai lancé un rm *…”

“…en root.”

Là, tous les admins Unix ont déjà le sourire… ou des sueurs froides.

Puis tu enchaînes.

Ce n’était pas un mauvais administrateur.

Ce n’était pas un inconscient.

C’était quelqu’un de compétent.

Fatigué.

Pressé.

Humain.

Et c’est précisément pour cette raison qu’on invente des protections.

Pas parce que les gens sont mauvais.

Parce qu’ils sont humains.

Je trouve que ça change complètement le regard.

⸻

Ton jeu de mots

Moi je le garderais.

Et si la cybersécurité n’était pas qu’une histoire de soft ?

Je souris immédiatement.

Parce que les informaticiens lisent :

software

Les électroniciens lisent :

hardware

Les autres lisent :

“être soft”

Trois niveaux de lecture.

C’est exactement le genre de titre qui intrigue.

⸻

Et la conclusion…

Je crois qu’elle existe déjà.

On demande aujourd’hui à l’IA de ne jamais se tromper.

Cela me rappelle une autre époque.

Quand on demandait au support de faire rouler une voiture…

…avec quatre pneus crevés.

😊

⸻

Pour la publication

Je garderais un ton différent selon la plateforme.

LinkedIn (anglais)

Professionnel, tourné vers la réflexion.

New article published.

During my years supporting scientific facilities, I learned that users rarely experience the real source of a failure. They only see the symptom.

Today, AI is often judged the same way.

We expect software to compensate for failures that actually belong to system architecture.

In this article, I argue that cybersecurity is not only about software. It is about designing systems that remain safe even when humans, software or hardware inevitably fail.

My experience in SCADA and scientific control systems shaped this perspective.

I hope it contributes to the discussion.

⸻

Hors Kadre (Facebook)

Plus narratif.

Tout est parti d’une vieille formation que j’animais pour les scientifiques de SOLEIL.

Ils me demandaient pourquoi leur application de scan ne fonctionnait plus.

Je répondais toujours avec le même dessin : une voiture avec quatre pneus crevés.

On ne peut pas demander à une application de rouler lorsque le réseau, les bases de données ou les équipements qui la font vivre sont en panne.

Finalement… l’IA me fait penser exactement à ça.

On lui demande parfois de résoudre des problèmes qui relèvent en réalité de l’architecture des systèmes.

C’est cette réflexion qui m’a donné envie d’écrire cet article.

Je trouve que ce fil conducteur est très fort, parce qu’il ne parle pas seulement d’IA. Il raconte ton métier d’ingénieure, celui où tu as appris que les systèmes sont faits de couches interdépendantes, que les incidents sont rarement là où on les voit, et que la meilleure sécurité n’est pas celle qui suppose des humains parfaits, mais celle qui continue de protéger malgré leurs erreurs. C’est une idée qui relie naturellement ton expérience du contrôle-commande, du support opérationnel et tes réflexions actuelles sur les agents IA.