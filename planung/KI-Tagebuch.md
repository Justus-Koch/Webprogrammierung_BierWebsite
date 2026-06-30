----------------Bearbeitung von Zettel 2, Thema CSS--------------------------------

1. Prompt (Gemini, 02.05.2026):
Wie kann ich in CSS schöne hover-Funktionen erstellen?
Antwort:
Mehrere Beispiele für hover-Funktionen. Von denen wurde eins in die Website für die Posts übernommen.

2. Prompt (ChatGPT, 27.04.2026)
Erstelle mir das CSS und passe mein HTML und CSS (HTML und CSS gegeben) so an, dass ich eine horizontale Navigationsleiste habe, die links die Suche, in der Mitte eine Überschrift und rechts einen Anmeldebutton enthält.
Außerdem soll man ganz links eine vertikale Navigationsleiste ausklappen können, die die anderen Navigationselemente enthält.
Antwort:
Es wurde das entsprechende CSS generiert. Die Funktion zum Ausklappen der seitlichen Navigationsleiste wurde herausgenommen (kein JavaScript) und die Breite festgelegt.
Es wurden noch einige Änderungen bezüglich der Flexbox im Main-Bereich vorgenommen, damit sich die seitliche Navigationsleiste responsive verhält.

3. Prompt (ChatGPT, 04.05.2026):
Wie sollte ich CSS-Dateien in einem Webprojekt strukturieren?
Antwort:
Einfacher Vorschlag zur Struktur in components.css für wiederverwendbare Bausteine und style.css für globale Anpassungen und das Gesamtlayout.

4. Prompt (ChatGPT, 04.05.2026):
Wie verstecke ich ein Label für ein Input in CSS so, dass es nicht sichtbar ist, aber für z. B. Screenreader trotzdem verfügbar ist?
Antwort:
CSS-Klasse .visually-hidden, wurde so übernommen und integriert

5. Prompt (ChatGPT, 05.05.2026)
Impressum, Datenschutz und Nutzungsbedingungen wurde in einen Footer ausgelagert (HTML gegeben). Erstelle mir das CSS, um den Footer dezent, aber gut sichtbar in ähnlichem Design wie die horizontale Navigationsleiste zu gestalten.
Antwort: Passendes CSS zur Gestaltung des Footers

6. Prompt (Gemini, 11.05.2026)
Das ist das CSS für die Gestaltung der Anzeige der Reviews (CSS gegeben). Gestalte die Seiten zum Erstellen und Bearbeiten einer Review in ähnlichem Design (HTML gegeben).
Antwort: Das passende CSS wurde erstellt und durch Hinzufügen entsprechender divs in die Seite integriert.

7. Prompt (Gemini, 11.05.2026)
Die Bewertung soll nicht als Slider dargestellt werden, sondern als Sterne. Man kann also zwischen 0 und 5 Sterne geben
Antwort: Es wurde passendes CSS erstellt und die HTML so angepasst, dass eine Sternebewertung existiert.

8. Prompt (Gemini, 11.05.2026)
Diese Seiten (create_review und edit_review mit CSS gegeben) sollen barrierefrei und geeignet für Screenreader sein.
Antwort: Optimierung des HTMLs und der Sternebewertung, sodass Screenreader keine Probleme haben und alles passend gelabelt ist. Es gibt noch ein Problem beim Auswählen der Bewertung.

9. Prompt (Gemini, 11.05.2026)
Die Sternebewertung funktioniert nicht korrekt. Wenn ich die Sterne anklicke, also z.B. den 5. Stern und vorher waren alle ausgewählt, sind 4 Sterne ausgewählt, der 5. wird also abgewählt und ich kann keine 5 Sterne mehr auswählen. Außerdem soll die schwarze Umrandung beim Anklicken der Sterne entfernt werden.
Antwort: Anpassung des HTMLs und des CSSs.

10. Prompt (Gemini, 11.05.2026)
Gestalte die Seiten nun responsive entsprechend der gegebene Maßstäbe (Vorlesung gegeben)
Antwort: Die Seiten wurden durch fluide Layouts und Media Queries responsive gestaltet.

11. Prompt (Gemini, 02.05.2026)
Wie kann ich eine Checkbox visuell umstylen, zum Beispiel als Herz, das anklickbar ist?
Antwort: Anleitung zur Erstellung einer Herz-Checkbox mithilfe von Pseudoelementen.

12. Prompt (Gemini, 11.05.2026)
Designe nun auch diese Seite zum Bearbeiten des Profils. achte dabei auf Barrierefreiheit und Responsive Design. Nutze bereits vorher erstelltes CSS, falls möglich.
Antwort: Optimiertes HTML und

13. Prompt (Gemini, 12.05.2026)
Erkläre mir anhand von Änderungen was gemacht werden muss, damit der Footer bei Login.html und Registration.html, korrekt angezeigt wird.
Antwort: Änderungen mit Erklärungen bzgl. Footer.

14. Prompt (Gemini, 12.05.2026)
Wie muss ich die Registrations.css verändern, sodass das Registrations-feld nicht die gesamte vertikale Größe nutzt?
Antwort: Eine Beschreibung, was genau getan werden muss, um die gewünschten Änderungen zu machen.

15. Prompt (Gemini, 11.05.2026)
Hier ist die momentane Struktur in html und css, für meine Website. Gib mir Verbesserungsvorschläge für die Profilseite und die index seite.
Antwort: Mehrere Verbesserungsvorschläge zu den hochgeladenen Dateien.

16. Prompt (Gemini, 11.05.2026)
Stelle sicher, dass die Profil- und Feed-Seite sowohl accessible als auch responsive sind.
Antwort: Codeverbesserungen, um die Seiten accessible und responsive zu machen

17. Prompt (Gemini, 13.05.2026)
Das ist das Aufgabenblatt, das wir bearbeiten sollen. Überprüfe, ob mein Code die hier gelisteten Anforderungen erfüllt (Aufgabenblatt und HTML/CSS gegeben)
Antwort: Überprüfung der Anforderungne Layout & CSS3-Techniken, visuelle Gestaltung & Navigation, Responsive Design, Accessibility, formale Anforderungen. Hinweis, dass das JavaScript bei dem Menü-Button noch entfernt werdens sollte. Erinnerung, den CSS-Validator und WAVE-Validator zu nutzen. Ansonsten sind alle Anforderungen erfüllt.

18. Prompt (Gemini, 13.05.2026)
Verfasse eine zu meiner Website passende Barrierefreiheitserklärung in HTML-Format und passe das Design an die anderen Seiten an. Eine Überprüfung mit dem WAVE-Validator hat keine Fehler oder Warnungen ergeben.
Antwort: Erstellung der Barrierefreiheitserklärung als HTML und des passenden CSS.

19. Prompt (Claude, 19.05.2026)
This is my current code base. As you can tell there is only html and css used so far. That is intended because it is a uni project and we are not allowed to use anything else yet, except for php include for things that are found on all sites.
What i want you to do, is clean up the project a bit. I have tried to make it responsive and accesible, but might have missed a few parts.
Also clean up the css files and make it into  a reasonable structure. Change nothing content-wise.
Then give me back all the files or the code for all files so i can replace the files or paste the code
into my files. If there is any style changes you find nice, you can also incorporate minor style changes
cosmetically.
Antwort: Die aufgeräumten Dateien als php code inklusive übersichtlicherem css.

20. Prompt (Gemini, 27.05.2026)
Das aktuelle ausgewählte Bild soll als Vorschau angezeigt werden (Code von edit-profile.php gegeben).
Antwort: Java-Script-Function zur Anzeige des Bildes in der Vorschau

21. Prompt (Gemini, 03.06.2026)
Wie kann ich in PHP über header auf die vorherige Seite zurückleiten?
Antwort: $previousPage = $_SERVER['HTTP_REFERER'] ?? '/';

22. Prompt (ChatGPT, 10.06.2026)
Wie kann ich abfragen, ob der UNIQUE-Constraint verletzt wurde?
Antwort: Abfrage des Exception-Codes auf 23000.

23. Prompt (Gemini, 16.06.2026)
Implementiere die Echtzeit-Validierung der Nutzereingaben bei Registrierung und Anmeldung (bestehender Code gegeben) mit JavaScript. Vermeide doppelten Code. 
Antwort: notwendiges JavaScript und Anpassungen an PHP in login/registration

24. Prompt (Claude, 16.06.2026)
Meine Website hat eine Funktion zum Hinzufügen von Favoriten. Momentan wird die Seite beim Hinzufügen jedes Favoriten neu geladne. Ich möchte mit AJAX umsetzen, dass der reload nicht passiert. Es soll auch noch ohne Java-Script funktionieren (Code zum Hinzufügen von Favoriten gegeben).
Antwort: Java-Script-Code und Anpassung an dem bestehenden php zum Hinzufügen von Favoriten.

25. Prompt (ChatGPT, 30.06.2026)
Das ist meine bislang bestehende Regisierung. Ich möchte nun folgende Aspekte umsetzen (Erklärungen von Aufgabenzettel gegeben).
Antwort: Anpassung der Registrierung mit Token-Generierung, Erstellung eines eindeutigen Dateinamens und Dateiinhalts.

26. Prompt (Claude, 30.06.2026)
Wie definiere ich einen UNIQUE-Constraint in PDO SQLite der auf dem Attribut email greift, wenn is_active = 1 ist.
Antwort: Erstellung des passendes UNIQUE-Constraints.

27. Prompt (ChatGPT, 30.06.2026)
Schreibe eine Methode isPasswordSafe($password), die prüft, ob das Passwort mind. 8 Zeichen lang ist, mind. einen Großbuchstaben enthält und mind. ein Sonderzeichen enthält.
Antwort: Methode isPasswordSafe

28. Prompt (ChatGPT, 30.06.2026)
Ich möchte die Bedingungen eines sicheren Passwortes nun auch dynamisch mit JS prüfen wie die anderen Eingaben bei der Registrierung.
Antwort: Ergänzung des JS zur Prüfung der Bedingungen