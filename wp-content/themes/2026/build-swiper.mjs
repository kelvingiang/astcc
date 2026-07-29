/**
 * build-swiper.mjs
 *
 * Ngày tạo  : 2026-07-29
 * Mục đích  : Build Swiper custom bundle chỉ gồm module cần thiết:
 *              - Core Swiper
 *              - Navigation  (nút prev/next)
 *              - Autoplay    (tự chạy)
 *             Từ full bundle ~43 KiB → custom bundle ~15-18 KiB (giảm ~60%)
 *
 * Cách dùng: npm run build:swiper
 */

import { writeFileSync, unlinkSync } from 'fs';
import { execSync }                   from 'child_process';
import { fileURLToPath }              from 'url';
import path                           from 'path';

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const tmpEntry  = path.join(__dirname, '_swiper-entry-tmp.mjs');

// Entry point: chỉ import Core + Navigation + Autoplay
// external: ['swiper/css'] để không bundle CSS vào JS
const entryContent = `
import Swiper from 'swiper';
import { Navigation } from 'swiper/modules';
import { Autoplay }   from 'swiper/modules';

Swiper.use([Navigation, Autoplay]);

// Expose ra global window để các inline <script> trong PHP dùng được
window.Swiper = Swiper;
`;

writeFileSync(tmpEntry, entryContent, 'utf8');
console.log('📦 Building custom Swiper bundle (Core + Navigation + Autoplay)...');

try {
    execSync(
        [
            'npx esbuild', tmpEntry,
            '--bundle',
            '--minify',
            '--format=iife',
            '--target=es2018',
            '--external:*.css',           // Không bundle CSS
            `--outfile=js/swiper.custom.min.js`,
        ].join(' '),
        { stdio: 'inherit', cwd: __dirname }
    );

    // Copy Swiper CSS vào js/ để serve cùng domain (tránh CDN)
    const { copyFileSync, statSync } = await import('fs');
    copyFileSync(
        path.join(__dirname, 'node_modules/swiper/swiper-bundle.min.css'),
        path.join(__dirname, 'js/swiper.min.css')
    );

    const jsSize  = (statSync('js/swiper.custom.min.js').size / 1024).toFixed(1);
    const cssSize = (statSync('js/swiper.min.css').size / 1024).toFixed(1);
    console.log(`✅ js/swiper.custom.min.js — ${jsSize} KiB`);
    console.log(`✅ js/swiper.min.css       — ${cssSize} KiB`);

} catch (e) {
    console.error('❌ Build failed:', e.message);
    process.exit(1);
} finally {
    try { unlinkSync(tmpEntry); } catch {}
}
