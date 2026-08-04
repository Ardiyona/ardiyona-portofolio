import { useEffect, useState } from "react";

// Dark by default; persists choice in localStorage and toggles `.dark` on <html>.
function getInitial(): boolean {
  const saved = localStorage.getItem("theme");
  if (saved) return saved === "dark";
  return true; // default dark (web3 vibe)
}

export default function ThemeToggle() {
  const [dark, setDark] = useState(getInitial);

  useEffect(() => {
    document.documentElement.classList.toggle("dark", dark);
    localStorage.setItem("theme", dark ? "dark" : "light");
  }, [dark]);

  return (
    <button
      type="button"
      onClick={() => setDark((d) => !d)}
      aria-label="Toggle theme"
      className="grid h-9 w-9 place-items-center rounded-lg border border-white/10 bg-white/5 text-lg transition hover:scale-110 hover:border-neon/50"
    >
      {dark ? "☀️" : "🌙"}
    </button>
  );
}
