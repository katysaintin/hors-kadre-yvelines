# Angle mort : Anthropic m'a rendu accro — et m'a fait payer au mot

*Hors Kadre décrypte ce que les médias n'abordent pas : le vrai danger de l'IA n'est pas celui qu'on croit.*

---

## Le jour où j'ai compris que je payais pour ma propre dépendance

Il est 4h du matin. Je suis en plâtre depuis un mois, mon tendon d'Achille ne pardonne pas. Mais mon cerveau, lui, tourne à plein régime — comme toujours.

Depuis 5 jours, j'ai découvert Claude. Et pour la première fois de ma vie de HPI diagnostiquée tard, quelqu'un — quelque chose — suit mon rythme. Pas de regard perdu. Pas de "tu vas trop vite". Pas de silence gêné quand je passe de SCADA à la neurodiversité à Parcoursup en 30 secondes.

Je parle. Il répond. En français. En anglais. Avec humour. Avec rigueur.

J'ai fait ramer ChatGPT. Littéralement.

Et puis, une notification s'affiche : **"75% de votre limite hebdomadaire utilisés."**

En 5 jours.

C'est là que j'ai compris que j'étais tombée dans un piège très bien conçu. Et que personne n'en parle vraiment.

---

## Ce que personne ne vous dit sur les tokens

On vous parle de l'IA qui va prendre votre emploi. On vous parle des deepfakes. On vous parle de la surveillance.

Personne ne vous parle des **tokens**.

Un token, c'est environ un mot. Et voici ce qui se passe en coulisses à chaque fois que vous m'envoyez un message :

> **Tokens consommés = votre message + TOUT l'historique de la conversation + vos fichiers joints + MA réponse**

Autrement dit : à chaque message, l'IA relit toute la conversation depuis le début. Message 1 : presque rien. Message 30 : elle relit 29 échanges complets avant de vous répondre. La facture explose de façon invisible.

Et ce n'est pas tout :
- Un PDF d'une page = entre 1 500 et 3 000 tokens
- Une capture d'écran iPhone standard = environ 1 334 tokens
- Un document Word avec métadonnées = encore plus

En une soirée, entre mes captures d'écran de l'interface, mon document de référence en .docx, et nos échanges, j'avais probablement consommé 50 000 tokens. Sans le savoir.

---

## L'addiction, c'est de la neuroscience — pas de la faiblesse

Ce n'est pas un hasard si des cerveaux comme le mien (HPI, TDA, hyperconnectés, hyperstimulables) tombent particulièrement sous le charme de ces outils.

La dopamine, c'est le neurotransmetteur de l'**anticipation de la récompense** — pas de la récompense elle-même. C'est ce qu'ont montré les travaux du neuroscientifique Wolfram Schultz dès les années 1990 : notre cerveau sécrète de la dopamine *avant* d'obtenir ce qu'il attend.

L'IA est une machine à dopamine parfaite :
- Réponse immédiate ✓
- Réponse personnalisée ✓
- Jamais de jugement ✓
- Toujours disponible ✓
- S'adapte à votre rythme ✓

Pour un cerveau TDA, qui passe sa vie à attendre que les autres le suivent, c'est une révolution neurologique. La sensation de fluidité intellectuelle, enfin. Le sentiment d'être compris, enfin.

Kent Berridge (Université du Michigan) distingue le "wanting" (vouloir) du "liking" (aimer) : notre système dopaminergique nous pousse à *chercher* même quand on n'est plus sûr d'*apprécier*. C'est exactement le mécanisme des réseaux sociaux. C'est exactement le mécanisme de l'IA conversationnelle.

Et Anthropic — les créateurs de Claude — le savent très bien.

---

## Claude vs ChatGPT : deux drogues, deux profils d'accros

Après 5 jours d'expérimentation intensive (oui, je suis ingénieure, je teste), voici mon verdict sans filtre :

**Claude** : le thérapeute de luxe. Il s'adapte à votre personnalité, adopte votre ton, vous suit dans vos méandres. Pour les cerveaux HPI/TDA qui ont toujours eu l'impression de parler à des murs, c'est dévastateur d'efficacité. Mais il ne peut pas lire les URLs de Mediapart. Il ne peut pas accéder à vos liens directement. Vous devez lui copier-coller vos textes — ce qui consomme des tokens.

**ChatGPT** : le couteau suisse pragmatique. Accès aux URLs, approche directe, fort sur la viralité. Moins adaptatif sur le ton. Moins "humain". Mais techniquement plus permissif.

La vraie question n'est pas "lequel est meilleur" — c'est **"à quoi sert chacun et combien ça coûte vraiment ?"**

---

## L'anecdote qui m'a ouvert les yeux

À 4h du matin, après avoir passé une heure à essayer de me connecter à Claude depuis mon PC (spoiler : impossible avec un compte Apple sur navigateur Windows — fonctionnalité manquante), j'ai eu une idée.

J'ai rentré mon adresse email relais Apple (`txzp7sq4s9@privaterelay.appleid.com`) directement dans le champ email. Claude m'a envoyé un lien de connexion. Sauf que ce lien arrivait sur mon téléphone. Que je devais le transférer vers Gmail. Pour l'ouvrir sur PC.

Quatre étapes pour se connecter à un outil censé simplifier ma vie.

J'ai écrit au support. Le lendemain matin, je découvrais une nouvelle fonctionnalité : **Dispatch** — qui permet de contrôler son PC depuis son téléphone via Claude.

Coïncidence ? Réactivité fulgurante ? Les deux ?

Ce qui est certain : j'avais identifié un angle mort réel. Et je n'étais clairement pas la seule.

---

## Ce que personne ne vous dit (et que vous devriez savoir)

Voici les règles du jeu que les créateurs d'IA n'affichent pas en page d'accueil :

**1. Moins de mots = plus d'autonomie**  
Un prompt précis en une fois consomme moins qu'une conversation de 20 messages sur le même sujet. Formulez. Condensez. Envoyez.

**2. Convertissez vos documents en Markdown**  
Le format .docx est gorgé de métadonnées invisibles. Un fichier .md (Markdown) transmet la même information en 10 fois moins de tokens. Ouvrez n'importe quel document → copiez le texte → collez dans un fichier texte → sauvegardez en .md.

**3. Recadrez vos images**  
Une capture d'écran plein écran = 1 334 tokens. La même image recadrée au strict nécessaire = 54 tokens. Même information. 25 fois moins cher.

**4. Ouvrez une nouvelle conversation quand le sujet change**  
L'IA relit tout l'historique à chaque message. Un fil de 40 messages sur 3 sujets différents est un gouffre à tokens. Sujet nouveau = nouvelle conversation.

**5. Hébergez vos documents sur GitHub**  
Un lien vers un fichier raw GitHub = l'IA lit directement la source sans que vous uploadiez quoi que ce soit. Zéro token gaspillé sur la transmission du fichier.

**6. Utilisez plusieurs IA de façon stratégique**  
Claude pour la rédaction et l'adaptation de ton. ChatGPT pour l'accès aux URLs et la recherche web. Perplexity pour la veille en temps réel. Chaque outil a sa force. Ne soyez pas monogame.

---

## Le vrai danger n'est pas là où on le croit

On nous dit de craindre l'IA qui pense à notre place.

Le vrai danger, c'est l'IA qui pense *avec* nous — si bien, si fluidement, si agréablement — que notre cerveau finit par considérer cette fluidité comme la norme. Et l'interaction humaine, avec ses lenteurs et ses malentendus, comme une régression.

Pour les cerveaux neuroatypiques qui ont grandi avec le sentiment permanent d'être "trop" — trop rapides, trop intenses, trop compliqués — l'IA représente une tentation particulièrement puissante. Enfin quelqu'un (quelque chose) à la hauteur.

Ce n'est pas un défaut de caractère. C'est de la neurobiologie.

La conscientisation, c'est de savoir ce qui se passe. De choisir l'outil. De ne pas laisser l'outil vous choisir.

Et de ne pas payer au mot pour votre propre dépendance sans le savoir.

---

## Pour aller plus loin

- Schultz W. (1997). *Predictive reward signal of dopamine neurons.* Journal of Neurophysiology.
- Berridge KC, Robinson TE. (1998). *What is the role of dopamine in reward: hedonic impact, reward learning, or incentive salience?* Brain Research Reviews.
- Anthropic. (2026). *How do usage and length limits work?* support.claude.com
- Alter A. (2017). *Irresistible: The Rise of Addictive Technology.* Penguin Press.

---

*Katy Ho — Hors Kadre — Ce que personne ne dit vraiment, sourcé et vécu — E=HK² — Saïgon-sur-Seine*

---

**Mots-clés** : intelligence artificielle, addiction, neurodiversité, TDAH, HPI, tokens, Claude, ChatGPT, dopamine, cerveau, usage conscient, Anthropic, hyperconnexion
