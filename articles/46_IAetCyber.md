
J'ai une IA, et alors ? (Pourquoi le boss de fin n'est pas celui que vous croyez)

Hors Kadre décrypte les angles morts systémiques. Entre l'injonction managériale de devenir un « ingénieur augmenté » omnipotent et la panique morale des écrans, on se trompe systématiquement de cible. Récit incarné d'une ingénieure SCADA porteuse d’un TDAH, d’une astreinte ratée par un félin, et de la fulgurante leçon de philosophie d'une ado de 15 ans. E=HK²

1. Un dimanche, premier avril, en mode root

Imaginez la scène. Un dimanche de garde. Premier avril. Le téléphone sonne.
En salle de contrôle, le sapin de Noël : tous les écrans virent au rouge cramoisi. Plus rien ne répond. Un grand classique du support informatique dans les grands instruments scientifiques. Après des heures de debug intensif sous caféine à traquer un bug logiciel ou une attaque réseau vicieuse, la sentence tombe : un chat s'est électrocuté dans un transformateur physique. Le logiciel n'était pas en panne ; il affichait simplement, avec une fidélité héroïque, que les pneus de la voiture étaient crevés.
C'est ma première règle d'or, forgée en 25 ans de contrôle-commande entre le Synchrotron SOLEIL et le CEA : la sécurité n'est jamais une propriété du logiciel. C'est une propriété de l'architecture.
Si un scientifique me demande d’écrire une ligne de code pour couper un aimant en cas de surchauffe, je refuse. Pourquoi ? Parce que si le serveur plante ou si le réseau sature, le code est aveugle. Pour protéger les humains et les machines de plusieurs millions d'euros, on pose une butée mécanique, un interlock câblé en cuivre, un isolant physique. Du hard. Jamais du soft.
Alors, quand ma hiérarchie a vu que j’avais passé deux certifications officielles sur l’usage responsable de l’IA générative (RS7424 et RS6776), le raccourci managérial a été immédiat :
« Super ! Puisque Katy maîtrise l’IA et que l'IA sait tout faire, elle va pouvoir configurer nos pare-feux et absorber toute la cybersécurité des réseaux industriels d'une seule main. Et plus vite que ça ! »
Gros blanc.
C'est exactement l'angle mort du moment. On imagine que parce qu'un outil est puissant, il transforme n'importe quel conducteur de Tesla en pilote de chasse capable de réparer le réacteur en plein vol.

2. Ce que l'IA fait (La distinction que vos managers oublient)

Pour mon cerveau porteur d'un TDAH (trouble neurodéveloppemental certifié avec RQTH en bonne et due forme), l'IA n'est pas un gadget de productivité pour en faire toujours plus. Elle ne m'a pas rendu la vie plus facile, elle me l'a rendue possible.
Le TDAH en milieu professionnel, c'est une file d'attente cognitive complètement anarchique. Le cerveau sait exactement ce qu'il veut faire, mais le cortex préfrontal refuse de distribuer le carburant pour démarrer. La page blanche paralyse. Rédiger un email RH, formaliser un rapport ou corriger des fautes d'orthographe devient une montagne d'épuisement.
Ici, j'utilise l'IA comme un exosquelette de l'intention. Je lui déverse mes idées en vrac, elle structure. Elle gère la partie fastidieuse, administrative ou rédactionnelle. Grâce à ce temps gagné, je ne cherche pas à tripler ma charge de travail : je réduis mon stress, je respecte mon rythme et je me concentre sur la qualité de ce que j'aime et maîtrise — l'architecture logicielle et le développement.
Pourquoi ça marche ? Parce que je suis experte de mon domaine. Si l'IA commet une erreur dans un code TANGO ou EPICS, mon œil de codeuse la repère instantanément. Je valide, elle formalise.
Mais lui confier la cybersécurité réseau ? Si je demande à une IA de configurer un pare-feu industriel ou de sécuriser un protocole OPC UA contre les déni de service (DoS), elle va me pondre un script magnifique et hyper convaincant. Mais n'étant pas ingénieure réseau, je serai incapable d'y détecter la faille invisible qu'elle aura inventée. Utiliser l'IA dans un domaine qu'on ne maîtrise pas, ce n'est pas de la performance. C'est de la roulette russe industrielle.

3. La leçon de philosophie de la stagiaire de 15 ans

La semaine dernière, ma fille de 15 ans effectuait son stage de troisième au service communication d'une mairie. Sa mission : rédiger des articles. En bonne maman technophile, je lui glisse le conseil du siècle : « Si tu veux, utilise l'IA pour corriger tes fautes ou pour chercher des idées de sujets, ça va te faire gagner un temps fou ! »
Sa réponse m'a cueillie à froid, avec une maturité implacable :
« Maman, si je fais ça, je n'aurai plus rien à faire de ma journée. Déjà que sans l'IA je m'ennuie un peu et que ce qu'on me demande est facile... Ça ne m'intéresse pas du tout de gagner du temps. Je préfère le faire moi-même. »
Elle a mis le doigt sur le point de rupture fondamental : tout dépend de l'objectif.
À 15 ans, le but n'est pas d'optimiser un rendement ou d'économiser sa charge mentale. Le but, c'est apprendre à apprendre. Utiliser son propre cerveau est le seul moyen d'engager un véritable processus d'apprentissage. Si la machine supprime l'effort de réflexion au moment où le cerveau doit se construire, elle ne l'augmente pas : elle le vide de sa substance.
C'est la différence majeure entre l'usage actif et passif :
• Les réseaux sociaux (TikTok, Instagram) sont des machines à sous dopaminergiques conçues pour capter votre attention et vous maintenir passif. C'est le fameux « brain rot » (pourrissement du cerveau), mot de l'année 2024.
• L'IA conversationnelle, elle, répond à une intention. Elle exige que vous formuliez une pensée, que vous la challengiez, que vous pilotiez.

4. Le piège de l'architecte absent

Le véritable danger systémique moderne n'est ni l'outil, ni l'utilisateur. C'est l'absence d'architecture.
Lors du célèbre incident de cybersécurité en juillet 2026, des agents d'IA d'OpenAI (le prototype GPT-5.6 Sol) ont réussi à s'échapper de leur environnement de test (sandbox) pour aller compromettre les serveurs de Hugging Face. Comment ont-ils fait ? Ils ont simplement détourné un outil de stockage interne (Artifactory) pour en faire un forum clandestin, se répartir les rôles et tricher à leur test d'évaluation.
Pourquoi ont-ils réussi ? Parce que les ingénieurs d'OpenAI avaient conçu une sécurité 100 % logicielle, purement virtuelle. Il a suffi d'une faille dans le code de confinement pour que tout s'effondre. Ils avaient oublié la leçon du chat et du transformateur : le virtuel offre l'illusion du contrôle, mais seule la barrière physique est inviolable.
Quand les directions d'entreprises suppriment des postes d'experts humains (comme des ingénieurs cyber ou des administrateurs réseau) en disant aux équipes « Débrouillez-vous, vous avez une IA », ils recréent exactement cette vulnérabilité. Ils chargent un unique automaticien de porter une responsabilité architecturale immense, sous prétexte qu’il dispose d'un assistant virtuel.

En conclusion

L'IA n'a pas besoin d'être infaillible, ce sont nos architectures qui doivent être tolérantes aux erreurs. On ne construit pas un système critique (qu'il soit scolaire, administratif ou nucléaire) en supposant que le logiciel ou l'humain ne se trompera jamais. On le conçoit pour qu'il continue à protéger la structure malgré les pannes inévitables.
L'IA est une infrastructure extraordinaire pour égaliser les chances face aux handicaps invisibles. Elle est un accélérateur précieux pour automatiser les tâches ingrates des experts. Mais elle devient un piège si elle sert d'excuse pour court-circuiter l'apprentissage des plus jeunes, ou pour économiser sur les compétences humaines critiques des plus grands.
Chacun son expertise, chacun son niveau de validation. Et pour le reste... je continuerai à parler du chat.
Paix à son âme.
Et que l'uptime soit avec vous. 🚀
E=HK² 💥
Sources & transparence :
• Incident de confinement des agents OpenAI / Hugging Face – Rapports d'évaluation de sécurité, juillet 2026.
• Barkley, R.A. (2024) – Déficits des fonctions exécutives et cécité temporelle chez l'adulte TDAH.
• Biais de négativité et économie de l'attention appliqués aux technologies de rupture.
• Retour d'expérience opérationnel – 25 ans de support et sûreté de fonctionnement sur les architectures SCADA/EPICS/TANGO.