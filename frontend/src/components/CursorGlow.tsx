import { useEffect } from "react";

// A soft neon glow that follows the cursor (web3 vibe). Sits behind content.
// ponytail: viewport-coord follow with CSS transition lag; skipped rAF throttle (setting a CSS var per move is cheap).
export default function CursorGlow() {
  useEffect(() => {
    // no cursor on touch → skip the listener entirely (CSS also hides the glow)
    if (window.matchMedia("(pointer: coarse)").matches) return;
    const move = (e: PointerEvent) => {
      const root = document.documentElement.style;
      root.setProperty("--mx", `${e.clientX}px`);
      root.setProperty("--my", `${e.clientY}px`);
    };
    window.addEventListener("pointermove", move);
    return () => window.removeEventListener("pointermove", move);
  }, []);

  return <div className="cursor-glow" aria-hidden="true" />;
}
