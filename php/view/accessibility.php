<?php $title = 'Barrierefreiheitserklärung'; 
if (!isset($abs_path)) {
  require_once "../../path.php";
}

require_once $abs_path . "/php/session-start.php";
?>
<?php include_once $abs_path.'/php/include/header.php'; ?>

<div class="layout">
  <?php include_once $abs_path.'/php/include/sidebar.php'; ?>

  <main>
    <div class="form-card accessibility-content">
      <h1>Erklärung zur Barrierefreiheit</h1>

      <p>Diese Erklärung gilt für die Website <strong>Prost-Protokoll</strong> (Stand: Mai 2026, generiert mit Gemini).</p>

      <section>
        <h2>Stand der Vereinbarkeit</h2>
        <p>Diese Website ist nach einer Prüfung durch den <strong>WAVE Accessibility-Validator</strong> weitesgehend barrierefrei.</p>
      </section>

      <section>
        <h2>Maßnahmen</h2>
        <ul>
          <li><strong>Tastaturbedienbarkeit:</strong> Alle Elemente sind ohne Maus steuerbar.</li>
          <li><strong>Semantik:</strong> Nutzung von <code>&lt;header&gt;</code>, <code>&lt;main&gt;</code> und <code>&lt;article&gt;</code>.</li>
          <li><strong>Kontraste:</strong> Optimiertes Farbschema für bessere Lesbarkeit.</li>
          <li><strong>Screenreader-Hilfen:</strong> Einsatz von <code>visually-hidden</code> für erklärende Texte.</li>
        </ul>
      </section>

      <section>
        <h2>Kontakt</h2>
        <p>Barrieren gefunden? Kontaktieren Sie uns unter: <em>maresa.ossenbeck@uni-oldenburg.de</em></p>
      </section>
    </div>
  </main>
</div>

<?php include_once $abs_path.'/php/include/footer.php'; ?>

</body>
</html>
