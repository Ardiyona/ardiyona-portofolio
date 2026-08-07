// Adaptive quality: GPU power can't be read from CSS media queries, so we can't
// know upfront whether a device (old iGPU laptop, weak phone) can afford the
// blur-heavy decoration. Instead we MEASURE: sample FPS while the heavy ambient
// animations are running, and if it's sustained-low, add `perf-lite` on <html>
// so CSS drops the expensive effects (backdrop-filter, big blurs, cursor glow).
//
// One-way (only degrades, never re-upgrades) to avoid visible quality flip-flop.
// ponytail: fixed 45fps threshold + 1s windows; good enough — no per-device tuning.

const TARGET_FPS = 45; // below this = "struggling"
const WINDOW_MS = 1000; // sample window length
const BAD_WINDOWS = 2; // consecutive bad windows before degrading (~2s)
const GIVE_UP_MS = 8000; // stop sampling after this (good GPU proven, save power)

export function startPerfGuard() {
  // reduced-motion users already get a near-static page; nothing heavy to measure
  if (window.matchMedia("(prefers-reduced-motion: reduce)").matches) return;

  let frames = 0;
  let windowStart = performance.now();
  let sampleStart = windowStart;
  let bad = 0;
  let raf = 0;

  const degrade = () => {
    document.documentElement.classList.add("perf-lite");
    // let the JS-driven ambient loops (orbs, tech field) shut themselves down
    window.dispatchEvent(new Event("perf-lite"));
    cancelAnimationFrame(raf);
  };

  const tick = (now: number) => {
    // background tabs throttle rAF → false low FPS. Reset the window instead.
    if (document.hidden) {
      frames = 0;
      windowStart = now;
      raf = requestAnimationFrame(tick);
      return;
    }

    frames++;
    if (now - windowStart >= WINDOW_MS) {
      const fps = (frames * 1000) / (now - windowStart);
      if (fps < TARGET_FPS) {
        if (++bad >= BAD_WINDOWS) return degrade();
      } else {
        bad = 0;
      }
      frames = 0;
      windowStart = now;
    }

    if (now - sampleStart >= GIVE_UP_MS) {
      cancelAnimationFrame(raf); // survived the probe → leave full quality on
      return;
    }
    raf = requestAnimationFrame(tick);
  };

  raf = requestAnimationFrame(tick);
}
