import { useEffect, useRef, useState } from "react";
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

// scatter spots inside one tile (percent of the tile = the section box).
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

  // perf-lite (set by perfGuard on weak GPUs): keep the field but freeze it —
  // render a single static layer and never start the animation loop.
  const [lite, setLite] = useState(
    () =>
      typeof document !== "undefined" &&
      document.documentElement.classList.contains("perf-lite")
  );
  useEffect(() => {
    const onLite = () => setLite(true);
    window.addEventListener("perf-lite", onLite);
    return () => window.removeEventListener("perf-lite", onLite);
  }, []);

  // fewer icons when we can't afford them: mobile GPU, or perf-lite → 1 layer.
  const mobile =
    typeof window !== "undefined" &&
    window.matchMedia("(max-width: 640px)").matches;
  const layers = mobile || lite ? LAYERS.slice(2) : LAYERS;

  useEffect(() => {
    if (lite) return; // static: no loop
    const el = wrap.current;
    if (!el) return;
    const reduce = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

    const layerEls = Array.from(el.querySelectorAll<HTMLElement>("[data-layer]"));
    const cfg = layerEls.map((l) => ({
      speed: Number(l.dataset.speed),
      ax: Number(l.dataset.ax),
      ay: Number(l.dataset.ay),
    }));

    let raf = 0;
    const tick = () => {
      // tile size = the field's own box (== section). overflow-hidden on the
      // section clips it, so no JS mask needed and no fixed-layer repaint quirks.
      const r = el.getBoundingClientRect();
      const W = r.width || 1;
      const H = r.height || 1;
      const t = reduce ? 0 : performance.now();
      const sy = reduce ? 0 : window.scrollY;
      layerEls.forEach((l, i) => {
        const c = cfg[i];
        // modulo keeps offsets in [0,W)/[0,H); the 2x2 tiling makes the wrap
        // point visually identical → seamless.
        const offX = (t * c.ax) % W;
        const offY = (sy * c.speed + t * c.ay) % H;
        l.style.transform = `translate(${offX.toFixed(1)}px, ${offY.toFixed(1)}px)`;
      });
      raf = requestAnimationFrame(tick);
    };
    raf = requestAnimationFrame(tick);

    return () => cancelAnimationFrame(raf);
  }, [lite]);

  return (
    <div
      ref={wrap}
      aria-hidden="true"
      // absolute inside the (relative, overflow-hidden) About section → clipped
      // to the band naturally. Sits above the band veil, below content (z-10).
      className="pointer-events-none absolute inset-0 overflow-hidden"
    >
      {layers.map((L, li) => (
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
