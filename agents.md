# AGENTS.md

Guidance for AI coding agents working in this repo. See [README.md](README.md) for the full human-facing writeup of the legacy system; this file focuses on what an agent needs to know to make correct changes.

## What this repo is

This repo powers the RMIT Library opening hours display. It currently contains **two generations of the same system**:

- **`2025/`** — the live, production PHP + MySQL system embedded via iframe into Adobe Experience Manager pages on `lib.rmit.edu.au`. This is authoritative for real users today. Treat it as read-mostly reference unless explicitly asked to change production behaviour — there is no local way to run or test it (no DB, no PHP server in this repo).
- **`docs/`** — a 2026 rebuild: a static, client-side rendering of the same calendar, published via GitHub Pages directly from this folder. This is where active development happens.

Do not assume the two share code or data — they don't. `2025/` reads from per-campus MySQL tables; `docs/` reads from a single flat-file data source (see below).

## `docs/` — the active app

- **[docs/hours.txt](docs/hours.txt)** is the single source of truth for opening-hours data. Despite the `.txt` extension, it is JSON: a top-level `locations` object keyed by location id (`swanston`, `bundoora`, `brunswick`, `carlton`, `makerspace`, `askthelibrary`), each with:
  - `name` — display name.
  - `defaults` — a Mon–Sun weekly template, each day either `{ "open": ..., "close": ... }` (optionally with `note`) or `{ "status": "closed" }`.
  - `ranges` — an ordered list of date-range overrides (`start`/`end` as `YYYY-MM-DD`, plus an `hours` block shaped like `defaults` and a `note`), for things like exam extended hours, summer hours, closedown periods. The first matching range wins.
  - `exceptions` — single-date overrides keyed by `YYYY-MM-DD`, for public holidays etc. Exceptions take priority over ranges, which take priority over defaults.
  - **Do not add or revive `.json` data files** (e.g. old `2026.json`/`2027.json`) as a data source — `hours.txt` is intentionally the only file the app reads. Those old JSON stubs were removed because nothing referenced them.
- **[docs/index.html](docs/index.html)** is the public display: a single-file app (`LibraryHours` class) that `fetch()`es `hours.txt` (relative path — must stay same-origin/relative so it works on GitHub Pages, do not point it back at an external host), resolves a given date to hours via exceptions → ranges → defaults, and renders a month calendar grid with a location `<select>`.
- **[docs/hours-editor.html](docs/hours-editor.html)** is a standalone authoring tool (no backend) for producing `hours.txt`: load/edit/download a file client-side, with a live preview that mirrors `index.html`'s rendering logic (including a mobile-width preview frame) and a raw-JSON escape hatch. If you change the resolution logic or data shape in `index.html`, mirror the change in `hours-editor.html`'s `getHoursForDate`/`buildCalendarHtml` — the two intentionally duplicate this logic and will drift if only one is edited.
- There is no build step, package manager, or test suite for `docs/` — it's plain HTML/CSS/vanilla JS. Validate changes by opening the HTML files directly in a browser (or a static file server) and checking the calendar renders/navigates correctly for each location, including edge cases: a date inside a `ranges` entry, a date matching an `exceptions` key, and a `status: closed` day.

## `2025/` — legacy production reference

- `open-hours-3col.php` — homepage "today's hours" widget, one row per campus, queried live from `<site>_hours` MySQL tables.
- `hoursNoBanner.php` — the full month-calendar iframe view, driven by `?site=`/`?m=`/`?c=` query params against the same tables.
- `brunswick_hours.sql` is a schema/data dump showing the shared table structure (`ymd`, `opening`, `closing`, `is_closed`, `is_semester`, `is_exam`, `notes`) used by all five per-campus tables.
- Known issue: some browsers show a Local Network Access prompt on the pages embedding these iframes, believed related to the iframe target resolving to internal RMIT address space (see README's "Current Known Issue" section, INC0496661). Keep this in mind if asked to debug embedding/loading issues on the legacy pages.

## Conventions

- Keep `docs/` self-contained and dependency-free unless asked otherwise — no bundlers, no npm packages; it needs to run as static files on GitHub Pages.
- Day keys are always lowercase three-letter English abbreviations: `mon tue wed thu fri sat sun`.
- Dates are always `YYYY-MM-DD`.
- When editing hours data by hand, prefer keeping `hours.txt` valid JSON (the editor's raw-JSON panel and `index.html`'s `fetch().json()` both require strict JSON despite the `.txt` extension).
