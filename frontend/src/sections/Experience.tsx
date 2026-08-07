import { useLandingPageExperiences } from "../features/landing-page";
import Reveal from "../components/Reveal";

type Experience = {
  id: number;
  position: string;
  company: string;
  location: string;
  work_arrangement: "fulltime" | "parttime" | "internship" | "freelance";
  work_style: "onsite" | "hybrid" | "remote";
  is_currently_working: boolean | number;
  work_start: string;
  work_end: string | null;
};

// "2025-02-01" -> "Feb 2025"
const fmt = (d: string | null) =>
  d ? new Date(d).toLocaleDateString("en-US", { month: "short", year: "numeric" }) : "";

const ms = (d: string | null) => (d ? new Date(d).getTime() : 0);
// ongoing (no end / flagged current) sorts as "ends in the far future" → floats to top
const endMs = (e: Experience) =>
  e.is_currently_working || !e.work_end ? Number.POSITIVE_INFINITY : ms(e.work_end);

// newest first: by start date, tie-broken by end date (ongoing on top).
const byRecency = (a: Experience, b: Experience) =>
  ms(b.work_start) - ms(a.work_start) || endMs(b) - endMs(a);

export default function ExperienceSection() {
  const { data, status, error } = useLandingPageExperiences();
  const items: Experience[] = [...(data?.data ?? [])].sort(byRecency);

  return (
    <section id="experience" className="mx-auto max-w-5xl scroll-mt-24 px-5 py-16">
      <Reveal>
        <h2 className="mb-2 font-mono text-sm text-neon">// experience</h2>
        <h3 className="mb-8 text-3xl font-bold sm:text-4xl">Pengalaman</h3>
      </Reveal>

      {status === "pending" && <p className="text-current/60">Memuat pengalaman…</p>}
      {status === "error" && (
        <p className="text-neon-3">Gagal memuat: {String((error as Error)?.message)}</p>
      )}
      {status === "success" && items.length === 0 && (
        <p className="text-current/60">Belum ada pengalaman.</p>
      )}

      <div className="relative ml-3 border-l border-slate-900/15 pl-8 dark:border-white/10">
        {items.map((e, i) => {
          const current = !!e.is_currently_working;
          return (
            <Reveal key={e.id} delay={i * 80}>
              <div className="relative pb-10 last:pb-0">
                {/* node */}
                <span
                  className={`absolute -left-[41px] top-1.5 grid h-4 w-4 place-items-center rounded-full ${
                    current ? "bg-neon" : "bg-slate-900/25 dark:bg-white/20"
                  }`}
                >
                  {current && (
                    <span className="absolute h-4 w-4 animate-ping rounded-full bg-neon/60" />
                  )}
                </span>

                <div className="glass rounded-2xl p-5">
                  <div className="flex flex-wrap items-center justify-between gap-2">
                    <h4 className="text-lg font-bold">{e.position}</h4>
                    <span className="font-mono text-xs text-current/60">
                      {fmt(e.work_start)} – {current ? "Present" : fmt(e.work_end)}
                    </span>
                  </div>
                  <p className="mt-0.5 font-medium text-neon">{e.company}</p>
                  <p className="text-sm text-current/60">{e.location}</p>

                  <div className="mt-3 flex flex-wrap gap-1.5">
                    <Badge>{e.work_arrangement}</Badge>
                    <Badge>{e.work_style}</Badge>
                    {current && <Badge tone="live">Current</Badge>}
                  </div>
                </div>
              </div>
            </Reveal>
          );
        })}
      </div>
    </section>
  );
}

function Badge({ children, tone }: { children: React.ReactNode; tone?: "live" }) {
  return (
    <span
      className={`rounded-full px-2.5 py-0.5 font-mono text-xs capitalize ${
        tone === "live"
          ? "bg-neon/15 text-neon"
          : "border border-white/10 text-current/70"
      }`}
    >
      {children}
    </span>
  );
}
