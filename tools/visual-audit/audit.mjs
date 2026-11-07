// Headless-Chrome audit of the Food Zero public site.
//
// Usage:
//   node audit.mjs [--out baseline|current] [--widths 375,768,1024,1440] [--pages home,menu] [--no-shots]
// Env:
//   BASE_URL   (default http://foodzero.local)
//   CHROME     (default: Chrome in Program Files)
//
// Writes screenshots to ./<out>/<page>-<width>.png and a JSON report to ./report-<out>.json,
// then prints a per-page summary of the checks required by the openspec change
// `frontend-design-audit-scss`.
import puppeteer from 'puppeteer-core';
import fs from 'node:fs';
import path from 'node:path';
import { fileURLToPath } from 'node:url';

const here = path.dirname(fileURLToPath(import.meta.url));
const args = Object.fromEntries(
    process.argv.slice(2).reduce((acc, a, i, all) => {
        if (a.startsWith('--')) acc.push([a.slice(2), all[i + 1] && !all[i + 1].startsWith('--') ? all[i + 1] : true]);
        return acc;
    }, []),
);

const BASE = process.env.BASE_URL || 'http://foodzero.local';
const CHROME = process.env.CHROME || 'C:/Program Files/Google/Chrome/Application/chrome.exe';
const OUT = args.out || 'current';
const WIDTHS = String(args.widths || '375,768,1024,1440').split(',').map(Number);

const PAGES = {
    home: '/foodzero',
    menu: '/foodzero/menu',
    fullmenu: '/foodzero/menu/full',
    blog: '/foodzero/blog',
    about: '/foodzero/about',
    contact: '/foodzero/contact',
    login: '/admin/login',
};
const only = args.pages ? String(args.pages).split(',') : Object.keys(PAGES);

const MIN_SIDE_PADDING = 16;

/** Runs inside the page: collects every DOM-level check. */
function domChecks(minPad) {
    const de = document.documentElement;
    const vw = de.clientWidth;
    const isHidden = (el) => {
        const cs = getComputedStyle(el);
        return cs.display === 'none' || cs.visibility === 'hidden' || el.getClientRects().length === 0;
    };
    const label = (el) =>
        el.tagName.toLowerCase() + (typeof el.className === 'string' && el.className.trim() ? '.' + el.className.trim().split(/\s+/).join('.') : '');
    const inBurger = (el) => !!el.closest('.burger-menu');

    // 1. Decorative (absolutely positioned) images overlapping text.
    const textEls = [...document.querySelectorAll('h1,h2,h3,h4,p,span,a,li,button,label')].filter(
        (el) => !isHidden(el) && !inBurger(el) && el.children.length === 0 && el.textContent.trim().length > 0,
    );
    const decor = [...document.images].filter((img) => {
        if (isHidden(img) || inBurger(img)) return false;
        if (img.closest('.img-container, .block-seasonings, .slide-people, .fashion-img, .banner-img, .section-img')) return false;
        let el = img;
        for (let i = 0; i < 3 && el; i++, el = el.parentElement) {
            if (['absolute', 'fixed'].includes(getComputedStyle(el).position)) return true;
        }
        return false;
    });
    const overlaps = [];
    for (const img of decor) {
        const r = img.getBoundingClientRect();
        for (const t of textEls) {
            if (img.contains(t) || t.contains(img)) continue;
            const tr = t.getBoundingClientRect();
            const w = Math.min(r.right, tr.right) - Math.max(r.left, tr.left);
            const h = Math.min(r.bottom, tr.bottom) - Math.max(r.top, tr.top);
            if (w > 4 && h > 4) {
                overlaps.push(`${label(img)}[${(img.alt || '').slice(0, 20)}] x "${t.textContent.trim().slice(0, 28)}"`);
                break;
            }
        }
    }

    // 2. Banner text must not touch the viewport edge on small screens.
    const h1 = document.querySelector('h1');
    const h1Left = h1 ? Math.round(h1.getBoundingClientRect().left) : null;
    const bannerOk = vw > 768 || h1Left === null ? true : h1Left >= minPad;

    // 3. Anything wider than the viewport.
    const wide = [];
    document.querySelectorAll('body *').forEach((el) => {
        const r = el.getBoundingClientRect();
        if (r.width > 0 && r.right > vw + 1 && getComputedStyle(el).position !== 'fixed' && !inBurger(el)) wide.push(label(el) + ` right=${Math.round(r.right)}`);
    });

    return {
        title: document.title,
        lang: de.lang || null,
        description: document.querySelector('meta[name=description]')?.content || null,
        scrollW: de.scrollWidth,
        clientW: vw,
        scrollH: de.scrollHeight,
        hOverflow: de.scrollWidth > vw + 1,
        wide: wide.slice(0, 6),
        h1Count: document.querySelectorAll('h1').length,
        h1Left,
        bannerOk,
        overlaps,
        brokenImgs: [...document.images].filter((i) => i.complete && i.naturalWidth === 0 && i.currentSrc).map((i) => i.currentSrc),
        telLinks: [...document.querySelectorAll('a[href^="tel:"]')].map((a) => a.getAttribute('href')),
        burgerTag: document.querySelector('.adaptive-icon')?.tagName || null,
        burgerAria: document.querySelector('.adaptive-icon')?.getAttribute('aria-label') || null,
    };
}

/** Raw-HTML check: the DOM parser hides nested <a>, so look at the source. */
async function rawHtmlChecks(url) {
    const res = await fetch(url);
    const html = await res.text();
    const nested = (html.match(/<a\b[^>]*>(?:(?!<\/a>)[\s\S])*?<a\b/g) || []).length;
    const badTags = (html.match(/<\/\w+\s+[^>]+>/g) || []).length;
    const typos = (html.match(/restuarant|bloger\b|beatiful|youtub\b/gi) || []).length;
    return { nestedAnchors: nested, malformedClosingTags: badTags, typos, httpStatus: res.status };
}

/** Opens the burger menu on a short phone screen and checks it is usable. */
async function burgerCheck(browser) {
    const page = await browser.newPage();
    await page.setViewport({ width: 375, height: 667 });
    await page.goto(BASE + PAGES.home, { waitUntil: 'networkidle2' });
    const res = {};
    try {
        await page.click('.adaptive-icon');
        await new Promise((r) => setTimeout(r, 700));
        Object.assign(
            res,
            await page.evaluate(() => {
                const m = document.querySelector('.burger-menu');
                const cs = getComputedStyle(m);
                const scrollable = ['auto', 'scroll'].includes(cs.overflowY) && m.scrollHeight > m.clientHeight;
                const icons = [...m.querySelectorAll('.media-link')];
                const last = icons[icons.length - 1];
                const lastBottom = last ? last.getBoundingClientRect().bottom : null;
                const close = m.querySelector('.close-btn');
                return {
                    menuScrollH: m.scrollHeight,
                    menuClientH: m.clientHeight,
                    overflowY: cs.overflowY,
                    socialReachable: lastBottom !== null && (lastBottom <= innerHeight || scrollable),
                    closeColor: close ? getComputedStyle(close).color : null,
                    ariaExpanded: document.querySelector('.adaptive-icon')?.getAttribute('aria-expanded') ?? null,
                };
            }),
        );
        await page.screenshot({ path: path.join(here, OUT, 'burger-375x667.png') });
    } catch (e) {
        res.error = e.message;
    }
    await page.close();
    return res;
}

/** Loads lazy images and waits until every image has settled. */
async function settle(page) {
    await page.evaluate(async () => {
        document.querySelectorAll('img[loading="lazy"]').forEach((i) => (i.loading = 'eager'));
        const imgs = [...document.images];
        await Promise.all(imgs.map((i) => (i.complete ? Promise.resolve() : new Promise((r) => { i.onload = i.onerror = r; }))));
        await Promise.all(imgs.map((i) => (i.decode ? i.decode().catch(() => {}) : null)));
    });
    await new Promise((r) => setTimeout(r, 300));
}

fs.mkdirSync(path.join(here, OUT), { recursive: true });
const browser = await puppeteer.launch({
    executablePath: CHROME,
    headless: 'new',
    args: ['--no-sandbox', '--host-resolver-rules=MAP foodzero.local 127.0.0.1'],
});

const report = [];
for (const name of only) {
    const url = PAGES[name];
    const raw = await rawHtmlChecks(BASE + url).catch((e) => ({ error: e.message }));
    for (const w of WIDTHS) {
        const page = await browser.newPage();
        await page.setViewport({ width: w, height: 900 });
        const problems = new Set();
        page.on('console', (m) => ['error', 'warning'].includes(m.type()) && problems.add(`console.${m.type()}: ${m.text()}`));
        page.on('pageerror', (e) => problems.add(`pageerror: ${e.message}`));
        page.on('response', (r) => r.status() >= 400 && problems.add(`HTTP ${r.status()}: ${r.url()}`));
        let status = 0;
        try {
            status = (await page.goto(BASE + url, { waitUntil: 'networkidle2', timeout: 30000 })).status();
        } catch (e) {
            problems.add('goto: ' + e.message);
        }
        await settle(page);
        const dom = await page.evaluate(domChecks, MIN_SIDE_PADDING);
        if (!args['no-shots']) await page.screenshot({ path: path.join(here, OUT, `${name}-${w}.png`), fullPage: true });
        report.push({ name, width: w, status, ...dom, raw, problems: [...problems] });
        await page.close();
    }
}
const burger = await burgerCheck(browser);
await browser.close();

fs.writeFileSync(path.join(here, `report-${OUT}.json`), JSON.stringify({ report, burger }, null, 1));

// ---- console summary -------------------------------------------------------
let failures = 0;
const fail = (msg) => { failures++; console.log('  ✗ ' + msg); };
for (const r of report) {
    console.log(`\n## ${r.name} @${r.width}  [${r.status}]  h=${r.scrollH}`);
    if (r.hOverflow) fail(`horizontal scroll ${r.scrollW}>${r.clientW}: ${r.wide.join(' | ')}`);
    if (r.h1Count !== 1 && r.name !== 'login') fail(`h1 count = ${r.h1Count}`);
    if (!r.bannerOk) fail(`banner h1 left edge = ${r.h1Left}px (< ${MIN_SIDE_PADDING})`);
    r.overlaps.forEach((o) => fail('decor overlaps text: ' + o));
    r.brokenImgs.forEach((i) => fail('broken image: ' + i));
    r.problems.forEach((p) => fail(p));
}
for (const r of report.filter((x) => x.width === WIDTHS[0])) {
    const raw = r.raw;
    if (raw.nestedAnchors) console.log(`\n[${r.name}] ✗ nested <a>: ${raw.nestedAnchors}`), failures++;
    if (raw.malformedClosingTags) console.log(`[${r.name}] ✗ malformed closing tags: ${raw.malformedClosingTags}`), failures++;
    if (raw.typos) console.log(`[${r.name}] ✗ known typos: ${raw.typos}`), failures++;
    if (r.name !== 'login' && (!r.lang || !r.description)) console.log(`[${r.name}] ✗ lang=${r.lang} description=${r.description ? 'yes' : 'missing'}`), failures++;
    if (r.telLinks.some((h) => /\+1\+86/.test(h))) console.log(`[${r.name}] ✗ malformed tel: ${r.telLinks.join(', ')}`), failures++;
}
console.log('\n## burger @375x667', JSON.stringify(burger));
if (!burger.socialReachable) { console.log('  ✗ social icons not reachable'); failures++; }
console.log(`\n${failures} failing check(s). Report: report-${OUT}.json`);
process.exitCode = failures ? 1 : 0;
