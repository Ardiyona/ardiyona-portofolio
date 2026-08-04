import { profile } from "../data/profile";
import Reveal from "../components/Reveal";
import { useLandingPageTechStacks } from "../features/landing-page";

export default function Hero() {
  const { email, github, linkedin } = profile.contacts;

  // tech stack dari backend (/tech-stack); fallback ke CV kalau kosong/error
  const { data } = useLandingPageTechStacks();
  const fromApi: string[] = (data?.data ?? []).map((t: { name: string }) => t.name);
  const skills = fromApi.length > 0 ? fromApi : [...profile.skills];

  return (
    <section id="top" className="relative mx-auto flex min-h-svh max-w-5xl flex-col items-center justify-center px-5 pt-24 text-center">
      <Reveal delay={100}>
        <p className="mb-3 font-mono text-sm text-neon">{"<hello world />"}</p>
      </Reveal>

      <Reveal delay={150}>
        <h1 className="gradient-text text-5xl font-extrabold tracking-tight sm:text-7xl">
          {profile.name}
        </h1>
      </Reveal>

      <Reveal delay={250}>
        <p className="mt-4 text-xl font-semibold sm:text-2xl">{profile.role}</p>
        <p className="mx-auto mt-3 max-w-xl text-current/70">{profile.tagline}</p>
      </Reveal>

      <Reveal delay={350}>
        <div className="mt-8 flex flex-wrap items-center justify-center gap-3">
          <a
            href={`mailto:${email}`}
            className="rounded-xl bg-gradient-to-r from-neon to-neon-2 px-5 py-2.5 text-sm font-semibold text-black transition hover:scale-105"
          >
            Contact Me
          </a>
          <a
            href={github}
            target="_blank"
            rel="noreferrer"
            className="glass rounded-xl px-5 py-2.5 text-sm font-semibold transition hover:scale-105 hover:text-neon"
          >
            GitHub
          </a>
          <a
            href={linkedin}
            target="_blank"
            rel="noreferrer"
            className="glass rounded-xl px-5 py-2.5 text-sm font-semibold transition hover:scale-105 hover:text-neon"
          >
            LinkedIn
          </a>
        </div>
      </Reveal>

      {/* skills ticker */}
      <Reveal delay={450} className="mt-12 w-full">
        <div className="flex flex-wrap justify-center gap-2">
          {skills.map((s) => (
            <span
              key={s}
              className="glass rounded-full px-3 py-1 font-mono text-xs text-current/80"
            >
              {s}
            </span>
          ))}
        </div>
      </Reveal>
    </section>
  );
}
