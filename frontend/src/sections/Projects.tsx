import { useLandingPageProjects } from "../features/landing-page";
import Reveal from "../components/Reveal";

// Shape returned by GET /project (wrapped in { status, data })
type Tech = { id: number; name: string; code: string };
type Category = { id: number; name: string; code: string } | null;
type Project = {
  id: number;
  title: string;
  description: string;
  category: Category;
  tech_stacks_project: Tech[];
};

export default function Projects() {
  const { data, status, error, isFetching } = useLandingPageProjects();
  const projects: Project[] = data?.data ?? [];

  return (
    <section id="projects" className="mx-auto max-w-5xl scroll-mt-24 px-5 py-24">
      <Reveal>
        <h2 className="mb-2 font-mono text-sm text-neon">// projects</h2>
        <h3 className="mb-8 text-3xl font-bold sm:text-4xl">Proyek</h3>
      </Reveal>

      {status === "pending" && <StateMsg>Memuat proyek…</StateMsg>}
      {status === "error" && (
        <StateMsg tone="error">Gagal memuat: {String((error as Error)?.message)}</StateMsg>
      )}
      {status === "success" && projects.length === 0 && (
        <StateMsg>Belum ada proyek.</StateMsg>
      )}

      <div className="grid gap-5 sm:grid-cols-2">
        {projects.map((p, i) => (
          <Reveal key={p.id} delay={(i % 2) * 100}>
            <article className="glass group h-full rounded-2xl p-6 transition hover:-translate-y-1 hover:border-neon/40">
              <div className="mb-3 flex items-center justify-between gap-3">
                <h4 className="text-lg font-bold transition group-hover:text-neon">
                  {p.title}
                </h4>
                {p.category && (
                  <span className="shrink-0 rounded-full bg-neon-2/15 px-2.5 py-0.5 font-mono text-xs text-neon-2">
                    {p.category.name}
                  </span>
                )}
              </div>
              <p className="text-sm leading-relaxed text-current/70">{p.description}</p>

              {p.tech_stacks_project?.length > 0 && (
                <div className="mt-4 flex flex-wrap gap-1.5">
                  {p.tech_stacks_project.map((t) => (
                    <span
                      key={t.id}
                      className="rounded-md border border-white/10 px-2 py-0.5 font-mono text-xs text-current/70"
                    >
                      {t.name}
                    </span>
                  ))}
                </div>
              )}
            </article>
          </Reveal>
        ))}
      </div>

      {isFetching && status === "success" && (
        <p className="mt-4 text-center font-mono text-xs text-current/40">refreshing…</p>
      )}
    </section>
  );
}

function StateMsg({ children, tone }: { children: React.ReactNode; tone?: "error" }) {
  return (
    <div
      className={`glass rounded-xl p-6 text-center text-sm ${
        tone === "error" ? "text-neon-3" : "text-current/60"
      }`}
    >
      {children}
    </div>
  );
}
