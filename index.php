<?php
$year = date('Y');
$month_data = [
    ['month' => 'Jan', 'rate' => 5.2, 'youth' => 6.8],
    ['month' => 'Feb', 'rate' => 5.1, 'youth' => 6.6],
    ['month' => 'Mär', 'rate' => 4.9, 'youth' => 6.4],
    ['month' => 'Apr', 'rate' => 4.8, 'youth' => 6.3],
    ['month' => 'Mai', 'rate' => 4.7, 'youth' => 6.1],
    ['month' => 'Jun', 'rate' => 4.9, 'youth' => 6.2],
    ['month' => 'Jul', 'rate' => 5.0, 'youth' => 6.5],
    ['month' => 'Aug', 'rate' => 5.1, 'youth' => 6.7],
    ['month' => 'Sep', 'rate' => 4.8, 'youth' => 6.3],
    ['month' => 'Okt', 'rate' => 4.7, 'youth' => 6.1],
    ['month' => 'Nov', 'rate' => 4.8, 'youth' => 6.2],
    ['month' => 'Dez', 'rate' => 5.0, 'youth' => 6.4],
];
$months_js    = json_encode(array_column($month_data, 'month'));
$rates_js     = json_encode(array_column($month_data, 'rate'));
$youth_js     = json_encode(array_column($month_data, 'youth'));
?>
<!DOCTYPE html>
<html lang="de">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Arbeitslosigkeit — Wirtschaft Dashboard</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<style>
/* ═══════════════════════════════════════════
   DESIGN TOKENS
═══════════════════════════════════════════ */
:root {
  --bg:       #0b0e12;
  --bg2:      #13171d;
  --bg3:      #1a1f27;
  --bg4:      #222831;
  --border:   #252d38;
  --border2:  #2e3a48;
  --text:     #e8ecf0;
  --text2:    #9ba8b5;
  --text3:    #5c6e7e;
  --gold:     #f0b429;
  --gold2:    rgba(240,180,41,.12);
  --gold3:    rgba(240,180,41,.06);
  --red:      #ef5353;
  --red2:     rgba(239,83,83,.12);
  --green:    #4ade9a;
  --green2:   rgba(74,222,154,.12);
  --blue:     #60a5fa;
  --blue2:    rgba(96,165,250,.12);
  --purple:   #a78bfa;
  --purple2:  rgba(167,139,250,.12);
  --orange:   #fb923c;
  --orange2:  rgba(251,146,60,.12);
  --r4:  4px;
  --r8:  8px;
  --r12: 12px;
  --shadow: 0 4px 24px rgba(0,0,0,.35);
  --nav-h: 64px;
}
*{margin:0;padding:0;box-sizing:border-box}
html{scroll-behavior:smooth}
body{
  background:var(--bg);
  color:var(--text);
  font-family:'Inter',system-ui,sans-serif;
  font-weight:400;
  line-height:1.6;
  overflow-x:hidden;
}

/* ═══════════════════════════════════════════
   SCROLLBAR
═══════════════════════════════════════════ */
::-webkit-scrollbar{width:6px;height:6px}
::-webkit-scrollbar-track{background:var(--bg2)}
::-webkit-scrollbar-thumb{background:var(--border2);border-radius:3px}
::-webkit-scrollbar-thumb:hover{background:var(--text3)}

/* ═══════════════════════════════════════════
   NAVIGATION
═══════════════════════════════════════════ */
.nav{
  position:fixed;top:0;left:0;right:0;z-index:1000;
  height:var(--nav-h);
  background:rgba(11,14,18,.92);
  backdrop-filter:blur(18px) saturate(180%);
  border-bottom:1px solid var(--border);
  display:flex;align-items:center;
  padding:0 2rem;
  gap:2rem;
  transition:box-shadow .3s;
}
.nav.scrolled{box-shadow:0 2px 32px rgba(0,0,0,.5)}

.nav-logo{
  display:flex;align-items:center;gap:.65rem;
  text-decoration:none;flex-shrink:0;
}
.nav-logo-icon{
  width:34px;height:34px;border-radius:8px;
  background:linear-gradient(135deg,var(--gold),#e09010);
  display:flex;align-items:center;justify-content:center;
  font-size:.85rem;font-weight:700;color:#000;letter-spacing:-.03em;
}
.nav-logo-text{font-size:.9rem;font-weight:600;color:var(--text);letter-spacing:-.01em}
.nav-logo-sub{font-size:.65rem;color:var(--text3);letter-spacing:.08em;text-transform:uppercase}

.nav-menu{
  display:flex;align-items:center;gap:.25rem;
  list-style:none;flex:1;
}
.nav-item{position:relative}
.nav-link{
  display:flex;align-items:center;gap:.35rem;
  padding:.5rem .85rem;
  font-size:.82rem;font-weight:500;
  color:var(--text2);
  text-decoration:none;
  border-radius:var(--r8);
  border:1px solid transparent;
  cursor:pointer;
  background:none;
  transition:color .18s,background .18s,border-color .18s;
  white-space:nowrap;
  user-select:none;
}
.nav-link:hover,.nav-link.active{
  color:var(--text);
  background:var(--bg3);
  border-color:var(--border);
}
.nav-link.active{color:var(--gold);border-color:rgba(240,180,41,.2)}
.nav-arrow{
  width:12px;height:12px;
  border-right:1.5px solid currentColor;
  border-bottom:1.5px solid currentColor;
  transform:rotate(45deg) translateY(-2px);
  transition:transform .2s;
  flex-shrink:0;
}
.nav-item.open .nav-arrow{transform:rotate(-135deg) translateY(-2px)}

.nav-dropdown{
  position:absolute;top:calc(100% + 10px);left:0;
  min-width:240px;
  background:var(--bg2);
  border:1px solid var(--border);
  border-radius:var(--r12);
  padding:.5rem;
  box-shadow:var(--shadow);
  opacity:0;visibility:hidden;transform:translateY(-8px);
  transition:opacity .2s,visibility .2s,transform .2s;
  pointer-events:none;
}
.nav-item.open .nav-dropdown{
  opacity:1;visibility:visible;transform:translateY(0);
  pointer-events:all;
}
.nav-dd-item{
  display:flex;align-items:center;gap:.75rem;
  padding:.65rem .85rem;border-radius:var(--r8);
  text-decoration:none;cursor:pointer;
  transition:background .15s;
}
.nav-dd-item:hover{background:var(--bg3)}
.nav-dd-icon{
  width:30px;height:30px;border-radius:var(--r4);
  display:flex;align-items:center;justify-content:center;
  font-size:.75rem;flex-shrink:0;
}
.nav-dd-label{font-size:.82rem;font-weight:500;color:var(--text)}
.nav-dd-desc{font-size:.72rem;color:var(--text3);margin-top:.05rem}
.nav-dd-sep{height:1px;background:var(--border);margin:.4rem 0}

.nav-right{
  display:flex;align-items:center;gap:.75rem;
  margin-left:auto;flex-shrink:0;
}
.nav-badge{
  font-size:.62rem;letter-spacing:.1em;text-transform:uppercase;
  color:var(--gold);background:var(--gold3);
  border:1px solid rgba(240,180,41,.25);
  padding:.25rem .7rem;border-radius:100px;
}
.nav-search{
  display:flex;align-items:center;gap:.5rem;
  background:var(--bg3);border:1px solid var(--border);
  border-radius:var(--r8);padding:.4rem .75rem;
  cursor:pointer;transition:border-color .18s;
}
.nav-search:hover{border-color:var(--border2)}
.nav-search-text{font-size:.75rem;color:var(--text3)}
.nav-search-kbd{
  font-size:.62rem;color:var(--text3);
  background:var(--bg4);border:1px solid var(--border2);
  padding:.05rem .35rem;border-radius:3px;
  font-family:monospace;
}

/* hamburger */
.nav-hamburger{
  display:none;flex-direction:column;gap:5px;
  width:32px;height:32px;justify-content:center;align-items:center;
  background:none;border:none;cursor:pointer;margin-left:auto;
}
.nav-hamburger span{
  display:block;width:20px;height:1.5px;
  background:var(--text2);border-radius:2px;
  transition:transform .25s,opacity .25s;
}

/* ═══════════════════════════════════════════
   MOBILE NAV PANEL
═══════════════════════════════════════════ */
.mobile-nav{
  position:fixed;top:var(--nav-h);left:0;right:0;bottom:0;
  background:var(--bg2);
  border-top:1px solid var(--border);
  z-index:999;
  transform:translateX(-100%);
  transition:transform .3s cubic-bezier(.4,0,.2,1);
  overflow-y:auto;
  padding:1.5rem;
  display:flex;flex-direction:column;gap:.5rem;
}
.mobile-nav.open{transform:translateX(0)}
.mobile-nav-link{
  display:block;padding:.85rem 1rem;
  font-size:.9rem;font-weight:500;color:var(--text2);
  text-decoration:none;border-radius:var(--r8);
  border:1px solid transparent;
  transition:background .15s,color .15s;
}
.mobile-nav-link:hover,.mobile-nav-link.active{
  background:var(--bg3);border-color:var(--border);color:var(--text);
}
.mobile-nav-link.active{color:var(--gold)}

/* ═══════════════════════════════════════════
   HERO / SLIDER
═══════════════════════════════════════════ */
.hero{
  margin-top:var(--nav-h);
  position:relative;overflow:hidden;
  height:520px;
}
.slides{
  display:flex;height:100%;
  transition:transform .7s cubic-bezier(.4,0,.2,1);
}
.slide{
  min-width:100%;height:100%;
  display:flex;align-items:flex-end;
  padding:3rem 4rem;
  position:relative;flex-shrink:0;
}
.slide-bg{
  position:absolute;inset:0;
  background-size:cover;background-position:center;
}
.slide-overlay{
  position:absolute;inset:0;
}
.slide-content{
  position:relative;z-index:2;
  max-width:680px;
}
.slide-eyebrow{
  font-size:.65rem;letter-spacing:.2em;text-transform:uppercase;
  color:rgba(255,255,255,.5);margin-bottom:.75rem;
  display:flex;align-items:center;gap:.5rem;
}
.slide-eyebrow::before{
  content:'';display:block;width:20px;height:1px;
  background:currentColor;
}
.slide-title{
  font-size:clamp(2rem,5vw,3.8rem);
  font-weight:700;line-height:1.05;
  letter-spacing:-.04em;
  color:#fff;margin-bottom:1rem;
}
.slide-title em{font-style:italic;font-weight:300}
.slide-desc{
  font-size:.9rem;color:rgba(255,255,255,.65);
  max-width:480px;line-height:1.75;
  margin-bottom:1.5rem;
}
.slide-tags{display:flex;flex-wrap:wrap;gap:.5rem}
.slide-tag{
  font-size:.68rem;letter-spacing:.06em;
  padding:.3rem .75rem;border-radius:100px;
  background:rgba(255,255,255,.12);
  border:1px solid rgba(255,255,255,.2);
  color:rgba(255,255,255,.8);
}
.slide-tag.accent{
  background:var(--gold2);
  border-color:rgba(240,180,41,.4);
  color:var(--gold);
}

/* slide 1 */
.slide:nth-child(1) .slide-bg{
  background:linear-gradient(135deg,#0d1b2a 0%,#1a2f4a 50%,#0b1e36 100%);
}
.slide:nth-child(1) .slide-overlay{
  background:linear-gradient(to top,rgba(0,0,0,.85) 0%,rgba(0,0,0,.2) 60%,transparent 100%);
}
/* decorative grid pattern */
.slide:nth-child(1) .slide-bg::after{
  content:'';position:absolute;inset:0;
  background-image:
    linear-gradient(rgba(96,165,250,.04) 1px,transparent 1px),
    linear-gradient(90deg,rgba(96,165,250,.04) 1px,transparent 1px);
  background-size:48px 48px;
}
/* slide 2 */
.slide:nth-child(2) .slide-bg{
  background:linear-gradient(135deg,#1a0d0d 0%,#3a1515 50%,#200a0a 100%);
}
.slide:nth-child(2) .slide-overlay{
  background:linear-gradient(to top,rgba(0,0,0,.85) 0%,rgba(0,0,0,.2) 60%,transparent 100%);
}
.slide:nth-child(2) .slide-bg::after{
  content:'';position:absolute;inset:0;
  background:radial-gradient(ellipse at 70% 30%,rgba(239,83,83,.08) 0%,transparent 60%);
}
/* slide 3 */
.slide:nth-child(3) .slide-bg{
  background:linear-gradient(135deg,#0a1a12 0%,#0f2e1e 50%,#071510 100%);
}
.slide:nth-child(3) .slide-overlay{
  background:linear-gradient(to top,rgba(0,0,0,.85) 0%,rgba(0,0,0,.2) 60%,transparent 100%);
}
.slide:nth-child(3) .slide-bg::after{
  content:'';position:absolute;inset:0;
  background:radial-gradient(ellipse at 30% 60%,rgba(74,222,154,.07) 0%,transparent 60%);
}

/* large decorative number */
.slide-number{
  position:absolute;right:3rem;top:50%;transform:translateY(-50%);
  font-size:clamp(6rem,15vw,12rem);
  font-weight:800;letter-spacing:-.06em;
  color:rgba(255,255,255,.03);
  line-height:1;pointer-events:none;
  user-select:none;
}

/* slider controls */
.slider-controls{
  position:absolute;bottom:1.5rem;right:3rem;
  display:flex;align-items:center;gap:.75rem;
  z-index:10;
}
.slider-btn{
  width:36px;height:36px;border-radius:50%;
  background:rgba(255,255,255,.1);
  border:1px solid rgba(255,255,255,.15);
  color:#fff;cursor:pointer;
  display:flex;align-items:center;justify-content:center;
  font-size:.9rem;
  transition:background .18s,border-color .18s;
}
.slider-btn:hover{background:rgba(255,255,255,.2);border-color:rgba(255,255,255,.3)}
.slider-dots{
  display:flex;align-items:center;gap:.4rem;
}
.slider-dot{
  width:6px;height:6px;border-radius:50%;
  background:rgba(255,255,255,.25);
  cursor:pointer;
  transition:background .25s,width .25s;
}
.slider-dot.active{
  width:18px;border-radius:3px;
  background:var(--gold);
}

/* slider progress bar */
.slider-progress{
  position:absolute;bottom:0;left:0;
  height:2px;background:var(--gold);
  transition:width linear;
  z-index:10;
}

/* ═══════════════════════════════════════════
   MAIN LAYOUT
═══════════════════════════════════════════ */
.main{
  max-width:1320px;
  margin:0 auto;
  padding:2.5rem 2rem 4rem;
}

/* section header */
.section-header{
  display:flex;align-items:flex-start;
  justify-content:space-between;
  margin-bottom:1.25rem;
  gap:1rem;flex-wrap:wrap;
}
.section-title{
  font-size:1rem;font-weight:600;
  color:var(--text);letter-spacing:-.02em;
}
.section-sub{
  font-size:.78rem;color:var(--text3);margin-top:.2rem;
}
.section-badge{
  font-size:.62rem;letter-spacing:.1em;text-transform:uppercase;
  color:var(--gold);background:var(--gold3);
  border:1px solid rgba(240,180,41,.2);
  padding:.25rem .7rem;border-radius:100px;
  flex-shrink:0;align-self:flex-start;margin-top:.15rem;
}

/* ═══════════════════════════════════════════
   KPI CARDS ROW
═══════════════════════════════════════════ */
.kpi-grid{
  display:grid;
  grid-template-columns:repeat(4,1fr);
  gap:1rem;
  margin-bottom:2rem;
}
.kpi{
  background:var(--bg2);
  border:1px solid var(--border);
  border-radius:var(--r12);
  padding:1.5rem;
  position:relative;
  overflow:hidden;
  transition:border-color .2s,transform .2s;
  cursor:default;
}
.kpi:hover{border-color:var(--border2);transform:translateY(-2px)}
.kpi::before{
  content:'';position:absolute;
  top:0;left:0;right:0;height:2px;
}
.kpi.k-gold::before{background:linear-gradient(90deg,var(--gold),transparent)}
.kpi.k-red::before{background:linear-gradient(90deg,var(--red),transparent)}
.kpi.k-green::before{background:linear-gradient(90deg,var(--green),transparent)}
.kpi.k-blue::before{background:linear-gradient(90deg,var(--blue),transparent)}
.kpi.k-purple::before{background:linear-gradient(90deg,var(--purple),transparent)}

.kpi-label{
  font-size:.68rem;letter-spacing:.1em;text-transform:uppercase;
  color:var(--text3);margin-bottom:.65rem;
}
.kpi-val{
  font-size:2.4rem;font-weight:700;
  letter-spacing:-.04em;line-height:1;
  margin-bottom:.4rem;
}
.kpi.k-gold  .kpi-val{color:var(--gold)}
.kpi.k-red   .kpi-val{color:var(--red)}
.kpi.k-green .kpi-val{color:var(--green)}
.kpi.k-blue  .kpi-val{color:var(--blue)}
.kpi.k-purple .kpi-val{color:var(--purple)}

.kpi-unit{font-size:1.2rem;font-weight:400;margin-left:.1rem}
.kpi-meta{
  display:flex;align-items:center;gap:.5rem;
  font-size:.75rem;color:var(--text3);margin-top:.5rem;
}
.kpi-delta{
  display:flex;align-items:center;gap:.2rem;
  font-size:.73rem;font-weight:600;
  padding:.15rem .45rem;border-radius:3px;
}
.kpi-delta.up{color:var(--red);background:var(--red2)}
.kpi-delta.dn{color:var(--green);background:var(--green2)}
.kpi-delta.nt{color:var(--text3);background:var(--bg4)}
.kpi-sparkline{
  position:absolute;bottom:0;right:0;
  width:90px;height:40px;opacity:.3;
}

/* ═══════════════════════════════════════════
   DASHBOARD GRID
═══════════════════════════════════════════ */
.dash-grid{
  display:grid;
  grid-template-columns:2fr 1fr;
  gap:1rem;
  margin-bottom:1rem;
}
.dash-grid-3{
  display:grid;
  grid-template-columns:1fr 1fr 1fr;
  gap:1rem;
  margin-bottom:1rem;
}
.card{
  background:var(--bg2);
  border:1px solid var(--border);
  border-radius:var(--r12);
  padding:1.5rem;
  position:relative;
  transition:border-color .2s;
}
.card:hover{border-color:var(--border2)}
.card-header{
  display:flex;align-items:center;justify-content:space-between;
  margin-bottom:1.25rem;
  gap:.75rem;
}
.card-title{
  font-size:.85rem;font-weight:600;color:var(--text);
}
.card-actions{
  display:flex;gap:.4rem;
}
.pill{
  font-size:.65rem;letter-spacing:.06em;
  padding:.22rem .65rem;border-radius:100px;
  cursor:pointer;
}
.pill-gold  {background:var(--gold2);color:var(--gold);border:1px solid rgba(240,180,41,.25)}
.pill-red   {background:var(--red2);color:var(--red);border:1px solid rgba(239,83,83,.25)}
.pill-green {background:var(--green2);color:var(--green);border:1px solid rgba(74,222,154,.25)}
.pill-blue  {background:var(--blue2);color:var(--blue);border:1px solid rgba(96,165,250,.25)}
.pill-purple{background:var(--purple2);color:var(--purple);border:1px solid rgba(167,139,250,.25)}
.pill-muted {background:var(--bg4);color:var(--text3);border:1px solid var(--border)}

/* chart canvas wrapper */
.chart-wrap{position:relative;width:100%}

/* ═══════════════════════════════════════════
   DISTRIBUTION / DONUT
═══════════════════════════════════════════ */
.donut-wrap{
  display:flex;flex-direction:column;align-items:center;
  gap:1rem;
}
.donut-chart{
  position:relative;width:180px;height:180px;
}
.donut-center{
  position:absolute;inset:0;
  display:flex;flex-direction:column;
  align-items:center;justify-content:center;
  text-align:center;pointer-events:none;
}
.donut-center-val{
  font-size:2rem;font-weight:700;
  color:var(--text);letter-spacing:-.04em;
  line-height:1;
}
.donut-center-label{
  font-size:.65rem;letter-spacing:.08em;
  text-transform:uppercase;color:var(--text3);
  margin-top:.25rem;
}
.donut-legend{width:100%;display:grid;gap:.5rem}
.donut-leg-item{
  display:flex;align-items:center;justify-content:space-between;
  font-size:.78rem;
}
.donut-leg-left{display:flex;align-items:center;gap:.5rem;color:var(--text2)}
.donut-leg-dot{
  width:8px;height:8px;border-radius:50%;flex-shrink:0;
}
.donut-leg-pct{
  font-size:.75rem;font-weight:600;color:var(--text);
}

/* ═══════════════════════════════════════════
   TABLE CARD
═══════════════════════════════════════════ */
.data-table{width:100%;border-collapse:collapse;font-size:.81rem}
.data-table th{
  font-size:.65rem;letter-spacing:.12em;text-transform:uppercase;
  color:var(--text3);text-align:left;
  padding:.55rem .75rem;
  border-bottom:1px solid var(--border);
  font-weight:500;
}
.data-table td{
  padding:.7rem .75rem;
  border-bottom:1px solid rgba(37,45,56,.5);
  color:var(--text2);
  vertical-align:middle;
}
.data-table tr:last-child td{border-bottom:none}
.data-table tr:hover td{background:var(--bg3)}
.td-country{
  display:flex;align-items:center;gap:.65rem;
  color:var(--text);font-weight:500;
}
.td-flag{
  width:22px;height:16px;border-radius:2px;
  display:flex;align-items:center;justify-content:center;
  font-size:.65rem;font-weight:600;letter-spacing:0;
  background:var(--bg3);color:var(--text3);
  flex-shrink:0;overflow:hidden;
}
.td-bar{
  display:flex;align-items:center;gap:.65rem;
}
.td-bar-track{
  flex:1;height:4px;border-radius:2px;
  background:var(--bg4);overflow:hidden;
}
.td-bar-fill{height:100%;border-radius:2px}
.td-num{font-variant-numeric:tabular-nums;font-weight:500}
.td-status{
  font-size:.65rem;letter-spacing:.08em;text-transform:uppercase;
  padding:.18rem .5rem;border-radius:3px;white-space:nowrap;
}

/* ═══════════════════════════════════════════
   TYPES MINI-GRID
═══════════════════════════════════════════ */
.types-grid{
  display:grid;
  grid-template-columns:repeat(3,1fr);
  gap:.75rem;
  margin-bottom:1rem;
}
.type-card{
  background:var(--bg2);
  border:1px solid var(--border);
  border-radius:var(--r12);
  padding:1.25rem;
  transition:border-color .2s,transform .2s;
  position:relative;overflow:hidden;
}
.type-card:hover{border-color:var(--border2);transform:translateY(-2px)}
.type-card-top{
  display:flex;align-items:flex-start;justify-content:space-between;
  margin-bottom:.85rem;
}
.type-icon{
  width:38px;height:38px;border-radius:var(--r8);
  display:flex;align-items:center;justify-content:center;
  font-size:1.1rem;flex-shrink:0;
}
.type-card-title{
  font-size:.85rem;font-weight:600;color:var(--text);
  margin-bottom:.35rem;
}
.type-card-desc{font-size:.77rem;color:var(--text3);line-height:1.65}
.type-card-footer{
  margin-top:.9rem;
  display:flex;align-items:center;justify-content:space-between;
}
.type-pct{
  font-size:1.5rem;font-weight:700;letter-spacing:-.04em;
  line-height:1;
}

/* ═══════════════════════════════════════════
   MEASURES / AKTIV-PASSIV
═══════════════════════════════════════════ */
.measures-grid{
  display:grid;grid-template-columns:1fr 1fr;
  gap:.75rem;
}
.measure-col-header{
  font-size:.68rem;letter-spacing:.12em;text-transform:uppercase;
  padding-bottom:.65rem;margin-bottom:.75rem;
  border-bottom:1px solid var(--border);
  font-weight:600;
}
.measure-item{
  display:flex;align-items:flex-start;gap:.65rem;
  padding:.6rem .75rem;
  background:var(--bg3);border:1px solid var(--border);
  border-radius:var(--r8);margin-bottom:.45rem;
  font-size:.8rem;color:var(--text2);
  transition:background .15s;
}
.measure-item:hover{background:var(--bg4)}
.measure-item:last-child{margin-bottom:0}
.measure-dot{
  width:6px;height:6px;border-radius:50%;
  flex-shrink:0;margin-top:.42rem;
}

/* ═══════════════════════════════════════════
   CALLOUT / QUOTE
═══════════════════════════════════════════ */
.callout{
  border-left:3px solid var(--gold);
  background:var(--gold3);
  border-radius:0 var(--r8) var(--r8) 0;
  padding:1rem 1.25rem;
  margin:1.25rem 0 0;
}
.callout-label{
  font-size:.62rem;letter-spacing:.14em;text-transform:uppercase;
  color:var(--gold);font-weight:600;margin-bottom:.35rem;
}
.callout-text{font-size:.83rem;color:var(--text2);line-height:1.75;font-style:italic}
.callout.c-red{border-left-color:var(--red);background:var(--red2)}
.callout.c-red .callout-label{color:var(--red)}
.callout.c-green{border-left-color:var(--green);background:var(--green2)}
.callout.c-green .callout-label{color:var(--green)}

/* ═══════════════════════════════════════════
   FOOTER
═══════════════════════════════════════════ */
.footer{
  border-top:1px solid var(--border);
  padding:1.75rem 2rem;
  max-width:1320px;margin:0 auto;
  display:flex;align-items:center;justify-content:space-between;
  flex-wrap:wrap;gap:.75rem;
}
.footer-left{display:flex;align-items:center;gap:1.5rem;flex-wrap:wrap}
.footer-copy{font-size:.72rem;color:var(--text3)}
.footer-links{display:flex;gap:1rem}
.footer-link{
  font-size:.72rem;color:var(--text3);text-decoration:none;
  transition:color .15s;
}
.footer-link:hover{color:var(--text2)}
.footer-right{font-size:.68rem;color:var(--text3);letter-spacing:.06em}

/* ═══════════════════════════════════════════
   RESPONSIVE
═══════════════════════════════════════════ */
@media(max-width:1100px){
  .kpi-grid{grid-template-columns:repeat(2,1fr)}
  .dash-grid{grid-template-columns:1fr}
  .dash-grid-3{grid-template-columns:1fr 1fr}
  .types-grid{grid-template-columns:repeat(2,1fr)}
}
@media(max-width:760px){
  .nav-menu,.nav-right .nav-search,.nav-right .nav-badge{display:none}
  .nav-hamburger{display:flex}
  .hero{height:420px}
  .slide{padding:2rem 1.5rem}
  .slide-number{display:none}
  .slider-controls{right:1.5rem}
  .main{padding:1.5rem 1rem 3rem}
  .kpi-grid{grid-template-columns:1fr 1fr}
  .dash-grid,.dash-grid-3,.types-grid{grid-template-columns:1fr}
  .measures-grid{grid-template-columns:1fr}
  .footer{padding:1.25rem 1rem}
}
@media(max-width:460px){
  .kpi-grid{grid-template-columns:1fr}
  .slide-title{font-size:1.75rem}
}

/* ═══════════════════════════════════════════
   ANIMATIONS
═══════════════════════════════════════════ */
@keyframes fadeUp{
  from{opacity:0;transform:translateY(16px)}
  to{opacity:1;transform:translateY(0)}
}
.fade-up{animation:fadeUp .4s ease both}
.fade-up-d1{animation-delay:.05s}
.fade-up-d2{animation-delay:.1s}
.fade-up-d3{animation-delay:.15s}
.fade-up-d4{animation-delay:.2s}
.fade-up-d5{animation-delay:.25s}
</style>
</head>
<body>

<!-- ═══════════════════════════════════════════
     NAVIGATION
═══════════════════════════════════════════ -->
<nav class="nav" id="mainNav">
  <a href="#" class="nav-logo">
    <div class="nav-logo-icon">A</div>
    <div>
      <div class="nav-logo-text">Arbeit.Info</div>
      <div class="nav-logo-sub">Wirtschaft · Kapitel 04</div>
    </div>
  </a>

  <ul class="nav-menu">
    <li class="nav-item">
      <a class="nav-link active" href="#dashboard">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
        Dashboard
      </a>
    </li>
    <li class="nav-item" id="drop-arten">
      <button class="nav-link" onclick="toggleDrop('drop-arten')">
        Arten
        <span class="nav-arrow"></span>
      </button>
      <div class="nav-dropdown">
        <a href="#arten" class="nav-dd-item" onclick="closeDrop('drop-arten')">
          <div class="nav-dd-icon" style="background:var(--red2);color:var(--red)">K</div>
          <div><div class="nav-dd-label">Konjunkturelle</div><div class="nav-dd-desc">Abschwung &amp; Aufschwung</div></div>
        </a>
        <a href="#arten" class="nav-dd-item" onclick="closeDrop('drop-arten')">
          <div class="nav-dd-icon" style="background:var(--blue2);color:var(--blue)">S</div>
          <div><div class="nav-dd-label">Strukturelle</div><div class="nav-dd-desc">Langfristiger Wandel</div></div>
        </a>
        <a href="#arten" class="nav-dd-item" onclick="closeDrop('drop-arten')">
          <div class="nav-dd-icon" style="background:var(--green2);color:var(--green)">F</div>
          <div><div class="nav-dd-label">Friktionelle</div><div class="nav-dd-desc">Jobwechsel-Phase</div></div>
        </a>
        <div class="nav-dd-sep"></div>
        <a href="#arten" class="nav-dd-item" onclick="closeDrop('drop-arten')">
          <div class="nav-dd-icon" style="background:var(--purple2);color:var(--purple)">T</div>
          <div><div class="nav-dd-label">Technologische</div><div class="nav-dd-desc">Automatisierung</div></div>
        </a>
      </div>
    </li>
    <li class="nav-item" id="drop-mass">
      <button class="nav-link" onclick="toggleDrop('drop-mass')">
        Maßnahmen
        <span class="nav-arrow"></span>
      </button>
      <div class="nav-dropdown">
        <a href="#massnahmen" class="nav-dd-item" onclick="closeDrop('drop-mass')">
          <div class="nav-dd-icon" style="background:var(--green2);color:var(--green)">A</div>
          <div><div class="nav-dd-label">Aktive Maßnahmen</div><div class="nav-dd-desc">Weiterbildung, Vermittlung</div></div>
        </a>
        <a href="#massnahmen" class="nav-dd-item" onclick="closeDrop('drop-mass')">
          <div class="nav-dd-icon" style="background:var(--red2);color:var(--red)">P</div>
          <div><div class="nav-dd-label">Passive Maßnahmen</div><div class="nav-dd-desc">ALG I, Bürgergeld</div></div>
        </a>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#international">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
        International
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#jugend">Jugend</a>
    </li>
  </ul>

  <div class="nav-right">
    <div class="nav-search">
      <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
      <span class="nav-search-text">Suchen…</span>
      <span class="nav-search-kbd">⌘K</span>
    </div>
    <span class="nav-badge">Kapitel 04</span>
  </div>

  <button class="nav-hamburger" id="hamburger" onclick="toggleMobileNav()" aria-label="Menü">
    <span></span><span></span><span></span>
  </button>
</nav>

<!-- ═══════════════════════════════════════════
     MOBILE NAV
═══════════════════════════════════════════ -->
<div class="mobile-nav" id="mobileNav">
  <a class="mobile-nav-link active" href="#dashboard" onclick="closeMobileNav()">Dashboard</a>
  <a class="mobile-nav-link" href="#arten" onclick="closeMobileNav()">Arten der Arbeitslosigkeit</a>
  <a class="mobile-nav-link" href="#massnahmen" onclick="closeMobileNav()">Maßnahmen</a>
  <a class="mobile-nav-link" href="#international" onclick="closeMobileNav()">Internationaler Vergleich</a>
  <a class="mobile-nav-link" href="#jugend" onclick="closeMobileNav()">Jugendarbeitslosigkeit</a>
</div>

<!-- ═══════════════════════════════════════════
     HERO SLIDER
═══════════════════════════════════════════ -->
<section class="hero" id="slider">
  <div class="slides" id="slides">

    <!-- Slide 1 -->
    <div class="slide">
      <div class="slide-bg"></div>
      <div class="slide-overlay"></div>
      <div class="slide-number">01</div>
      <div class="slide-content">
        <p class="slide-eyebrow">Wirtschaft · Kapitel 04</p>
        <h1 class="slide-title">Arbeits<em>losig</em>keit<br>verstehen</h1>
        <p class="slide-desc">Definition, Messung und die verschiedenen Formen — von konjunkturell bis strukturell. Ein vollständiger Überblick.</p>
        <div class="slide-tags">
          <span class="slide-tag accent">4,8 % Arbeitslosenquote</span>
          <span class="slide-tag">2,7 Mio. Betroffene</span>
          <span class="slide-tag">6 Arten</span>
        </div>
      </div>
    </div>

    <!-- Slide 2 -->
    <div class="slide">
      <div class="slide-bg"></div>
      <div class="slide-overlay"></div>
      <div class="slide-number">02</div>
      <div class="slide-content">
        <p class="slide-eyebrow">Verzerrung · Messprobleme</p>
        <h1 class="slide-title">Die <em>stille</em><br>Reserve</h1>
        <p class="slide-desc">Offizielle Statistiken unterschätzen das wahre Ausmaß. Millionen tauchen gar nicht auf — Stille Reserve, Maßnahmenteilnehmer, Kurzarbeiter.</p>
        <div class="slide-tags">
          <span class="slide-tag accent">Untererfassung ~+30 %</span>
          <span class="slide-tag">Stille Reserve</span>
          <span class="slide-tag">Schwarzarbeit</span>
        </div>
      </div>
    </div>

    <!-- Slide 3 -->
    <div class="slide">
      <div class="slide-bg"></div>
      <div class="slide-overlay"></div>
      <div class="slide-number">03</div>
      <div class="slide-content">
        <p class="slide-eyebrow">Politik · Bekämpfung</p>
        <h1 class="slide-title"><em>Aktiv</em> oder<br>Passiv?</h1>
        <p class="slide-desc">Weiterbildung und Vermittlung vs. Einkommenssicherung — staatliche Instrumente und ihre Wirksamkeit im Vergleich.</p>
        <div class="slide-tags">
          <span class="slide-tag accent">ALG I · Bürgergeld</span>
          <span class="slide-tag">Qualifizierungsoffensive</span>
          <span class="slide-tag">Kurzarbeitergeld</span>
        </div>
      </div>
    </div>

  </div><!-- /slides -->

  <div class="slider-progress" id="sliderProgress"></div>

  <div class="slider-controls">
    <div class="slider-dots" id="sliderDots">
      <button class="slider-dot active" onclick="goSlide(0)" aria-label="Folie 1"></button>
      <button class="slider-dot" onclick="goSlide(1)" aria-label="Folie 2"></button>
      <button class="slider-dot" onclick="goSlide(2)" aria-label="Folie 3"></button>
    </div>
    <button class="slider-btn" onclick="prevSlide()" aria-label="Zurück">&#8592;</button>
    <button class="slider-btn" onclick="nextSlide()" aria-label="Weiter">&#8594;</button>
  </div>
</section>

<!-- ═══════════════════════════════════════════
     DASHBOARD
═══════════════════════════════════════════ -->
<main class="main" id="dashboard">

  <!-- KPI strip -->
  <div class="section-header fade-up">
    <div>
      <div class="section-title">Aktuelle Kennzahlen</div>
      <div class="section-sub">Deutschland · <?= $year ?> · Bundesagentur für Arbeit</div>
    </div>
    <span class="section-badge">Live-Daten</span>
  </div>

  <div class="kpi-grid">
    <div class="kpi k-gold fade-up fade-up-d1">
      <div class="kpi-label">Arbeitslosenquote</div>
      <div class="kpi-val">4<span class="kpi-unit">,8 %</span></div>
      <div class="kpi-meta">
        <span class="kpi-delta up">▲ +0,1</span>
        <span>ggü. Vormonat</span>
      </div>
      <svg class="kpi-sparkline" viewBox="0 0 90 40" preserveAspectRatio="none">
        <polyline points="0,30 15,28 30,32 45,25 60,22 75,26 90,24" fill="none" stroke="var(--gold)" stroke-width="1.5"/>
      </svg>
    </div>
    <div class="kpi k-red fade-up fade-up-d2">
      <div class="kpi-label">Arbeitslose (Mio.)</div>
      <div class="kpi-val">2<span class="kpi-unit">,71 M</span></div>
      <div class="kpi-meta">
        <span class="kpi-delta up">▲ +42k</span>
        <span>ggü. Vorjahr</span>
      </div>
      <svg class="kpi-sparkline" viewBox="0 0 90 40" preserveAspectRatio="none">
        <polyline points="0,35 15,32 30,30 45,28 60,26 75,29 90,27" fill="none" stroke="var(--red)" stroke-width="1.5"/>
      </svg>
    </div>
    <div class="kpi k-green fade-up fade-up-d3">
      <div class="kpi-label">Offene Stellen (Mio.)</div>
      <div class="kpi-val">0<span class="kpi-unit">,69 M</span></div>
      <div class="kpi-meta">
        <span class="kpi-delta dn">▼ −18k</span>
        <span>ggü. Vorjahr</span>
      </div>
      <svg class="kpi-sparkline" viewBox="0 0 90 40" preserveAspectRatio="none">
        <polyline points="0,10 15,12 30,15 45,18 60,22 75,26 90,28" fill="none" stroke="var(--green)" stroke-width="1.5"/>
      </svg>
    </div>
    <div class="kpi k-blue fade-up fade-up-d4">
      <div class="kpi-label">Jugendarbeitslosigkeit</div>
      <div class="kpi-val">6<span class="kpi-unit">,3 %</span></div>
      <div class="kpi-meta">
        <span class="kpi-delta nt">→ 0,0</span>
        <span>stabil</span>
      </div>
      <svg class="kpi-sparkline" viewBox="0 0 90 40" preserveAspectRatio="none">
        <polyline points="0,20 15,22 30,18 45,24 60,20 75,22 90,21" fill="none" stroke="var(--blue)" stroke-width="1.5"/>
      </svg>
    </div>
  </div>

  <!-- Line chart + Donut -->
  <div class="dash-grid fade-up fade-up-d2">
    <!-- Line chart -->
    <div class="card">
      <div class="card-header">
        <div class="card-title">Jahresverlauf der Arbeitslosenquote</div>
        <div class="card-actions">
          <span class="pill pill-gold">12 M.</span>
          <span class="pill pill-muted">Quartal</span>
        </div>
      </div>
      <div class="chart-wrap" style="height:260px">
        <canvas id="lineChart"></canvas>
      </div>
    </div>
    <!-- Donut -->
    <div class="card">
      <div class="card-header">
        <div class="card-title">Arten der Arbeitslosigkeit</div>
      </div>
      <div class="donut-wrap">
        <div class="donut-chart">
          <canvas id="donutChart"></canvas>
          <div class="donut-center">
            <div class="donut-center-val">2,71<span style="font-size:1rem">M</span></div>
            <div class="donut-center-label">Gesamt</div>
          </div>
        </div>
        <div class="donut-legend">
          <div class="donut-leg-item"><div class="donut-leg-left"><div class="donut-leg-dot" style="background:#ef5353"></div>Konjunkturell</div><div class="donut-leg-pct">34 %</div></div>
          <div class="donut-leg-item"><div class="donut-leg-left"><div class="donut-leg-dot" style="background:#60a5fa"></div>Strukturell</div><div class="donut-leg-pct">28 %</div></div>
          <div class="donut-leg-item"><div class="donut-leg-left"><div class="donut-leg-dot" style="background:#f0b429"></div>Friktionell</div><div class="donut-leg-pct">18 %</div></div>
          <div class="donut-leg-item"><div class="donut-leg-left"><div class="donut-leg-dot" style="background:#a78bfa"></div>Technologisch</div><div class="donut-leg-pct">12 %</div></div>
          <div class="donut-leg-item"><div class="donut-leg-left"><div class="donut-leg-dot" style="background:#4ade9a"></div>Saisonal</div><div class="donut-leg-pct">8 %</div></div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bar chart -->
  <div class="card fade-up" style="margin-bottom:1rem">
    <div class="card-header">
      <div class="card-title">Vergleich: Allgemeine vs. Jugendarbeitslosigkeit</div>
      <div class="card-actions">
        <span class="pill pill-gold">Gesamt</span>
        <span class="pill pill-blue">Jugend</span>
      </div>
    </div>
    <div class="chart-wrap" style="height:220px">
      <canvas id="barChart"></canvas>
    </div>
  </div>

  <!-- ─── ARTEN ─── -->
  <div class="section-header fade-up" id="arten" style="margin-top:2rem">
    <div>
      <div class="section-title">Arten der Arbeitslosigkeit</div>
      <div class="section-sub">Sechs Hauptkategorien im Überblick</div>
    </div>
    <span class="section-badge">Kapitel 04.1</span>
  </div>

  <div class="types-grid fade-up fade-up-d1">
    <div class="type-card">
      <div class="type-card-top">
        <div class="type-icon" style="background:var(--red2);color:var(--red)">&#8681;</div>
        <span class="pill pill-red">Temporär</span>
      </div>
      <div class="type-card-title">Konjunkturelle</div>
      <div class="type-card-desc">Entsteht in Wirtschaftsabschwüngen durch sinkende Nachfrage. Kehrt mit dem Aufschwung meist zurück.</div>
      <div class="type-card-footer">
        <div class="type-pct" style="color:var(--red)">34<small style="font-size:.9rem">%</small></div>
        <span class="pill pill-red">~920k Betroffene</span>
      </div>
    </div>
    <div class="type-card">
      <div class="type-card-top">
        <div class="type-icon" style="background:var(--blue2);color:var(--blue)">&#9112;</div>
        <span class="pill pill-blue">Langfristig</span>
      </div>
      <div class="type-card-title">Strukturelle</div>
      <div class="type-card-desc">Dauerhafter Wandel (Digitalisierung, Deindustrialisierung). Erfordert Umschulung und Mobilität.</div>
      <div class="type-card-footer">
        <div class="type-pct" style="color:var(--blue)">28<small style="font-size:.9rem">%</small></div>
        <span class="pill pill-blue">~759k Betroffene</span>
      </div>
    </div>
    <div class="type-card">
      <div class="type-card-top">
        <div class="type-icon" style="background:var(--gold2);color:var(--gold)">&#8652;</div>
        <span class="pill pill-gold">Normal</span>
      </div>
      <div class="type-card-title">Friktionelle</div>
      <div class="type-card-desc">Kurzfristiger Übergang zwischen zwei Arbeitsstellen. Unvermeidlich in einer freien Marktwirtschaft.</div>
      <div class="type-card-footer">
        <div class="type-pct" style="color:var(--gold)">18<small style="font-size:.9rem">%</small></div>
        <span class="pill pill-gold">~488k Betroffene</span>
      </div>
    </div>
    <div class="type-card">
      <div class="type-card-top">
        <div class="type-icon" style="background:var(--purple2);color:var(--purple)">&#9881;</div>
        <span class="pill pill-purple">Wachsend</span>
      </div>
      <div class="type-card-title">Technologische</div>
      <div class="type-card-desc">Automatisierung und Robotik ersetzen Arbeitskräfte. Unterform der Strukturarbeitslosigkeit.</div>
      <div class="type-card-footer">
        <div class="type-pct" style="color:var(--purple)">12<small style="font-size:.9rem">%</small></div>
        <span class="pill pill-purple">~325k Betroffene</span>
      </div>
    </div>
    <div class="type-card">
      <div class="type-card-top">
        <div class="type-icon" style="background:var(--green2);color:var(--green)">&#9400;</div>
        <span class="pill pill-green">Saisonal</span>
      </div>
      <div class="type-card-title">Saisonale</div>
      <div class="type-card-desc">Wiederkehrend durch Jahreszeiten (Bau, Tourismus, Landwirtschaft). Vorhersehbar und befristet.</div>
      <div class="type-card-footer">
        <div class="type-pct" style="color:var(--green)">8<small style="font-size:.9rem">%</small></div>
        <span class="pill pill-green">~217k Betroffene</span>
      </div>
    </div>
    <div class="type-card">
      <div class="type-card-top">
        <div class="type-icon" style="background:var(--orange2);color:var(--orange)">&#9656;</div>
        <span class="pill pill-muted">Persistent</span>
      </div>
      <div class="type-card-title">Sockelarbeitslosigkeit</div>
      <div class="type-card-desc">Verbleibt selbst im Konjunkturhoch. Schwer vermittelbare Personen mit multiplen Vermittlungshemmnissen.</div>
      <div class="type-card-footer">
        <div class="type-pct" style="color:var(--orange)">— </div>
        <span class="pill pill-muted">Sockelbasis</span>
      </div>
    </div>
  </div>

  <!-- Callout -->
  <div class="callout c-red fade-up" style="margin-bottom:2rem">
    <div class="callout-label">Merksatz · Verzerrung</div>
    <div class="callout-text">Die offizielle Arbeitslosenquote unterschätzt das wahre Ausmaß systematisch: Stille Reserve, Maßnahmeteilnehmer und Kurzarbeiter erscheinen nicht in der Statistik. Die tatsächliche Sockelarbeitslosigkeit liegt regelmäßig 25–35 % über den Meldezahlen.</div>
  </div>

  <!-- ─── INTERNATIONAL ─── -->
  <div class="section-header fade-up" id="international">
    <div>
      <div class="section-title">Internationaler Vergleich</div>
      <div class="section-sub">EU-Staaten · Arbeitslosenquoten (Ø <?= $year ?>)</div>
    </div>
    <span class="section-badge">EUROSTAT</span>
  </div>

  <div class="card fade-up" style="margin-bottom:2rem">
    <table class="data-table">
      <thead>
        <tr>
          <th>Land</th>
          <th>Quote (%)</th>
          <th>Anteil</th>
          <th>Trend</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $countries = [
          ['DE','Deutschland',4.8,'dn','Stabil'],
          ['AT','Österreich',5.1,'nt','Stabil'],
          ['NL','Niederlande',3.7,'dn','Gut'],
          ['PL','Polen',2.9,'dn','Sehr gut'],
          ['FR','Frankreich',7.3,'nt','Erhöht'],
          ['ES','Spanien',11.2,'up','Kritisch'],
          ['IT','Italien',6.7,'dn','Erhöht'],
          ['GR','Griechenland',10.1,'nt','Kritisch'],
          ['SE','Schweden',8.4,'up','Erhöht'],
          ['DK','Dänemark',4.9,'nt','Stabil'],
        ];
        $max_rate = 12;
        $status_styles = [
          'Gut'       => 'background:var(--green2);color:var(--green)',
          'Sehr gut'  => 'background:var(--green2);color:var(--green)',
          'Stabil'    => 'background:var(--gold2);color:var(--gold)',
          'Erhöht'    => 'background:var(--orange2);color:var(--orange)',
          'Kritisch'  => 'background:var(--red2);color:var(--red)',
        ];
        $trend_icons = ['up'=>'▲','dn'=>'▼','nt'=>'→'];
        $trend_colors = ['up'=>'var(--red)','dn'=>'var(--green)','nt'=>'var(--text3)'];
        foreach($countries as $c):
          [$code,$name,$rate,$trend,$status] = $c;
          $pct = round($rate/$max_rate*100);
          $bar_color = $rate < 5 ? 'var(--green)' : ($rate < 8 ? 'var(--gold)' : 'var(--red)');
        ?>
        <tr>
          <td>
            <div class="td-country">
              <div class="td-flag"><?= $code ?></div>
              <?= htmlspecialchars($name) ?>
            </div>
          </td>
          <td class="td-num"><?= number_format($rate,1,',','.') ?> %</td>
          <td>
            <div class="td-bar">
              <div class="td-bar-track">
                <div class="td-bar-fill" style="width:<?= $pct ?>%;background:<?= $bar_color ?>"></div>
              </div>
            </div>
          </td>
          <td style="color:<?= $trend_colors[$trend] ?>;font-weight:600"><?= $trend_icons[$trend] ?></td>
          <td><span class="td-status" style="<?= $status_styles[$status] ?>"><?= $status ?></span></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <!-- ─── MASSNAHMEN ─── -->
  <div class="section-header fade-up" id="massnahmen">
    <div>
      <div class="section-title">Maßnahmen zur Bekämpfung</div>
      <div class="section-sub">Aktive vs. passive staatliche Instrumente</div>
    </div>
    <span class="section-badge">Kapitel 04.2</span>
  </div>

  <div class="dash-grid-3 fade-up" id="jugend">
    <div class="card" style="grid-column:span 2">
      <div class="card-header">
        <div class="card-title">Aktiv vs. Passiv — Überblick</div>
      </div>
      <div class="measures-grid">
        <div>
          <div class="measure-col-header" style="color:var(--green)">Aktive Maßnahmen</div>
          <?php
          $aktiv = [
            'Aus- und Weiterbildungsförderung',
            'Arbeitsvermittlung (Agentur für Arbeit)',
            'Eingliederungszuschüsse für Arbeitgeber',
            'Arbeitsbeschaffungsmaßnahmen (ABM)',
            'Gründungszuschuss (Selbstständigkeit)',
            'Lohnkostenzuschüsse & Prämien',
          ];
          foreach($aktiv as $m):?>
          <div class="measure-item">
            <div class="measure-dot" style="background:var(--green)"></div>
            <?= htmlspecialchars($m) ?>
          </div>
          <?php endforeach; ?>
        </div>
        <div>
          <div class="measure-col-header" style="color:var(--red)">Passive Maßnahmen</div>
          <?php
          $passiv = [
            'Arbeitslosengeld I (ALG I) — beitragsfinanziert',
            'Bürgergeld (ehem. Hartz IV) — steuerfinanziert',
            'Kurzarbeitergeld — Beschäftigungssicherung',
            'Insolvenzgeld bei Arbeitgeberpleite',
          ];
          foreach($passiv as $m):?>
          <div class="measure-item">
            <div class="measure-dot" style="background:var(--red)"></div>
            <?= htmlspecialchars($m) ?>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
      <div class="callout">
        <div class="callout-label">Merksatz</div>
        <div class="callout-text">Aktive Maßnahmen bekämpfen die Ursache und fördern Wiedereingliederung. Passive Maßnahmen sichern das Einkommen — lösen das Grundproblem aber nicht.</div>
      </div>
    </div>
    <div class="card">
      <div class="card-header">
        <div class="card-title">Jugend · Quote</div>
      </div>
      <div style="text-align:center;padding:1rem 0">
        <div style="font-size:4rem;font-weight:800;color:var(--blue);letter-spacing:-.06em;line-height:1">6,3<span style="font-size:2rem;font-weight:400">%</span></div>
        <div style="font-size:.75rem;color:var(--text3);margin:.5rem 0 1.5rem;text-transform:uppercase;letter-spacing:.1em">unter 25 Jahren</div>
        <div class="chart-wrap" style="height:140px">
          <canvas id="youthGauge"></canvas>
        </div>
        <div class="callout c-green" style="margin-top:1rem;text-align:left">
          <div class="callout-label">Maßnahmen</div>
          <div class="callout-text">Berufsausbildungsbeihilfe, Azubi-Prämien, BaE — Berufsausbildung in außerbetrieblichen Einrichtungen, Jugendberufshilfe.</div>
        </div>
      </div>
    </div>
  </div>

</main>

<!-- ═══════════════════════════════════════════
     FOOTER
═══════════════════════════════════════════ -->
<footer class="footer">
  <div class="footer-left">
    <span class="footer-copy">&copy; <?= $year ?> Arbeit.Info — Wirtschaft Kapitel 04</span>
    <div class="footer-links">
      <a href="#" class="footer-link">Impressum</a>
      <a href="#" class="footer-link">Datenschutz</a>
      <a href="#" class="footer-link">Quellen</a>
    </div>
  </div>
  <span class="footer-right">Daten: Bundesagentur für Arbeit · EUROSTAT</span>
</footer>

<!-- ═══════════════════════════════════════════
     JAVASCRIPT
═══════════════════════════════════════════ -->
<script>
/* ── NAV ── */
const mainNav = document.getElementById('mainNav');
window.addEventListener('scroll',()=>{
  mainNav.classList.toggle('scrolled', window.scrollY > 20);
});

function toggleDrop(id){
  document.querySelectorAll('.nav-item').forEach(el=>{
    if(el.id !== id) el.classList.remove('open');
  });
  document.getElementById(id)?.classList.toggle('open');
}
function closeDrop(id){
  document.getElementById(id)?.classList.remove('open');
}
document.addEventListener('click',e=>{
  if(!e.target.closest('.nav-item')) {
    document.querySelectorAll('.nav-item').forEach(el=>el.classList.remove('open'));
  }
});

/* mobile nav */
const mobileNav = document.getElementById('mobileNav');
const hamburger  = document.getElementById('hamburger');
let mobileOpen = false;
function toggleMobileNav(){
  mobileOpen = !mobileOpen;
  mobileNav.classList.toggle('open', mobileOpen);
  document.body.style.overflow = mobileOpen ? 'hidden' : '';
  const [a,b,c] = hamburger.querySelectorAll('span');
  a.style.transform = mobileOpen ? 'translateY(6.5px) rotate(45deg)' : '';
  b.style.opacity   = mobileOpen ? '0' : '';
  c.style.transform = mobileOpen ? 'translateY(-6.5px) rotate(-45deg)' : '';
}
function closeMobileNav(){
  if(mobileOpen) toggleMobileNav();
}

/* ── SLIDER ── */
let current = 0;
const total = 3;
const INTERVAL = 6000;
const slides     = document.getElementById('slides');
const dots       = document.querySelectorAll('.slider-dot');
const progressEl = document.getElementById('sliderProgress');
let timer, progressStart, progressRaf;

function goSlide(n){
  current = ((n % total) + total) % total;
  slides.style.transform = `translateX(-${current * 100}%)`;
  dots.forEach((d,i)=> d.classList.toggle('active', i===current));
  resetTimer();
}
function nextSlide(){ goSlide(current+1) }
function prevSlide(){ goSlide(current-1) }

function startProgress(){
  cancelAnimationFrame(progressRaf);
  progressEl.style.transition = 'none';
  progressEl.style.width = '0%';
  progressStart = performance.now();

  function step(now){
    const elapsed = now - progressStart;
    const pct = Math.min((elapsed / INTERVAL) * 100, 100);
    progressEl.style.width = pct + '%';
    if(pct < 100){
      progressRaf = requestAnimationFrame(step);
    }
  }
  requestAnimationFrame(step);
}

function resetTimer(){
  clearInterval(timer);
  startProgress();
  timer = setInterval(()=>{ goSlide(current+1); }, INTERVAL);
}
resetTimer();

/* keyboard nav */
document.addEventListener('keydown',e=>{
  if(e.key==='ArrowRight') nextSlide();
  if(e.key==='ArrowLeft')  prevSlide();
});

/* ── CHARTS ── */
Chart.defaults.color = '#5c6e7e';
Chart.defaults.font.family = "'Inter', system-ui, sans-serif";
Chart.defaults.font.size   = 11;

const months = <?= $months_js ?>;
const rates  = <?= $rates_js ?>;
const youth  = <?= $youth_js ?>;

/* Line chart */
new Chart(document.getElementById('lineChart'), {
  type: 'line',
  data: {
    labels: months,
    datasets: [
      {
        label: 'Arbeitslosenquote',
        data: rates,
        borderColor: '#f0b429',
        backgroundColor: 'rgba(240,180,41,.08)',
        borderWidth: 2,
        pointRadius: 3,
        pointHoverRadius: 5,
        pointBackgroundColor: '#f0b429',
        fill: true,
        tension: .4,
      },
    ]
  },
  options: {
    responsive: true, maintainAspectRatio: false,
    interaction: { intersect: false, mode: 'index' },
    plugins: {
      legend: { display: false },
      tooltip: {
        backgroundColor: '#1a1f27',
        borderColor: '#252d38',
        borderWidth: 1,
        padding: 10,
        callbacks: {
          label: ctx => ` ${ctx.dataset.label}: ${ctx.parsed.y.toFixed(1)} %`
        }
      }
    },
    scales: {
      x: { grid: { color: 'rgba(37,45,56,.5)' }, border: { display: false } },
      y: {
        grid: { color: 'rgba(37,45,56,.5)' },
        border: { display: false },
        ticks: { callback: v => v + ' %' },
        min: 4, max: 6,
      }
    }
  }
});

/* Donut */
new Chart(document.getElementById('donutChart'), {
  type: 'doughnut',
  data: {
    labels: ['Konjunkturell','Strukturell','Friktionell','Technologisch','Saisonal'],
    datasets: [{
      data: [34, 28, 18, 12, 8],
      backgroundColor: ['#ef5353','#60a5fa','#f0b429','#a78bfa','#4ade9a'],
      borderColor: '#13171d',
      borderWidth: 3,
      hoverOffset: 6,
    }]
  },
  options: {
    responsive: true, maintainAspectRatio: false,
    cutout: '72%',
    plugins: {
      legend: { display: false },
      tooltip: {
        backgroundColor: '#1a1f27',
        borderColor: '#252d38',
        borderWidth: 1,
        padding: 10,
        callbacks: {
          label: ctx => ` ${ctx.label}: ${ctx.parsed} %`
        }
      }
    }
  }
});

/* Bar chart */
new Chart(document.getElementById('barChart'), {
  type: 'bar',
  data: {
    labels: months,
    datasets: [
      {
        label: 'Allgemein',
        data: rates,
        backgroundColor: 'rgba(240,180,41,.7)',
        borderColor: '#f0b429',
        borderWidth: 1,
        borderRadius: 3,
      },
      {
        label: 'Jugend (< 25)',
        data: youth,
        backgroundColor: 'rgba(96,165,250,.5)',
        borderColor: '#60a5fa',
        borderWidth: 1,
        borderRadius: 3,
      }
    ]
  },
  options: {
    responsive: true, maintainAspectRatio: false,
    interaction: { intersect: false, mode: 'index' },
    plugins: {
      legend: {
        display: true,
        labels: { color: '#9ba8b5', boxWidth: 12, boxHeight: 12 }
      },
      tooltip: {
        backgroundColor: '#1a1f27',
        borderColor: '#252d38',
        borderWidth: 1,
        padding: 10,
        callbacks: {
          label: ctx => ` ${ctx.dataset.label}: ${ctx.parsed.y.toFixed(1)} %`
        }
      }
    },
    scales: {
      x: { grid: { display: false }, border: { display: false } },
      y: {
        grid: { color: 'rgba(37,45,56,.5)' },
        border: { display: false },
        ticks: { callback: v => v + ' %' },
        min: 0, max: 9,
      }
    }
  }
});

/* Youth gauge (doughnut style) */
new Chart(document.getElementById('youthGauge'), {
  type: 'doughnut',
  data: {
    datasets: [{
      data: [6.3, 93.7],
      backgroundColor: ['#60a5fa', 'rgba(96,165,250,.08)'],
      borderColor: ['#60a5fa', 'rgba(96,165,250,.08)'],
      borderWidth: 1,
      circumference: 180,
      rotation: -90,
    }]
  },
  options: {
    responsive: true, maintainAspectRatio: false,
    cutout: '75%',
    plugins: { legend: { display: false }, tooltip: { enabled: false } }
  }
});

/* ── SCROLL FADE-IN ── */
const observer = new IntersectionObserver(entries=>{
  entries.forEach(e=>{
    if(e.isIntersecting) e.target.style.animationPlayState = 'running';
  });
},{ threshold: .1 });
document.querySelectorAll('.fade-up').forEach(el=>{
  el.style.animationPlayState = 'paused';
  observer.observe(el);
});
</script>
</body>
</html>
