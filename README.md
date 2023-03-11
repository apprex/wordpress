# apprex_wordpress
Onlinekurse mit WordPress verkaufen. Nutze unser apprex WordPress Plugin zum stets aktuellen Anzeigen deiner Onlinekurse

## Installation (DE)
### Plugin hochladen
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

### Nach Kategorie filtern
Übergib eine ID einer Kategorie und die Produkte werden angezeigt.
```
[apprex category_id="2bab1429-da71-47c3-b187-3e8456763dad"]
```

### Anzahl der Spalten ändern
Standard sind 3 Spalten. Mindestens 1 und maximal 12. Du kannst die Spaltenanzahl auch ändern.
```
[apprex cols=2]
```

### Maximale Produktanzahl
Wenn Du etwa nur 2 Artikel pro Typ anzeigen möchtest, so gibst Du "max" als Attribut mit.
```
[apprex max=2]
```

### Produkttypen
Du kannst standardmäßig alle Produkttypen (`type=articles`) anzeigen lassen. Doch kannst Du auch zwischen den anderen Inhaltstypen filtern.
Zur Verfügung stehen: `courses`, `posts`, `plans`, `products` und `events`.
```
[apprex type=courses]
```

### Affiliate
Du kannst zu deinem Aufruf einen Affiliate Key hinzufügen. Nutze hierzu den Parameter `affiliate`.
```
[apprex affiliate=deine_digistore_id]
```

### Campaign Key
Du kannst zu deinem Aufruf einen Affiliate Key hinzufügen. Nutze hierzu den Parameter `campaign`.
```
[apprex campaign=DEINE_KAMPAGNE]
```

### Eigene URL ändern
Unter `Einstellungen > apprex` hast du die Möglichkeit die Akademie URL für deine gesamte WordPress Instanz festzulegen.
Du kannst dem Shortcode allerdings auch Parameter mitgeben, wie zum Beispiel:
```
[apprex url_academy="https://deine-akademie.apprex.net"]
```
