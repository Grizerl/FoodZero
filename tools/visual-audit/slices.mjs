// Screenshot a page in viewport-sized slices so long pages stay readable.
// node slices.mjs <out-prefix> <url-path> <width> [slice-height=1000] [cookie-for-admin]
import puppeteer from 'puppeteer-core';

const [, , prefix, path, width, sliceHeight = '1000', cookie] = process.argv;
const browser = await puppeteer.launch({
    executablePath: 'C:/Program Files/Google/Chrome/Application/chrome.exe',
    headless: 'new',
    args: ['--no-sandbox', '--host-resolver-rules=MAP foodzero.local 127.0.0.1'],
});
const page = await browser.newPage();
await page.setViewport({ width: +width, height: +sliceHeight });
if (cookie) {
    await page.setExtraHTTPHeaders({ Cookie: cookie });
}
// ADMIN_EMAIL / ADMIN_PASSWORD in the environment: sign in through /admin/login first.
if (process.env.ADMIN_EMAIL) {
    await page.goto('http://foodzero.local' + (process.env.ADMIN_LOGIN_PATH || '/admin/login'), { waitUntil: 'networkidle2' });
    await page.type('#email', process.env.ADMIN_EMAIL);
    await page.type('#password', process.env.ADMIN_PASSWORD);
    await Promise.all([page.waitForNavigation({ waitUntil: 'networkidle2' }), page.click('button[type=submit]')]);
}
await page.goto('http://foodzero.local' + path, { waitUntil: 'networkidle2' });
const isAdmin = Boolean(process.env.ADMIN_EMAIL);
await page.evaluate(async (settle) => {
    // Public pages: jump CSS animations to their end. Admin: let AdminLTE settle (preloader, sidebar).
    if (!settle) {
        document.getAnimations().forEach((a) => {
            try {
                a.finish();
            } catch (e) {}
        });
    }
    document.querySelectorAll('img[loading=lazy]').forEach((i) => (i.loading = 'eager'));
    await Promise.all([...document.images].map((i) => (i.complete ? 0 : new Promise((r) => { i.onload = i.onerror = r; }))));
}, isAdmin);
await new Promise((r) => setTimeout(r, isAdmin ? 1500 : 300));
const total = await page.evaluate(() => document.documentElement.scrollHeight);
let n = 0;
for (let y = 0; y < total; y += +sliceHeight) {
    const out = `${prefix}-${String(n++).padStart(2, '0')}.png`;
    if (isAdmin) {
        // AdminLTE's fixed sidebar misrenders in clipped captures: scroll and shoot the viewport instead.
        await page.evaluate((top) => window.scrollTo(0, top), y);
        await new Promise((r) => setTimeout(r, 200));
        await page.screenshot({ path: out });
    } else {
        await page.screenshot({ path: out, clip: { x: 0, y, width: +width, height: Math.min(+sliceHeight, total - y) } });
    }
}
console.log(`${n} slices, page height ${total}`);
await browser.close();
