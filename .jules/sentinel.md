# Sentinel Security Learnings

## 2026-04-25 - Command Injection via escapeshellcmd in PHP

`escapeshellcmd` is insufficient for preventing argument injection when user input is part of a larger command string. While it prevents command chaining (e.g., using `;` or `&&`), it doesn't escape spaces, allowing an attacker to pass additional flags to the binary being executed.

The secure fix is to use an array of arguments with Symfony's `Process` component (or `proc_open`), which bypasses the shell entirely or handles escaping of each argument individually.

On Windows, when using the `start` command to open a URL, the correct and secure way to invoke it via an array is `['cmd', '/c', 'start', '', $url]`. The empty string `''` is crucial as it occupies the 'title' argument of `start`, preventing a quoted URL from being misinterpreted as a window title.
