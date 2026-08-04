import { useEffect, useRef } from "react";

// Background orbs that physically react when the cursor glow overlaps them:
// within reach -> pushed away proportional to overlap; otherwise spring back to origin.
// ponytail: simple distance-based repel + lerp return (no real engine); add velocity/inertia only if it feels too stiff.
const CURSOR_R = 130; // cursor "touch" radius (px)
const STRENGTH = 0.4; // push force per px of overlap
const MAX_PUSH = 190; // cap displacement (px)
const EASE = 0.12; // spring-ish return/approach factor
const CORE = 0.5; // orb blurred edge -> treat only inner half as solid

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
    const cur = els.map(() => ({ x: 0, y: 0 })); // current applied offset

    let raf = 0;
    const tick = () => {
      const c = cursor.current;
      els.forEach((el, i) => {
        const r = el.getBoundingClientRect();
        // base center = rendered center minus our own offset (decouples feedback)
        const bx = r.left + r.width / 2 - cur[i].x;
        const by = r.top + r.height / 2 - cur[i].y;
        const dx = bx - c.x;
        const dy = by - c.y;
        const dist = Math.hypot(dx, dy) || 0.0001;
        const reach = (r.width / 2) * CORE + CURSOR_R;

        let tx = 0;
        let ty = 0;
        if (dist < reach) {
          const push = Math.min((reach - dist) * STRENGTH, MAX_PUSH);
          tx = (dx / dist) * push;
          ty = (dy / dist) * push;
        }
        cur[i].x += (tx - cur[i].x) * EASE;
        cur[i].y += (ty - cur[i].y) * EASE;
        el.style.translate = `${cur[i].x.toFixed(1)}px ${cur[i].y.toFixed(1)}px`;
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
