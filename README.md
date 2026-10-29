# AITEA Core: Backend / CMS (Member 2)

## Install (staging)
1. WordPress 6.x, PHP 7.4+ (Austrian Plesk host from Member 4).
2. Install & activate **Polylang** (free). Languages: German (default), English. Hindi later: Settings > Languages > Add, no code change.
3. Upload `aitea-core.zip` (Plugins > Add New > Upload) and activate.
   Activation creates: content types, taxonomies, roles, draft pages, Vienna timezone, pretty permalinks.
4. Polylang > Settings > Custom post types and Taxonomies: AITEA types are already ticked.

## What the client can edit (Admin / Editor)
| Menu | Content | Key fields |
|---|---|---|
| News | posts | title, text, image, Objective category |
| Events | events | start/end date, location, link, Objective |
| Downloads | files | file upload, category, members-only flag, language |
| Sponsors & Partners | logos | featured image = logo, URL, type, order |
| Pages | static pages | Home, About, Board, etc. (seeded as drafts) |

Each item has a language selector (Polylang). Create the DE version, then use the "+" next to EN to translate it.

## Roles
- **Administrator**: everything.
- **Editor**: all content + media; cannot touch plugins, users, settings.
- **aitea_applicant / aitea_member**: created for Member 3. Members get `aitea_read_members_only`.

## Shortcodes
- `[aitea_contact]`: GDPR-consent contact form (honeypot, nonce, rate limit, no DB storage)
- `[aitea_downloads category="statutes"]`: list of downloads, filtered by current language and member status

## Template helpers for Member 1
- Post types: `aitea_news`, `aitea_event`, `aitea_download`, `aitea_sponsor`
- Taxonomies: `aitea_objective`, `aitea_download_cat`, `aitea_sponsor_type`
- Meta: `_aitea_event_start|end|location|link`, `_aitea_sponsor_url`, `_aitea_file_id`, `_aitea_members_only`
- Theme files expected: `archive-aitea_news.php`, `single-aitea_news.php`, `archive-aitea_event.php`, `single-aitea_event.php`, `archive-aitea_sponsor.php`
- Translate UI strings with `aitea__( 'Read more' )`
- All types are in the REST API (`/wp-json/wp/v2/aitea_news`, ...)

## Statutes (German only)
Downloads > Add New > title "Statuten", category *Statutes*, upload PDF, set language = German, publish. Do not create an EN translation.

## Config
- Contact recipient: `define('AITEA_CONTACT_TO','info@aitea.at');` in wp-config.php (default: admin email).
- SMTP: install *WP Mail SMTP* and use the aitea.at mailbox so mails don't land in spam.

## Hand-offs
- **M4**: SMTP/DNS (SPF/DKIM), backups of uploads + DB, cookie banner, privacy/imprint text.
- **M3**: use roles `aitea_applicant` > `aitea_member`; call `aitea_user_can_read_members_only()` to gate content.
- **Known limitation**: members-only files are streamed through `/?aitea_dl=ID`, but the raw file in /wp-content/uploads is still reachable if its URL is guessed. For stricter protection M4 can add an .htaccess/nginx rule on a `/uploads/members/` folder (see M4 task list).
