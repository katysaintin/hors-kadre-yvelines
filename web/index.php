<?php
/*
 * Hors Kadre — Page d'accueil
 * Copyright (c) 2026 Katy Saintin
 * Code: MIT License — Content: CC BY-NC 4.0
 */
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Hors Kadre — Comprendre l'orientation, simplement</title>
<meta name="description" content="Hors Kadre : outils gratuits pour comprendre Parcoursup et comparer les lycées. Pour les familles, sans jargon.">

<script async src="https://www.googletagmanager.com/gtag/js?id=G-TTTNJ36H5D"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'G-TTTNJ36H5D', { 'anonymize_ip': true });
</script>

<style>
:root {
  --navy:     #1B3A6B;
  --terra:    #C4572A;
  --offwhite: #F5F0EB;
  --gray:     #666;
  --border:   #d9d1ca;
  --white:    #fff;
}
* { box-sizing: border-box; margin: 0; padding: 0; }
body {
  font-family: Georgia, "Times New Roman", serif;
  background: #fcfaf8;
  color: var(--navy);
  line-height: 1.6;
  min-height: 100vh;
}
a { color: var(--terra); text-decoration: none; }
a:hover { text-decoration: underline; }

/* HEADER */
.site-header {
  background: var(--offwhite);
  border-bottom: 3px solid var(--terra);
  padding: 20px 16px 16px;
  text-align: center;
}
.site-header img {
  max-width: 420px;
  width: 60%;
  height: auto;
  display: inline-block;
  margin-bottom: 10px;
}
.tagline {
  font-size: .88rem;
  color: var(--gray);
  font-style: italic;
  margin-bottom: 10px;
}
.mediapart-links {
  font-size: .82rem;
  margin-bottom: 10px;
  line-height: 2.2;
}
.mediapart-links a {
  margin: 0 8px;
  color: var(--navy);
}
.mediapart-links a:hover { color: var(--terra); }

/* CONTAINER */
.container {
  max-width: 720px;
  margin: 0 auto;
  padding: 40px 20px 80px;
}

/* ACCROCHE */
.accroche {
  text-align: center;
  margin-bottom: 40px;
}
.accroche h1 {
  font-size: 1.35rem;
  color: var(--terra);
  margin-bottom: 10px;
  font-weight: 700;
  line-height: 1.4;
}
.accroche p {
  font-size: .93rem;
  color: var(--gray);
  max-width: 520px;
  margin: 0 auto;
  line-height: 1.7;
}

/* TUILES */
.tuiles {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 16px;
  margin-bottom: 32px;
}

.tuile {
  background: var(--white);
  border: 2px solid var(--border);
  border-radius: 16px;
  padding: 28px 20px 24px;
  text-align: center;
  text-decoration: none;
  color: var(--navy);
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 12px;
  transition: border-color .2s, box-shadow .2s, transform .15s;
  cursor: pointer;
}
.tuile:hover {
  border-color: var(--terra);
  box-shadow: 0 6px 20px rgba(196,87,42,.15);
  transform: translateY(-2px);
  text-decoration: none;
  color: var(--navy);
}

.tuile-icon { font-size: 2.4rem; }
.tuile h2 {
  font-size: 1rem;
  color: var(--navy);
  line-height: 1.3;
  margin: 0;
}
.tuile p {
  font-size: .82rem;
  color: var(--gray);
  line-height: 1.5;
  margin: 0;
}
.tuile .badge {
  display: inline-block;
  background: #fef3c7;
  color: #92400e;
  border: 1px solid #fcd34d;
  border-radius: 10px;
  font-size: .72rem;
  font-weight: 700;
  padding: 2px 8px;
}
.tuile-primary {
  border-color: var(--terra);
  background: linear-gradient(135deg, #fff 80%, #fdf5f2);
}

/* CITATION */
.citation {
  background: var(--offwhite);
  border: 1px solid var(--border);
  border-radius: 10px;
  padding: 16px 20px;
  margin-bottom: 28px;
  text-align: center;
  font-size: .88rem;
}
.citation blockquote {
  font-style: italic;
  color: var(--navy);
  margin-bottom: 6px;
  line-height: 1.6;
}
.citation cite { font-size: .8rem; color: var(--gray); }
.citation cite a { color: var(--terra); }

/* FOOTER */
footer {
  text-align: center;
  color: var(--gray);
  font-size: .8rem;
  padding-top: 20px;
  border-top: 1px solid var(--border);
  line-height: 1.9;
}
footer a { color: var(--terra); }

/* RGPD */
#rgpd {
  position: fixed; bottom: 0; left: 0; right: 0;
  background: var(--navy); color: #F5F0EB;
  padding: 12px 20px; font-size: 13px;
  display: flex; justify-content: space-between; align-items: center;
  z-index: 9999; font-family: Georgia, serif;
}
#rgpd a { color: var(--terra); }
#rgpd button {
  background: var(--terra); color: #fff; border: none;
  padding: 8px 16px; cursor: pointer; border-radius: 4px;
  margin-left: 20px; white-space: nowrap; font-size: 13px;
}

@media (max-width: 480px) {
  .tuiles { grid-template-columns: 1fr; }
  .accroche h1 { font-size: 1.2rem; }
  #rgpd { flex-direction: column; gap: 8px; text-align: center; }
}
</style>
</head>
<body>

<header class="site-header">
  <img src="banniere.png" alt="Hors Kadre">
  <div class="tagline">Ce que personne ne dit vraiment — sourcé, vécu, pour les familles</div>
  <div class="mediapart-links">
    <a href="https://www.facebook.com/people/Hors-Kadre/61570725300507/" target="_blank">📘 Facebook</a>
    <a href="https://blogs.mediapart.fr/katy-ho/blog/190426/98-de-reussite-au-bac-et-apres" target="_blank">98% au bac. Et après ?</a>
    <a href="https://blogs.mediapart.fr/katy-ho/blog/230426/qui-classe-les-lycees-et-pourquoi-ca-nest-pas-un-hasard" target="_blank">Qui classe les lycées ?</a>
    <a href="https://blogs.mediapart.fr/katy-ho/blog/090526/parcoursup-une-etape-la-fois-et-tout-seclaircit-1" target="_blank">Parcoursup : une étape à la fois →</a>
  </div>
</header>

<div class="container">

  <div class="accroche">
    <h1>L'information utile sur l'orientation — enfin expliquée simplement.</h1>
    <p>Des outils gratuits, des données publiques, des mots simples.<br>Pour les familles qui veulent comprendre — dès la Seconde.</p>
  </div>

  <div class="tuiles">

    <a href="parcoursup.php" class="tuile tuile-primary">
      <div class="tuile-icon">🎓</div>
      <h2>Comprendre Parcoursup</h2>
      <p>Combien de candidats pour une place ? Quel profil a été admis ? Les vrais chiffres, en clair.</p>
      <span class="badge">France entière</span>
    </a>

    <a href="indexival.php" class="tuile">
      <div class="tuile-icon">🏫</div>
      <h2>Comparer les lycées</h2>
      <p>Tous les lycées ne notent pas pareil. Voyez le niveau réel de chaque établissement.</p>
      <span class="badge">Données 2025</span>
    </a>

    <a href="typeformation.html" class="tuile">
      <div class="tuile-icon">📖</div>
      <h2>Quelle formation après le bac ?</h2>
      <p>BUT, BTS, Licence, Prépa… Les différences expliquées sans jargon, en 5 minutes.</p>
    </a>

    <a href="doublettes.php" class="tuile">
      <div class="tuile-icon">📊</div>
      <h2>Spécialités qui ouvrent les portes</h2>
      <p>Maths+PC ouvre-t-elle vraiment toutes les portes ? Les données 2024 répondent.</p>
      <span class="badge">Nouveau !</span>
    </a>

  </div>

  <div class="citation">
    <blockquote>"Être bien informé permet d'accompagner les jeunes avec plus de sérénité et de confiance."</blockquote>
    <cite>— <a href="https://www.linkedin.com/in/virginiebusquet/" target="_blank">Virginie Busquet</a>, conseillère d'orientation</cite>
  </div>

  <!-- Lien PDF -->
  <div style="text-align:center;margin:24px 0 8px;padding:14px 20px;background:var(--offwhite);border:1px solid var(--border);border-radius:10px;font-size:.88rem;">
    📥 <a href="https://katysaintin.github.io/hors-kadre-yvelines/ParcoursupInfoHorsKadre.pdf" target="_blank" style="font-weight:600;color:var(--terra);">Télécharger le guide Parcoursup (PDF)</a>
    <span style="color:var(--gray)"> — à imprimer ou partager avec les familles</span>
  </div>

  <footer>
        <a href="https://blogs.mediapart.fr/katy-ho/blog/090526/parcoursup-une-etape-la-fois-et-tout-seclaircit-1" target="_blank" style="font-weight:600;">📰 Lire l'article : Parcoursup, une étape à la fois</a><br>
    ©2026 Katy Saintin — Hors Kadre<br>
    Données Open Data — Traitement indépendant — Réutilisation autorisée avec attribution<br>
    <a href="legal/apropos.html">À propos</a> |
    <a href="legal/mentions-legales.html">Mentions légales</a> |
    <a href="mailto:katy.saintin@gmail.com">Contact</a> |
    <a href="https://katysaintin.github.io/hors-kadre-yvelines/" target="_blank">Version Yvelines (GitHub)</a>
  </footer>

</div>

<div id="rgpd">
  <span>Ce site utilise Google Analytics pour mesurer l'audience anonymement.
    <a href="legal/mentions-legales.html">En savoir plus</a>
  </span>
  <button onclick="document.getElementById('rgpd').style.display='none';
    document.cookie='rgpd=1;max-age=31536000;path=/'">J'ai compris</button>
</div>
<script>
  if (document.cookie.indexOf('rgpd=1') >= 0)
    document.getElementById('rgpd').style.display = 'none';
</script>

</body>
</html>
