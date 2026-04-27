## 2025-02-14 - Fix Command Injection in Process::fromShellCommandline

**Vulnerability:** Command injection vulnerability in `DocsCommand.php` where `Process::fromShellCommandline(escapeshellcmd(...))` was used to launch the browser or system commands with user-controlled input (`$url`).

**Learning:** Using `Process::fromShellCommandline` with `escapeshellcmd` is not entirely secure against command and argument injection. Even if some characters are escaped, it could still be possible to bypass or inject arguments, especially on Windows (`cmd /c start`).

**Prevention:** To prevent command injection when executing external commands, prefer using the Symfony `Process` constructor that accepts an array of arguments (e.g., `new Process(['cmd', '/c', 'start', '', $url])` or `new Process([$binary, $url])`). This allows Symfony's `Process` component to securely handle internal escaping and formatting per the operating system, mitigating the risk of argument/command injection.
