## 2024-04-24 - [Timing Attack in Cookie Prefix Validation]
**Vulnerability:** Cookie prefixes (HMAC hashes) were validated using `str_starts_with`, which is vulnerable to timing attacks as it fails early on mismatch, potentially leaking the expected hash character by character.
**Learning:** Even built-in string functions like `str_starts_with` or `==` are unsafe for comparing secrets or hashes. The framework specifically handles cookie values which incorporate security critical HMAC hashes that must be compared securely.
**Prevention:** Always use `hash_equals` for comparing hashes or secrets, combined with string slicing (e.g., `substr`) to match the exact length of the expected hash.
