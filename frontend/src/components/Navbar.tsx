import ThemeToggle from "./ThemeToggle";
import { profile } from "../data/profile";

const links = [
  { href: "#about", label: "About" },
  { href: "#projects", label: "Projects" },
  { href: "#experience", label: "Experience" },
];

export default function Navbar() {
  return (
    <header className="fixed inset-x-0 top-0 z-50 border-b border-white/5">
      <nav className="glass mx-auto flex max-w-5xl items-center justify-between px-5 py-3">
        <a href="#top" className="font-mono text-sm font-bold tracking-tight">
          {profile.name.split(" ")[0]}
          <span className="text-neon">.dev</span>
        </a>

        <div className="flex items-center gap-1">
          {links.map((l) => (
            <a
              key={l.href}
              href={l.href}
              className="rounded-md px-3 py-1.5 text-sm text-current/70 transition hover:bg-white/5 hover:text-neon"
            >
              {l.label}
            </a>
          ))}
          <div className="ml-2">
            <ThemeToggle />
          </div>
        </div>
      </nav>
    </header>
  );
}
