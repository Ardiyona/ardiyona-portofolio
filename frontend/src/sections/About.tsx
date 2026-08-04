import { useState } from "react";
import { profile } from "../data/profile";
import Reveal from "../components/Reveal";

const initials = profile.name
  .split(" ")
  .map((w) => w[0])
  .slice(0, 2)
  .join("");

export default function About() {
  const { education } = profile;
  const [imgOk, setImgOk] = useState(true);

  return (
    <section id="about" className="mx-auto max-w-5xl scroll-mt-24 px-5 pt-4 pb-16">
      <Reveal>
        <h2 className="mb-2 font-mono text-sm text-neon">// about</h2>
        <h3 className="mb-8 text-3xl font-bold sm:text-4xl">Tentang Saya</h3>
      </Reveal>

      {/* photo (3x4, left) + bio (right) */}
      <div className="grid items-stretch gap-6 md:grid-cols-5">
        <Reveal className="md:col-span-2">
          <div className="relative mx-auto aspect-[3/4] w-full max-w-[280px]">
            {/* glow */}
            <div className="absolute -inset-1 rounded-2xl bg-gradient-to-br from-neon via-neon-2 to-neon-3 opacity-60 blur-lg" />
            {imgOk ? (
              <img
                src={profile.photo}
                alt={profile.name}
                onError={() => setImgOk(false)}
                className="relative h-full w-full rounded-2xl object-cover"
              />
            ) : (
              <div className="glass relative grid h-full w-full place-items-center rounded-2xl font-mono text-6xl font-bold">
                {initials}
              </div>
            )}
          </div>
        </Reveal>

        <Reveal delay={120} className="md:col-span-3">
          <div className="glass flex h-full flex-col justify-center gap-4 rounded-2xl p-6 leading-relaxed text-current/80">
            {profile.bio.map((para, i) => (
              <p key={i}>{para}</p>
            ))}
          </div>
        </Reveal>
      </div>

      {/* education below, full width */}
      <Reveal delay={200}>
        <div className="glass mt-6 rounded-2xl p-6">
          <p className="mb-3 font-mono text-xs text-neon">riwayat pendidikan</p>
          <div className="flex flex-wrap items-start justify-between gap-4">
            <div>
              <p className="text-lg font-semibold">{education.school}</p>
              <p className="mt-1 text-current/70">{education.program}</p>
            </div>
            <div className="text-right">
              <p className="font-mono text-sm">
                <span className="text-current/60">GPA </span>
                <span className="font-semibold text-neon">{education.gpa}</span>
              </p>
              <p className="mt-1 font-mono text-sm text-current/70">{education.period}</p>
            </div>
          </div>
        </div>
      </Reveal>
    </section>
  );
}
