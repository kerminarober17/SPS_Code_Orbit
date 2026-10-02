# Cody 🤖 — AI Programming Tutor Integration

## Setup (required)

Cody configuration lives in **`config/config.php`** (server-side only).  
**No `.env` is required for Cody.**

Open `config/config.php` and set:

```php
// >>> PUT YOUR OPENROUTER API KEY HERE <<<
$CODY_OPENROUTER_API_KEY_DEFAULT = 'sk-or-v1-your-key-here';
// >>> PUT YOUR PRIMARY MODEL HERE <<<
$CODY_PRIMARY_MODEL_DEFAULT      = 'openrouter/free';
// Optional fallback model (empty string = none)
$CODY_FALLBACK_MODEL_DEFAULT     = '';
$CODY_MAX_TOKENS_DEFAULT         = '1024';
$CODY_TIMEOUT_SECONDS_DEFAULT    = '45';
$CODY_RATE_LIMIT_PER_MINUTE_DEFAULT = '20';
$CODY_ENABLED_DEFAULT            = '1';
```

Get a key at https://openrouter.ai/keys  

Change `CODY_PRIMARY_MODEL` anytime without touching other code.

**Never put the API key in HTML, JS, or client-visible files.**

Optional: if a project-root `.env` already exists for database settings, you may also set
`CODY_*` keys there; non-empty values still override the PHP defaults. Cody itself does
not require `.env`.

## How to access

- **Dedicated chat:** `/student/cody.html` (also “Cody Tutor” in the student sidebar)
- **Inside lessons:** On programming lessons with a code editor, a Cody panel appears with
  quick actions (Hint, Explain error, Explain concept, Review code, Ask Cody).

## Architecture

```
Browser
  → POST /cody_api.php  (PHP session + CSRF)
  → OpenRouter Chat Completions API (server-side, API key never leaves PHP)
  → Cody service formats reply
  → JSON response to browser
```

## Auth & CSRF

- Uses the same `window.session` (`js/session.js` → `SessionManager`) as every other
  protected student page: `requireAuth(['student', ...])` / `fetchUser()`.
- CSRF token from `/api/auth/me.php` (or `session.getCsrfToken()`), sent as
  `X-CSRF-Token` header and `csrf_token` body field.
- Backend: `middleware/auth.php` + `middleware/csrf.php`.

## Notes

- Chat history is session/client-side only (no new DB tables).
- Streaming is not used (reliable non-streaming for shared hosting).
- Exam paths are treated as restricted mode (conceptual help only).
- AI output is escaped before rendering; code blocks have a Copy button.


## InfinityFree notes

- This endpoint avoids HTTP **403** status codes because InfinityFree often replaces
  403 responses with `errors.infinityfree.net`, which breaks browser `fetch`.
- Auth/CSRF failures return **400** or **401** JSON instead.
- GET `/cody_api.php` returns a small health payload (`enabled`, `configured`, `authenticated`).
- Outbound calls to OpenRouter require the host to allow external HTTP (curl / allow_url_fopen).
  If the key is set but replies still fail with “temporarily unavailable”, check the host allows
  outbound HTTPS to `openrouter.ai`.


## API endpoint (important)

**Primary:** `POST /cody_api.php`

Also available (fallback / legacy):
- `POST /api/cody_chat.php`
- `POST /api/cody/chat.php` (may be blocked on some hosts if the `cody` subfolder is restricted)

Health check (browser, while logged in):
`GET https://your-domain/cody_api.php`


## Hosting 403 troubleshooting (InfinityFree)

1. Open `https://your-domain/cody_ping.php` — must return JSON `{"ok":true,...}`.
2. Open `https://your-domain/cody_api.php` while logged in — must return Cody health JSON.
3. Cody frontend calls **`/cody_api.php`** (project root), not `/api/...`.
4. Requests use **session cookie + CSRF only**. They intentionally do **not** send
   `Authorization` / `X-User-Id` headers (those can trigger InfinityFree 403).
