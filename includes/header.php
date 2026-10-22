<?php
$pageTitle = $pageTitle ?? "ZassTech | Digital products that move business forward";
$pageDescription = $pageDescription ?? "ZassTech builds thoughtful digital platforms for food, healthcare, and commerce.";
$currentPage = basename($_SERVER["PHP_SELF"] ?? "index.php");
if (session_status() !== PHP_SESSION_ACTIVE) {
    $isHttps = (!empty($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] !== "off") || (($_SERVER["SERVER_PORT"] ?? "") === "443");
    session_set_cookie_params([
        "httponly" => true,
        "secure" => $isHttps,
        "samesite" => "Lax",
        "path" => "/",
    ]);
    session_start();
}
if (empty($_SESSION["csrf_token"])) {
    session_regenerate_id(true);
    $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
}
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: SAMEORIGIN");
header("Referrer-Policy: strict-origin-when-cross-origin");
header("Permissions-Policy: camera=(), microphone=(), geolocation=()");
if ((!empty($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] !== "off") || (($_SERVER["SERVER_PORT"] ?? "") === "443")) {
    header("Strict-Transport-Security: max-age=31536000; includeSubDomains");
}
?>
<!doctype html>
<html lang="en"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><meta name="description" content="<?= htmlspecialchars($pageDescription, ENT_QUOTES, "UTF-8") ?>"><meta name="theme-color" content="#5b21b6"><title><?= htmlspecialchars($pageTitle, ENT_QUOTES, "UTF-8") ?></title>
<link rel="icon" href="assets/favicon.svg" type="image/svg+xml"><link rel="apple-touch-icon" href="assets/favicon.svg">
<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet"><script src="https://cdn.tailwindcss.com"></script>
<script>tailwind.config={theme:{extend:{fontFamily:{sans:["DM Sans","sans-serif"],display:["Space Grotesk","sans-serif"]},colors:{ink:"#10152b",aqua:"#0e9fb0",coral:"#ea684d"}}}}</script>
<style>:root{--ink:#10152b;--navy:#10152b;--violet:#5b21b6;--violet-bright:#7c3aed;--aqua:#0e9fb0;--coral:#ea684d;--lime:#d9f45b;--muted:#64708a;--surface:#f7f5ef}html{scroll-behavior:smooth;scroll-padding-top:6rem}body{font-family:"DM Sans",sans-serif;color:var(--ink);background:#fbfaf7}.display{font-family:"Space Grotesk",sans-serif;letter-spacing:-.055em}.gradient-hero{background:radial-gradient(circle at 82% 16%,rgba(217,244,91,.17),transparent 24%),linear-gradient(135deg,#15132c 0%,#241452 45%,#0f6375 100%)}.gradient-text{background:linear-gradient(100deg,#5b21b6,#0e9fb0 58%,#d26b48);-webkit-background-clip:text;background-clip:text;color:transparent}.soft-grid{background-color:var(--surface);background-image:linear-gradient(rgba(16,21,43,.045) 1px,transparent 1px),linear-gradient(90deg,rgba(16,21,43,.045) 1px,transparent 1px);background-size:24px 24px}.glass{background:rgba(255,255,255,.13);border:1px solid rgba(255,255,255,.27);backdrop-filter:blur(16px)}.card-lift{transition:transform .25s ease,box-shadow .25s ease;border-radius:1rem 2rem 1rem 2rem!important}.card-lift:hover{transform:translateY(-7px) rotate(-.35deg);box-shadow:0 24px 60px rgba(34,26,76,.16)}.orb{position:absolute;border-radius:9999px;filter:blur(1px);pointer-events:none}.nav-link{transition:color .2s ease}.nav-link:hover{color:var(--violet)}.form-field:focus{outline:none;border-color:var(--violet-bright);box-shadow:0 0 0 4px rgba(124,58,237,.14)}.contact-submit{background:linear-gradient(110deg,#5b21b6,#155e75)!important;color:#fff!important;border:0;min-height:52px;text-shadow:0 1px 2px rgba(24,16,55,.35)}.contact-submit:hover{background:linear-gradient(110deg,#4c1d95,#0e7490)!important;color:#fff!important}.contact-form{min-width:0}.contact-form input,.contact-form select,.contact-form textarea{box-sizing:border-box;max-width:100%;min-width:0}.brand-mark{position:relative}.brand-mark:after{content:"";position:absolute;right:-5px;bottom:-5px;width:11px;height:11px;border-radius:999px;background:var(--lime);border:2px solid #fff}.signal-label{display:inline-flex;align-items:center;gap:.5rem;font-size:.7rem;font-weight:800;letter-spacing:.18em;text-transform:uppercase}.signal-label:before{content:"";width:2rem;height:2px;background:currentColor}.signal-card{border:1px solid rgba(16,21,43,.12);background:linear-gradient(145deg,#fff 0%,#f3f0e7 100%);box-shadow:10px 10px 0 rgba(217,244,91,.75)}.section-number{font-family:"Space Grotesk",sans-serif;color:var(--coral);font-size:.8rem;font-weight:800;letter-spacing:.14em}.ink-panel{background:#11152c;color:#fff}.lime-chip{background:var(--lime);color:#182022}.editorial-rule{height:1px;background:rgba(16,21,43,.16)}@media(max-width:767px){.card-lift:hover{transform:translateY(-4px)}}@media(prefers-reduced-motion:reduce){*,*::before,*::after{scroll-behavior:auto!important;animation-duration:.01ms!important;transition-duration:.01ms!important}}</style>
</head><body class="bg-white antialiased">
<header class="fixed inset-x-0 top-0 z-50 border-b border-white/70 bg-white/90 backdrop-blur-xl"><nav class="mx-auto flex max-w-7xl items-center justify-between px-5 py-4 lg:px-8" aria-label="Main navigation">
<a href="index.php" class="brand-mark flex items-center gap-2.5" aria-label="ZassTech home"><img src="assets/zasstech-mark.svg" alt="" class="h-10 w-10 rounded-xl shadow-lg shadow-blue-200/70"><span class="display text-2xl font-bold tracking-tight">Zass<span class="text-violet-700">Tech</span></span></a>
<button id="menu-toggle" class="grid h-10 w-10 place-items-center rounded-xl border border-slate-200 text-slate-700 md:hidden" aria-expanded="false" aria-controls="mobile-menu" aria-label="Open navigation menu"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 7h16M4 12h16M4 17h16"/></svg></button>
<div class="hidden items-center gap-8 md:flex"><a class="nav-link text-sm font-semibold <?= $currentPage === "index.php" ? "text-violet-700" : "text-slate-600" ?>" href="index.php">Home</a><a class="nav-link text-sm font-semibold text-slate-600" href="index.php#products">Our products</a><a class="nav-link text-sm font-semibold <?= $currentPage === "contact.php" ? "text-violet-700" : "text-slate-600" ?>" href="contact.php">Contact</a><a href="contact.php" class="rounded-full bg-ink px-5 py-2.5 text-sm font-bold text-white shadow-lg transition hover:bg-violet-700">Let’s talk <span aria-hidden="true">↗</span></a></div></nav>
<div id="mobile-menu" class="hidden border-t border-slate-100 bg-white px-5 pb-5 pt-2 md:hidden"><a class="block rounded-lg px-3 py-3 font-semibold text-slate-700 hover:bg-violet-50" href="index.php">Home</a><a class="block rounded-lg px-3 py-3 font-semibold text-slate-700 hover:bg-violet-50" href="index.php#products">Our products</a><a class="block rounded-lg px-3 py-3 font-semibold text-slate-700 hover:bg-violet-50" href="contact.php">Contact</a><a class="mt-2 block rounded-full bg-violet-700 px-5 py-3 text-center font-bold text-white" href="contact.php">Let’s talk ↗</a></div></header><main class="pt-[72px]"><script>(()=>{const b=document.getElementById("menu-toggle"),m=document.getElementById("mobile-menu");if(!b||!m)return;b.addEventListener("click",()=>{const o=b.getAttribute("aria-expanded")==="true";b.setAttribute("aria-expanded",String(!o));b.setAttribute("aria-label",o?"Open navigation menu":"Close navigation menu");m.classList.toggle("hidden",o)});m.querySelectorAll("a").forEach(a=>a.addEventListener("click",()=>{m.classList.add("hidden");b.setAttribute("aria-expanded","false")}))})();</script>
