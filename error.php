<?php
http_response_code(404);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Page Not Found</title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<style>
:root { color-scheme: light dark; }
* { box-sizing: border-box; }
body { margin:0; font-family: system-ui,-apple-system,Segoe UI,Roboto,Ubuntu,"Fira Sans","Droid Sans","Helvetica Neue",Arial,sans-serif; background:#0f1419; color:#e6edf3; display:flex; align-items:center; justify-content:center; min-height:100vh; padding:40px; }
.main { max-width:720px; width:100%; text-align:center; }
.halo { font-size:180px; line-height:0.8; font-weight:700; letter-spacing:-6px; background:linear-gradient(135deg,#ff4d4f,#ffb347); -webkit-background-clip:text; color:transparent; margin:0 0 10px; }
.subtitle { font-size:28px; font-weight:600; margin:0 0 24px; }
.msg { font-size:16px; line-height:1.55; opacity:.85; margin:0 auto 28px; max-width:560px; }
.actions { display:flex; flex-wrap:wrap; gap:14px; justify-content:center; }
.actions a { text-decoration:none; padding:14px 26px; border-radius:10px; font-weight:600; font-size:15px; letter-spacing:.5px; transition:.25s; position:relative; overflow:hidden; }
.actions a.home { background:#2563eb; color:#fff; }
.actions a.home:hover { filter:brightness(1.15); }
.actions a.retry { background:#334155; color:#e2e8f0; }
.actions a.retry:hover { background:#475569; }
.search { margin-top:32px; }
.search form { display:flex; gap:10px; max-width:420px; margin:0 auto; }
.search input { flex:1; padding:12px 14px; border-radius:8px; border:1px solid #334155; background:#1e293b; color:#e2e8f0; font-size:14px; }
.search input:focus { outline:2px solid #2563eb; outline-offset:2px; }
.search button { padding:12px 18px; border:none; background:#0d9488; color:#fff; border-radius:8px; font-weight:600; cursor:pointer; }
.search button:hover { filter:brightness(1.15); }
.hints { margin-top:40px; font-size:13px; opacity:.65; }
.small-links { margin-top:24px; display:flex; gap:18px; justify-content:center; font-size:13px; }
.small-links a { color:#94a3b8; text-decoration:none; }
.small-links a:hover { color:#fff; }
@media (max-width:600px) { .halo { font-size:120px; letter-spacing:-4px; } .subtitle { font-size:22px; } }
</style>
</head>
<body>
  <div class="main">
    <div class="halo">404</div>
    <div class="subtitle">Page not found</div>
    <p class="msg">The page you were looking for doesn't exist, was moved, or maybe never existed.<br>Check the address, try a quick search, or head back home.</p>
    <div class="actions">
      <a class="home" href="/Library/index">Go Home</a>
      <a class="retry" href="javascript:location.reload()">Retry</a>
    </div>
    <div class="search">
      <form action="/Library/books" method="post">
        <input type="text" name="search" placeholder="Search books..." required>
        <button type="submit" name="submit">Search</button>
      </form>
    </div>
    <div class="small-links">
      <a href="/Library/login">Login</a>
      <a href="/Library/register">Register</a>
      <a href="/Library/contact">Contact</a>
    </div>
    <div class="hints">Error code: 404 · Smart Library Management System</div>
  </div>
</body>
</html>


