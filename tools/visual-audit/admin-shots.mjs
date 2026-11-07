// Sign in once, then screenshot several admin pages (viewport + full-page scroll metrics).
// ADMIN_EMAIL=... ADMIN_PASSWORD=... node admin-shots.mjs <out-dir> <width> <height> <path> [<path> ...]
// /admin/login is throttled to 5 requests/minute, so one sign-in serves every page.
import { mkdirSync } from 'node:fs';
import puppeteer from 'puppeteer-core';

const [, , outDir, width, height, ...paths] = process.argv;
mkdirSync(outDir, { recursive: true });

const browser = await puppeteer.launch({
    executablePath: 'C:/Program Files/Google/Chrome/Application/chrome.exe',
    headless: 'new',
    args: ['--no-sandbox', '--host-resolver-rules=MAP foodzero.local 127.0.0.1'],
});
const page = await browser.newPage();
await page.setViewport({ width: +width, height: +height });
await page.goto('http://foodzero.local' + (process.env.ADMIN_LOGIN_PATH || '/admin/login'), { waitUntil: 'networkidle2' });
await page.type('#email', process.env.ADMIN_EMAIL);
await page.type('#password', process.env.ADMIN_PASSWORD);
await Promise.all([page.waitForNavigation({ waitUntil: 'networkidle2' }), page.click('button[type=submit]')]);

for (const path of paths) {
    // TinyMCE / elFinder keep connections open on form pages, so wait for load, not network idle.
    await page.goto('http://foodzero.local' + path, { waitUntil: 'load' });
    await new Promise((r) => setTimeout(r, 1800));
    const metrics = await page.evaluate(() => ({
        title: document.title,
        overflowX: document.documentElement.scrollWidth - document.documentElement.clientWidth,
    }));
    const file = `${outDir}/${path.replace(/[^a-z0-9]+/gi, '_').replace(/^_|_$/g, '') || 'root'}.png`;
    await page.screenshot({ path: file });
    console.log(JSON.stringify({ path, file, ...metrics }));
}
await browser.close();
