import {
  useLandingPageProjects,
  useLandingPageTechStacks,
  useLandingPageExperiences,
} from './features/landing-page'

function Block({ title, query }: { title: string; query: any }) {
  return (
    <section style={{ marginBottom: 24 }}>
      <h2>{title}</h2>
      <p>
        status: <b>{query.status}</b>
        {query.isFetching ? ' (fetching…)' : ''}
      </p>
      <pre style={{ background: '#111', color: '#0f0', padding: 12, overflow: 'auto' }}>
        {query.error
          ? String(query.error)
          : JSON.stringify(query.data, null, 2)}
      </pre>
    </section>
  )
}

export default function FetchTest() {
  const projects = useLandingPageProjects()
  const techStacks = useLandingPageTechStacks()
  const experiences = useLandingPageExperiences()

  return (
    <main style={{ padding: 24, fontFamily: 'monospace' }}>
      <h1>Fetch Test</h1>
      <Block title="Projects" query={projects} />
      <Block title="Tech Stacks" query={techStacks} />
      <Block title="Experiences" query={experiences} />
    </main>
  )
}
