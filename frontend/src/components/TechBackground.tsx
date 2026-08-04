import { useEffect, useRef } from "react";
import {
  SiReact,
  SiLaravel,
  SiFlutter,
  SiPhp,
  SiJavascript,
  SiTailwindcss,
  SiPostgresql,
  SiMysql,
  SiGit,
} from "react-icons/si";

const ICONS = [
  SiReact,
  SiLaravel,
  SiFlutter,
  SiPhp,
  SiJavascript,
  SiTailwindcss,
  SiPostgresql,
  SiMysql,
  SiGit,
];

// scatter spots inside one tile (percent of the viewport-sized tile).
const SPOTS = [
  { top: 6, left: 8 },
  { top: 16, left: 72 },
  { top: 30, left: 40 },
  { top: 44, left: 14 },
  { top: 54, left: 82 },
  { top: 66, left: 52 },
  { top: 78, left: 24 },
  { top: 88, left: 66 },
  { top: 22, left: 90 },
];

// 2x2 copies (this cell + up + left + up-left) so drifting down-right always
// has a neighbour filling the exposed top/left edge → seamless loop.
const CELLS = [
  [0, 0],
  [-1, 0],
  [0, -1],
  [-1, -1],
];

// depth layers, far → near. `speed` = scroll parallax; `ax/ay` = ambient drift
// px/ms (down faster than right → "turun ke kanan bawah"), very slow.
const LAYERS = [
  { speed: 0.15, ax: 0.003, ay: 0.006, size: 30, opacity: 0.22 },
  { speed: 0.35, ax: 0.005, ay: 0.009, size: 46, opacity: 0.28 },
  { speed: 0.6, ax: 0.008, ay: 0.013, size: 66, opacity: 0.34 },
];

export default function TechBackground() {
  const wrap = useRef<HTMLDivElement>(null);

  useEffect(() => {
    const el = wrap.current;
    if (!el) return;
    const section = el.parentElement;
    if (!section) return;
    const reduce = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

    const layers = Array.from(el.querySelectorAll<HTMLElement>("[data-layer]"));
    const cfg = layers.map((l) => ({
      speed: Number(l.dataset.speed),
      ax: Number(l.dataset.ax),
      ay: Number(l.dataset.ay),
    }));

    let raf = 0;
    const tick = () => {
      const r = section.getBoundingClientRect();
      const W = window.innerWidth || 1;
      const H = window.innerHeight || 1;
      // feather the field to the band's on-screen slice with a soft mask so
      // logos fade in/out at the edges instead of being hard-cut.
      const F = 90; // feather height (px)
      const top = Math.max(0, r.top);
      const bot = Math.min(H, r.bottom);
      const mask =
        `linear-gradient(to bottom,` +
        ` transparent ${top}px,` +
        ` #000 ${Math.min(top + F, bot)}px,` +
        ` #000 ${Math.max(bot - F, top)}px,` +
        ` transparent ${bot}px)`;
      el.style.maskImage = mask;
      el.style.setProperty("-webkit-mask-image", mask);

      const t = reduce ? 0 : performance.now();
      const sy = reduce ? 0 : window.scrollY;
      layers.forEach((l, i) => {
        const c = cfg[i];
        // modulo keeps offsets in [0,W)/[0,H); wrap point is visually identical
        // (2x2 tiling) so the loop has no seam.
        const offX = (t * c.ax) % W;
        const offY = (sy * c.speed + t * c.ay) % H;
        l.style.transform = `translate(${offX.toFixed(1)}px, ${offY.toFixed(1)}px)`;
      });
      raf = requestAnimationFrame(tick);
    };
    raf = requestAnimationFrame(tick);

    return () => cancelAnimationFrame(raf);
  }, []);

  return (
    <div
      ref={wrap}
      aria-hidden="true"
      // z -2 → behind aurora/orbs (z -1); the translucent band veil in front
      // lets it read through while orbs float on top.
      className="pointer-events-none fixed inset-0 z-[-2] overflow-hidden"
    >
      {LAYERS.map((L, li) => (
        <div
          key={li}
          data-layer
          data-speed={L.speed}
          data-ax={L.ax}
          data-ay={L.ay}
          className="absolute inset-0 will-change-transform"
        >
          {CELLS.map(([cx, cy], ci) => (
            <div
              key={ci}
              className="absolute inset-0"
              style={{ transform: `translate(${cx * 100}%, ${cy * 100}%)` }}
            >
              {SPOTS.map((s, si) => {
                const Icon = ICONS[(si + li * 3) % ICONS.length];
                return (
                  <span
                    key={si}
                    className="tech-ico absolute text-neon"
                    style={{ top: `${s.top}%`, left: `${s.left}%`, opacity: L.opacity }}
                  >
                    <Icon size={L.size} />
                  </span>
                );
              })}
            </div>
          ))}
        </div>
      ))}
    </div>
  );
}
