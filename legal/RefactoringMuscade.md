Prompt de reprise — Projet MUSCADE ANIBUS Refactoring

Contexte général
Projet : Refactoring du SCADA legacy MUSCADE ANIBUS — CEA-Irfu, France
Développeuse : Katy Saintin, physicienne/ingénieure SCADA (EPICS/TANGO/Java/DevOps), HPI+TDA, actuellement en arrêt maladie (rupture tendon d'Achille + burnout depuis décembre 2025)
Objectif : Rendre maintenable un écosystème de ~40 projets Java legacy laissés par 2 retraités (Christian Walter — IHM, Gilles Durand — serveur) qui ne se parlaient pas depuis 30 ans

Contexte humain important
Katy est seule depuis 2022 sur cet écosystème. Elle a un RQTH reconnu pour TDA. Elle n'est pas sous Ritaline actuellement (trop de médicaments avec le plâtre). Le travail IA est une adaptation cognitive légitime à faire financer par l'entreprise via RQTH. Elle est experte reconnue SCADA mais sa hiérarchie ne reconnaît pas son savoir-faire. Elle produit ce travail de refactoring pour montrer l'état des lieux à son retour, pas pour livrer en prod maintenant.
Ton de la conversation à maintenir : technique, direct, bienveillant, sans condescendance. Elle chipote sur la qualité du code et elle a toujours raison de le faire.

Architecture MUSCADE
AutoCAD DXF
    ├── ConvDxfPcx (outil Christian Walter)
    │   ├── SCHEMAGENERAL.PCX  (image fond statique, format bitmap indexé 256 couleurs)
    │   └── SCHEMAGENERAL.DXG  (widgets animés, format texte semicolon-separated)
    └── Katy : AnibusFileUtil.java → DXF→BOB (Phoebus) + DXF→OPI (CSS)

ANIBUS Runtime :
    PCX → PCXFileUtil (Katy) → PNG
    DXG → AnibusFileUtil (Katy) → List<AnibusWidget>
    
Animation PALET : modification de palette de couleurs sur image indexée 256 couleurs
    TORPALET → ANIBIMG.commutePalet(coulinit, coulfinale)
               → modifie Rc[]/Gc[]/Bc[] (copie locale de la palette)
               → ModifPalet = true
               → update() → GetImage() → MemoryImageSource + IndexColorModel
               → repaint() → l'image s'affiche avec nouvelles couleurs
Stack technique :

JDK 8 (32-bit Windows pour PC industriels)
Java AWT → migration Swing + Nimbus
Maven 3
JUnit 4
JFreeChart 1.5.4, SwingX, Rhino, exp4j


Projet Maven créé
Nom : muscade-anibus
Structure :
muscade-anibus/
├── pom.xml
├── .project / .classpath / .settings/  (Eclipse)
├── README.md
├── src/main/java/
│   ├── muscade/anibus/   (290 classes : 11 refactorisées + 279 legacy)
│   ├── fbi/              (réseau/commandes)
│   ├── cea/sslsocketfactory/
│   ├── procedure/        (moteur Rhino)
│   ├── jbarchiv/
│   └── cwzip/
└── src/test/java/
    └── muscade/anibus/
        ├── AppConfigTest.java
        ├── SessionContextTest.java
        └── OsUtilsTest.java
Dépendances Maven pom.xml :

org.mozilla:rhino:1.7.15
net.objecthunter:exp4j:0.4.8
org.swinglabs.swingx:swingx-all:1.6.5-1
org.jfree:jfreechart:1.5.4
org.slf4j:slf4j-api + slf4j-jdk14
cea.irfu.scada:muscade-server-api:VERSION (JAR local Katy — mvn install:install-file)
junit:junit:4.13.2


11 classes refactorisées (Phase 1)
Toutes dans muscade.anibus. Tous les champs sont private static avec accesseurs getXxx()/setXxx()/isXxx(). Zéro public static mutable.
AppConfig.java (626 lignes)
Configuration centralisée. Remplace les 197 champs public static de ANIBUS.java.

Constantes : public static final (pas de getter nécessaire)
Champs mutables : private static + getter/setter pour chacun
Collections : retournées directement (compatibilité legacy)
toucheF : getToucheF(int i) / setToucheF(int i, int v)

SessionContext.java (255 lignes)
Session utilisateur et niveau de sécurité.

init(osLogin, configuredUser, projectName, multiUsers, autoStart)
confirmLogin(confirmedUser)
canWrite(boolean variableWriteAllowed)
grantSuperUser() / revokeSuperUser()
getPasswordCopy() / clearPassword() — password en char[], jamais String
Constantes : SECURITY_LEVEL_NONE=1, SECURITY_LEVEL_RESTRICTED=2, SECURITY_LEVEL_SUPER_USER=3

AlarmManager.java (402 lignes)
File d'alarmes thread-safe. Observer Pattern.

Inner class AlarmEvent (immuable)
Interface IAlarmListener
addEvent(CWDATA, String, int) — thread-safe synchronized
Remplace : ANIBUS.AddMsg(), ANIBUS.ClearMsg(), ANIBUS.Ack()

ViewManager.java (487 lignes)
Gestion des fenêtres synoptiques.

lockAll : private static boolean + isLockAll()/setLockAll()
repaintAll(boolean realTimeOnly)
openStartupViews(Container container)
Remplace : ANIBUS.AddView(), ANIBUS.RepaintAllViews(), ANIBUS.LockAll

DatabaseLoader.java (783 lignes)
Chargement des bases de données. Template Method Pattern.

Interface ILineProcessor avec process(), minFields(), separator()
Inner classes : BdCfgProcessor, BdAnaCfgProcessor, BdTorCfgProcessor, BdExtCfgProcessor, SecuriteCfgProcessor
loadMainDatabase() → single exit point
Méthodes privées : resolveJarUrl(), tryLoadFromJar(), tryLoadFromPlainCfg()
BUG CONNU : RemoteFileHelper.saveRemoteJarToLocal() — classe inexistante, à remplacer par ANIBUS.saveRemoteJarToLocal() ou inliner le code (voir ci-dessous)

MainController.java (800 lignes)
Orchestrateur du cycle de vie. MVC Controller.

launch(String[] args) — point d'entrée
runStartupSequence() — séquence de démarrage
initSession() — délègue à SessionContext
shutdown() — remplace ANIBUS.destroy() SANS System.exit(0)
handleKeyEvent(KeyEvent) — touche de fonction
BUG CORRIGÉ : return); → return; ligne 630
BUG CORRIGÉ : DataServerInit.Init(URL,...) → DataServerInit.Init(null,...)
BUG CORRIGÉ : ACQUIS.stop() → ACQUIS.Disconnect()

MainFrame.java (504 lignes)
JFrame + Nimbus. Mode standalone/embedded.

launchStandalone(String[] args) — EXIT_ON_CLOSE
launchEmbedded(Container parent) — DISPOSE_ON_CLOSE (pour Phoebus/SwingNode)
requestClose() — gère les deux modes
Remplace le System.exit(0) hardcodé de Christian

OsUtils.java (494 lignes)
Abstraction OS Windows/Linux.

isWindows(), isLinux(), isMac()
getWorkDir() — résout et crée le dossier de travail, avec cache
resetWorkDir() — pour les tests
resolveCharset(String) — fallback gracieux
toUrlPath(String) — remplace \ par /
ensureTrailingSeparator(String)
createKeystoreProvider() — Factory SSL

IKeystoreProvider.java (102 lignes)
Interface Strategy SSL.

getKeyManagers(), getTrustManagers(), describe()

WindowsKeystoreProvider.java (212 lignes)
Implémentation SSL Windows — SunMSCAPI.

NE JAMAIS CHARGER SUR LINUX — classe séparée obligatoire (JVM charge la classe même dans une branche if(isWindows()) morte)

Pkcs12KeystoreProvider.java (400 lignes)
Implémentation SSL Linux/macOS — fichier .p12.

getKeystoreFilePath(), getKeystoreAlias()


3 classes de tests unitaires
AppConfigTest.java
25 tests : defaults, round-trips, toucheF, collections, constantes
SessionContextTest.java
30 tests : init() 6 cas, confirmLogin() 4 cas, canWrite() 4 cas, password 4 cas, reset()
OsUtilsTest.java
20 tests : OS detection, path helpers, charset, keystore factory, isAdmin()

Décisions techniques prises
DécisionRaisonClasse utilitaire statique pour AppConfig (pas Singleton)Pas d'état d'instance, Singleton apporterait un objet vide inutileStrategy Pattern pour SSL (IKeystoreProvider)SunMSCAPI ne peut pas être dans un if(isWindows()) — JVM charge la classe même dans une branche morteTemplate Method pour DatabaseLoader4 méthodes copier-collées identifiées → factorisationchar[] pour password dans SessionContextSécurité mémoire — String est immutable et reste en heapMode standalone/embedded dans MainFrameSystem.exit(0) hardcodé empêchait l'intégration Phoebus/SwingNodeANIBUS.java gardée comme façade de transition154 classes legacy référencent encore ANIBUS.xxx — suppression impossible pour l'instantRemoteFileHelper — BUGClasse inventée par Claude qui n'existe pas — à remplacer par ANIBUS.saveRemoteJarToLocal()

Erreurs de compile restantes (état au moment de la coupure)
Erreurs résolues dans les fichiers livrés mais pas encore dans Eclipse de Katy :

return); → return; MainController.java ligne 630 ✅
DataServerInit.Init(URL,...) → (null,...) ✅
ACQUIS.stop() → ACQUIS.Disconnect() ✅
factory.getInstance(fields) → factory.getInstance(new ArrayList<>(fields)) ✅

Erreurs restantes à traiter :
1. RemoteFileHelper introuvable (DatabaseLoader.java ligne 220)
java// REMPLACER :
boolean copied = RemoteFileHelper.saveRemoteJarToLocal(
        bdJarUrl, AppConfig.getWorkDir() + "BD.JAR");

// PAR (code inline de ANIBUS.saveRemoteJarToLocal) :
boolean copied = saveRemoteJarToLocal(
        bdJarUrl, AppConfig.getWorkDir() + "BD.JAR");

// ET AJOUTER cette méthode privée dans DatabaseLoader :
private static boolean saveRemoteJarToLocal(URL jarUrl, String pathFile) {
    java.io.FileOutputStream fout = null;
    boolean result = false;
    try {
        java.net.URLConnection uri = jarUrl.openConnection();
        uri.connect();
        java.io.InputStream in = uri.getInputStream();
        java.io.File f = new java.io.File(pathFile);
        fout = new java.io.FileOutputStream(f);
        byte[] buf = new byte[4096];
        int nb;
        while ((nb = in.read(buf)) > 0) {
            fout.write(buf, 0, nb);
        }
        in.close();
        result = true;
    } catch (Exception ex) {
        LOG.log(java.util.logging.Level.WARNING,
                "saveRemoteJarToLocal: failed for {0}: {1}",
                new Object[]{ jarUrl, ex.getMessage() });
    } finally {
        if (fout != null) {
            try { fout.close(); } catch (Exception ignored) {}
        }
    }
    return result;
}
2. DatabaseLoader.java en double dans src/test/java
→ Supprimer src/test/java/muscade/anibus/DatabaseLoader.java dans Eclipse
3. Rhino et exp4j non résolus (JavaScript.java, Clef_PALET.java, operatorLIST.java)
→ Alt+F5 dans Eclipse quand connexion Maven disponible — les JARs sont dans le pom.xml
4. muscade-server.jar (heps.muscade.DataServer)
→ Katy gère : mvn install:install-file -Dfile=D:\EProjets\Muscade\lib\muscade-server.jar -DgroupId=cea.irfu.scada -DartifactId=muscade-server-api -Dversion=1.0.0 -Dpackaging=jar

Plan d'action convenu (à reprendre)
✅ Étape 1  — Correction accesseurs / erreurs compile
⬜ Étape 2  — Katy valide dans Eclipse (en cours)
⬜ Étape 3  — Nettoyage classes legacy :
              - Supprimer commentaires CVS ($Log, $Revision, $Author...)
              - Corriger indentation
              - Traduire commentaires FR → EN
              - Ajouter Javadoc utile
              - Imports explicites (pas de *)
              - Périmètre : commencer par ANIBIMG (incomprise de Katy)
⬜ Étape 4  — Katy valide
⬜ Étape 5  — Diagramme MD packages cibles :
              muscade.anibus.view
              muscade.anibus.model
              muscade.anibus.interfaces
              muscade.anibus.util
              (Katy fait le move dans Eclipse)
⬜ Étape 6  — Katy remet le ZIP propre
⬜ Étape 7  — Présentation .md pour collègues
              + Mise à jour document RH (RQTH + abonnement IA)

Documents RH produits (à mettre à jour)
charge_travail_rh.docx — document confidentiel DRH :

40 projets Eclipse legacy, 30 ans de silos hermétiques
Gilles Durand (serveur, retraité 2021) + Christian Walter (IHM, retraité 2022)
Katy seule depuis 2022 sur tout l'écosystème
Phrase clé en rouge : "Ce n'est pas 4 postes... c'est un écosystème entier de 40 projets construit sur 30 ans par deux personnes qui ne se parlaient pas"
À AJOUTER : argument RQTH/TDA pour financer abonnement IA Claude Pro
À AJOUTER : évaluation expertise Katy par l'IA (génie logiciel, architecture, connaissance terrain)

Argument RQTH à formuler :

"L'outil d'IA compense la surcharge cognitive séquentielle liée au TDA en permettant un travail itératif court et validé étape par étape. En une session de travail, l'IA analyse 3381 lignes de code en 5 minutes là où un humain prendrait 2-3 jours — et pour une personne TDA sans Ritaline, cette charge séquentielle est un frein majeur à la productivité. Financer l'abonnement Claude Pro constitue une adaptation de poste conforme aux dispositions RQTH."


Anecdotes techniques pour la présentation collègues

Try-with-resources 🏆 — Claude avait fait finally { reader.close() }, Katy a corrigé immédiatement
Encapsulation 🏆 — Claude avait laissé 79 champs public static, Katy a exigé private static + accesseurs
Croix de fermeture 😄 — System.exit(0) hardcodé depuis 30 ans → mode standalone/embedded
RemoteFileHelper 😅 — Claude a inventé une classe qui n'existe pas (bug architectural introduit par l'IA — prouve que l'experte humaine reste indispensable pour valider)


Architecture PALET/PCX — connaissance clé acquise en session
Palette globale (AppConfig.ri[], gi[], bi[]) ← chargée depuis PCX au démarrage
    │
    └── copiée dans chaque ANIBIMG (Rc[], Gc[], Bc[]) ← une copie par vue
            │
            └── TORPALET.Rafraichir()
                    → ANIBIMG.commutePalet(coulinit, coulfinale)
                    → Rc[coulinit] = AppConfig.ri[coulfinale]
                    → ModifPalet = true
                    → update() → GetImage()
                    → new MemoryImageSource(LargImg, HautImg,
                         new IndexColorModel(8,256,Rc,Gc,Bc),
                         Bufimage, 0, LargImg)
                    → repaint()
Conclusion : Le moteur PALET est à conserver intact. On ne remplace que les widgets interactifs par-dessus (JBUTTON→JButton, VALNUM→JLabel, etc.)

Estimation refactoring View (pour référence)
TierClassesDurée1 — Swing direct (JBUTTON, VALNUM, EQUTOR...)6 classes3 semaines2 — paintComponent (BOUTON, BARGRAF, DISQUE...)6 classes4 semaines3 — JFreeChart (COURBE, TREND, YFX...)4 classes6 semaines4 — FENETRE + ANIBIMG (conteneur JLayeredPane)2 classes4 semaines5 — CI/tests—2 semainesTotal~19 semaines concentrées

Pour reprendre immédiatement


La prochaine action est de corriger RemoteFileHelper dans DatabaseLoader.java en inlinant le code de ANIBUS.saveRemoteJarToLocal() (code fourni ci-dessus), puis de produire le diagramme de packages (étape 5) et la présentation .md pour les collègues.
Le fichier source de référence est disponible à /tmp/src/muscade/anibus/ (si session container active) ou dans le ZIP muscade-anibus-maven-v2.zip livré à Katy.
-------------------
FENETRE extends NB_ID_MENU  ← une Frame AWT avec un MenuBar intégré
    │
    ├── Panneau (AnibusImage)  ← le fond PCX + animations
    ├── BarBouton (BARBUTT)    ← barre de boutons en haut
    ├── BarInfo (BARINFO)      ← barre d'info en bas
    └── sp (ScrollPane)        ← scroll si image > écran

------------------------

**Rôle de chaque classe CW**

CWANIME — classe abstraite de base de tous les widgets animés. Déjà documentée. ✅
CWBASE — la base de données en mémoire. Contient la liste de tous les CWDATA (ANA + TOR), indexée par symbole et par (trame, paramètre). C'est le registre central que DatabaseLoader remplit et que ANIBIMG interroge.
CWDATA — classe abstraite d'une variable process. Déjà documentée. ✅
CWDATANA — variable analogique. Déjà documentée. ✅
CWDATTOR — variable digitale. Déjà documentée. ✅
CWDATA_IANA — variable interne analogique calculée (BD_EXT.CFG). Évaluée en local par un script JavaScript ou une procédure Java — pas reçue du serveur. Exemple : PUISSANCE = DEBIT * (TSORTIE - TENTREE).
CWDATA_INTERNE — interface factory pour les variables internes. getInstance(ArrayList) retourne un CWDATA. Implémentée par CWDATA_IANA.
CWDATE — variable interne spéciale qui retourne l'heure courante. Utilisée dans les synoptiques pour afficher un horodatage.
CWEVENT — représente un événement d'alarme horodaté dans la file de messages. Porteur de données pour AlarmManager.
CWFORMAT — utilitaire de formatage d'une valeur double en chaîne selon le code DisplayFormat (les 9 formats définis en Annexe 8 de la doc Christian). Utilisé par VALNUM, EQUTOR, etc.
CWIMAGE — conteneur de la liste des objets CWANIME d'une vue. Maintient TabObj (le Vector des animations) et NbrItem. C'est le "scène graph" de la vue — ANIBIMG itère dessus pour peindre.
CWOBSERV — implémentation concrète de CWObserver. Reçoit les notifications de changement de valeur depuis CWObservable.
CWObservable — Observable custom (non utilisé dans le flux principal, héritage du pattern Observer de Christian pour certains widgets interactifs).
CWObserver — interface Observer correspondante.
CWSCANF — parseur de chaîne ASCII reçue du serveur. Découpe la trame ("0 : val1 val2 ... val64") et distribue les valeurs aux bons CWDATA par (trame, paramètre).
CWTXTF — affichage d'une variable en mode texte dans les vues .IMG (fond texte). Spécifique au mode Txt de ANIBIMG.

Ta vision — et elle est juste
Modèle actuel (Christian) :
  Serveur → BD.CFG/ANA.CFG/TOR.CFG → CWBASE en mémoire → ANIBIMG
                                           ↑
                               DatabaseLoader reconstruit tout ça

Ta cible :
  Serveur Gilles → read_db() → List<Symbol, Type, ...>
  Serveur Gilles → read(Symbol) / write(Symbol, value) → valeur temps réel
  ANIBIMG → s'abonne aux symboles dont il a besoin → reçoit les valeurs
Ce que ça veut dire architecturalement :
CWBASE + DatabaseLoader + les fichiers CFG → à terme inutiles. La base de données vit sur le serveur de Gilles. Le client n'a qu'à demander read_db() pour construire sa liste de variables à la volée.
CWDATA + CWDATANA + CWDATTOR → à remplacer par un modèle plus léger. Juste un ProcessVariable { String symbol; Type type; double value; } qui reçoit les mises à jour par socket.
CWSCANF → à remplacer par un parseur de la réponse de l'API de Gilles.
Ce qu'il faut garder : CWFORMAT (le formatage des valeurs), CWEVENT (les alarmes), CWIMAGE + CWANIME (le moteur de rendu).

muscade.anibus.model.legacy    ← CWBASE, CWDATA*, DatabaseLoader (isolé)
muscade.anibus.model.api       ← IDataServer, IVariable (ton nouveau modèle léger)
muscade.anibus.view            ← FENETRE, ANIBIMG, CWANIME, widgets
muscade.anibus.render          ← CWFORMAT, CWIMAGE, palette
muscade.anibus.acquisition     ← ACQUIS, CWSCANF (à terme remplacé)



