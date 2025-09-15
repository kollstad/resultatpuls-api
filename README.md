# Friidrett API (Laravel 12)

Åpent JSON API for friidrettsstatistikk – kretser, klubber, utøvere, stevner og resultater.  
Bygget i **Laravel 12** med **PostgreSQL 16**.

---

## 🚀 Stack

-   PHP 8.2+ / Laravel 12
-   PostgreSQL 16, Redis 7
-   Scribe for API-dokumentasjon (`/docs`)
-   UUID (HasUuids) som primærnøkler
-   Append-only modell for resultater (videreutvikles)

---

## ✅ Forhåndskrav

-   macOS (eller Linux/WSL)
-   PHP 8.2+, Composer 2.x
-   PostgreSQL 16 + `psql` i PATH
-   Redis 7
-   Node 20 (kun for frontend senere)

---

## 🔧 Kom i gang (dev)

```bash
# 1) Klargjør prosjekt
composer install

# 2) Kopier miljøfil og generer app key
cp .env.example .env
php artisan key:generate

# 3) Sett følgende i .env (eksempel)
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=friidrett_api_dev
DB_USERNAME=friidrett
DB_PASSWORD=********

# 4) Migrer og seed
php artisan migrate
php artisan db:seed

# 5) Kjør utviklingsserver
php artisan serve
# -> http://127.0.0.1:8000
```

---

## 📚 API-dokumentasjon (Scribe)

-   Generer/oppdater dokumentasjon:
    ```bash
    php artisan scribe:generate
    ```
-   Åpne: `http://127.0.0.1:8000/docs`
-   OpenAPI/Swagger: `public/docs/openapi.yaml`
-   Postman-kolleksjon: `public/docs/collection.json`

---

## 🧱 Datamodell (MVP)

-   `districts`, `clubs`, `athletes`, `disciplines`
-   `events`, `event_disciplines`, `performances`
-   Se `database/migrations/*` for detaljer.

---

## 🔌 API (v1) – endepunkter

**Les:**

```
GET /api/v1/districts?q=Agder
GET /api/v1/clubs?district_id={uuid}&q=KIF
GET /api/v1/athletes?club_id={uuid}&q=Nordmann
GET /api/v1/events?type=outdoor&date_from=2025-01-01&date_to=2025-12-31&q=Kristiansand
GET /api/v1/performances?athlete_id={uuid}&discipline_code=100m&legal=true&sort=mark_raw
```

**Skriv (foreløpig uten auth – beskyttes senere):**

```
POST /api/v1/districts
POST /api/v1/clubs
POST /api/v1/athletes
POST /api/v1/events
POST /api/v1/performances
```

### Eksempel: registrer resultat

```bash
curl -X POST http://127.0.0.1:8000/api/v1/performances   -H "Content-Type: application/json"   -d '{
    "event_id":"<EVENT_UUID>",
    "discipline_code":"100m",
    "age_category":"Senior",
    "round":"finale",
    "timing_method":"auto",
    "athlete_id":"<ATHLETE_UUID>",
    "unit":"s",
    "mark_display":"11.72",
    "position":1,
    "wind":1.1,
    "status":"OK",
    "is_legal":true
  }'
```

---

## 🧪 Tester

-   Rammeverk: Pest (legges til senere).
-   Kjør: `php artisan test`

---

## 🔒 Videre arbeid

-   Auth for POST (Sanctum/Passport)
-   Signerte innsendinger (Ed25519)
-   Moderasjon og revisjonshistorikk
-   Partisjonering av `performances` per år
-   Meilisearch for fritekstsøk
-   Webhooks og rekorder

---

## 💅 Kodekvalitet

-   Installer: `composer require --dev larastan/preset pint`
-   Kjør: `./vendor/bin/pint` og `./vendor/bin/phpstan`

---

## 📄 Lisens

MIT (kode). Åpne data kan merkes med CC BY 4.0.

Forge
-- oppsett av app-server på digital ocean
Sudo Password:
$EY}P}.iSpu2lhT1C6FY
Database Password:
vWjTUW3PoxsyarJK7YWt
