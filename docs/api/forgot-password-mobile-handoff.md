# Mobile password recovery handoff

## API contract

Use the API origin configured for the current environment. Release builds MUST use HTTPS. This is a public endpoint; do not send a bearer token or browser CSRF token.

```http
POST {api-origin}/api/forgot-password
Accept: application/json
Content-Type: application/json
```

```json
{"email":"user@example.com"}
```

Do not include a password, token, role, deep-link target, or other recovery parameter.

| Status | Response / behavior |
| --- | --- |
| `202` | `{"status":true,"message":"Jika alamat email terdaftar, kami akan mengirimkan tautan untuk mengatur ulang kata sandi."}` The request was accepted for processing. This does not mean the address belongs to an account or that an email arrived. |
| `422` | Laravel validation response: `message` plus `errors.email[]`. The email is required, syntactically valid, a string, and at most 255 characters. |
| `429` | `{"status":false,"message":"Terlalu banyak permintaan. Silakan coba kembali nanti."}` Honor integer-seconds `Retry-After`. |
| `503` | `{"status":false,"message":"Permintaan reset kata sandi belum dapat diproses. Silakan coba kembali nanti."}` Offer a manual retry. |

Initiation is limited to five requests per IP per minute, shared between the browser and API. The password broker suppresses another token issuance for the same account for 60 seconds. During that window the request can still return 202, but no new link is issued. A later issuance replaces the previous token. Each issued reset token expires after 24 hours. Worker/mail delays and failures are not exposed as account-specific API states.

## Mobile flow

1. The forgot-password action on sign-in opens an email-entry form. Disable duplicate submission while the request is in flight.
2. On 202, show the neutral server message, offer an email-app action, and let the user return manually to sign-in. Never say the inbox received an email based only on 202.
3. Keep the address editable so the user can correct it and submit again. Show 422 email errors, honor 429 `Retry-After`, and provide manual retry for 503/network failure. Do not retry automatically based on an account-specific assumption.
4. The email link opens the existing HTTPS website in the device's default browser. The website owns the reset token, new password, and confirmation. There is no native reset screen, OTP, universal/app link, forced app installation, completion polling, or automatic sign-in.
5. On return to the app, show normal sign-in. App resume is not evidence that reset succeeded. The existing login endpoint and payload remain unchanged.
6. Successful reset invalidates all prior account web sessions and API access/refresh credentials. On 401, clear the local access/refresh token pair and return to login. Do not repeatedly refresh credentials that were rejected.

Google-created accounts can establish a local password without unlinking Google. Reset does not activate an inactive account. The website requires a confirmed password of at least eight characters; this is the browser reset rule, not a store requirement or policy for a nonexistent native reset screen.

Never send email addresses, reset URLs/tokens, or passwords to mobile analytics or crash logs.

## Mobile QA checklist

- [ ] Known and unknown addresses receive the same neutral 202 UI; do not assert delivery from the response.
- [ ] Empty, malformed, and overlong email values show the 422 field error.
- [ ] Duplicate taps are disabled while submitting; 429 observes `Retry-After`.
- [ ] Offline and 503 states offer a deliberate manual retry.
- [ ] Email link opens the website in the default browser; website accepts confirmed passwords meeting its minimum length.
- [ ] Invalid, expired, and reused links show the website's recovery error; app does not poll for completion.
- [ ] Returning to the app shows normal sign-in, without inferring reset success from resume.
- [ ] A pre-reset access token and refresh token are rejected; app clears the pair and does not loop refresh attempts.
- [ ] A Google-created account can sign in with the newly established local password while Google remains linked; inactive status remains unchanged.
- [ ] Email, reset URL/token, and password are absent from analytics/crash reports.

## Verification record

### Automated and runtime checks

- `php artisan test tests/Feature/Api/ForgotPasswordTest.php tests/Feature/WebPasswordRecoveryTest.php tests/Feature/PasswordResetTest.php`: passed, 8 tests / 85 assertions. Covers API and browser initiation, async worker processing, neutral known/unknown response, rate limits and trusted reset URL, rendered reset page analytics exclusion, privacy headers, password reset, access/refresh revocation, and deletion of only the target user's database sessions.
- `php artisan test tests/Feature/Api/ForgotPasswordTest.php tests/Feature/WebPasswordRecoveryTest.php tests/Feature/PasswordResetTest.php tests/Feature/Api/GoogleAuthTest.php tests/Feature/Api/LoginRoleAutoSwitchTest.php tests/Feature/Api/ProfileAndLocationTest.php`: passed, 28 tests / 351 assertions.
- OpenAPI JSON parsed with `JSON_THROW_ON_ERROR`; OpenAPI YAML parsed with Ruby YAML.
- Live initiation command used the local HTTP server and the approved inbox; response was 202. A one-shot worker on the isolated queue completed (`DONE`). A second explicitly approved attempt also returned 202 and completed (`DONE`). These are server/worker observations, not independent SMTP receipt proof.
- DBX showed one matching account; the recovery-token timestamp was present after the first worker attempt, with no queued or failed job remaining on that isolated queue. No token value, password, SMTP credentials, or reset URL was read or recorded.

### User-reported live observation

After the second attempt, the user reported: “okay success nice.” This is recorded as a user-reported successful email/browser check; no inbox contents, reset URL, screenshot, or browser network trace was retained. The trusted `autoloker.test` hostname did not resolve from the command shell. The user reported access from their browser. Automated rendered-HTML and response-header checks passed, but browser DevTools/network inspection was not independently captured.

### Not established

No iOS/Android device run, production deployment verification, store approval, production mail reliability, or proxy/APM log-redaction verification is established. SQLite tests do not prove row-lock behavior under concurrent redemption; verify concurrency against a disposable database with real row locks before claiming it. Confirm deployment worker availability and that users, API tokens, and database sessions share the transaction database. Ensure web-server/proxy/APM logs redact reset-token paths, email query strings, and submitted passwords before release.
