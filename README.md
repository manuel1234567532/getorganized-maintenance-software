# GetOrganized

GetOrganized ist eine Instandhaltungssoftware, welche es dir ermöglicht, Projekte und Ersatzteile zu tracken.

## Beschreibung

Die Anwendung wurde mit Laravel entwickelt und bietet eine Vielzahl an Funktionen:
- **Login**: Sicheres und benutzerfreundliches Anmeldesystem.
- **2FA Funktion**: Zwei-Faktor-Authentifizierung für zusätzliche Sicherheit.
- **User Management mit Rollenzuweisung**: Verwalten Sie Benutzer und weisen Sie ihnen spezifische Rollen zu.
- **Detaillierte Berechtigungssteuerung**: Steuern Sie die Berechtigungen für jede Rolle individuell auf der gesamten Webseite.
- **Arbeitsaufträge mit automatischen Intervallen**: Verwalten Sie wiederkehrende Aufgaben effizient mit automatisierten Intervallen.
- **Benachrichtigungen**: Erhalten Sie Benachrichtigungen, wenn z.B. ein Teammitglied einem Arbeitsauftrag hinzugefügt wird.
- **Ersatzteilmanagement mit QR Codes und Status**: Verfolgen und verwalten Sie Ersatzteile mithilfe von QR-Codes und Statusupdates.
- **und vieles mehr**: Entdecken Sie weitere nützliche Funktionen, die Ihre Instandhaltungsprozesse optimieren.

## Login
![Login](https://i.imgur.com/xCp1X8B.jpeg)
## Dashboard
![Dashboard](https://i.imgur.com/nxROT3c.jpeg)
## Ersatzteile
![Ersatzteile](https://i.imgur.com/szEUuig.jpeg)
## Arbeitsaufträge
![Arbeitsaufträge](https://i.imgur.com/n8sn9id.jpeg)
## Arbeitsauftäge abgeschlossen
![Arbeitsauftäge abgeschlossen](https://i.imgur.com/NLgfGuc.jpeg)
## Dateimanager
![Dateimanager](https://i.imgur.com/1bjzPrO.jpeg)
## Dateimanager Ordner
![Dateimanager Ordner](https://i.imgur.com/f6XWTQL.jpeg)
## Dateimanager Datei
![Dateimanager Datei](https://i.imgur.com/bbMUJZn.jpeg)
## Admin Einstellungen
![Admin Einstellungen](https://i.imgur.com/LtzhRwk.jpeg)

## Installation

1. Klone das Repository:
    ```sh
    git clone https://github.com/manuel1234567532/getorganized-maintenance-software.git
    ```

2. Installiere die Abhängigkeiten:
    ```sh
    composer install
    npm install
    npm run dev
    ```

3. Konfiguriere die `.env` Datei:
    ```sh
    cp .env.example .env
    php artisan key:generate
    ```

4. Migriere die Datenbank und fülle sie mit den Seed-Daten:
    ```sh
    php artisan migrate --seed
    ```

## Erster Login

Logge dich mit den folgenden Anmeldeinformationen ein:
- **Benutzername:** Administrator
- **Passwort:** 12345678

Führe sämtliche Einstellungen wie z.B. SMTP-Einstellungen unter "Admin" durch.

## You're ready to go!

Du kannst jetzt die Anwendung verwenden und deine Projekte sowie Ersatzteile effizient tracken.

---

Für weitere Informationen und detaillierte Anweisungen, siehe die offizielle [Laravel-Dokumentation](https://laravel.com/docs) und die [API-Dokumentation](https://laravel.com/api).

Viel Spaß beim Organisieren!

---

**Lizenz**

Dieses Projekt steht unter der MIT-Lizenz. Weitere Informationen findest du in der [LICENSE](License)-Datei.
