## 2024-05-18 - [Fix TypeError DoS in hash_equals]
**Vulnerability:** Uncaught TypeError in hash_equals leading to 500 server error.
**Learning:** In PHP 8+, passing non-strings to hash_equals throws a TypeError. This can be exploited for DoS if session values are missing or tampered to be non-strings.
**Prevention:** Always enforce type checks (! is_string) before passing dynamic inputs to hash_equals.
