# Latest dependencies checked

Latest version of each rule provider whose rules have been reviewed against the config sets.

**Tool:**
- symplify/easy-coding-standard 13.3.21 — it bundles scoped copies of php-cs-fixer and php_codesniffer, and
  those are the ones actually running the checks, not the ones in the root vendor. It also ships the Symplify
  fixers
- friendsofphp/php-cs-fixer 3.95.32 (bundled) — no new fixers since 3.95.5
- squizlabs/php_codesniffer 4.0.4 (bundled) — no new sniffs since 4.0.1

**Fixers:**
- kubawerlos/php-cs-fixer-custom-fixers 3.37.5
- pedrotroller/php-cs-custom-fixer 2.35 — requires PHP >= 8.3 and adds no fixers over 2.34
- Symplify fixers (bundled by ECS 13.3.21)

**Sniffs:**
- slevomat/coding-standard 8.31.3
