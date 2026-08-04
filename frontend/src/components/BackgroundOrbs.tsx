import { useEffect, useRef } from "react";

// Background orbs with a random-walk drift that also physically react when the
// cursor glow overlaps them (pushed away proportional to overlap).
// ponytail: constant-speed wander toward random targets + distance-based repel; no real engine.
const CURSOR_R = 130; // cursor "touch" radius (px)
const STRENGTH = 0.4; // push force per px of overlap
const MAX_PUSH = 190; // cap displacement (px)
const EASE = 0.12; // spring-ish push approach factor
const CORE = 0.5; // orb blurred edge -> treat only inner half as solid
const WANDER = 160; // random-walk range from home (px)
const WSPEED = 0.35; // wander speed (px/frame) — small = slow drift

const rnd = () => (Math.random() * 2 - 1) * WANDER;

export default function BackgroundOrbs() {
  const wrapRef = useRef<HTMLDivElement>(null);
  const cursor = useRef({ x: -9999, y: -9999 });

  useEffect(() => {
    // honor reduced-motion: leave orbs static
    if (window.matchMedia("(prefers-reduced-motion: reduce)").matches) return;

    const move = (e: PointerEvent) => {
      cursor.current = { x: e.clientX, y: e.clientY };
    };
    const leave = () => {
      cursor.current = { x: -9999, y: -9999 };
    };
    window.addEventListener("pointermove", move, { passive: true });
    window.addEventListener("pointerout", leave);

    const els = Array.from(
      wrapRef.current?.querySelectorAll<HTMLElement>(".orb") ?? []
    );
    const wander = els.map(() => ({ x: rnd(), y: rnd() })); // current drift offset
    const target = els.map(() => ({ x: rnd(), y: rnd() })); // random-walk target
    const push = els.map(() => ({ x: 0, y: 0 })); // eased cursor repel offset

    let raf = 0;
    const tick = () => {
      const c = cursor.current;
      els.forEach((el, i) => {
        // random-walk: step toward target at constant speed, repick on arrival
        const wx = target[i].x - wander[i].x;
        const wy = target[i].y - wander[i].y;
        const wd = Math.hypot(wx, wy) || 0.0001;
        if (wd < 4) {
          target[i] = { x: rnd(), y: rnd() };
        } else {
          wander[i].x += (wx / wd) * WSPEED;
          wander[i].y += (wy / wd) * WSPEED;
        }

        const r = el.getBoundingClientRect();
        // base center = rendered center minus our whole applied offset
        const off = { x: wander[i].x + push[i].x, y: wander[i].y + push[i].y };
        const bx = r.left + r.width / 2 - off.x;
        const by = r.top + r.height / 2 - off.y;
        const dx = bx - c.x;
        const dy = by - c.y;
        const dist = Math.hypot(dx, dy) || 0.0001;
        const reach = (r.width / 2) * CORE + CURSOR_R;

        let tx = 0;
        let ty = 0;
        if (dist < reach) {
          const p = Math.min((reach - dist) * STRENGTH, MAX_PUSH);
          tx = (dx / dist) * p;
          ty = (dy / dist) * p;
        }
        push[i].x += (tx - push[i].x) * EASE;
        push[i].y += (ty - push[i].y) * EASE;

        el.style.translate = `${(wander[i].x + push[i].x).toFixed(1)}px ${(
          wander[i].y + push[i].y
        ).toFixed(1)}px`;
      });
      raf = requestAnimationFrame(tick);
    };
    raf = requestAnimationFrame(tick);

    return () => {
      cancelAnimationFrame(raf);
      window.removeEventListener("pointermove", move);
      window.removeEventListener("pointerout", leave);
    };
  }, []);

  return (
    <div ref={wrapRef} aria-hidden="true">
      <span className="orb orb-1" />
      <span className="orb orb-2" />
      <span className="orb orb-3" />
    </div>
  );
}
