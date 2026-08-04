import { useEffect, useRef } from "react";

// Shared scroll-direction tracker (one listener for all reveals).
let scrollDir: "down" | "up" = "down";
let lastY = typeof window !== "undefined" ? window.scrollY : 0;
let bound = false;
function ensureScrollTracker() {
  if (bound || typeof window === "undefined") return;
  bound = true;
  window.addEventListener(
    "scroll",
    () => {
      const y = window.scrollY;
      if (y !== lastY) {
        scrollDir = y > lastY ? "down" : "up";
        lastY = y;
      }
    },
    { passive: true }
  );
}

// Toggles `.in` whenever the element enters/leaves the viewport (replays every pass).
// The hidden offset direction follows scroll direction: scrolling down reveals from
// below, scrolling up reveals from above. Pairs with `.reveal` CSS (uses --rev-y).
export function useReveal<T extends HTMLElement = HTMLDivElement>() {
  const ref = useRef<T>(null);

  useEffect(() => {
    const el = ref.current;
    if (!el) return;
    ensureScrollTracker();

    const io = new IntersectionObserver(
      ([entry]) => {
        el.style.setProperty("--rev-y", scrollDir === "up" ? "-28px" : "28px");
        el.classList.toggle("in", entry.isIntersecting);
      },
      { threshold: 0.15 }
    );
    io.observe(el);
    return () => io.disconnect();
  }, []);

  return ref;
}
