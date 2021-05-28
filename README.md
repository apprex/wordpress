# apprex_wordpress
Onlinekurse mit WordPress verkaufen. Nutze unser apprex WordPress Plugin zum stets aktuellen Anzeigen deiner Onlinekurse

## Installation (DE)
### Plugin hochladne
Um das Plugin zu installieren, lade dir die aktuelle Version [hier](https://github.com/apprex/wordpress/archive/refs/heads/main.zip) herunter.
Das Zip Archiv (https://github.com/apprex/wordpress/archive/refs/heads/main.zip), welches du heruntergeladen hast, musst du dann entweder
* Über dein WordPress Admin Backend unter Plugins > Hochladen
* Via FTP in den Ordner `/wp-content/plugins/` hochlden und dann in `/apprex` entpacken 

Dann musst du nur noch das Plugin aktivieren.

### Plugin einrichten
Nach dem Hochladen und Aktivieren klicke bitte auf `Einstellungen > apprex` um deine Akademie URL einzutragen.
Diese ist beispielsweise `https://deine-akademie.apprex.net`. Du kannst die URL auch an jeder verwendeten Stelle manuell angeben (siehe weiter unten).

## Shortcode
### Zeige alle Kurse an
Füge einfach an der Stelle deiner Seite nachfolgenden Shortcode ein, an der du *alle* Kurse darstellen möchtest.
```
[apprex]
```

### Nach Titel filtern
Wenn du viele Kurse und Artikel hast, bietet sich die Filterung etwa nach dem Titel an.
```
[apprex filter_title="Einsteiger"]
```

### Eigene URL ändern
Unter `Einstellungen > apprex` hast du die Möglichkeit die Akademie URL für deine gesamte WordPress Instanz festzulegen.
Du kannst dem Shortcode allerdings auch Parameter mitgeben, wie zum Beispiel:
```
[apprex url_academy="https://deine-akademie.apprex.net"]
```
