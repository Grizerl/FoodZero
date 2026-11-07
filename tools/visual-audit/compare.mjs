// Pixel-diff two screenshot sets produced by audit.mjs.
//   node compare.mjs [baseline] [current] [--widths 1440] [--threshold 0.1] [--max-diff-ratio 0.002]
// Writes diff images to ./diff/ and exits non-zero when any image exceeds the allowed diff ratio.
import fs from 'node:fs';
import path from 'node:path';
import { fileURLToPath } from 'node:url';
import { PNG } from 'pngjs';
import pixelmatch from 'pixelmatch';

const here = path.dirname(fileURLToPath(import.meta.url));
const argv = process.argv.slice(2);
const flags = {};
const pos = [];
for (let i = 0; i < argv.length; i++) {
    if (argv[i].startsWith('--')) flags[argv[i].slice(2)] = argv[++i];
    else pos.push(argv[i]);
}
const [a = 'baseline', b = 'current'] = pos;
const widths = flags.widths ? flags.widths.split(',') : null;
const threshold = Number(flags.threshold ?? 0.1);
const maxRatio = Number(flags['max-diff-ratio'] ?? 0.002);

const dirA = path.join(here, a);
const dirB = path.join(here, b);
const outDir = path.join(here, 'diff');
fs.mkdirSync(outDir, { recursive: true });

let bad = 0;
for (const f of fs.readdirSync(dirA).filter((n) => n.endsWith('.png') && !n.startsWith('burger'))) {
    if (widths && !widths.some((w) => f.endsWith(`-${w}.png`))) continue;
    const pB = path.join(dirB, f);
    if (!fs.existsSync(pB)) { console.log(`✗ ${f}: missing in ${b}`); bad++; continue; }
    const A = PNG.sync.read(fs.readFileSync(path.join(dirA, f)));
    const B = PNG.sync.read(fs.readFileSync(pB));
    if (A.width !== B.width || A.height !== B.height) {
        console.log(`✗ ${f}: size ${A.width}x${A.height} -> ${B.width}x${B.height}`);
        bad++;
        continue;
    }
    const diff = new PNG({ width: A.width, height: A.height });
    const n = pixelmatch(A.data, B.data, diff.data, A.width, A.height, { threshold });
    const ratio = n / (A.width * A.height);
    const ok = ratio <= maxRatio;
    if (!ok) { bad++; fs.writeFileSync(path.join(outDir, f), PNG.sync.write(diff)); }
    console.log(`${ok ? '✓' : '✗'} ${f}: ${n} px (${(ratio * 100).toFixed(3)}%)`);
}
console.log(bad ? `\n${bad} image(s) differ` : '\nall images match');
process.exitCode = bad ? 1 : 0;
