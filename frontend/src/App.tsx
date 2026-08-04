import CursorGlow from "./components/CursorGlow";
import Navbar from "./components/Navbar";
import Hero from "./sections/Hero";
import About from "./sections/About";
import Projects from "./sections/Projects";
import Experience from "./sections/Experience";
import { profile } from "./data/profile";

export default function App() {
  return (
    <>
      <div className="aurora" aria-hidden="true">
        <span className="orb orb-1" />
        <span className="orb orb-2" />
        <span className="orb orb-3" />
      </div>
      <CursorGlow />
      <Navbar />

      <main>
        <Hero />
        <About />
        <Projects />
        <Experience />
      </main>

      <footer className="mx-auto max-w-5xl px-5 py-10 text-center text-sm text-current/50">
        <p className="font-mono">
          © 2026 {profile.name} — built with React + Tailwind
        </p>
        <div className="mt-2 flex justify-center gap-4">
          <a className="hover:text-neon" href={`mailto:${profile.contacts.email}`}>
            Email
          </a>
          <a className="hover:text-neon" href={profile.contacts.github} target="_blank" rel="noreferrer">
            GitHub
          </a>
          <a className="hover:text-neon" href={profile.contacts.linkedin} target="_blank" rel="noreferrer">
            LinkedIn
          </a>
        </div>
      </footer>
    </>
  );
}
