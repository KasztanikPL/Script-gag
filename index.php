<?php
$yr=date('Y');
$countries=[['DE','Deutschland',4.8,'dn'],['AT','Österreich',5.1,'nt'],['NL','Niederlande',3.7,'dn'],['PL','Polen',2.9,'dn'],['FR','Frankreich',7.3,'nt'],['ES','Spanien',11.2,'up'],['IT','Italien',6.7,'dn'],['GR','Griechenland',10.1,'nt']];
?><!DOCTYPE html>
<html lang="de">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Arbeitslosigkeit — Wirtschaft</title>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<style>
:root{--bg:#0b0e12;--bg2:#13171d;--bg3:#1a1f27;--bd:#252d38;--bd2:#2e3a48;--tx:#e8ecf0;--tx2:#9ba8b5;--tx3:#5c6e7e;--gold:#f0b429;--red:#ef5353;--green:#4ade9a;--blue:#60a5fa;--purple:#a78bfa}
*{margin:0;padding:0;box-sizing:border-box}
html{scroll-behavior:smooth}
body{background:var(--bg);color:var(--tx);font-family:system-ui,sans-serif;font-weight:400;line-height:1.6;overflow-x:hidden}
a{text-decoration:none;color:inherit}
/* NAV */
.nav{position:fixed;top:0;left:0;right:0;z-index:100;height:60px;background:rgba(11,14,18,.95);backdrop-filter:blur(16px);border-bottom:1px solid var(--bd);display:flex;align-items:center;padding:0 1.5rem;gap:1rem}
.nav-logo{display:flex;align-items:center;gap:.6rem;font-weight:700;font-size:.95rem}
.nav-icon{width:32px;height:32px;border-radius:8px;background:linear-gradient(135deg,var(--gold),#c88a10);display:flex;align-items:center;justify-content:center;font-size:.85rem;font-weight:800;color:#000}
.nav-links{display:flex;gap:.15rem;margin-left:.5rem}
.nav-link{font-size:.8rem;color:var(--tx2);padding:.45rem .8rem;border-radius:6px;border:1px solid transparent;cursor:pointer;position:relative;transition:color .15s,background .15s}
.nav-link:hover,.nav-link.act{color:var(--tx);background:var(--bg3);border-color:var(--bd)}
.nav-link.act{color:var(--gold);border-color:rgba(240,180,41,.25)}
.nav-link .arr{display:inline-block;width:8px;height:8px;border-right:1.5px solid currentColor;border-bottom:1.5px solid currentColor;transform:rotate(45deg) translateY(-2px);margin-left:4px;transition:transform .2s}
.nav-item.open .arr{transform:rotate(-135deg) translateY(-2px)}
.nav-dd{position:absolute;top:calc(100% + 8px);left:0;min-width:200px;background:var(--bg2);border:1px solid var(--bd);border-radius:10px;padding:.4rem;box-shadow:0 8px 32px rgba(0,0,0,.4);opacity:0;visibility:hidden;transform:translateY(-6px);transition:all .18s;pointer-events:none}
.nav-item.open .nav-dd{opacity:1;visibility:visible;transform:translateY(0);pointer-events:all}
.dd-item{display:block;padding:.6rem .8rem;border-radius:6px;font-size:.8rem;color:var(--tx2);transition:background .12s}
.dd-item:hover{background:var(--bg3);color:var(--tx)}
.nav-badge{margin-left:auto;font-size:.62rem;letter-spacing:.1em;text-transform:uppercase;color:var(--gold);background:rgba(240,180,41,.1);border:1px solid rgba(240,180,41,.2);padding:.2rem .6rem;border-radius:100px}
.hbg{display:none;flex-direction:column;gap:5px;background:none;border:none;cursor:pointer;margin-left:auto;padding:4px}
.hbg span{display:block;width:20px;height:1.5px;background:var(--tx2);border-radius:2px;transition:transform .25s,opacity .25s}
/* MOBILE NAV */
.mob-nav{position:fixed;top:60px;left:0;right:0;bottom:0;background:var(--bg2);z-index:99;transform:translateX(-100%);transition:transform .3s;padding:1.5rem;display:flex;flex-direction:column;gap:.4rem;overflow-y:auto}
.mob-nav.open{transform:translateX(0)}
.mob-link{display:block;padding:.8rem 1rem;font-size:.9rem;color:var(--tx2);border-radius:8px;border:1px solid transparent;transition:all .15s}
.mob-link:hover,.mob-link.act{background:var(--bg3);border-color:var(--bd);color:var(--tx)}
.mob-link.act{color:var(--gold)}
/* SLIDER */
.hero{margin-top:60px;position:relative;overflow:hidden;height:480px}
.slides{display:flex;height:100%;transition:transform .7s cubic-bezier(.4,0,.2,1)}
.slide{min-width:100%;height:100%;display:flex;align-items:flex-end;padding:2.5rem 3rem;position:relative;flex-shrink:0}
.s-bg{position:absolute;inset:0}
.s-ov{position:absolute;inset:0;background:linear-gradient(to top,rgba(0,0,0,.85) 0%,rgba(0,0,0,.15) 65%,transparent 100%)}
.s-content{position:relative;z-index:2;max-width:620px}
.s-eye{font-size:.62rem;letter-spacing:.18em;text-transform:uppercase;color:rgba(255,255,255,.45);margin-bottom:.65rem}
.s-title{font-size:clamp(1.8rem,5vw,3.5rem);font-weight:700;line-height:1.05;letter-spacing:-.04em;color:#fff;margin-bottom:.75rem}
.s-title em{font-style:italic;font-weight:300;color:var(--gold)}
.s-desc{font-size:.85rem;color:rgba(255,255,255,.6);max-width:460px;line-height:1.7;margin-bottom:1.25rem}
.s-tags{display:flex;flex-wrap:wrap;gap:.4rem}
.s-tag{font-size:.67rem;padding:.25rem .7rem;border-radius:100px;background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.18);color:rgba(255,255,255,.75)}
.s-tag.hi{background:rgba(240,180,41,.15);border-color:rgba(240,180,41,.35);color:var(--gold)}
.slide:nth-child(1) .s-bg{background:linear-gradient(135deg,#0d1b2a,#1a3050,#0b1e36)}
.slide:nth-child(2) .s-bg{background:linear-gradient(135deg,#1a0d0d,#3a1515,#1a0a0a)}
.slide:nth-child(3) .s-bg{background:linear-gradient(135deg,#0a1a12,#0f2e1e,#071510)}
.s-num{position:absolute;right:2.5rem;top:50%;transform:translateY(-50%);font-size:min(12rem,20vw);font-weight:800;letter-spacing:-.06em;color:rgba(255,255,255,.03);line-height:1;pointer-events:none;user-select:none}
.s-ctrl{position:absolute;bottom:1.25rem;right:2rem;display:flex;align-items:center;gap:.6rem;z-index:10}
.s-btn{width:34px;height:34px;border-radius:50%;background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.15);color:#fff;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:.85rem;transition:background .15s}
.s-btn:hover{background:rgba(255,255,255,.2)}
.s-dots{display:flex;gap:.35rem}
.s-dot{width:6px;height:6px;border-radius:50%;background:rgba(255,255,255,.25);cursor:pointer;transition:all .25s}
.s-dot.on{width:18px;border-radius:3px;background:var(--gold)}
.s-bar{position:absolute;bottom:0;left:0;height:2px;background:var(--gold);z-index:10}
/* MAIN */
.main{max-width:1280px;margin:0 auto;padding:2rem 1.5rem 4rem}
.sec-hd{display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:1rem;gap:1rem;flex-wrap:wrap}
.sec-title{font-size:.95rem;font-weight:600;letter-spacing:-.01em}
.sec-sub{font-size:.75rem;color:var(--tx3);margin-top:.15rem}
.sec-badge{font-size:.6rem;letter-spacing:.1em;text-transform:uppercase;color:var(--gold);background:rgba(240,180,41,.1);border:1px solid rgba(240,180,41,.2);padding:.22rem .65rem;border-radius:100px;flex-shrink:0}
/* KPI */
.kpi-row{display:grid;grid-template-columns:repeat(4,1fr);gap:.85rem;margin-bottom:1rem}
.kpi{background:var(--bg2);border:1px solid var(--bd);border-radius:10px;padding:1.25rem;position:relative;overflow:hidden;transition:border-color .2s,transform .2s;cursor:default}
.kpi:hover{border-color:var(--bd2);transform:translateY(-2px)}
.kpi::before{content:'';position:absolute;top:0;left:0;right:0;height:2px}
.kpi.g::before{background:linear-gradient(90deg,var(--gold),transparent)}
.kpi.r::before{background:linear-gradient(90deg,var(--red),transparent)}
.kpi.gr::before{background:linear-gradient(90deg,var(--green),transparent)}
.kpi.b::before{background:linear-gradient(90deg,var(--blue),transparent)}
.kpi-lbl{font-size:.65rem;letter-spacing:.1em;text-transform:uppercase;color:var(--tx3);margin-bottom:.5rem}
.kpi-val{font-size:2.2rem;font-weight:700;letter-spacing:-.04em;line-height:1;margin-bottom:.35rem}
.kpi.g .kpi-val{color:var(--gold)}.kpi.r .kpi-val{color:var(--red)}.kpi.gr .kpi-val{color:var(--green)}.kpi.b .kpi-val{color:var(--blue)}
.kpi-u{font-size:1.1rem;font-weight:400}
.kpi-meta{display:flex;align-items:center;gap:.4rem;font-size:.72rem;color:var(--tx3)}
.delta{font-size:.7rem;font-weight:600;padding:.12rem .4rem;border-radius:3px}
.up{color:var(--red);background:rgba(239,83,83,.12)}.dn{color:var(--green);background:rgba(74,222,154,.12)}.nt{color:var(--tx3);background:var(--bg3)}
/* CHARTS ROW */
.charts-row{display:grid;grid-template-columns:2fr 1fr;gap:.85rem;margin-bottom:.85rem}
.card{background:var(--bg2);border:1px solid var(--bd);border-radius:10px;padding:1.35rem;transition:border-color .2s}
.card:hover{border-color:var(--bd2)}
.card-hd{display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem}
.card-title{font-size:.85rem;font-weight:600}
.pill{font-size:.62rem;letter-spacing:.05em;padding:.2rem .6rem;border-radius:100px}
.pg{background:rgba(240,180,41,.1);color:var(--gold);border:1px solid rgba(240,180,41,.2)}
.pb{background:rgba(96,165,250,.1);color:var(--blue);border:1px solid rgba(96,165,250,.2)}
.pm{background:var(--bg3);color:var(--tx3);border:1px solid var(--bd)}
/* DONUT */
.dnt-wrap{display:flex;flex-direction:column;align-items:center;gap:.85rem}
.dnt-box{position:relative;width:160px;height:160px}
.dnt-ctr{position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;pointer-events:none}
.dnt-val{font-size:1.7rem;font-weight:700;letter-spacing:-.04em;line-height:1}
.dnt-label{font-size:.6rem;letter-spacing:.08em;text-transform:uppercase;color:var(--tx3);margin-top:.2rem}
.dnt-leg{width:100%;display:grid;gap:.4rem}
.dnt-li{display:flex;align-items:center;justify-content:space-between;font-size:.76rem}
.dnt-li-l{display:flex;align-items:center;gap:.45rem;color:var(--tx2)}
.dnt-dot{width:7px;height:7px;border-radius:50%;flex-shrink:0}
.dnt-pct{font-size:.73rem;font-weight:600;color:var(--tx)}
/* TYPES GRID */
.types-g{display:grid;grid-template-columns:repeat(3,1fr);gap:.75rem;margin-bottom:.85rem}
.type-c{background:var(--bg2);border:1px solid var(--bd);border-radius:10px;padding:1.1rem;transition:border-color .2s,transform .2s}
.type-c:hover{border-color:var(--bd2);transform:translateY(-2px)}
.type-top{display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:.7rem}
.t-icon{width:36px;height:36px;border-radius:7px;display:flex;align-items:center;justify-content:center;font-size:1rem;flex-shrink:0}
.type-title{font-size:.83rem;font-weight:600;margin-bottom:.3rem}
.type-desc{font-size:.75rem;color:var(--tx3);line-height:1.6}
.type-ft{display:flex;align-items:center;justify-content:space-between;margin-top:.8rem}
.type-pct{font-size:1.4rem;font-weight:700;letter-spacing:-.04em;line-height:1}
/* TABLE */
.tbl-card{margin-bottom:.85rem}
table{width:100%;border-collapse:collapse;font-size:.79rem}
th{font-size:.62rem;letter-spacing:.12em;text-transform:uppercase;color:var(--tx3);text-align:left;padding:.5rem .7rem;border-bottom:1px solid var(--bd);font-weight:500}
td{padding:.65rem .7rem;border-bottom:1px solid rgba(37,45,56,.4);color:var(--tx2);vertical-align:middle}
tr:last-child td{border-bottom:none}
tr:hover td{background:var(--bg3)}
.td-c{display:flex;align-items:center;gap:.55rem;color:var(--tx);font-weight:500}
.td-flag{width:26px;height:18px;border-radius:2px;background:var(--bg3);display:flex;align-items:center;justify-content:center;font-size:.6rem;font-weight:700;color:var(--tx3);flex-shrink:0}
.bar-t{flex:1;height:4px;border-radius:2px;background:var(--bg3);overflow:hidden}
.bar-f{height:100%;border-radius:2px}
.td-st{font-size:.63rem;letter-spacing:.07em;text-transform:uppercase;padding:.16rem .48rem;border-radius:3px}
/* CALLOUT */
.callout{border-left:3px solid var(--gold);background:rgba(240,180,41,.06);border-radius:0 8px 8px 0;padding:.9rem 1.1rem;margin-top:1rem}
.callout.red{border-left-color:var(--red);background:rgba(239,83,83,.06)}
.callout.green{border-left-color:var(--green);background:rgba(74,222,154,.06)}
.callout-lbl{font-size:.6rem;letter-spacing:.14em;text-transform:uppercase;font-weight:600;margin-bottom:.25rem}
.callout .callout-lbl{color:var(--gold)}.callout.red .callout-lbl{color:var(--red)}.callout.green .callout-lbl{color:var(--green)}
.callout-txt{font-size:.81rem;color:var(--tx2);line-height:1.7;font-style:italic}
/* MEASURES */
.meas-grid{display:grid;grid-template-columns:1fr 1fr;gap:.75rem;margin-bottom:.85rem}
.meas-col-hd{font-size:.65rem;letter-spacing:.12em;text-transform:uppercase;font-weight:600;padding-bottom:.55rem;margin-bottom:.65rem;border-bottom:1px solid var(--bd)}
.meas-item{display:flex;align-items:flex-start;gap:.55rem;padding:.55rem .7rem;background:var(--bg3);border:1px solid var(--bd);border-radius:7px;margin-bottom:.4rem;font-size:.78rem;color:var(--tx2);transition:background .13s}
.meas-item:hover{background:var(--bg2)}
.meas-item:last-child{margin-bottom:0}
.m-dot{width:6px;height:6px;border-radius:50%;flex-shrink:0;margin-top:.42rem}
/* FOOTER */
footer{border-top:1px solid var(--bd);padding:1.5rem;max-width:1280px;margin:0 auto;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:.5rem;font-size:.7rem;color:var(--tx3)}
/* RESPONSIVE */
@media(max-width:1000px){.kpi-row{grid-template-columns:repeat(2,1fr)}.charts-row{grid-template-columns:1fr}.types-g{grid-template-columns:repeat(2,1fr)}.meas-grid{grid-template-columns:1fr}}
@media(max-width:680px){.nav-links,.nav-badge{display:none}.hbg{display:flex}.hero{height:400px}.slide{padding:2rem 1.2rem}.s-num{display:none}.s-ctrl{right:1.2rem}.main{padding:1.25rem 1rem 3rem}.kpi-row{grid-template-columns:1fr 1fr}.types-g{grid-template-columns:1fr}}
@media(max-width:420px){.kpi-row{grid-template-columns:1fr}}
</style>
</head>
<body>

<!-- NAV -->
<nav class="nav" id="nav">
  <a href="#" class="nav-logo">
    <div class="nav-icon">A</div>
    <span>Arbeit.Info</span>
  </a>
  <div class="nav-links">
    <a class="nav-link act" href="#dashboard">Dashboard</a>
    <div class="nav-item" id="d1">
      <button class="nav-link" onclick="td('d1')">Arten <span class="arr"></span></button>
      <div class="nav-dd">
        <a class="dd-item" href="#arten" onclick="cd('d1')">Konjunkturelle</a>
        <a class="dd-item" href="#arten" onclick="cd('d1')">Strukturelle</a>
        <a class="dd-item" href="#arten" onclick="cd('d1')">Friktionelle</a>
        <a class="dd-item" href="#arten" onclick="cd('d1')">Technologische</a>
      </div>
    </div>
    <div class="nav-item" id="d2">
      <button class="nav-link" onclick="td('d2')">Maßnahmen <span class="arr"></span></button>
      <div class="nav-dd">
        <a class="dd-item" href="#mass" onclick="cd('d2')">Aktive Maßnahmen</a>
        <a class="dd-item" href="#mass" onclick="cd('d2')">Passive Maßnahmen</a>
      </div>
    </div>
    <a class="nav-link" href="#intl">International</a>
    <a class="nav-link" href="#jugend">Jugend</a>
  </div>
  <span class="nav-badge">Kapitel 04</span>
  <button class="hbg" id="hbg" onclick="toggleMob()" aria-label="Menü">
    <span></span><span></span><span></span>
  </button>
</nav>

<!-- MOBILE NAV -->
<div class="mob-nav" id="mobNav">
  <a class="mob-link act" href="#dashboard" onclick="closeMob()">Dashboard</a>
  <a class="mob-link" href="#arten" onclick="closeMob()">Arten der Arbeitslosigkeit</a>
  <a class="mob-link" href="#mass" onclick="closeMob()">Maßnahmen</a>
  <a class="mob-link" href="#intl" onclick="closeMob()">International</a>
  <a class="mob-link" href="#jugend" onclick="closeMob()">Jugendarbeitslosigkeit</a>
</div>

<!-- SLIDER -->
<section class="hero">
  <div class="slides" id="slides">
    <div class="slide">
      <div class="s-bg"></div><div class="s-ov"></div>
      <div class="s-num">01</div>
      <div class="s-content">
        <p class="s-eye">Wirtschaft · Kapitel 04</p>
        <h1 class="s-title">Arbeits<em>losig</em>keit<br>verstehen</h1>
        <p class="s-desc">Definition, Messung und die verschiedenen Formen — von konjunkturell bis strukturell.</p>
        <div class="s-tags"><span class="s-tag hi">4,8 % Quote</span><span class="s-tag">2,71 Mio.</span><span class="s-tag">6 Arten</span></div>
      </div>
    </div>
    <div class="slide">
      <div class="s-bg"></div><div class="s-ov"></div>
      <div class="s-num">02</div>
      <div class="s-content">
        <p class="s-eye">Verzerrung · Messprobleme</p>
        <h1 class="s-title">Die <em>stille</em><br>Reserve</h1>
        <p class="s-desc">Offizielle Statistiken unterschätzen das wahre Ausmaß. Stille Reserve, Maßnahmenteilnehmer, Kurzarbeiter.</p>
        <div class="s-tags"><span class="s-tag hi">~+30 % Untererfassung</span><span class="s-tag">Stille Reserve</span></div>
      </div>
    </div>
    <div class="slide">
      <div class="s-bg"></div><div class="s-ov"></div>
      <div class="s-num">03</div>
      <div class="s-content">
        <p class="s-eye">Politik · Bekämpfung</p>
        <h1 class="s-title"><em>Aktiv</em> oder<br>Passiv?</h1>
        <p class="s-desc">Weiterbildung und Vermittlung vs. Einkommenssicherung — staatliche Instrumente im Vergleich.</p>
        <div class="s-tags"><span class="s-tag hi">ALG I · Bürgergeld</span><span class="s-tag">Kurzarbeitergeld</span></div>
      </div>
    </div>
  </div>
  <div class="s-bar" id="sBar"></div>
  <div class="s-ctrl">
    <div class="s-dots" id="sDots">
      <button class="s-dot on" onclick="go(0)"></button>
      <button class="s-dot" onclick="go(1)"></button>
      <button class="s-dot" onclick="go(2)"></button>
    </div>
    <button class="s-btn" onclick="prev()">&#8592;</button>
    <button class="s-btn" onclick="next()">&#8594;</button>
  </div>
</section>

<!-- MAIN -->
<main class="main" id="dashboard">

  <div class="sec-hd">
    <div><div class="sec-title">Aktuelle Kennzahlen</div><div class="sec-sub">Deutschland · <?=$yr?> · Bundesagentur für Arbeit</div></div>
    <span class="sec-badge">Live-Daten</span>
  </div>

  <!-- KPI -->
  <div class="kpi-row">
    <div class="kpi g"><div class="kpi-lbl">Arbeitslosenquote</div><div class="kpi-val">4<span class="kpi-u">,8 %</span></div><div class="kpi-meta"><span class="delta up">▲ +0,1</span> ggü. Vormonat</div></div>
    <div class="kpi r"><div class="kpi-lbl">Arbeitslose (Mio.)</div><div class="kpi-val">2<span class="kpi-u">,71 M</span></div><div class="kpi-meta"><span class="delta up">▲ +42k</span> ggü. Vorjahr</div></div>
    <div class="kpi gr"><div class="kpi-lbl">Offene Stellen</div><div class="kpi-val">0<span class="kpi-u">,69 M</span></div><div class="kpi-meta"><span class="delta dn">▼ −18k</span> ggü. Vorjahr</div></div>
    <div class="kpi b"><div class="kpi-lbl">Jugendarbeitslosigkeit</div><div class="kpi-val">6<span class="kpi-u">,3 %</span></div><div class="kpi-meta"><span class="delta nt">→ 0,0</span> stabil</div></div>
  </div>

  <!-- CHARTS -->
  <div class="charts-row">
    <div class="card">
      <div class="card-hd"><span class="card-title">Jahresverlauf der Arbeitslosenquote</span><div style="display:flex;gap:.4rem"><span class="pill pg">12 M.</span><span class="pill pb">Jugend</span></div></div>
      <div style="position:relative;height:230px"><canvas id="lineChart"></canvas></div>
    </div>
    <div class="card">
      <div class="card-hd"><span class="card-title">Arten — Verteilung</span></div>
      <div class="dnt-wrap">
        <div class="dnt-box">
          <canvas id="donut"></canvas>
          <div class="dnt-ctr"><div class="dnt-val">2,71<span style="font-size:1rem">M</span></div><div class="dnt-label">Gesamt</div></div>
        </div>
        <div class="dnt-leg">
          <div class="dnt-li"><div class="dnt-li-l"><div class="dnt-dot" style="background:var(--red)"></div>Konjunkturell</div><div class="dnt-pct">34%</div></div>
          <div class="dnt-li"><div class="dnt-li-l"><div class="dnt-dot" style="background:var(--blue)"></div>Strukturell</div><div class="dnt-pct">28%</div></div>
          <div class="dnt-li"><div class="dnt-li-l"><div class="dnt-dot" style="background:var(--gold)"></div>Friktionell</div><div class="dnt-pct">18%</div></div>
          <div class="dnt-li"><div class="dnt-li-l"><div class="dnt-dot" style="background:var(--purple)"></div>Technologisch</div><div class="dnt-pct">12%</div></div>
          <div class="dnt-li"><div class="dnt-li-l"><div class="dnt-dot" style="background:var(--green)"></div>Saisonal</div><div class="dnt-pct">8%</div></div>
        </div>
      </div>
    </div>
  </div>

  <!-- ARTEN -->
  <div class="sec-hd" id="arten" style="margin-top:1.75rem">
    <div><div class="sec-title">Arten der Arbeitslosigkeit</div><div class="sec-sub">Sechs Hauptkategorien</div></div>
    <span class="sec-badge">Kapitel 04.1</span>
  </div>
  <div class="types-g">
    <div class="type-c"><div class="type-top"><div class="t-icon" style="background:rgba(239,83,83,.12);color:var(--red)">&#8681;</div><span class="pill pm">Temporär</span></div><div class="type-title">Konjunkturelle</div><div class="type-desc">Wirtschaftsabschwung → Nachfrage sinkt. Kehrt mit Aufschwung zurück.</div><div class="type-ft"><div class="type-pct" style="color:var(--red)">34%</div><span class="pill" style="background:rgba(239,83,83,.1);color:var(--red);border:1px solid rgba(239,83,83,.2)">~920k</span></div></div>
    <div class="type-c"><div class="type-top"><div class="t-icon" style="background:rgba(96,165,250,.12);color:var(--blue)">&#9112;</div><span class="pill pm">Langfristig</span></div><div class="type-title">Strukturelle</div><div class="type-desc">Dauerhafter Wandel (Digitalisierung). Erfordert Umschulung.</div><div class="type-ft"><div class="type-pct" style="color:var(--blue)">28%</div><span class="pill" style="background:rgba(96,165,250,.1);color:var(--blue);border:1px solid rgba(96,165,250,.2)">~759k</span></div></div>
    <div class="type-c"><div class="type-top"><div class="t-icon" style="background:rgba(240,180,41,.12);color:var(--gold)">&#8652;</div><span class="pill pm">Normal</span></div><div class="type-title">Friktionelle</div><div class="type-desc">Übergang zwischen Jobs. Unvermeidlich in freier Marktwirtschaft.</div><div class="type-ft"><div class="type-pct" style="color:var(--gold)">18%</div><span class="pill pg">~488k</span></div></div>
    <div class="type-c"><div class="type-top"><div class="t-icon" style="background:rgba(167,139,250,.12);color:var(--purple)">&#9881;</div><span class="pill pm">Wachsend</span></div><div class="type-title">Technologische</div><div class="type-desc">Automatisierung ersetzt Arbeitskräfte. Unterform der Strukturarbeitslosigkeit.</div><div class="type-ft"><div class="type-pct" style="color:var(--purple)">12%</div><span class="pill" style="background:rgba(167,139,250,.1);color:var(--purple);border:1px solid rgba(167,139,250,.2)">~325k</span></div></div>
    <div class="type-c"><div class="type-top"><div class="t-icon" style="background:rgba(74,222,154,.12);color:var(--green)">&#9400;</div><span class="pill pm">Saisonal</span></div><div class="type-title">Saisonale</div><div class="type-desc">Jahreszeiten (Bau, Tourismus, Landwirtschaft). Vorhersehbar.</div><div class="type-ft"><div class="type-pct" style="color:var(--green)">8%</div><span class="pill" style="background:rgba(74,222,154,.1);color:var(--green);border:1px solid rgba(74,222,154,.2)">~217k</span></div></div>
    <div class="type-c"><div class="type-top"><div class="t-icon" style="background:rgba(251,146,60,.12);color:var(--orange,#fb923c)">&#9656;</div><span class="pill pm">Persistent</span></div><div class="type-title">Sockelarbeitslosigkeit</div><div class="type-desc">Verbleibt im Konjunkturhoch. Schwer vermittelbare Personen.</div><div class="type-ft"><div class="type-pct" style="color:#fb923c">—</div><span class="pill pm">Sockelbasis</span></div></div>
  </div>
  <div class="callout red"><div class="callout-lbl">Merksatz · Verzerrung</div><div class="callout-txt">Die offizielle Quote unterschätzt das wahre Ausmaß: Stille Reserve, Maßnahmeteilnehmer und Kurzarbeiter fehlen. Reale Arbeitslosigkeit liegt 25–35% über den Meldezahlen.</div></div>

  <!-- INTERNATIONAL -->
  <div class="sec-hd" id="intl" style="margin-top:1.75rem">
    <div><div class="sec-title">Internationaler Vergleich</div><div class="sec-sub">EU-Staaten · <?=$yr?> · EUROSTAT</div></div>
    <span class="sec-badge">EUROSTAT</span>
  </div>
  <div class="card tbl-card">
    <table>
      <thead><tr><th>Land</th><th>Quote</th><th>Anteil</th><th>Trend</th><th>Status</th></tr></thead>
      <tbody>
      <?php
      $ss=['Sehr gut'=>'rgba(74,222,154,.12);color:#4ade9a','Gut'=>'rgba(74,222,154,.12);color:#4ade9a','Stabil'=>'rgba(240,180,41,.12);color:#f0b429','Erhöht'=>'rgba(251,146,60,.12);color:#fb923c','Kritisch'=>'rgba(239,83,83,.12);color:#ef5353'];
      $ti=['up'=>['▲','var(--red)'],'dn'=>['▼','var(--green)'],'nt'=>['→','var(--tx3)']];
      $status_map=[3.7=>'Gut',2.9=>'Sehr gut',4.8=>'Stabil',4.9=>'Stabil',5.1=>'Stabil',6.7=>'Erhöht',7.3=>'Erhöht',8.4=>'Erhöht',10.1=>'Kritisch',11.2=>'Kritisch'];
      foreach($countries as $c){
        [$code,$name,$rate,$trend]=$c;
        $pct=round($rate/12*100);
        $bc=$rate<5?'var(--green)':($rate<8?'var(--gold)':'var(--red)');
        $st=$status_map[$rate];
        echo "<tr><td><div class='td-c'><div class='td-flag'>$code</div>$name</div></td>";
        echo "<td style='font-variant-numeric:tabular-nums;font-weight:500'>".number_format($rate,1,',','.')." %</td>";
        echo "<td><div style='display:flex;align-items:center;gap:.5rem'><div class='bar-t'><div class='bar-f' style='width:$pct%;background:$bc'></div></div></div></td>";
        echo "<td style='color:{$ti[$trend][1]};font-weight:600'>{$ti[$trend][0]}</td>";
        echo "<td><span class='td-st' style='background:{$ss[$st]}'>{$st}</span></td></tr>";
      }?>
      </tbody>
    </table>
  </div>

  <!-- MASSNAHMEN -->
  <div class="sec-hd" id="mass" style="margin-top:1.75rem">
    <div><div class="sec-title">Maßnahmen zur Bekämpfung</div><div class="sec-sub">Aktive vs. passive Instrumente</div></div>
    <span class="sec-badge">Kapitel 04.2</span>
  </div>
  <div class="meas-grid">
    <div class="card" id="jugend">
      <div class="meas-col-hd" style="color:var(--green)">Aktive Maßnahmen</div>
      <?php foreach(['Aus- und Weiterbildungsförderung','Arbeitsvermittlung (Agentur für Arbeit)','Eingliederungszuschüsse','Arbeitsbeschaffungsmaßnahmen (ABM)','Gründungszuschuss','Lohnkostenzuschüsse'] as $m):?>
      <div class="meas-item"><div class="m-dot" style="background:var(--green)"></div><?=htmlspecialchars($m)?></div>
      <?php endforeach;?>
    </div>
    <div class="card">
      <div class="meas-col-hd" style="color:var(--red)">Passive Maßnahmen</div>
      <?php foreach(['Arbeitslosengeld I (ALG I)','Bürgergeld (ehem. Hartz IV)','Kurzarbeitergeld','Insolvenzgeld'] as $m):?>
      <div class="meas-item"><div class="m-dot" style="background:var(--red)"></div><?=htmlspecialchars($m)?></div>
      <?php endforeach;?>
      <div class="callout green" style="margin-top:.85rem"><div class="callout-lbl">Jugend · 6,3 %</div><div class="callout-txt">Berufsausbildungsbeihilfe, Azubi-Prämien, BaE — Berufsausbildung in außerbetrieblichen Einrichtungen.</div></div>
    </div>
  </div>
  <div class="callout"><div class="callout-lbl">Merksatz</div><div class="callout-txt">Aktive Maßnahmen bekämpfen die Ursache. Passive Maßnahmen sichern das Einkommen — lösen das Problem aber nicht.</div></div>

</main>

<footer>
  <span>&copy; <?=$yr?> Arbeit.Info — Wirtschaft Kapitel 04</span>
  <span>Daten: Bundesagentur für Arbeit · EUROSTAT</span>
</footer>

<script>
// NAV
window.addEventListener('scroll',()=>document.getElementById('nav').style.boxShadow=scrollY>20?'0 2px 24px rgba(0,0,0,.5)':'');
function td(id){document.querySelectorAll('.nav-item').forEach(e=>{if(e.id!==id)e.classList.remove('open')});document.getElementById(id)?.classList.toggle('open')}
function cd(id){document.getElementById(id)?.classList.remove('open')}
document.addEventListener('click',e=>{if(!e.target.closest('.nav-item'))document.querySelectorAll('.nav-item').forEach(e=>e.classList.remove('open'))});

// MOBILE NAV
let mob=false;
function toggleMob(){
  mob=!mob;
  document.getElementById('mobNav').classList.toggle('open',mob);
  document.body.style.overflow=mob?'hidden':'';
  const [a,b,c]=document.getElementById('hbg').querySelectorAll('span');
  a.style.transform=mob?'translateY(6.5px) rotate(45deg)':'';
  b.style.opacity=mob?'0':'';
  c.style.transform=mob?'translateY(-6.5px) rotate(-45deg)':'';
}
function closeMob(){if(mob)toggleMob()}

// SLIDER
let cur=0,timer,pStart,pRaf;
const INTV=6000;
const slidesEl=document.getElementById('slides');
const dots=document.querySelectorAll('.s-dot');
const barEl=document.getElementById('sBar');
function go(n){cur=((n%3)+3)%3;slidesEl.style.transform=`translateX(-${cur*100}%)`;dots.forEach((d,i)=>d.classList.toggle('on',i===cur));reset()}
function next(){go(cur+1)}function prev(){go(cur-1)}
function startBar(){cancelAnimationFrame(pRaf);barEl.style.transition='none';barEl.style.width='0%';pStart=performance.now();function s(n){const p=Math.min((n-pStart)/INTV*100,100);barEl.style.width=p+'%';if(p<100)pRaf=requestAnimationFrame(s)}requestAnimationFrame(s)}
function reset(){clearInterval(timer);startBar();timer=setInterval(()=>go(cur+1),INTV)}
reset();
document.addEventListener('keydown',e=>{if(e.key==='ArrowRight')next();if(e.key==='ArrowLeft')prev()});

// CHARTS
Chart.defaults.color='#5c6e7e';
Chart.defaults.font.family='system-ui,sans-serif';
Chart.defaults.font.size=11;
const months=['Jan','Feb','Mär','Apr','Mai','Jun','Jul','Aug','Sep','Okt','Nov','Dez'];
const rates=[5.2,5.1,4.9,4.8,4.7,4.9,5.0,5.1,4.8,4.7,4.8,5.0];
const youth=[6.8,6.6,6.4,6.3,6.1,6.2,6.5,6.7,6.3,6.1,6.2,6.4];
new Chart(document.getElementById('lineChart'),{type:'line',data:{labels:months,datasets:[{label:'Allgemein',data:rates,borderColor:'#f0b429',backgroundColor:'rgba(240,180,41,.08)',borderWidth:2,pointRadius:3,pointHoverRadius:5,pointBackgroundColor:'#f0b429',fill:true,tension:.4},{label:'Jugend',data:youth,borderColor:'#60a5fa',backgroundColor:'rgba(96,165,250,.05)',borderWidth:2,pointRadius:3,pointHoverRadius:5,pointBackgroundColor:'#60a5fa',fill:true,tension:.4}]},options:{responsive:true,maintainAspectRatio:false,interaction:{intersect:false,mode:'index'},plugins:{legend:{display:true,labels:{color:'#9ba8b5',boxWidth:10,boxHeight:10}},tooltip:{backgroundColor:'#1a1f27',borderColor:'#252d38',borderWidth:1,padding:10,callbacks:{label:c=>` ${c.dataset.label}: ${c.parsed.y.toFixed(1)} %`}}},scales:{x:{grid:{color:'rgba(37,45,56,.5)'},border:{display:false}},y:{grid:{color:'rgba(37,45,56,.5)'},border:{display:false},ticks:{callback:v=>v+' %'},min:3,max:8}}}});
new Chart(document.getElementById('donut'),{type:'doughnut',data:{labels:['Konjunkturell','Strukturell','Friktionell','Technologisch','Saisonal'],datasets:[{data:[34,28,18,12,8],backgroundColor:['#ef5353','#60a5fa','#f0b429','#a78bfa','#4ade9a'],borderColor:'#13171d',borderWidth:3,hoverOffset:5}]},options:{responsive:true,maintainAspectRatio:false,cutout:'72%',plugins:{legend:{display:false},tooltip:{backgroundColor:'#1a1f27',borderColor:'#252d38',borderWidth:1,padding:10,callbacks:{label:c=>` ${c.label}: ${c.parsed} %`}}}}});
</script>
</body>
</html>
