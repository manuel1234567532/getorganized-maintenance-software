# GetOrganized

GetOrganized ist eine Instandhaltungssoftware, welche es dir ermöglicht, Projekte und Ersatzteile zu tracken.

## Beschreibung

Die Anwendung ist in Laravel geschrieben. Clone das Repository oder installiere es manuell auf deinem Server.

![Login](https://i.imgur.com/xCp1X8B.jpeg)
![Dashboard](https://i.imgur.com/nxROT3c.jpeg)
![Ersatzteile](https://i.imgur.com/szEUuig.jpeg)
![Arbeitsaufträge](https://i.imgur.com/n8sn9id.jpeg)
![Arbeitsauftäge abgeschlossen](https://i.imgur.com/NLgfGuc.jpeg)
![Dateimanager](https://i.imgur.com/1bjzPrO.jpeg)
![Dateimanager Ornder](https://i.imgur.com/f6XWTQL.jpeg)
![Dateimanager Datei](https://i.imgur.com/bbMUJZn.jpeg)
![Admin Einstellungen](https://i.imgur.com/LtzhRwk.jpeg)

## Installation

1. Klone das Repository:
    ```sh
    git clone https://github.com/dein-benutzername/getorganized.git
    cd getorganized
    ```

2. Installiere die Abhängigkeiten:
    ```sh
    composer install
    npm install
    npm run dev
    ```

3. Konfiguriere deine `.env` Datei:
    ```sh
    cp .env.example .env
    php artisan key:generate
    ```

4. Migriere die Datenbank und fülle sie mit Seed-Daten:
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
