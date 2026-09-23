# MasjidMediaHelpCenter

Public help center for FreeScout: a branded landing page and a contact form
that creates real tickets, without any paid FreeScout module.

## Install

```
php artisan module:enable MasjidMediaHelpCenter
php artisan freescout:module-install masjidmediahelpcenter
```

## Required `.env`

```
APP_DASHBOARD_PATH=dashboard
APP_HOMEPAGE_CONTROLLER="\Modules\MasjidMediaHelpCenter\Http\Controllers\LandingController@index"
HELPCENTER_MAILBOX_ID=<id of the mailbox that should receive contact-form tickets>
HELPCENTER_SUPPORT_EMAIL=support@masjidmedia.id
# Public repo of this module. The footer's source-code link is hidden until set.
HELPCENTER_SOURCE_URL=
```

Then:

```
php artisan freescout:clear-cache
php artisan freescout:build
```

`APP_DASHBOARD_PATH` moves the agent dashboard off `/` so the landing page
can live there instead. **If you disable this module, revert
`APP_HOMEPAGE_CONTROLLER` too** (or `/` will point at a controller that no
longer exists).

## What it does

- `/` — landing page with link cards to the mobile app guide, TV app guide,
  full documentation, privacy policy, terms, and the contact form. No FAQ
  content is stored here; every card links out to `docs.masjidmedia.id` or
  `masjidmedia.id`.
- `/contact` — a form that creates a real `Customer` + `Conversation` in the
  configured mailbox via `Conversation::create()` (`app/Conversation.php`),
  the same path FreeScout's own email fetcher uses. This means the mailbox's
  auto-reply and agent notifications fire normally.

## Design

The layout is a plain-CSS port of masjid-media-website (header, footer, container widths, the legal-page heading block, the About page's hairline card grid, `btn-brass`, `eyebrow`) because FreeScout modules have no Tailwind build. `Public/css/helpcenter.css` mirrors the website's Tailwind values; when the website's look changes, update it to match rather than tuning it locally.

## Spam protection

A honeypot field, a minimum/maximum time-to-fill check, and
`throttle:5,1` on the POST route. No third-party service.

## Known gaps

- Card links and UI strings are in `id`/`en` only, matching the app.
- The subject line always tags the topic in Indonesian
  (`ContactController::topicLabelForTriage()`), regardless of which
  language the customer used, so agent triage stays consistent.
- Editing the card links or the target mailbox does not require a code
  change — see `Config/config.php`.
