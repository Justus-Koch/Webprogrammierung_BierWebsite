<?php $title = 'Barrierefreiheitserklärung'; ?>
<?php include_once './php/include/header.php'; ?>

<div class="layout">
  <?php include_once './php/include/sidebar.php'; ?>

  <main>
    <div class="form-card accessibility-content">
      <h2>Erklärung zur Barrierefreiheit</h2>

      <p>Diese Erklärung gilt für die Website <strong>Prost-Protokoll</strong> (Stand: Mai 2026, generiert mit Gemini).</p>

      <section>
        <h3>Stand der Vereinbarkeit</h3>
        <p>Diese Website ist nach einer Prüfung durch den <strong>WAVE Accessibility-Validator</strong> vollständig barrierefrei. Es wurden 0 Fehler und 0 Kontrastfehler gefunden.</p>
      </section>

      <section>
        <h3>Maßnahmen</h3>
        <ul>
          <li><strong>Tastaturbedienbarkeit:</strong> Alle Elemente sind ohne Maus steuerbar.</li>
          <li><strong>Semantik:</strong> Nutzung von <code>&lt;header&gt;</code>, <code>&lt;main&gt;</code> und <code>&lt;article&gt;</code>.</li>
          <li><strong>Kontraste:</strong> Optimiertes Farbschema für bessere Lesbarkeit.</li>
          <li><strong>Screenreader-Hilfen:</strong> Einsatz von <code>visually-hidden</code> für erklärende Texte.</li>
        </ul>
      </section>

      <section>
        <h3>Kontakt</h3>
        <p>Barrieren gefunden? Kontaktieren Sie uns unter: <em>maresa.ossenbeck@uni-oldenburg.de</em></p>
      </section>
    </div>
  </main>
</div>

<?php include_once './php/include/footer.php'; ?>
